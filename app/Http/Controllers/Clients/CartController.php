<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    //

    public function add(Request $request)
    {
        // $request->session()->forget('cart');
        $item = Products::find($request->id);
        $cart = Session::get('cart');
        if (is_null($cart) || empty($cart)) {
            $item->number = $request->number;
            $item->total = (int)($request->number) * (float)($item->price);
            $cart = [];
            array_push($cart, $item);
        } else {
            $check = 0;
            if (!empty($cart)) {
                $itemNew = null;
                $keyNew = null;
                foreach ($cart as $key => $itemChild) {

                    if ((int)($itemChild->id) === (int)($request->id)) {
                        $itemChild->number = (int)($itemChild->number) + (int)$request->number;
                        $itemChild->total = (int)($itemChild->number) * (float)($item->price);
                        $itemNew = $itemChild;
                        $keyNew = $key;
                        $check = 1;
                        break;
                    }
                }
                if ($check === 1) {
                    $cart[$keyNew] = [];
                    $cart[$keyNew] = $itemNew;
                } else {
                    $item->number = $request->number;
                    $item->total = (int)($request->number) * $item->price;
                    array_push($cart, $item);
                }
            }
        }

        Session::put('cart', $cart);
        $cart = Session::get('cart');
        return response()->json($cart);
    }

    public function remove(Request $request)
    {
        $cart = Session::get('cart');
        if (is_null($cart)) {
        } else {
            if (!empty($cart)) {
                $keyRemove = -1;
                foreach ($cart as $key => $item) {
                    if ($item->id == $request->id) {
                        $keyRemove = $key;
                    }
                }
                if ($keyRemove > -1) {
                    array_splice($cart, $keyRemove, 1);
                }
            }
        }
        Session::put('cart', $cart);
        $cart = Session::get('cart');
        return response()->json($cart);
    }
}
