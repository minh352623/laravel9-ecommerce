@extends('layouts.client')

@section('title')
    <title>Giỏ hàng</title>
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
            Shoping Cart
        </span>
    </div>
</div>
<!-- Shoping Cart -->
<style>
    .column-0{
        width: 5%;
        max-width: 5%;

        padding-right: 20px;
    }
    .table-shopping-cart .column-1{
        padding-left: 20px;
    }
    .remove-item:hover{
        color: red;
        cursor: pointer;
        transform:scale(1.2);
    }
</style>

<form action="{{route('features.checkout')}}" method="POST" class="form-checkout bg0 p-t-75 p-b-85">

    @csrf
    <div class="container">
      
        <div class="row">
            <div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
             
                <div class="m-l-25 m-r--38 m-lr-0-xl">
                    <h2 class="message-check font-weight-bold mb-2">Đặt hàng thành công!</h2>
                    <p class="title-check text-success mb-3">Cảm ơn quý khách đã tin tưởng và đặt hàng của chúng tôi!</p>
                    <div class="wrap-table-shopping-cart">
                        <table class="table-shopping-cart">
                            <thead class="table_head">
                                <th class="column-1">Product</th>
                                <th class="column-2"></th>
                                <th class="column-3">Price</th>
                                <th class="column-4">Quantity</th>
                                <th class="column-5">Total</th>

                            </thead>
                            <tbody class="tbody-shopping">
                                @php
                                    $sum =0;
                                @endphp
                                @if ($bill->detailBill)
                            
                                    @foreach ($bill->detailBill as $item)
                                        @php
                                            $sum+=(float)($item->total);
                                        @endphp
                                        <tr class="table_row">
                                            <td class="column-1">
                                                <div class="how-itemcart1">
                                                    <img src="{{asset($item->image)}}" alt="IMG">
                                                </div>
                                            </td>
                                            <td class="column-2">{{$item->name_pro}}</td>
                                            <td class="column-3">$ {{$item->price}}</td>
                                            <td class="column-4">
                                                <div class="wrap-num-product flex-w m-l-auto m-r-0" data-id={{$item->id}}>
                                                    {{-- <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m" data-url="{{route('cart.add')}}">
                                                        <i class="fs-16 zmdi zmdi-minus"></i>
                                                    </div> --}}
            
                                                    <input class="mtext-104 cl3 txt-center num-product" type="number" name="num-product-{{$item->id}}" value="{{$item->number}}">
            
                                                    {{-- <div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m" data-url="{{route('cart.add')}}">
                                                        <i class="fs-16 zmdi zmdi-plus"></i>
                                                    </div> --}}
                                                </div>
                                            </td>
                                            <td class="column-5">$ {{$item->total}}</td>

                                        </tr>
                                    @endforeach
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

            <div class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50">
                <div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm">
                    <h4 class="mtext-109 cl2 p-b-30">
                        Cart Totals
                    </h4>

                    <div class="flex-w flex-t bor12 p-b-13">
                        <div class="size-208">
                            <span class="stext-110 cl2">
                                Subtotal:
                            </span>
                        </div>

                        <div class="size-209">
                            <span class="mtext-110 cl2 cart-sum-page">
                                ${{$sum?$sum:0}}
                            </span>
                        </div>
                    </div>

                    <div class="flex-w flex-t bor12 p-t-15 p-b-30">
                        <div class="size-208 w-full-ssm">
                            <span class="stext-110 cl2">
                                Shipping:
                            </span>
                        </div>

                        <div class="size-209 p-r-18 p-r-0-sm w-full-ssm">
                            <p class="stext-111 cl6 p-t-2">
                                There are no shipping methods available. Please double check your address, or contact us if you need any help.
                            </p>
                            
                            <div class="p-t-15">
                                <span class="stext-112 cl8">
                                    Calculate Shipping
                                </span>

                                <div class="rs1-select2 rs2-select2 bor8 bg0 m-b-12 m-t-9">
                                    <select class="js-select2" name="time" disabled>
                                        <option value ="0">Select a country...</option>
                                        <option value="vietnam" {{$bill->country == 'vietname' ? 'selected':false}}>Việt Nam</option>
                                        <option value="usa" {{$bill->country == 'usa' ? 'selected':false}}>USA</option>
                                        <option value="uk" {{$bill->country == 'uk' ? 'selected':false}}>UK</option>

                                    </select>

                                    <div class="dropDownSelect2"></div>
                                    <style>
                                        .error{

                                        }
                                    </style>
                                   
                                </div>
                                <div class="text-danger error-country ">

                                </div>
                                <div class="bor8 bg0 m-b-12">
                                    <input class="stext-111 cl8 plh3 size-111 p-lr-15" disabled value="{{$bill->address}}" type="text" name="address" placeholder="Address">
                                   
                                </div>
                                <div class="text-danger error-address ">

                                </div>

                                <div class="bor8 bg0 m-b-22">
                                    <input class="stext-111 cl8 plh3 size-111 p-lr-15" disabled value="{{$bill->tel}}" type="text" name="phone" placeholder="phone">
                                 
                                </div>
                                <div class="text-danger error-phone ">

                                </div>
                                {{-- <div class="flex-w">
                                    <div class="flex-c-m stext-101 cl2 size-115 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer">
                                        Update Totals
                                    </div>
                                </div> --}}
                                    
                            </div>
                        </div>
                    </div>

                    <div class="flex-w flex-t p-t-27 p-b-33">
                        <div class="size-208">
                            <span class="mtext-101 cl2">
                                Total:
                            </span>
                        </div>

                        <div class="size-209 p-t-1">
                            <span class="mtext-110 cl2 cart-sum-page">
                                ${{$sum?$sum:0}}
                            </span>
                        </div>
                    </div>

                    {{-- <button type="submit" class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">
                        Proceed to Checkout
                    </button> --}}
                </div>
            </div>
        </div>
    </div>
