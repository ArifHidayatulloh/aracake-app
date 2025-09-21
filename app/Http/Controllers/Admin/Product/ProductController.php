<?php

namespace App\Http\Controllers\Admin\Product;

use App\Enums\LogLevel;
use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Models\SystemLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Metode pembantu untuk validasi produk.
     * @param Request $request
     * @param Product|null $product Untuk kasus update (opsional, saat ini tidak digunakan sepenuhnya di sini)
     * @return array The validated data.
     * @throws \Illuminate\Validation\ValidationException
     */
    private function validateProduct(Request $request, $product = null)
    {
        $rules = [
            'category_id' => ['required', 'exists:product_categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'sku' => ['required', 'string', 'max:255', 'unique:products,sku' . ($product ? ',' . $product->id : '')],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'preparation_time_days' => ['required', 'integer', 'min:0'],
            'is_available' => ['boolean'],
            'is_recommended' => ['boolean'],
            'is_featured' => ['boolean'],
            'is_active' => ['boolean'],
        ];

        $messages = [
            'name.required' => 'Nama produk harus diisi.',
            'sku.unique' => 'SKU produk sudah ada.',
            'category_id.exists' => 'Kategori produk tidak ditemukan.',
            'images.required' => 'Setidaknya satu gambar produk harus diunggah.',
            'images.min' => 'Setidaknya satu gambar produk harus diunggah.',
        ];

        return $request->validate($rules, $messages);
    }

    // ... (metode index, show, edit, update, destroy tidak diubah)

    /**
     * Menampilkan daftar semua produk.
     */
    public function index(Request $request)
    {
        $categories = ProductCategory::where('is_active', true)->orderBy('name')->get();

        // Menggunakan metode when() untuk query yang lebih bersih
        $products = Product::with('category')
            ->when($request->filled('search'), function ($query) use ($request) {
                $searchTerm = '%' . $request->search . '%';
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('name', 'like', $searchTerm)
                      ->orWhere('sku', 'like', $searchTerm);
                });
            })
            ->when($request->filled('category'), function ($query) use ($request) {
                $query->where('category_id', $request->category);
            })
            ->when($request->filled('is_active'), function ($query) use ($request) {
                $query->where('is_active', $request->is_active);
            })
            ->when($request->filled('is_available'), function ($query) use ($request) {
                $query->where('is_available', $request->is_available);
            })
            ->when($request->filled('is_recommended'), function ($query) use ($request) {
                $query->where('is_recommended', $request->is_recommended);
            })
            ->when($request->filled('sort_by'), function ($query) use ($request) {
                // Whitelist untuk keamanan sorting
                $sortables = ['name', 'price', 'sku', 'created_at'];
                $direction = $request->input('direction', 'asc');
                if (in_array($request->sort_by, $sortables)) {
                    $query->orderBy($request->sort_by, $direction);
                }
            }, function ($query) {
                // Default sort jika tidak ada parameter sorting
                $query->latest();
            })
            ->paginate(10)
            ->withQueryString(); // Otomatis membawa semua parameter filter saat paginasi

        return view('admin.product.index', compact('products', 'categories'));
    }
    
    // [BARU] Method untuk toggle status
    public function toggleStatus(Request $request, Product $product)
    {
        $request->validate(['field' => 'required|in:is_active,is_available,is_recommended,is_featured']);
        
        $field = $request->field;
        $product->update([$field => !$product->$field]);
        
        return back()->with('success', 'Status produk berhasil diperbarui.');
    }


    /**
     * Menampilkan formulir untuk membuat produk baru.
     */
    public function create()
    {
        $categories = ProductCategory::where('is_active', true)->orderBy('name', 'asc')->get();
        return view('admin.product.create', compact('categories'));
    }

    /**
     * Menyimpan produk baru beserta gambarnya ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:product_categories,id',
            'sku' => 'required|string|max:255|unique:products,sku',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'preparation_time_days' => 'required|integer|min:1',
            'is_available' => 'boolean',
            'is_recommended' => 'boolean',
            'is_featured' => 'boolean',
            'images' => 'required|array|min:1',
            'images.*.file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images.*.alt_text' => 'nullable|string|max:255',
            'images.*.is_thumbnail' => 'boolean',
        ]);

        DB::beginTransaction();

        try {
            // Create product
            $product = Product::create([
                'category_id' => $request->category_id,
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'sku' => $request->sku,
                'description' => $request->description,
                'price' => $request->price,
                'preparation_time_days' => $request->preparation_time_days,
                'is_available' => $request->boolean('is_available', true),
                'is_recommended' => $request->boolean('is_recommended'),
                'is_featured' => $request->boolean('is_featured'),
                'is_active' => true,
            ]);

            // Handle images
            $thumbnailUrl = null;
            $hasThumbnail = false;

            foreach ($request->images as $index => $imageData) {
                if (isset($imageData['file']) && $imageData['file']) {
                    // Store image
                    $imagePath = $imageData['file']->store('products', 'public');
                    $imageUrl = Storage::url($imagePath);

                    $isThumbnail = isset($imageData['is_thumbnail']) && $imageData['is_thumbnail'];

                    // If this is the first image and no thumbnail is explicitly set, make it thumbnail
                    if ($index === 0 && !$hasThumbnail) {
                        $isThumbnail = true;
                    }

                    // Create product image
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_url' => $imageUrl,
                        'alt_text' => $imageData['alt_text'] ?? null,
                        'is_thumbnail' => $isThumbnail,
                        'sort_order' => $index,
                    ]);

                    // Set thumbnail URL for product table
                    if ($isThumbnail) {
                        $thumbnailUrl = $imageUrl;
                        $hasThumbnail = true;
                    }
                }
            }

            // Update product with thumbnail URL
            if ($thumbnailUrl) {
                $product->update(['image_url' => $thumbnailUrl]);
            }


            // ---- Catat Aktivitas ke SystemLog ---- //
            SystemLog::log(
                LogLevel::INFO->value,
                'PRODUCT_CREATED',
                'Produk "' . $product->name . '" telah berhasil dibuat oleh ' . (Auth::user()->name ?? 'Pengguna Tidak Dikenal') . '.',
                [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'created_by_user_id' => Auth::id(),
                    'request_data' => $request->all(),
                ]
            );
            // ---- End Log ---- //

            DB::commit();

            return redirect()
                ->route('admin.product.index')
                ->with('success', 'Produk berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollback();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan produk: ' . $e->getMessage());
        }
    }

    public function show(Product $product)
    {
        return view('admin.product.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = ProductCategory::all();

        // Eager load images to avoid N+1 queries
        $product->load('images');

        // Pass the product and categories to the view
        return view('admin.product.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:product_categories,id',
            'sku' => 'required|string|max:255|unique:products,sku,' . $product->id,
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'preparation_time_days' => 'required|integer|min:1',
            'is_available' => 'boolean',
            'is_recommended' => 'boolean',
            'is_featured' => 'boolean',
            'images' => 'required|array|min:1',
            'images.*.file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images.*.alt_text' => 'nullable|string|max:255',
            'images.*.is_thumbnail' => 'boolean',
        ]);

        DB::beginTransaction();

        try {
            // Update product data
            $product->update([
                'category_id' => $request->category_id,
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'sku' => $request->sku,
                'description' => $request->description,
                'price' => $request->price,
                'preparation_time_days' => $request->preparation_time_days,
                'is_available' => $request->boolean('is_available', true),
                'is_recommended' => $request->boolean('is_recommended'),
                'is_featured' => $request->boolean('is_featured'),
            ]);

            $submittedImageIds = collect($request->images)->pluck('id')->filter()->toArray();

            // Delete images that were removed from the form
            $product->images()->whereNotIn('id', $submittedImageIds)->get()->each(function ($image) {
                if (Storage::disk('public')->exists($image->image_url)) {
                    Storage::disk('public')->delete($image->image_url);
                }
                $image->delete();
            });

            $thumbnailUrl = null;

            // Process images from the request
            foreach ($request->images as $index => $imageData) {
                $isThumbnail = isset($imageData['is_thumbnail']) && $imageData['is_thumbnail'];

                // Handle existing images
                if (isset($imageData['id']) && $imageData['id']) {
                    $productImage = ProductImage::findOrFail($imageData['id']);

                    // If a new file is uploaded for an existing image, replace it
                    if (isset($imageData['file']) && $imageData['file']) {
                        // Delete old file
                        if (Storage::disk('public')->exists($productImage->image_url)) {
                            Storage::disk('public')->delete($productImage->image_url);
                        }

                        // Store new file
                        $imagePath = $imageData['file']->store('products', 'public');
                        $imageUrl = Storage::url($imagePath);
                        $productImage->update([
                            'image_url' => $imageUrl,
                            'alt_text' => $imageData['alt_text'] ?? null,
                            'is_thumbnail' => $isThumbnail,
                            'sort_order' => $index,
                        ]);
                    } else {
                        // No new file, just update alt_text and thumbnail status
                        $productImage->update([
                            'alt_text' => $imageData['alt_text'] ?? null,
                            'is_thumbnail' => $isThumbnail,
                            'sort_order' => $index,
                        ]);
                    }

                    if ($isThumbnail) {
                        $thumbnailUrl = $productImage->image_url;
                    }
                } else {
                    // Handle new images
                    if (isset($imageData['file']) && $imageData['file']) {
                        $imagePath = $imageData['file']->store('products', 'public');
                        $imageUrl = Storage::url($imagePath);

                        $productImage = ProductImage::create([
                            'product_id' => $product->id,
                            'image_url' => $imageUrl,
                            'alt_text' => $imageData['alt_text'] ?? null,
                            'is_thumbnail' => $isThumbnail,
                            'sort_order' => $index,
                        ]);

                        if ($isThumbnail) {
                            $thumbnailUrl = $imageUrl;
                        }
                    }
                }
            }

            // If a new thumbnail was set, update the main product image_url
            if ($thumbnailUrl) {
                $product->update(['image_url' => $thumbnailUrl]);
            }

            // ---- Catat Aktivitas ke SystemLog ---- //
            SystemLog::log(
                LogLevel::INFO->value,
                'PRODUCT_UPDATED',
                'Produk "' . $product->name . '" telah berhasil diperbarui oleh ' . (Auth::user()->name ?? 'Pengguna Tidak Dikenal') . '.',
                [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'updated_by_user_id' => Auth::id(),
                    'request_data' => $request->except(['_token', '_method', 'images']),
                ]
            );
            // ---- End Log ---- //

            DB::commit();

            return redirect()
                ->route('admin.product.index')
                ->with('success', 'Produk berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui produk: ' . $e->getMessage());
        }
    }

    public function destroy(Product $product)
    {
        $checkOrderItems = OrderItem::where('product_id', $product->id)->first();

        if ($checkOrderItems) {
            return redirect()->back()->with('error', 'Produk tidak dapat dihapus karena masih digunakan dalam pesanan.');
        }

        $product->delete();

        // ---- Catat Aktivitas ke SystemLog ---- //
        SystemLog::log(
            LogLevel::INFO->value,
            'PRODUCT_DELETED',
            'Produk "' . $product->name . '" telah berhasil dihapus oleh ' . (Auth::user()->name ?? 'Pengguna Tidak Dikenal') . '.',
            [
                'product_id' => $product->id,
                'product_name' => $product->name,
                'deleted_by_user_id' => Auth::id(),
            ]
        );
        // ---- End Log ---- //

        return redirect()
            ->route('admin.product.index')
            ->with('success', 'Produk berhasil dihapus!');
    }
}
