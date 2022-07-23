@extends('layouts.client')
@section('title')
    <title>Trang chủ</title>
@endsection
@section('header')
@include('clients.components.header')
	
@endsection
@section('content')
 






	<!-- Slider -->
	<section class="section-slide">
		<div class="wrap-slick1 rs2-slick1">
			<div class="slick1">
                @if ($slider->count()>0)
                    @foreach ($slider as $item)
                        <div class="item-slick1 bg-overlay1" style="background-image: url({{asset($item->image_path)}});" data-thumb="{{$item->image_path}}" data-caption="{{$item->name}}">
                            <div class="container h-full">
                                <div class="flex-col-c-m h-full p-t-100 p-b-60 respon5">
                                    <div class="layer-slick1 animated visible-false" data-appear="fadeInDown" data-delay="0">
                                        <span class="ltext-202 txt-center cl0 respon2">
                                           {{$item->name}}
                                        </span>
                                    </div>
                                        
                                    <div class="layer-slick1 animated visible-false" data-appear="fadeInUp" data-delay="800">
                                        <h2 class="ltext-104 txt-center cl0 p-t-22 p-b-40 respon1">
                                           {!!$item->description!!}
                                        </h2>
                                    </div>
                                        
                                    <div class="layer-slick1 animated visible-false" data-appear="zoomIn" data-delay="1600">
                                        <a href="{{route('product.index')}}" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn2 p-lr-15 trans-04">
                                            Shop Now
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    
                @endif
				
			</div>

			<div class="wrap-slick1-dots p-lr-10"></div>
		</div>
	</section>


	<!-- Banner -->
	<div class="sec-banner bg0 p-t-95 p-b-55">
		<div class="container">
			<div class="row">
				@if ($category->count()>0)
					@foreach ($category  as $key=>$item)
						@if ($key<2)
							<div class="col-md-6 p-b-30 m-lr-auto">
								<!-- Block1 -->
								<div class="block1 wrap-pic-w">
									<img src="{{asset($item->image)}}" alt="IMG-BANNER">
			
									<a href="{{route('product.index')}}" class="block1-txt ab-t-l s-full flex-col-l-sb p-lr-38 p-tb-34 trans-03 respon3">
										<div class="block1-txt-child1 flex-col-l">
											<span class="block1-name ltext-102 trans-04 p-b-8">
												{{$item->name}}
											</span>
			
											<span class="block1-info stext-102 trans-04">
												New Trend
											</span>
										</div>
			
										<div class="block1-txt-child2 p-b-4 trans-05">
											<div class="block1-link stext-101 cl0 trans-09">
												Shop Now
											</div>
										</div>
									</a>
								</div>
							</div>
						@else
						<div class="col-md-6 col-lg-4 p-b-30 m-lr-auto">
							<!-- Block1 -->
							<div class="block1 wrap-pic-w">
								<img src="{{asset($item->image)}}" alt="IMG-BANNER">
		
								<a href="{{route('product.index')}}" class="block1-txt ab-t-l s-full flex-col-l-sb p-lr-38 p-tb-34 trans-03 respon3">
									<div class="block1-txt-child1 flex-col-l">
										<span class="block1-name ltext-102 trans-04 p-b-8">
											{{$item->name}}
										</span>
		
										<span class="block1-info stext-102 trans-04">
											Spring 2018
										</span>
									</div>
		
									<div class="block1-txt-child2 p-b-4 trans-05">
										<div class="block1-link stext-101 cl0 trans-09">
											Shop Now
										</div>
									</div>
								</a>
							</div>
						</div>
						@endif
						
					
					@endforeach
				@endif
			</div>
		</div>
	</div>


    @include('clients.components.product')


	@include('clients.components.blog')
@endsection


@section('js')
    <!--===============================================================================================-->	

        <script>
            $(".js-select2").each(function(){
                $(this).select2({
                    minimumResultsForSearch: 20,
                    dropdownParent: $(this).next('.dropDownSelect2')
                });
            })
        </script>
  
        <script>
            $('.parallax100').parallax100();
        </script>
    <!--===============================================================================================-->
        <script>
            $('.gallery-lb').each(function() { // the containers for all your galleries
                $(this).magnificPopup({
                    delegate: 'a', // the selector for gallery item
                    type: 'image',
                    gallery: {
                        enabled:true
                    },
                    mainClass: 'mfp-fade'
                });
            });
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
    <!--===============================================================================================-->
    <script>


   /*==================================================================
    [ +/- num product ]*/
    $(".btn-num-product-down").on("click", function () {
        var numProduct = Number($(this).next().val());
        if (numProduct > 1)
            $(this)
                .next()
                .val(numProduct - 1);
    });

    $(".btn-num-product-up").on("click", function () {
        var numProduct = Number($(this).prev().val());
        $(this)
            .prev()
            .val(numProduct + 1);
    });
	/*---------------------------------------------*/
	let container = document.querySelector('.header-cart-wrapitem');
	let headerCartTotal = document.querySelector('.header-cart-total');
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
	$('.js-addcart-detail').each(function(){
		$(this).on('click', function(e){
				var nameProduct = e.target.parentElement.parentElement.parentElement.parentElement.querySelector('.js-name-detail').textContent;
				let numberCart = document.querySelectorAll('.js-show-cart');
				let id = e.target.dataset.id;
				let number = +(e.target.parentElement.querySelector('input').value);
				$.ajaxSetup({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
				});
				$.ajax({
					url: $(this).data('url'),
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

						response.forEach((item,index)=>{
							count +=+item.number;
							sumMoney+=(+item.price)*(+item.number);
							redderItemCart(item);

						})
						headerCartTotal.textContent = 'Total: $ '+sumMoney.toFixed(2);;
						numberCart.forEach((item)=>{
							item.dataset.notify = count;

						})
						swal(nameProduct, "is added to cart !", "success");
					},
					error: function(e){
						console.log('lỗi');
					}
				})
			});
		});
	</script>
@endsection