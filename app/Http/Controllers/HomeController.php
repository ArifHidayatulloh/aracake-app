<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = ProductCategory::where('is_active', true)
            ->orderBy('name')
            ->get();

        $featuredProducts = Product::where('is_active', true)
            ->where('is_available', true)
            ->where('is_featured', true)
            ->with('category','images')
            ->limit(8)
            ->get();

        return view('home', compact('categories', 'featuredProducts'));
    }

    public function dashboard(){
        return view('admin.dashboard');
    }
}
