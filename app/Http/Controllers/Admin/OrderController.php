<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    //
    const PER_PAGE = 5;
    public function index(Request $request)
    {
        $bills = DB::table('bills')
            ->select('bills.*', 'users.name as name_user', 'users.email as email_user')
            ->join('users', 'users.id', '=', 'bills.user_id');
        if (!empty($request->keyword) || !empty($request->status)) {

            if (!empty($request->keyword)) {
                $keyword = $request->keyword;
                $bills = $bills->where(function ($query) use ($keyword) {
                    $query->orWhere('users.email', 'like', '%' . $keyword . '%');
                    $query->orWhere('users.name', 'like', '%' . $keyword . '%');
                });
            }
            if (!empty($request->status)) {
                $status = $request->status;
                if ($request->status == 3) {
                    $status = 0;
                }
                $bills = $bills->where('status', $status);
            }
            // dd($bills);
        }
        $bills = $bills->paginate(self::PER_PAGE);
        return view('admin.orders.lists', compact('bills'));
    }

    public function edit(Bill $order)
    {

        return view('admin.orders.detail', compact('order'));
    }

    public function changeStatus(Request $request)
    {
        $status = $request->bill_status;
        $id = $request->id;
        $bill = Bill::find($id);
        $bill->status = $status;
        $bill->save();
        return back()->with('msg', 'Cập nhật thành công');
    }
}
