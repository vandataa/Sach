@extends('layout.layout')
@section('content')
    <!-- Start breadcrumb area -->
    <div class="ht__breadcrumb__area bg-image--6">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__inner text-center">
                        <h2 class="breadcrumb-title">Hóa Đơn</h2>
                        <nav class="breadcrumb-content">
                            <a class="breadcrumb_item" href="{{ route('home') }}">Home</a>
                            <span class="brd-separator">/</span>
                            <span class="breadcrumb_item active">Hóa đơn</span>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- End breadcrumb area -->
    <!-- cart-main-area start -->
    <div class="cart-main-area section-padding--lg bg--white">

        <div class="container">
            @if (session('message'))
                <h1 class="text-primary text-center">{{ session('message') }}</h1>
            @endif
            <p class="text-center">Bạn Đã hủy Thanh Toán hoặc Thanh Toán Lỗi </p>
            <br>
            <p class="text-center">Vui Lòng Mời Bạn Mua Hàng Lại Và Thanh Toán Lại !!!</p>
            <div class="row">
                <button class="mt-4" style="color: white; text-decoration: none;">
                    <a href="{{ route('books.show') }}">Quay lại Sản Phẩm mua hàng</a> </button>
            </div>

        </div>
    </div>
    <!-- cart-main-area end -->
@endsection