</form>

@endsection
@section('js')
<script>
    $(".js-select2").each(function(){
        $(this).select2({
            minimumResultsForSearch: 20,
            dropdownParent: $(this).next('.dropDownSelect2')
        });
    })
</script>
<script>
    $('.js-pscroll').each(function(){
        $(this).css('position','relative');
        $(this).css('overflow','hidden');
        var ps = new PerfectScrollbar(this, {
            wheelSpeed: 1,
            scrollingThreshold: 1000,
            wheelPropagation: false,
        });

        $(window).on('resize', function(){
            ps.update();
        })
    });
</script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
      /*==================================================================
         [ +/- num product ]*/
        let container = document.querySelector('.header-cart-wrapitem');
	    let headerCartTotal = document.querySelector('.header-cart-total');
        let numberCart = document.querySelectorAll('.js-show-cart');
        let cartSumPage  = document.querySelectorAll('.cart-sum-page');

        let bodyShopping = document.querySelector('.tbody-shopping');

        function redderItemCart(item){
		let template = `
					<li class="header-cart-item flex-w flex-t m-b-12">
							<div class="header-cart-item-img">
								<img src="${item.feature_image_path}" alt="IMG">
							</div>

							<div class="header-cart-item-txt p-t-8">
								<a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
									${item.name}
								</a>

								<span class="header-cart-item-info">
									${item.number} x$ ${item.price}
								</span>
							</div>
						</li>
		`;

		container.insertAdjacentHTML('beforeend',template);
	}

    bodyShopping.addEventListener('click',function(e){
        if(e.target.matches('.btn-num-product-down')){

             var numProduct = Number(e.target.nextElementSibling.value);
             let url = e.target.dataset.url;
             let urlRemove  =e.target.parentElement.parentElement.nextElementSibling.nextElementSibling.dataset.url;
             if (numProduct > 1)
                e.target.nextElementSibling.value = numProduct - 1;

            let id = e.target.parentElement.dataset.id;
            let number = -1;

            $.ajaxSetup({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
			});
             $.ajax({
					url: url,
					type: "POST",
					data:{
                        id:id,
                        number:+number
                    },
					dataType: "json",
					success: function (response) {
						console.log(response);
						let count = 0;
						let sumMoney = 0;
						container.innerHTML = '';
                        bodyShopping.innerHTML = '';

						response.forEach((item,index)=>{
                            item.total = +(item.total).toFixed(2);
							count +=+item.number;
							sumMoney+=(+item.price)*(+item.number);
							redderItemCart(item);
                            renderItemCartPage(item,urlRemove,url);

						})
						headerCartTotal.textContent = 'Total: $ '+sumMoney.toFixed(2);
                        cartSumPage.forEach((item,key)=>{
                            if(key ==0){

                                item.textContent = '$'+sumMoney.toFixed(2);
                            }else{
                                item.textContent = '$'+sumMoney.toFixed(2);

                            }
                        })
						numberCart.forEach((item)=>{
							item.dataset.notify = count;

						})
						// swal(nameProduct, "is added to cart !", "success");
					},
					error: function(e){
						console.log('lỗi');
					}
			})	
             
     

        }else if(e.target.matches('.btn-num-product-up')){
            var numProduct = Number(e.target.previousElementSibling.value);
             let url = e.target.dataset.url;
             let urlRemove  =e.target.parentElement.parentElement.nextElementSibling.nextElementSibling.dataset.url;

            e.target.previousElementSibling.value = numProduct +1;


            let id = e.target.parentElement.dataset.id;
            let number = 1;

            $.ajaxSetup({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
			});
             $.ajax({
					url: url,
					type: "POST",
					data:{
                        id:id,
                        number:+number
                    },
					dataType: "json",
					success: function (response) {
						console.log(response);
						let count = 0;
						let sumMoney = 0;
						container.innerHTML = '';
                        bodyShopping.innerHTML = '';

						response.forEach((item,index)=>{
                            item.total = +(item.total).toFixed(2);

							count +=+item.number;
							sumMoney+=(+item.price)*(+item.number);
							redderItemCart(item);
                            renderItemCartPage(item,urlRemove,url);

						})
						headerCartTotal.textContent = 'Total: $ '+sumMoney.toFixed(2);
                        cartSumPage.forEach((item,key)=>{
                            if(key ==0){

                                item.textContent = '$'+sumMoney.toFixed(2);
                            }else{
                                item.textContent = '$'+sumMoney.toFixed(2);

                            }
                        })
						numberCart.forEach((item)=>{
							item.dataset.notify = count;

						})
						// swal(nameProduct, "is added to cart !", "success");
					},
					error: function(e){
						console.log('lỗi');
					}
			})	


        }
    })

         //remove item
         let table = document.querySelector('.table-shopping-cart');
         function renderItemCartPage(item,urlRemove,urlButton){
            let template = `
                    <tr class="table_row">
                                        <td class="column-1">
                                            <div class="how-itemcart1">
                                                <img src="${item.feature_image_path}" alt="IMG">
                                            </div>
                                        </td>
                                        <td class="column-2">${item.name}</td>
                                        <td class="column-3">$ ${item.price}</td>
                                        <td class="column-4">
                                            <div class="wrap-num-product flex-w m-l-auto m-r-0" data-id="${item.id}">
                                                <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m" data-url="${urlButton}">
                                                    <i class="fs-16 zmdi zmdi-minus"></i>
                                                </div>
        
                                                <input class="mtext-104 cl3 txt-center num-product" type="number" name="num-product1" value="${item.number}">
        
                                                <div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m" data-url="${urlButton}">
                                                    <i class="fs-16 zmdi zmdi-plus"></i>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="column-5">$ ${item.total}</td>
                                        <td class="column-0" data-url="${urlRemove}" data-id="${item.id}" style="text-align:center"><i style="font-size:25px;" class="remove-item fa fa-trash" aria-hidden="true"></i></td>

                    </tr>
            
            `;
            bodyShopping.insertAdjacentHTML('beforeend',template);
         }

         let iconRemove = document.querySelectorAll('.remove-item');

         function handleRemoveItem(e){
            e.preventDefault();
            if(e.target.matches('.remove-item')){
            console.log(e.target.parentElement);
            let id = e.target.parentElement.dataset.id;
            // let url = ($(this).parent().data('url'));
            let url = e.target.parentElement.dataset.url;
            let urlButton = e.target.parentElement.parentElement.querySelector('.btn-num-product-down').dataset.url;
            $.ajaxSetup({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
			});
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                })
                .then((result) => {

                if (result.isConfirmed) {
                    console.log($(this).attr('href'));
                    $.ajax({
					url: url,
					type: "POST",
					data:{
                        id:id,
                    },
					dataType: "json",
					success: function (response) {
						console.log(response);
						let count = 0;
						let sumMoney = 0;
						container.innerHTML = '';
                        bodyShopping.innerHTML = '';
						response.forEach((item,index)=>{
                            item.total = +(item.total).toFixed(2);
							count +=+item.number;
							sumMoney+=(+item.price)*(+item.number);
							redderItemCart(item);
                            renderItemCartPage(item,url,urlButton);
						})
						headerCartTotal.textContent = 'Total: $ '+sumMoney.toFixed(2);
                        cartSumPage.forEach((item,key)=>{
                            if(key ==0){

                                item.textContent = '$'+sumMoney.toFixed(2);
                            }else{
                                item.textContent = '$'+sumMoney.toFixed(2);

                            }
                        })
						numberCart.forEach((item)=>{
							item.dataset.notify = count;

						})
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                            );
					},
					error: function(e){
						console.log('lỗi');
					}
			    })	
                
                }
                })
            }
         
        }
        table.addEventListener('click',handleRemoveItem);
</script>



@endsection