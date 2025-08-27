<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function storeAddress(Request $request)
    {
        $validated = $request->validate([
            'address_line1' => 'required|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
        ]);

        // Cek apakah is_default dicentang. Jika tidak, nilainya akan false.
        $isDefault = $request->has('is_default');

        // Jika alamat baru dijadikan default, nonaktifkan alamat default sebelumnya
        if ($isDefault) {
            Auth::user()->addresses()->update(['is_default' => false]);
        }

        // Gabungkan data yang sudah divalidasi dengan nilai is_default
        $addressData = array_merge($validated, ['is_default' => $isDefault]);

        // Buat alamat baru dengan data yang sudah lengkap
        $address = Auth::user()->addresses()->create($addressData);

        return response()->json([
            'success' => true,
            'message' => 'Alamat berhasil ditambahkan',
            'address' => $address
        ]);
    }

    public function destroyAddress(UserAddress $address)
    {
        // Pastikan alamat yang akan dihapus milik pengguna yang sedang login
        if ($address->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak berhak menghapus alamat ini.'
            ], 403); // HTTP 403 Forbidden
        }

        // Perbarui kolom 'is_active' menjadi false
        $address->is_active = false;
        $address->save();

        // Atau jika Anda sudah menyertakan 'is_active' di $fillable model:
        // $address->update(['is_active' => false]);

        return response()->json([
            'success' => true,
            'message' => 'Alamat berhasil dinonaktifkan.'
        ]);
    }
}
