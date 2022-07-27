@extends('layouts.client')
@section('title')
    <title>{{$product->name}}</title>
@endsection
@section('header')
@include('clients.components.headerV4')
	
@endsection

@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.1/moment.min.js"></script>

<!-- breadcrumb -->
<div class="container">
    <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
        <a href="index.html" class="stext-109 cl8 hov-cl1 trans-04">
            Home
            <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
        </a>

        <a href="product.html" class="stext-109 cl8 hov-cl1 trans-04">
            {{$product->categories->name}}
            <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
        </a>

        <span class="stext-109 cl4">
            {{$product->name}}
        </span>
    </div>
</div>
	<!-- Product Detail -->
	<section class="sec-product-detail bg0 p-t-65 p-b-60">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-lg-7 p-b-30">
					<div class="p-l-25 p-r-30 p-lr-0-lg">
						<div class="wrap-slick3 flex-sb flex-w">
							<div class="wrap-slick3-dots"></div>
							<div class="wrap-slick3-arrows flex-sb-m flex-w"></div>
                           
							<div class="slick3 gallery-lb">
                                @if ($product->images)
                                    @foreach ($product->images as $item)
                                        <div class="item-slick3" data-thumb="{{$item->image_path}}">
                                            <div class="wrap-pic-w pos-relative">
                                                <img src="{{$item->image_path}}" alt="IMG-PRODUCT">
        
                                                <a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="{{$item->image_path}}">
                                                    <i class="fa fa-expand"></i>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
								{{-- <div class="item-slick3" data-thumb="images/product-detail-01.jpg">
									<div class="wrap-pic-w pos-relative">
										<img src="images/product-detail-01.jpg" alt="IMG-PRODUCT">

										<a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="images/product-detail-01.jpg">
											<i class="fa fa-expand"></i>
										</a>
									</div>
								</div>

								<div class="item-slick3" data-thumb="images/product-detail-02.jpg">
									<div class="wrap-pic-w pos-relative">
										<img src="images/product-detail-02.jpg" alt="IMG-PRODUCT">

										<a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="images/product-detail-02.jpg">
											<i class="fa fa-expand"></i>
										</a>
									</div>
								</div>

								<div class="item-slick3" data-thumb="images/product-detail-03.jpg">
									<div class="wrap-pic-w pos-relative">
										<img src="images/product-detail-03.jpg" alt="IMG-PRODUCT">

										<a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="images/product-detail-03.jpg">
											<i class="fa fa-expand"></i>
										</a>
									</div>
								</div> --}}
							</div>
						</div>
					</div>
				</div>
					
				<div class="col-md-6 col-lg-5 p-b-30">
					<div class="p-r-50 p-t-5 p-lr-0-lg">
						<h4 class="mtext-105 cl2 js-name-detail p-b-14">
							{{$product->name}}
						</h4>

						<span class="mtext-106 cl2">
							$ {{$product->price}}
						</span>

						<p class="stext-102 cl3 p-t-23">
							{!!$product->content!!}
						</p>
						
						<!--  -->
						<div class="p-t-33">
							<div class="flex-w flex-r-m p-b-10">
								<div class="size-203 flex-c-m respon6">
									Size
								</div>

								<div class="size-204 respon6-next">
									<div class="rs1-select2 bor8 bg0">
										<select class="js-select2" name="time">
											<option>Choose an option</option>
											<option>Size S</option>
											<option>Size M</option>
											<option>Size L</option>
											<option>Size XL</option>
										</select>
										<div class="dropDownSelect2"></div>
									</div>
								</div>
							</div>

							<div class="flex-w flex-r-m p-b-10">
								<div class="size-203 flex-c-m respon6">
									Color
								</div>

								<div class="size-204 respon6-next">
									<div class="rs1-select2 bor8 bg0">
										<select class="js-select2" name="time">
											<option>Choose an option</option>
											<option>Red</option>
											<option>Blue</option>
											<option>White</option>
											<option>Grey</option>
										</select>
										<div class="dropDownSelect2"></div>
									</div>
								</div>
							</div>

							<div class="flex-w flex-r-m p-b-10">
								<div class="size-204 flex-w flex-m respon6-next">
									<div class="wrap-num-product flex-w m-r-20 m-tb-10">
										<div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
											<i class="fs-16 zmdi zmdi-minus"></i>
										</div>

										<input class="mtext-104 cl3 txt-center num-product" type="number" name="num-product" value="1">

										<div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
											<i class="fs-16 zmdi zmdi-plus"></i>
										</div>
									</div>

									<button data-id={{$product->id}} data-url="{{route('cart.add')}}" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail">
										Add to cart
									</button>
								</div>
							</div>	
						</div>

						<!--  -->
						<div class="flex-w flex-m p-l-100 p-t-40 respon7">
							<div class="flex-m bor9 p-r-10 m-r-11">
								<a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 js-addwish-detail tooltip100" data-tooltip="Add to Wishlist">
									<i class="zmdi zmdi-favorite"></i>
								</a>
							</div>

							<a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100" data-tooltip="Facebook">
								<i class="fa fa-facebook"></i>
							</a>

							<a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100" data-tooltip="Twitter">
								<i class="fa fa-twitter"></i>
							</a>

							<a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100" data-tooltip="Google Plus">
								<i class="fa fa-google-plus"></i>
							</a>
						</div>
						<div class="p-t-20">
							<h4 class="mtext-112 cl2 p-b-27">
								Tags
							</h4>

							<div class="flex-w m-r--5">
								@if ($product->tags->count()>0)
									@foreach ($product->tags as $item)
										<a href="#" class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
											{{$item->name}}
										</a>
									@endforeach
								@endif
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="bor10 m-t-50 p-t-43 p-b-40">
				<!-- Tab01 -->
				<div class="tab01">
					<!-- Nav tabs -->
					<ul class="nav nav-tabs" role="tablist">
						<li class="nav-item p-b-10">
							<a class="nav-link active" data-toggle="tab" href="#description" role="tab">Description</a>
						</li>

						<li class="nav-item p-b-10">
							<a class="nav-link" data-toggle="tab" href="#information" role="tab">Additional information</a>
						</li>

						<li class="nav-item p-b-10">
							<a class="nav-link review-count" data-toggle="tab" href="#reviews" role="tab">Reviews ({{$comments->count()}})</a>
						</li>
					</ul>

					<!-- Tab panes -->
					<div class="tab-content p-t-43">
						<!-- - -->
						<div class="tab-pane fade show active" id="description" role="tabpanel">
							<div class="how-pos2 p-lr-15-md">
								<p class="stext-102 cl6">
									Aenean sit amet gravida nisi. Nam fermentum est felis, quis feugiat nunc fringilla sit amet. Ut in blandit ipsum. Quisque luctus dui at ante aliquet, in hendrerit lectus interdum. Morbi elementum sapien rhoncus pretium maximus. Nulla lectus enim, cursus et elementum sed, sodales vitae eros. Ut ex quam, porta consequat interdum in, faucibus eu velit. Quisque rhoncus ex ac libero varius molestie. Aenean tempor sit amet orci nec iaculis. Cras sit amet nulla libero. Curabitur dignissim, nunc nec laoreet consequat, purus nunc porta lacus, vel efficitur tellus augue in ipsum. Cras in arcu sed metus rutrum iaculis. Nulla non tempor erat. Duis in egestas nunc.
								</p>
							</div>
						</div>

						<!-- - -->
						<div class="tab-pane fade" id="information" role="tabpanel">
							<div class="row">
								<div class="col-sm-10 col-md-8 col-lg-6 m-lr-auto">
									<ul class="p-lr-28 p-lr-15-sm">
										<li class="flex-w flex-t p-b-7">
											<span class="stext-102 cl3 size-205">
												Weight
											</span>

											<span class="stext-102 cl6 size-206">
												0.79 kg
											</span>
										</li>

										<li class="flex-w flex-t p-b-7">
											<span class="stext-102 cl3 size-205">
												Dimensions
											</span>

											<span class="stext-102 cl6 size-206">
												110 x 33 x 100 cm
											</span>
										</li>

										<li class="flex-w flex-t p-b-7">
											<span class="stext-102 cl3 size-205">
												Materials
											</span>

											<span class="stext-102 cl6 size-206">
												60% cotton
											</span>
										</li>

										<li class="flex-w flex-t p-b-7">
											<span class="stext-102 cl3 size-205">
												Color
											</span>

											<span class="stext-102 cl6 size-206">
												Black, Blue, Grey, Green, Red, White
											</span>
										</li>

										<li class="flex-w flex-t p-b-7">
											<span class="stext-102 cl3 size-205">
												Size
											</span>

											<span class="stext-102 cl6 size-206">
												XL, L, M, S
											</span>
										</li>
									</ul>
								</div>
							</div>
						</div>

						<!-- - -->
						<div class="tab-pane fade" id="reviews" role="tabpanel">
							<div class="row">
								<div class="col-sm-10 col-md-8 col-lg-6 m-lr-auto">
									<div class="p-b-30 m-lr-15-sm">

										<div class="container-review">
											<!-- Review -->

											@if ($comments->count()>0)
												@foreach ($comments as $item)
													<div class="flex-w flex-t p-b-68">
														<div class="wrap-pic-s size-109 bor0 of-hidden m-r-18 m-t-6">
															<img src="{{$item->user->image?asset('Themes/images/avatar-01.jpg'):'https://st.quantrimang.com/photos/image/072015/22/avatar.jpg'}}" alt="AVATAR">
														</div>
			
														<div class="size-207">
															<div class="flex-w flex-sb-m p-b-17">
																<span class="mtext-107 cl2 p-r-20">
																	{{$item->user->name}}
																</span>
			
																<span class="fs-18 cl11">
																	@if ($item->rating > 0)
																		@for ($i = 1;$i <= 5; $i++)
																			@if ($i<=$item->rating)
																				<i class="zmdi zmdi-star"></i>
																				
																			@else
																				<i class="zmdi zmdi-star-outline"></i>

																			@endif
																			
																		@endfor
																	@endif
																	{{-- <i class="zmdi zmdi-star"></i>
																	<i class="zmdi zmdi-star"></i>
																	<i class="zmdi zmdi-star"></i>
																	<i class="zmdi zmdi-star-half"></i> --}}
																</span>
															</div>
															<div class="info-comment d-flex justify-content-between">
																<p class="stext-102 cl6">
																	{{$item->message}}
																</p>
																<span>{{Carbon\Carbon::create($item->created_at)->toDayDateTimeString()}}</span>
															</div>
														</div>
													</div>
												@endforeach
											@endif
											
									
										</div>
										
										<!-- Add review -->
										<form class="w-full form-comments" action="{{route('comments.add')}}" method="post">
											<h5 class="mtext-108 cl2 p-b-7">
												Add a review
											</h5>

											<p class="stext-102 cl6">
												Your email address will not be published. Required fields are marked *
											</p>

											<div class="flex-w flex-m p-t-50 p-b-23">
												<span class="stext-102 cl3 m-r-16">
													Your Rating
												</span>

												<span class="wrap-rating fs-18 cl11 pointer">
													<i class="item-rating pointer zmdi zmdi-star-outline"></i>
													<i class="item-rating pointer zmdi zmdi-star-outline"></i>
													<i class="item-rating pointer zmdi zmdi-star-outline"></i>
													<i class="item-rating pointer zmdi zmdi-star-outline"></i>
													<i class="item-rating pointer zmdi zmdi-star-outline"></i>
													<input class="dis-none" type="number" name="rating">
												</span>
											</div>

											<div class="row p-b-25">
												<div class="col-12 p-b-5">
													<label class="stext-102 cl3" for="review">Your review</label>
													<input class="size-110 bor8 stext-102 cl2 p-lr-20 p-tb-10" id="review" name="review">
												</div>

												{{-- <div class="col-sm-6 p-b-5">
													<label class="stext-102 cl3" for="name">Name</label>
													<input class="size-111 bor8 stext-102 cl2 p-lr-20" id="name" type="text" name="name">
												</div>

												<div class="col-sm-6 p-b-5">
													<label class="stext-102 cl3" for="email">Email</label>
													<input class="size-111 bor8 stext-102 cl2 p-lr-20" id="email" type="text" name="email">
												</div> --}}
											</div>

											<button data-id="{{$product->id}}" type="submit" class="flex-c-m stext-101 cl0 size-112 bg7 bor11 hov-btn3 p-lr-15 trans-04 m-b-10">
												Submit
											</button>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="bg6 flex-c-m flex-w size-302 m-t-73 p-tb-15">
			<span class="stext-107 cl6 p-lr-25">
				SKU: {{$product->name}}
			</span>

			<span class="stext-107 cl6 p-lr-25">
				Categories: {{$product->categories->name}}
			</span>
		</div>
	</section>


	<!-- Related Products -->
	<section class="sec-relate-product bg0 p-t-45 p-b-105">
		<div class="container">
			<div class="p-b-45">
				<h3 class="ltext-106 cl5 txt-center">
					Related Products
				</h3>
			</div>

			<!-- Slide2 -->
			<div class="wrap-slick2">
				<div class="slick2">
                    @if ($listRelated->count()>0)
                        @foreach ($listRelated as $item)
                            <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
                                <!-- Block2 -->
                                <div class="block2">
                                    <div class="block2-pic hov-img0">
                                        <img src="{{$item->feature_image_path}}" alt="IMG-PRODUCT">
        
                                        <a href="{{route('product.show',$item->id)}}" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
                                            Quick View
                                        </a>
                                    </div>
        
                                    <div class="block2-txt flex-w flex-t p-t-14">
                                        <div class="block2-txt-child1 flex-col-l ">
                                            <a href="{{route('product.detail',$item->id)}}" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                                {{$item->name}}
                                            </a>
        
                                            <span class="stext-105 cl3">
                                                $ {{$item->price}}
                                            </span>
                                        </div>
        
                                        <div class="block2-txt-child2 flex-r p-t-3">
                                            <a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                                <img class="icon-heart1 dis-block trans-04" src="{{asset('/Themes/images/icons/icon-heart-01.png')}}" alt="ICON">
                                                <img class="icon-heart2 dis-block trans-04 ab-t-l" src="{{asset('/Themes/images/icons/icon-heart-02.png')}}" alt="ICON">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
				</div>
			</div>
		</div>
	</section>
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
    $('.parallax100').parallax100();
