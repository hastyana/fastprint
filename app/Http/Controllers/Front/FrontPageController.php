<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class FrontPageController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::where('status_id', 1)->get();
        return view('front.content.index', [
            'products' => $products
    ]);
    }
}
