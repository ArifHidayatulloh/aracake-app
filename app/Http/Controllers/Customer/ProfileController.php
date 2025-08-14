<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
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
            'is_default' => 'boolean',
        ]);

        // Jika dijadikan default, nonaktifkan default sebelumnya
        if ($request->is_default) {
            Auth::user()->addresses()->update(['is_default' => false]);
        }

        $address = Auth::user()->addresses()->create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Alamat berhasil ditambahkan',
            'address' => $address
        ]);
    }
}
