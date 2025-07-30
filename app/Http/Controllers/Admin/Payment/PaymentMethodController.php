<?php

namespace App\Http\Controllers\Admin\Payment;

use App\Enums\LogLevel;
use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use App\Models\SystemLog;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentMethodController extends Controller
{
    private function validatePaymentMethod(Request $request, $paymentMethodId = null)
    {
        $rules = [
            'method_name' => 'required|unique:payment_methods,method_name,' . $paymentMethodId,
            'account_details' => 'required',
            'is_active' => 'required',
        ];

        $messages = [
            'method_name.unique' => 'Metode pembayaran sudah ada.',
            'method_name.required' => 'Nama metode wajib diisi.',
            'account_details.required' => 'Detail akun wajib diisi.',
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

        $paymentMethodQuery = PaymentMethod::query();

        if (!empty($searchParam)) {
            $paymentMethodQuery->where('method_name', 'like', '%' . $searchParam . '%');
        }

        // Only apply is_active filter if it's explicitly set (0 or 1)
        if (!is_null($isActiveParam)) {
            // Cast to boolean if it comes as '0' or '1' string
            $paymentMethodQuery->where('is_active', (bool) $isActiveParam);
        }

        // Pass the normalized parameters to appends to maintain filters in pagination links
        $paymentMethods = $paymentMethodQuery->paginate(10)->appends([
            'search' => $searchParam,
            'is_active' => $isActiveParam,
        ]);

        return view('admin.payment-method.index', compact('paymentMethods'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.payment-method.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $this->validatePaymentMethod($request);

        try {
            PaymentMethod::create($validatedData);

            // ---- Catat Aktivitas ke SystemLog ---- //
            SystemLog::log(
                LogLevel::INFO->value,
                'PAYMENT_METHOD_CREATED',
                'Metode pembayaran baru telah berhasil dibuat oleh ' . (Auth::user()->name ?? 'Pengguna Tidak Dikenal') . '.',
                [
                    'method_name' => $validatedData['method_name'],
                    'account_details' => $validatedData['account_details'],
                    'is_active' => $validatedData['is_active'],
                    'created_by_user_id' => Auth::id(),
                    'request_data' => $validatedData,
                ]
            );
            // ---- End Log ---- //

            return redirect()->route('admin.payment-method.index')->with('success', 'Metode pembayaran berhasil dibuat.');
        } catch (Exception $e) {
            return redirect()->route('admin.payment-method.index')->with('error', 'Terjadi kesalahan saat membuat metode pembayaran.');
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
    public function edit(PaymentMethod $paymentMethod)
    {
        return view('admin.payment-method.edit', compact('paymentMethod'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        $validatedData = $this->validatePaymentMethod($request, $paymentMethod->id);

        try {
            $paymentMethod->update($validatedData);

            // ---- Catat Aktivitas ke SystemLog ---- //
            SystemLog::log(
                LogLevel::INFO->value,
                'PAYMENT_METHOD_UPDATED',
                'Metode pembayaran "' . $paymentMethod->method_name . '" telah berhasil diperbarui oleh ' . (Auth::user()->name ?? 'Pengguna Tidak Dikenal') . '.',
                [
                    'method_name' => $validatedData['method_name'],
                    'account_details' => $validatedData['account_details'],
                    'is_active' => $validatedData['is_active'],
                    'updated_by_user_id' => Auth::id(),
                    'request_data' => $validatedData,
                ]
            );
            // ---- End Log ---- //

            return redirect()->route('admin.payment-method.index')->with('success', 'Metode pembayaran berhasil diperbarui.');
        } catch (Exception $e) {
            return redirect()->route('admin.payment-method.index')->with('error', 'Terjadi kesalahan saat memperbarui metode pembayaran.');
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
