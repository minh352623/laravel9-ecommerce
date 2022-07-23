<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Products;
use App\Models\Slider;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    const PER_PAGE = 8;
    public function index()
    {
        $slider = Slider::all();
        $category = Category::all();
        $products = Products::orderBy('created_at', 'desc')->paginate(self::PER_PAGE);
        return view('clients.home.home', compact('slider', 'category', 'products'));
    }
}
