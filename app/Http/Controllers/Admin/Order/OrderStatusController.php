<?php

namespace App\Http\Controllers\Admin\Order;

use App\Enums\LogLevel;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\SystemLog;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderStatusController extends Controller
{

    private function validateOrderStatus(Request $request, $orderStatusId = null)
    {
        $rules = [
            'status_name' => 'required|unique:order_statuses,status_name,' . $orderStatusId,
            'description' => 'nullable',
            'status_color' => 'required',
            'is_active' => 'required',
        ];

        $messages = [
            'status_name.unique' => 'Status pesanan sudah ada.',
            'status_name.required' => 'Nama status wajib diisi.',
            'status_color.required' => 'Warna status wajib diisi.',
            'is_active.required' => 'Status wajib diisi.',
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

        $orderStatusQuery = OrderStatus::query();

        if (!empty($searchParam)) {
            $orderStatusQuery->where('status_name', 'like', '%' . $searchParam . '%');
        }

        // Only apply is_active filter if it's explicitly set (0 or 1)
        if (!is_null($isActiveParam)) {
            // Cast to boolean if it comes as '0' or '1' string
            $orderStatusQuery->where('is_active', (bool) $isActiveParam);
        }

        // Pass the normalized parameters to appends to maintain filters in pagination links
        $orderStatuses = $orderStatusQuery->orderBy('order', 'asc')->paginate(10)->appends([
            'search' => $searchParam,
            'is_active' => $isActiveParam,
        ]);

        return view('admin.order-status.index', compact('orderStatuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.order-status.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $this->validateOrderStatus($request);

        try {
            OrderStatus::create($validatedData);

            // ---- Catat Aktivitas ke SystemLog ---- //
            SystemLog::log(
                LogLevel::INFO->value,
                'ORDER_STATUS_CREATED',
                'Status pesanan baru telah berhasil dibuat oleh ' . (Auth::user()->name ?? 'Pengguna Tidak Dikenal') . '.',
                [
                    'status_name' => $validatedData['status_name'],
                    'description' => $validatedData['description'],
                    'status_color' => $validatedData['status_color'],
                    'is_active' => $validatedData['is_active'],
                    'created_by_user_id' => Auth::id(),
                    'request_data' => $validatedData,
                ]
            );
            // ---- End Log ---- //
            return redirect()->route('admin.order-status.index')->with('success', 'Status pesanan berhasil dibuat.');
        } catch (Exception $e) {
            return redirect()->route('admin.order-status.index')->with('error', 'Terjadi kesalahan saat membuat status pesanan.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OrderStatus $orderStatus)
    {
        return view('admin.order-status.edit', compact('orderStatus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OrderStatus $orderStatus)
    {
        $validatedData = $this->validateOrderStatus($request, $orderStatus->id);

        try {
            $orderStatus->update($validatedData);

            // ---- Catat Aktivitas ke SystemLog ---- //
            SystemLog::log(
                LogLevel::INFO->value,
                'ORDER_STATUS_UPDATED',
                'Status pesanan "' . $orderStatus->status_name . '" telah berhasil diperbarui oleh ' . (Auth::user()->name ?? 'Pengguna Tidak Dikenal') . '.',
                [
                    'status_name' => $validatedData['status_name'],
                    'description' => $validatedData['description'],
                    'status_color' => $validatedData['status_color'],
                    'is_active' => $validatedData['is_active'],
                    'updated_by_user_id' => Auth::id(),
                    'request_data' => $validatedData,
                ]
            );
            // ---- End Log ---- //

            return redirect()->route('admin.order-status.index')->with('success', 'Status pesanan berhasil diperbarui.');
        } catch (Exception $e) {
            return redirect()->route('admin.order-status.index')->with('error', 'Terjadi kesalahan saat memperbarui status pesanan.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrderStatus $orderStatus)
    {

    }
}
