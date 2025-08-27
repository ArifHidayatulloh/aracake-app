<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\SystemSetting;
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

    public function about(){
        return view('about');
    }

    public function contact(){
        $setting = SystemSetting::where('is_active', true)->get()->keyBy('setting_key');
        return view('contact', compact('setting'));
    }
}
