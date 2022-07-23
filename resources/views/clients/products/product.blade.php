@extends('layouts.client')
@section('title')
    <title>Sản Phẩm</title>
@endsection

@section('header')
@include('clients.components.headerV4')
@endsection

@section('content')
    @include('clients.components.product')
    
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
<!--===============================================================================================-->

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
                             console.log(response.length);
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