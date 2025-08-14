<?php

namespace App\Http\Controllers\Customer\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class CustomerProductController extends Controller
{
    public function productList(Request $request)
    {
        // Get active categories for filter
        $categories = ProductCategory::where('is_active', true)
            ->orderBy('name', 'asc')
            ->get();

        // Get filter parameters
        $category = $request->get('category');
        $search = $request->get('search');
        $sort = $request->get('sort');

        // Base query for products
        $products = Product::where('is_active', true)
            ->where('is_available', true)
            ->with(['category', 'images', 'orderItems']);

        // Apply category filter
        if ($category && $category !== '') {
            $products->where('category_id', $category);
        }

        // Apply search filter
        if ($search && $search !== '') {
            $products->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        // Apply sorting
        if ($sort && in_array($sort, ['asc', 'desc'])) {
            $products->orderBy('price', $sort);
        } else {
            // Default sorting
            $products->orderBy('is_recommended', 'desc')
                ->orderBy('created_at', 'desc');
        }

        // Paginate results (preserve query parameters)
        $products = $products->paginate(12)->withQueryString();

        return view('customer.product.product-list', compact('categories', 'products'));
    }

    public function show(Product $product)
    {
        // Check if product is active and available for viewing
        if (!$product->is_active) {
            abort(404, 'Product not found');
        }

        // Load relationships with proper ordering for images
        $product->load([
            'category',
            'images' => function ($query) {
                $query->orderBy('sort_order', 'asc')->orderBy('created_at', 'asc');
            },
            'orderItems' // For counting orders
        ]);

        // Get related products from the same category
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->where('is_available', true)
            ->with(['category', 'orderItems'])
            ->inRandomOrder()
            ->limit(4)
            ->get();

        // You might want to track product views here
        // $this->trackProductView($product);

        return view('customer.product.detail', compact('product', 'relatedProducts'));
    }
}
