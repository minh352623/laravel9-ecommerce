@extends('layouts.client')


@section('title')
    <title>Đơn hàng của tôi</title>
@endsection

@section('header')
@include('clients.components.headerV4')
	
@endsection

@section('content')
   <!-- breadcrumb -->
<div class="container">
    <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
        <a href="index.html" class="stext-109 cl8 hov-cl1 trans-04">
            Home
            <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
        </a>

        <span class="stext-109 cl4">
            My Bill
        </span>
    </div>
</div>

<form action="{{route('features.checkout')}}" method="POST" class="form-checkout bg0 p-t-75 p-b-85">

    @csrf
    <div class="container">
      
        <div class="row">
            <div class="col-lg-10 col-xl-12 m-lr-auto m-b-50">
                <div class="m-l-25 m-r--38 m-lr-0-xl">
                    <h5 class=" mb-3"><span class="text-warning">Attention:</span>  Deleting orders that are only valid for 24 hours after 24 hours cannot be deleted !</h5>
                    <div class="filter-bill d-flex gap-3">
                        <a href="{{route('features.mybill')}}" class="flex-c-m stext-101 text-light cl2 size-119 bg-dark  bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-10">
                            ALL
                        </a>
                        <a href="{{route('features.mybill')}}?status=0" class="flex-c-m mx-3 stext-101 cl2 size-119 bg-warning  bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-10">
                            WAITING
                        </a>    
                        <a href="{{route('features.mybill')}}?status=1" class="flex-c-m stext-101 cl2 size-119 bg-info  bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-10">
                            DELIVERY
                        </a>
                        <a href="{{route('features.mybill')}}?status=2" class="flex-c-m ml-3 stext-101 cl2 size-119 bg-success  bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-10">
                            DELIVERED
                        </a>
                    </div>
                    <div class="wrap-table-shopping-cart">
                        <style>
                            .table-shopping-cart .column-1{
                                width: 10%;
                            }
                            .table-shopping-cart .column-2{
                                width: 25%;
                            }
                            .table-shopping-cart .column-4{
                                width: 15%;
                                padding:0 30px;
                            }
                            .table-shopping-cart .column-5{
                                width: 20%;
                                text-align:center;
                            }
                            .table-shopping-cart .column-0{
                                width: 20%;
                            }
                            .table-shopping-cart .column-3{
                                padding-right: 50px;
                                text-align:end;
                                width: 10%;
                            }
                        </style>
                        <table class="table-shopping-cart w-100">
                            <thead class="table_head">
                                <th class="column-1">Id</th>
                                <th class="column-2">image</th>
                                <th class="column-4">Total</th>
                                <th class="column-5">Status</th>
                                <th class="column-0">Date</th>
                                <th class="column-3">Action</th>

                            </thead>
                            <style>
                                .bill-action.size-119{
                                    width: 100px;
                                    max-width: 100px;
                                    min-width: unset;
                                }
                            </style>
                            <tbody class="tbody-shopping">
                          
                                @if ($bills->count()>0)
                                    @php
                                        $now = date('Y-m-d H:i:s');
                                    @endphp
                                    @foreach ($bills as $item)
                                        @php
                                            
                                            $houseAgo = floor((strtotime($now)-strtotime($item->created_at))/3600)
                                        @endphp
                                        <tr class="table_row">
                                            <td class="column-1">
                                                {{$item->id}}
                                               
                                            </td>
                                            <td class="column-2">
                                                <div class="images d-flex">

                                                    @if ($item->detailBill)
                                                        @foreach ($item->detailBill as $value)
                                                            <div class="how-itemcart1">
                                                                <img src="{{asset($value->image)}}" alt="IMG">
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>

                                            </td>
                                            <td class="column-4">$ {{$item->total}}</td>
                                            <td class="column-5">
                                                <div class="flex-c-m stext-101 cl2 size-119 bg-{{$item->status == 0 ? 'warning': ($item->status == 1?'info':'success')}} bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-10">
                                                    {{getStatusBill($item->status)}}
                                                </div>
                                            </td>
                                            <td class="column-0">
                                                {{$item->created_at}}
                                                <br/>
                                                {{$houseAgo}} hours ago
                                            </td>
                                            
                                            <td class="column-3  gap-3" >
                                                <a href="{{route('features.bill',$item->id)}}" class="flex-c-m bill-action  stext-101 cl2 size-119 bg-info bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-10">
                                                   View
                                                </a>
                                                @if ($houseAgo >24)
                                                    <div disabled class="flex-c-m bill-action bill-action-false stext-101 cl2 size-119 bg-secondary bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-10">
                                                        Cancel
                                                    </div>
                                                    
                                                @else
                                                    <a href="{{route('features.delete',$item->id)}}"  class="flex-c-m bill-action bill-action-true  stext-101 cl2 size-119 bg-danger bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-10">
                                                        Cancel
                                                    </a>
                                                @endif
                                            </td>

                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6" class="text-secondary text-center py-5" >
                                            <span style="font-size:30px">You don't have any orders yet</span>

                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    {{-- <div class="flex-w flex-sb-m bor15 p-t-18 p-b-15 p-lr-40 p-lr-15-sm">
                        <div class="flex-w flex-m m-r-20 m-tb-5">
                            <input class="stext-104 cl2 plh4 size-117 bor13 p-lr-20 m-r-10 m-tb-5" type="text" name="coupon" placeholder="Coupon Code">
                                
                            <div class="flex-c-m stext-101 cl2 size-118 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-5">
                                Apply coupon
                            </div>
                        </div>

                        <div class="flex-c-m stext-101 cl2 size-119 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-10">
                            Update Cart
                        </div>
                    </div> --}}
                    <style>
                        .return-product{
                            width: 200px;
                        }
                    </style>
                    <a href="{{route('product.index')}}" class="flex-c-m stext-101 cl2 size-119 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-10 return-product">
                        <i class="fa fa-long-arrow-left mr-3" aria-hidden="true"></i>  Shop
                    </a>
                </div>
            </div>

            
        </div>
    </div>
</form>
@endsection

@section('js')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        let actoinFalse = document.querySelectorAll('.bill-action-false');
        let actoinTrue = document.querySelectorAll('.bill-action-true');
        console.log(actoinTrue);
        actoinFalse.forEach(item=>{
            item.addEventListener('click',function(){
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!',
                    footer: '<a href="">Why do I have this issue?</a>'
                });
            });

        });
        actoinTrue.forEach(item=>{
            item.addEventListener('click', function(e){
                // e.preventDefault();
                Swal.fire(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                );
            });

        });

    </script>

@endsection