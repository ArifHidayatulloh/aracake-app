<?php

namespace App\Http\Controllers\Admin\Delivery;

use App\Enums\LogLevel;
use App\Http\Controllers\Controller;
use App\Models\DeliveryMethod;
use App\Models\SystemLog;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeliveryMethodController extends Controller
{
    private function validateDeliveryMethod(Request $request, $deliveryMethodId = null)
    {
        $rules = [
            'method_name' => 'required|unique:delivery_methods,method_name,' . $deliveryMethodId,
            'description' => 'required',
            'base_cost' => 'required',
            'cost_per_km' => 'required',
            'is_pickup' => 'required',
            'is_active' => 'required',
        ];

        $messages = [
            'method_name.unique' => 'Metode pengiriman sudah ada.',
            'method_name.required' => 'Nama metode wajib diisi.',
            'description.required' => 'Deskripsi wajib diisi.',
            'base_cost.required' => 'Biaya dasar wajib diisi.',
            'cost_per_km.required' => 'Biaya per KM wajib diisi.',
            'is_pickup.required' => 'Metode pengiriman wajib diisi.',
            'is_active.required' => 'Metode aktif wajib diisi.',
        ];

        return $request->validate($rules, $messages);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchParam = is_array($request->search) ? ($request->search[0] ?? '') : ($request->search ?? '');
        $isActiveParam = is_array($request->is_active) ? ($request->is_active[0] ?? null) : ($request->is_active ?? null); // Keep null for no filter
        $isPickupParam = is_array($request->is_pickup) ? ($request->is_pickup[0] ?? null) : ($request->is_pickup ?? null); // Keep null for no filter

        $deliveryMethodQuery = DeliveryMethod::query();

        if (!empty($searchParam)) {
            $deliveryMethodQuery->where('method_name', 'like', '%' . $searchParam . '%');
        }

        // Only apply is_active filter if it's explicitly set (0 or 1)
        if (!is_null($isActiveParam)) {
            // Cast to boolean if it comes as '0' or '1' string
            $deliveryMethodQuery->where('is_active', (bool) $isActiveParam);
        }

        // Only apply is_pickup filter if it's explicitly set (0 or 1)
        if (!is_null($isPickupParam)) {
            // Cast to boolean if it comes as '0' or '1' string
            $deliveryMethodQuery->where('is_pickup', (bool) $isPickupParam);
        }

        // Pass the normalized parameters to appends to maintain filters in pagination links
        $deliveryMethods = $deliveryMethodQuery->paginate(10)->appends([
            'search' => $searchParam,
            'is_active' => $isActiveParam,
            'is_pickup' => $isPickupParam,
        ]);

        return view('admin.delivery-method.index', compact('deliveryMethods'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.delivery-method.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $this->validateDeliveryMethod($request);

        try {
            DeliveryMethod::create($validatedData);

            // ---- Catat Aktivitas ke SystemLog ---- //
            SystemLog::log(
                LogLevel::INFO->value,
                'DELIVERY_METHOD_CREATED',
                'Metode pengiriman baru telah berhasil dibuat oleh ' . (Auth::user()->name ?? 'Pengguna Tidak Dikenal') . '.',
                [
                    'method_name' => $validatedData['method_name'],
                    'description' => $validatedData['description'],
                    'base_cost' => $validatedData['base_cost'],
                    'cost_per_km' => $validatedData['cost_per_km'],
                    'is_pickup' => $validatedData['is_pickup'],
                    'is_active' => $validatedData['is_active'],
                    'created_by_user_id' => Auth::id(),
                    'request_data' => $validatedData,
                ]
            );
            // ---- End Log ---- //

            return redirect()->route('admin.delivery-method.index')->with('success', 'Metode pengiriman berhasil dibuat.');
        } catch (Exception $e) {
            return redirect()->route('admin.delivery-method.index')->with('error', 'Metode pengiriman gagal dibuat.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DeliveryMethod $deliveryMethod)
    {
        return view('admin.delivery-method.edit', compact('deliveryMethod'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DeliveryMethod $deliveryMethod)
    {
        $validatedData = $this->validateDeliveryMethod($request, $deliveryMethod->id);

        try {
            $deliveryMethod->update($validatedData);

            // ---- Catat Aktivitas ke SystemLog ---- //
            SystemLog::log(
                LogLevel::INFO->value,
                'DELIVERY_METHOD_UPDATED',
                'Metode pengiriman "' . $deliveryMethod->method_name . '" telah berhasil diperbarui oleh ' . (Auth::user()->name ?? 'Pengguna Tidak Dikenal') . '.',
                [
                    'method_name' => $validatedData['method_name'],
                    'description' => $validatedData['description'],
                    'base_cost' => $validatedData['base_cost'],
                    'cost_per_km' => $validatedData['cost_per_km'],
                    'is_pickup' => $validatedData['is_pickup'],
                    'is_active' => $validatedData['is_active'],
                    'updated_by_user_id' => Auth::id(),
                    'request_data' => $validatedData,
                ]
            );
            // ---- End Log ---- //

            return redirect()->route('admin.delivery-method.index')->with('success', 'Metode pengiriman berhasil diperbarui.');
        } catch (Exception $e) {
            return redirect()->route('admin.delivery-method.index')->with('error', 'Metode pengiriman gagal diperbarui.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
