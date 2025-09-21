<?php

namespace App\Http\Controllers\Admin\Product;

use App\Enums\LogLevel;
use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use App\Models\SystemLog;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Validate
     */
    private function validateCategory(Request $request, $categoryId = null)
    {
        $rules = [
            'name' => 'required|string|max:100|unique:product_categories,name' . ($categoryId ? ',' . $categoryId : ''),
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_active' => ['required', 'boolean'],
            'remove_image' => 'nullable|boolean',
        ];

        $messages = [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.unique' => 'Nama kategori sudah ada. Mohon gunakan nama lain.',
            'description.string' => 'Deskripsi harus berupa teks.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar yang diperbolehkan adalah jpeg, png, jpg, gif, svg.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
        ];

        return $request->validate($rules, $messages);
    }

    /**
     * Display a listing of the resource.
     */
    // public function index(Request $request)
    // {
    //     $searchParam = is_array($request->search) ? ($request->search[0] ?? '') : ($request->search ?? '');
    //     $isActiveParam = is_array($request->is_active) ? ($request->is_active[0] ?? null) : ($request->is_active ?? null); // Keep null for no filter

    //     $categoryQuery = ProductCategory::query();

    //     if (!empty($searchParam)) {
    //         $categoryQuery->where('name', 'like', '%' . $searchParam . '%');
    //     }

    //     // Only apply is_active filter if it's explicitly set (0 or 1)
    //     if (!is_null($isActiveParam)) {
    //         // Cast to boolean if it comes as '0' or '1' string
    //         $categoryQuery->where('is_active', (bool) $isActiveParam);
    //     }

    //     // Pass the normalized parameters to appends to maintain filters in pagination links
    //     $categories = $categoryQuery->paginate(10)->appends([
    //         'search' => $searchParam,
    //         'is_active' => $isActiveParam,
    //     ]);

    //     return view('admin.category.index', compact('categories'));
    // }

    public function index(Request $request)
    {
        // Use Laravel's built-in filtering for cleaner code
        $categories = ProductCategory::query()
            ->withCount('products') // EFFICIENTLY COUNT PRODUCTS
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%');
            })
            ->when($request->filled('is_active'), function ($query) use ($request) {
                $query->where('is_active', $request->is_active);
            })
            ->latest() // Default sort by newest
            ->paginate(10)
            ->withQueryString(); // Automatically appends all filter parameters

        return view('admin.category.index', compact('categories'));
    }
    
    // NEW METHOD to handle the toggle switch
    public function toggleStatus(ProductCategory $category)
    {
        $category->update(['is_active' => !$category->is_active]);
        return back()->with('success', 'Status kategori berhasil diperbarui.');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $this->validateCategory($request);

        try {
            $validatedData['slug'] = Str::slug($validatedData['name']);

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $validatedData['image'] = $file->store('category', 'public');
            }

            $category = ProductCategory::create($validatedData);

            // ---- Catat Aktivitas ke SystemLog ---- //
            SystemLog::log(
                LogLevel::INFO->value,
                'PRODUCT_CATEGORY_CREATED',
                'Kategori produk "' . $category->name . '" telah berhasil dibuat oleh ' . (Auth::user()->name ?? 'Pengguna Tidak Dikenal') . '.',
                [
                    'category_id' => $category->id,
                    'category_name' => $category->name,
                    'created_by_user_id' => Auth::id(),
                    'request_data' => $validatedData,
                ]
            );
            // ---- End Log ---- //

            return redirect()->route('admin.category.index')->with('success', 'Kategori produk berhasil dibuat.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat membuat kategori: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductCategory $category)
    {
        return view('admin.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductCategory $category)
    {
        $validatedData = $this->validateCategory($request, $category->id);

        try {
            $validatedData['slug'] = Str::slug($validatedData['name']);

            if ($request->has('remove_image') && $request->input('remove_image') == 1) {
                // Hapus gambar lama jika ada dan user ingin menghapusnya
                if ($category->image && Storage::disk('public')->exists(str_replace('storage/', '', $category->image))) {
                    Storage::disk('public')->delete(str_replace('storage/', '', $category->image));
                }
                $validatedData['image'] = null; // Set image ke null di database
            }

            if ($request->hasFile('image')) {
                // Hapus gambar lama jika ada
                if ($category->image && Storage::disk('public')->exists(str_replace('storage/', '', $category->image))) {
                    Storage::disk('public')->delete(str_replace('storage/', '', $category->image));
                }
                $file = $request->file('image');
                $validatedData['image'] = $file->store('category', 'public');
            } elseif (!$request->has('remove_image')) {
                // Jika tidak ada upload gambar baru DAN tidak ada permintaan hapus gambar,
                // maka pertahankan gambar yang sudah ada
                unset($validatedData['image']); // Pastikan 'image' tidak di-update ke null jika tidak ada perubahan
            }

            $category->update($validatedData);

            // ---- Catat Aktivitas ke SystemLog ---- //
            SystemLog::log(
                LogLevel::INFO->value,
                'PRODUCT_CATEGORY_UPDATED',
                'Kategori produk "' . $category->name . '" telah berhasil diperbarui oleh ' . (Auth::user()->name ?? 'Pengguna Tidak Dikenal') . '.',
                [
                    'category_id' => $category->id,
                    'category_name' => $category->name,
                    'updated_by_user_id' => Auth::id(),
                    'request_data' => $validatedData,
                ]
            );
            // ---- End Log ---- //

            return redirect()->route('admin.category.index')->with('success', 'Kategori produk berhasil diperbarui.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengupdate kategori: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function setActive(ProductCategory $category)
    {
        if ($category->is_active == true) {
            $category->is_active = false;
            $category->save();
            return redirect()->route('admin.category.index')->with('success', 'Kategori produk berhasil dinonaktifkan.');
        } else {
            $category->is_active = true;
            $category->save();
            return redirect()->route('admin.category.index')->with('success', 'Kategori produk berhasil diaktifkan.');
        }
    }

    // NEW METHOD for safe deletion
    public function destroy(ProductCategory $category)
    {
        // Prevent deletion if the category has products
        if ($category->products()->count() > 0) {
            return back()->with('error', 'Kategori tidak dapat dihapus karena masih memiliki produk terkait.');
        }

        // Add logic to delete the image from storage if it exists
        Storage::disk('public')->delete($category->image);

        $category->delete();
        return back()->with('success', 'Kategori berhasil dihapus.');
    }
}
