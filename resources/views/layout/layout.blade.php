<!doctype html>
<html class="no-js" lang="zxx">


<!-- Mirrored from htmldemo.net/boighor/boighor/index-2.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 30 Sep 2023 07:52:53 GMT -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Tri Thức Online</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicons -->
    <link rel="shortcut icon" href="{{ asset('assets/images/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/images/icon.png') }}">

    <!-- Google font (font-family: 'Roboto', sans-serif; Poppins ; Satisfy) -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,300i,400,400i,500,600,600i,700,700i,800"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <!-- Cusom css -->
    <link rel="stylesheet" href="{{ asset('assets/css/customz.css') }}">

    <!-- Login  -->
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/searchInput.css') }}">


    <!-- Modernizer js -->
    <script src="{{ asset('assets/js/vendor/modernizr-3.5.0.min.js') }}"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Thư viện Bootstrap CSS -->


</head>

<body>
    <!--[if lte IE 9]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade
    your browser</a> to improve your experience and security.</p>
<![endif]-->

    <!-- Main wrapper -->
    <div class="wrapper" id="wrapper">
        @include('layout.header')

        @yield('content')

        @include('layout.footer')
        <!-- QUICKVIEW PRODUCT -->
        <div id="quickview-wrapper">
            <!-- Modal -->
            <div class="modal fade" id="productmodal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal__container" role="document">
                    <div class="modal-content">
                        <div class="modal-header modal__header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="modal-product">
                                <!-- Start product images -->
                                <div class="product-images">
                                    <div class="main-image images">
                                        <img alt="big images" src="images/product/big-img/1.jpg">
                                    </div>
                                </div>
                                <!-- end product images -->
                                <div class="product-info">
                                    <h1>Simple Fabric Bags</h1>
                                    <div class="rating__and__review">
                                        <ul class="rating">
                                            <li><span class="ti-star"></span></li>
                                            <li><span class="ti-star"></span></li>
                                            <li><span class="ti-star"></span></li>
                                            <li><span class="ti-star"></span></li>
                                            <li><span class="ti-star"></span></li>
                                        </ul>
                                        <div class="review">
                                            <a href="#">4 customer reviews</a>
                                        </div>
                                    </div>
                                    <div class="price-box-3">
                                        <div class="s-price-box">
                                            <span class="new-price">$17.20</span>
                                            <span class="old-price">$45.00</span>
                                        </div>
                                    </div>
                                    <div class="quick-desc">
                                        Designed for simplicity and made from high quality materials. Its sleek geometry
                                        and material combinations creates a modern look.
                                    </div>
                                    <div class="select__color">
                                        <h2>Select color</h2>
                                        <ul class="color__list">
                                            <li class="red"><a title="Red" href="#">Red</a></li>
                                            <li class="gold"><a title="Gold" href="#">Gold</a></li>
                                            <li class="orange"><a title="Orange" href="#">Orange</a></li>
                                            <li class="orange"><a title="Orange" href="#">Orange</a></li>
                                        </ul>
                                    </div>
                                    <div class="select__size">
                                        <h2>Select size</h2>
                                        <ul class="color__list">
                                            <li class="l__size"><a title="L" href="#">L</a></li>
                                            <li class="m__size"><a title="M" href="#">M</a></li>
                                            <li class="s__size"><a title="S" href="#">S</a></li>
                                            <li class="xl__size"><a title="XL" href="#">XL</a></li>
                                            <li class="xxl__size"><a title="XXL" href="#">XXL</a></li>
                                        </ul>
                                    </div>
                                    <div class="social-sharing">
                                        <div class="widget widget_socialsharing_widget">
                                            <h3 class="widget-title-modal">Share this product</h3>
                                            <ul class="social__net social__net--2 d-flex justify-content-start">
                                                <li class="facebook"><a href="#" class="rss social-icon"><i
                                                            class="zmdi zmdi-rss"></i></a></li>
                                                <li class="linkedin"><a href="#"
                                                        class="linkedin social-icon"><i
                                                            class="zmdi zmdi-linkedin"></i></a></li>
                                                <li class="pinterest"><a href="#"
                                                        class="pinterest social-icon"><i
                                                            class="zmdi zmdi-pinterest"></i></a></li>
                                                <li class="tumblr"><a href="#" class="tumblr social-icon"><i
                                                            class="zmdi zmdi-tumblr"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="addtocart-btn">
                                        <a href="#">Add to cart</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END QUICKVIEW PRODUCT -->
    </div>
    <!-- //Main wrapper -->

    <!-- JS Files -->
    <script src="{{ asset('assets/js/vendor/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins.js') }}"></script>
    <script src="{{ asset('assets/js/active.js') }}"></script>
    <script src="{{ asset('assets/js/my-account.js') }}"></script>

    <script>
        $(function() {
            function readURL(input, selector) {
                if (input.files && input.files[0]) {
                    let reader = new FileReader();

                    reader.onload = function(e) {
                        $(selector).attr('src', e.target.result);
                    };

                    reader.readAsDataURL(input.files[0]);
                }
            }
            $("#image").change(function() {
                readURL(this, '#image_preview');
            });

        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <script>
        $(".cart_update").change(function(e) {
            e.preventDefault();
            var ele = $(this);
            var newQuantity = ele.val();
            var ship = $('#shipping .price').html();

            // Kiểm tra số lượng là số dương
            if (newQuantity <= 0) {
                var bookName = ele.parents("tr").find(".product-name a").text();
                $("#error-message").text('Số lượng sách "' + bookName +
                    '" bạn chọn phải là một số dương và lớn hơn 0.');
                return;
            }

            $.ajax({
                url: '{{ route('cart.updateCart') }}',
                method: "patch",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: ele.parents("tr").attr("data-id"),
                    quantity: newQuantity,
                    ship: ship
                },
                success: function(response) {
                    if (response.status === 'success') {
                        // Cập nhật tổng tiền trong trang không cần làm mới
                        ele.parents("tr").find(".product-subtotal").text(response.new_price_formatted);
                        // Cập nhật tổng tiền và tổng tiền phải trả
                        // $('#total-price').val(response.total);
                        $("#total-price").text(response.total);
                        $("#total-amount").text(response.final_total);
                        $("#total-amount-price").text(response.final_total);
                        $("#shipping .price").text(response.ship);
                        $("#total-discount-price").text(response.discount);
                        $("#error-message").text(''); // Xóa thông báo lỗi nếu có
                    } else {
                        // Hiển thị thông báo lỗi cụ thể
                        $("#error-message").text(response.message);
                    }
                },
                error: function(error) {
                    console.error('Ajax request failed:', error);
                }
            });
        });
    </script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.choose').on('change',function(){
            var action = $(this).attr('id');
            var id_tp = $(this).val();
            var _token = $('input[name = "_token"]').val();
            var result = '';
            if(action =='city'){
                result = 'province';
            }else{
                result = 'wards';
            }
            var url = '{{ route('cart.ship') }}';
            $.ajax({
                url : url,
                method:'POST',
                data:{
                    action:action,
                    id_tp:id_tp,
                    _token:_token
                },
                success:function(data){
                    $('#'+result).html(data);
                }

            });
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.btn-ship').click(function(){
            var url = '{{ route('cart.ship.count') }}';
            var matp = $('.city').val();
            var maqh = $('.province').val();
            var maxa = $('.wards').val();
            var total = $('#total .price').html();
            var discount = $('#total-discount-price .price').html();
            var totalAmount = $('#total-amount .price').html();
            var _token = $('input[name = "_token"]').val();
            if(matp =='' || maqh=='' || maxa==''){
                alert('Bạn hãy chọn địa chỉ để tính phí vận chuyển.');
            }else{
                $.ajax({
                    url : url,
                    method:'POST',
                    data:{
                        matp:matp,
                        maqh:maqh,
                        maxa:maxa,
                        total:total,
                        discount:discount,
                        totalAmount:totalAmount,
                        _token:_token
                    },
                    success:function(data){
                        location.reload();
                    }
                });
            }

        });
    });
</script>







</body>


<!-- Mirrored from htmldemo.net/boighor/boighor/index-2.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 30 Sep 2023 07:52:54 GMT -->

</html>
