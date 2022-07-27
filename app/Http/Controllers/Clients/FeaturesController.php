<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\BillDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeaturesController extends Controller
{
    //
    public function index()
    {
        return view('clients.features.features');
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'country' => ['required', function ($attribute, $value, $fail) {
                if ($value == 0) {
                    $fail('Vui lòng chọn quốc gia !');
                }
            }],
            'address' => 'required',
            'phone' => 'bail|required|min:10|numeric'

        ], [
            'country.required' => 'Quốc gia bắt buộc phải nhập!',
            'address.required' => 'Địa chỉ bắt buộc phải nhập!',
            'phone.min' => 'Số điện thoại phải là :min số!',
            'phone.required' => 'Số điện thoại bắt buộc phải nhập!',
            'phone.numeric' => 'Số điện thoại phải là số!',
        ]);
        $total = 0;
        if (session('cart')) {
            foreach (session('cart') as $item) {
                $total += (float)$item->total;
            }
        }
        $bill = new  Bill();

        $bill = $bill->create([
            'tel' => $request->phone,
            'address' => $request->address,
            'country' => $request->country,
            'total' => $total,
            'user_id' => Auth::user()->id
        ]);

        if (session('cart')) {
            foreach (session('cart') as $item) {
                $detailBill = new BillDetail();
                $detailBill->id_bill = $bill->id;
                $detailBill->id_pro = $item->id;
                $detailBill->number = (int)($item->number);
                $detailBill->total = $item->total;
                $detailBill->price = $item->price;
                $detailBill->image = $item->feature_image_path;
                $detailBill->name_pro = $item->name;
                $detailBill->save();
            }
        }

        $request->session()->forget('cart');
        return response()->json([
            'message' => 'Đặt hàng thành công!',
            'title' => 'Cảm ơn quý khách đã tin tưởng và đặt hàng của chúng tôi!',
            'href' => route('features.bill', $bill->id),
        ]);
    }

    function bill($id)
    {
        $bill = Bill::find($id);
        return view('clients.features.bill', compact('bill'));
    }

    public function mybill(Request $request)
    {
        if (Auth::check()) {
            $status = $request->query->get('status');
            // dd($status);
            if ($status != '') {
                $bills = Bill::where('user_id', Auth::user()->id)->where('status', $status)->get();
            } else {

                $bills = Bill::where('user_id', Auth::user()->id)->get();
            }
            return view('clients.features.mybill', compact('bills'));
        } else {
            return redirect()->route('login');
        }
    }


    public function delete($id)
    {
        if ($id > 0) {
            $detailBill = BillDetail::where('id_bill', $id)->get();
            if ($detailBill->count() > 0) {
                foreach ($detailBill as $item) {
                    BillDetail::destroy($item->id);
                }
            }
            Bill::destroy($id);
        }

        return back();
    }
}
