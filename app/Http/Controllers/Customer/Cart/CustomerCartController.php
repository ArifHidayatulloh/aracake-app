<?php

namespace App\Http\Controllers\Customer\Cart;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\DeliveryMethod;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\SystemSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerCartController extends Controller
{
    // app/Http/Controllers/Customer/CartController.php

    public function cart()
    {
        $cart = Auth::user()->cart;

        // Inisialisasi variabel untuk subtotal dan total item
        $subtotal = 0;
        $totalItems = 0;

        $cartItems = $cart ? $cart->items()
            ->whereHas('product', function ($q) {
                $q->where('is_active', true)->where('is_available', true);
            })
            ->with(['product'])
            ->get() : collect();


        // Loop untuk menghitung subtotal dan total item
        foreach ($cartItems as $item) {
            $subtotal += $item->product->price * $item->quantity;
            $totalItems += $item->quantity;
        }

        $deliveryMethod = DeliveryMethod::orderBy('created_at', 'desc')->get();
        $paymentMethod = PaymentMethod::orderBy('created_at', 'desc')->get();
        $min_preparation_days = (int) SystemSetting::where('setting_key', 'min_preparation_days')->value('setting_value');

        // Kirim semua variabel yang diperlukan ke view
        return view('customer.cart.cart', compact('cart', 'cartItems', 'deliveryMethod', 'paymentMethod', 'min_preparation_days', 'subtotal', 'totalItems'));
    }

    public function addToCart(Request $request, Product $product)
    {
        $cart = Auth::user()->cart()->firstOrCreate([]);
        $quantity = $request->input('quantity', 1);

        $cartItem = $cart->items()->where('product_id', $product->id)->first();

        if ($cartItem) {
            // Jika ada, perbarui kuantitas
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            // Jika tidak ada, buat item baru
            $cartItem = new CartItem();
            $cartItem->cart_id = $cart->id;
            $cartItem->product_id = $product->id;
            $cartItem->quantity = $quantity;
            $cartItem->save();
        }

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function updateQuantity(Request $request, CartItem $cartItem)
    {
        // Pastikan item keranjang yang diperbarui adalah milik pengguna yang sedang login
        if ($cartItem->cart->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        // Validasi input
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // Perbarui kuantitas
        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return response()->json(['success' => true, 'message' => 'Kuantitas berhasil diperbarui']);
    }

    public function removeFromCart(CartItem $cartItem)
    {
        // Pastikan item yang dihapus adalah milik pengguna yang sedang login
        if ($cartItem->cart->user_id !== Auth::id()) {
            return redirect()->route('cart.index')->with('error', 'Item tidak valid.');
        }

        $cartItem->delete();

        return redirect()->back()->with('success', 'Produk berhasil dihapus dari keranjang.');
    }
}
