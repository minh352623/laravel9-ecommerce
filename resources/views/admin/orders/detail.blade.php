@extends('layouts.admin')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Chi tiết đơn hàng</h1>
</div>
@if (session('msg'))
<div class="alert alert-success">
{{session('msg')}}
</div>
    
@endif
<div class="row">
    <div class="col-lg-12">
        <style>
            .frmcontent,
             .container-info-user{
                box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
                padding:12px;
                border-radius:12px;
                margin:12px 0;
             }
            .container-info-user > div{
                display:flex;
                gap:0 12px;
                align-items: center;
                margin:8px 0;
            }
        </style>
        <form class="container-info-user" method="post" action="{{route('admin.orders.changeStatus')}}">
            @csrf
            <div>
                <span>
                    Khách hàng:
                </span>
                <span>{{$order->user->name}}</span>
            </div>
            <div>
                <span>
                    Sô điện thoại:
                </span>
                <span>{{$order->tel}}</span>
            </div>
            <div>
                <span>
                    Địa chỉ:
                </span>
                <span>{{$order->address}}</span>
            </div>
          
            <div>
                <span>
                    Tổng đơn:
                </span>
                <span>${{$order->total}}</span>
            </div>
            <div >
                <span>
                    Ngày đặt:
                </span>
                <span>{{$order->created_at}}</span>
            </div>
            <div class="d-flex gap-3">
                <span>
                    Trạng thái:
                </span>
                <select name="bill_status" style="width:200px" class="form-select" aria-label="Default select example">
                    <option value="0" class="text-warning  border-warning" {{$order->status == 0 ? 'selected':false}}>Đang chờ duyệt</option>
                    <option value="1" class="text-success  border-success" {{$order->status == 1 ? 'selected':false}}>Đang giao hàng</option>
                    <option value="2" class="text-primary  border-peimary" {{$order->status == 2 ? 'selected':false}}>Đã nhận hàng</option>
                </select>

            </div>
            <div class="d-flex justify-content-end mt-3">
                <input type="hidden" name="id" value="{{$order->id}}">
                <input type="submit" class="btn btn-primary bg-primary px-3" name="update_bill" value="Cập nhật">
            </div>
        </form>
    </div>
    <div class="col-lg-12">
        <div class="row frmcontent rounded m-auto">
            <div class="row mb10 frmdsloai m-auto rounded">
                <table class="table">
                    <tbody>
                    <tr class="rounded ">
                        <th width="25%">HÌNH SẢN PHẨM</th>
                        <th>TÊN SẢN PHẨM</th>
                        <th>GIÁ </th>
                        <th>SỐ LƯỢNG </th>
                        <th>TỔNG TIỀN</th>

                    </tr>
                    @if ($order->detailBill->count()>0)
                        @foreach ($order->detailBill as $item)
                            <tr>
                                <td class="admin_hinh d-flex gap-3">
                                    <img style="width:80px" src="{{$item->image}}">
        
                                </td>
                                <td>{{$item->name_pro}}</td>
                                <td>{{$item->price}}</td>
                                <td>{{$item->number}}</td>
                                <td>{{$item->total}}</td>
        
        
                        
                            </tr>
                        @endforeach
                    @endif
                    
              

                </tbody></table>
            </div>
            <!-- <div class=" row mb10">
                        <input type="button" value="Chọn tất cả" />
                        <input type="button" value="Bỏ chọn tất cả" />
                        <input type="button" value="Xóa các mục đã chọn" />
            </div> -->
        </div>
    </div>
</div>
@endsection