</script>
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
    $('.js-addwish-b2, .js-addwish-detail').on('click', function(e){
        e.preventDefault();
    });

    $('.js-addwish-b2').each(function(){
        var nameProduct = $(this).parent().parent().find('.js-name-b2').html();
        $(this).on('click', function(){
            swal(nameProduct, "is added to wishlist !", "success");

            $(this).addClass('js-addedwish-b2');
            $(this).off('click');
        });
    });

    $('.js-addwish-detail').each(function(){
        var nameProduct = $(this).parent().parent().parent().find('.js-name-detail').html();

        $(this).on('click', function(){
            swal(nameProduct, "is added to wishlist !", "success");

            $(this).addClass('js-addedwish-detail');
            $(this).off('click');
        });
    });

    /*---------------------------------------------*/

    $('.js-addcart-detail').each(function(){
        var nameProduct = $(this).parent().parent().parent().parent().find('.js-name-detail').html();
        $(this).on('click', function(){
            swal(nameProduct, "is added to cart !", "success");
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

	<script>
		let formComment= document.querySelector('.form-comments');
		let containerComment = document.querySelector('.container-review');

		function renderComment(item){
			let template = `
			<div class="flex-w flex-t p-b-68">
														<div class="wrap-pic-s size-109 bor0 of-hidden m-r-18 m-t-6">
															<img src="${item.avatar?item.avatar:'https://st.quantrimang.com/photos/image/072015/22/avatar.jpg'}" alt="AVATAR">
														</div>
			
														<div class="size-207">
															<div class="flex-w flex-sb-m p-b-17">
																<span class="mtext-107 cl2 p-r-20">
																	${item.name_user}
																</span>
			
																<span class="fs-18 cl11">`;
																	if (item.rating > 0){
																		for (let i = 1;i <= 5; i++){
																			if (i<=item.rating){

																				template += '<i class="zmdi zmdi-star"></i>';
																			}else{

																				template +='<i class="zmdi zmdi-star-outline"></i>';
																			}
																				
																
																		}
																			
																		
																	}
																		
												template +=					
																`
																</span>
															</div>
															<div class="info-comment d-flex justify-content-between">
																<p class="stext-102 cl6">
																	${item.message}
																</p>
																<span>${moment(item.created_at).format('llll')}</span>
															</div>
														</div>
													</div>
			`;
			containerComment.insertAdjacentHTML('afterbegin',template);
			}

		formComment.addEventListener('submit',function(e){
			e.preventDefault();

			let url = this.getAttribute('action');
			let message = this.querySelector('input[name="review"]').value.trim();
			let reating = this.querySelectorAll('.zmdi-star').length;
			let productId = this.querySelector('button[type="submit"]').dataset.id;
			if(reating>0 && message != ''){
				$.ajaxSetup({
                     headers: {
                         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                     }
				});
				$.ajax({
						url: url,
						type: "POST",
						data:{
							productId:productId,
							rating:+reating,
							message:message
						},
						dataType: "json",
						success: function (response) {
							console.log(response);
							containerComment.innerHTML = '';
							(response).forEach((item,index)=>{
								// JSON.parse(item)
								renderComment(item);

							});
							$('.review-count').text('Review ('+response.length+')');



							Swal.fire({
								position: 'bottom-end',
								icon: 'success',
								title: 'Add comment success',
								showConfirmButton: false,
								timer: 500
							});
							formComment.reset();
						},
						error: function(e){
							console.log('lỗi');
						}
					})
			}else{
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: 'please choose the number of stars & comment!',
					footer: '<a href="">Why do I have this issue?</a>'
				})
			}
			// console.log(message,reating,productId);
		
		});
	</script>
@endsection
