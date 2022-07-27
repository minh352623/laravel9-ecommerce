<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Comments;
use App\Models\Products;
use Illuminate\Http\Request;

class ProductClientController extends Controller
{
    const PER_PAGE = 12;
    //
    public function index()
    {

        $category = Category::all();
        $products = Products::orderBy('created_at', 'desc')->paginate(self::PER_PAGE);

        return  view('clients.products.product', compact('products', 'category'));
    }


    public function showProductGlobal($id, Request $request)
    {
        $data = [];

        $product = Products::find($id);
        $data[] = $product;
        $imageDetail = $product->images;
        $data[] = $imageDetail;

        // dd($product);
        return response()->json($data);
    }

    public function detail($id, Request $request)
    {
        $comments = Comments::where('product_id', $id)->orderBy('created_at', 'asc')->get();
        $product = Products::find($id);
        $listRelated  = Products::paginate(8);
        return view('clients.products.detail', compact('product', 'listRelated', 'comments'));
    }
}
