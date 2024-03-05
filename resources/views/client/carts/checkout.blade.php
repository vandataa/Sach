@extends('layout.layout')
@section('content')
    <!-- Start breadcrumb area -->
    <div class="ht__breadcrumb__area bg-image--6">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__inner text-center">
                        <h2 class="breadcrumb-title">Mua</h2>
                        <nav class="breadcrumb-content">
                            <a class="breadcrumb_item" href="{{ route('home') }}">Trang chủ</a>
                            <span class="brd-separator">/</span>
                            <span class="breadcrumb_item active">Mua</span>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- End breadcrumb area -->
    <!-- Start Checkout Area -->
    <section class="wn__checkout__area section-padding--lg bg__white">
        <div class="container">
            @if (session('message'))
                <h4 style="color:red; width:100%;text-align:center">{{ session('message') }}</h4>'
            @endif
            <div class="row">
                <form class="row" action="{{ route('checkout.process') }}" method="POST">
                    @csrf
                    <div class="col-lg-6 col-12">
                        <div class="customer_details">
                            <h3>Hóa đơn</h3>
                            <div class="customar__field">
                                <div class="margin_between">
                                    <div class="input_box space_between">
                                        <label>Tên khách hàng <span>*</span></label>
                                        <input type="text" name="customer_name" value="{{ $user->name }}"
                                            id="name_above">
                                        @error('customer_name')
                                            <p class="d-flex justify-content-start ps-3 text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                </div>
                                <div class="input_box">
                                    <label>Địa chỉ <span>*</span></label>

                                    <input type="text" placeholder="Số nhà" name="customer_address">

                                    <input type="text" placeholder="Địa chỉ" class="mt-3" value="{{ $user->address }}"
                                        disabled>
                                    <input type="hidden" placeholder="Địa chỉ" class="mt-3" name="customer_address_1"
                                        value="{{ $user->address }}">
                                    @error('customer_address')
                                        <p class="d-flex justify-content-start ps-3 text-danger">{{ $message }}</p>
                                    @enderror

                                </div>
                                <div class="margin_between">
                                    <div class="input_box space_between">
                                        <label>Số điện thoại <span>*</span></label>
                                        <input type="text" name="customer_phone" value="{{ $user->phone }}"
                                            placeholder="Số điện thoại">
                                        @error('customer_phone')
                                            <p class="d-flex justify-content-start ps-3 text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="input_box space_between">
                                        <label>Địa chỉ email<span>*</span></label>
                                        <input type="email" name="customer_email" value="{{ $user->email }}">
                                        @error('customer_email')
                                            <p class="d-flex justify-content-start ps-3 text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                </div>
                                <div class="input_box">
                                    <label>Ghi chú</label>
                                    <textarea name="note" class="col-12" style="min-height:200px"></textarea>
                                </div>
                            </div>
                        </div>
                        @php
                            $now = date('Y-m-d H:i:s');
                            $code_bill = strtotime($now);
                        @endphp

                    </div>
                    <div class="col-lg-6 col-12 ">
                        <div class="wn__order__box">
                            <h3 class="order__title">Đơn hàng của bạn</h3>
                            <ul class="order__total">
                                <li>Mã đơn hàng: {{ $code_bill }}</li>
                                <input type="hidden" name="code_bill" value="{{ $code_bill }}">
                            </ul>
                            <ul class="order__total">
                                <li>Sách</li>
                                <li>Tổng</li>
                            </ul>
                            @foreach ($carts as $cart)
                                <ul class="order_product">
                                    <li>{{ $cart->title_book }} ×
                                        {{ $cart->quantity }}<span>{{ number_format($cart->money * $cart->quantity, 0, ',', '.') }}
                                            VNĐ</span>
                                    </li>

                                </ul>
                            @endforeach
                            <ul class="shipping__method">
                                @php
                                    $cart_total = 0;

                                @endphp
                                @foreach ($carts as $cart)
                                    @php
                                        $cart_total += $cart->money * $cart->quantity;
                                    @endphp
                                @endforeach

                                @if (session('discount'))
                                    @php
                                        $discount = session('discount')['sale'];
                                    @endphp
                                    @if (session('discount')['type'] == '%')
                                        <li>
                                            @php

                                                $totalDis = $cart_total - $discount * $cart_total;
                                            @endphp

                                            Giảm giá <span>
                                                <h6 class="total-price" data-price="{{ $discount * $cart_total }}">

                                                    {{ number_format($discount * $cart_total, 0, ',', '.') }} VNĐ
                                                </h6>

                                            </span>

                                        </li>
                                    @else
                                        <li>
                                            @php
                                                $totalDis = $cart_total - $discount;
                                            @endphp
                                            Giảm giá <span>
                                                <h6 class="total-price" data-price="{{ $discount }}">
                                                    {{ number_format($discount, 0, ',', '.') }} VNĐ
                                                </h6>

                                            </span>
                                        </li>
                                    @endif
                                    @php
                                        if ($totalDis < 0) {
                                            $totalDis = 0;
                                    } @endphp @php $cart_total=$totalDis; @endphp
                                @endif
                                <li>Tổng tiền <span>
                                        <h6 class="total-price" data-price="{{ $cart_total }}">
                                            {{ number_format($cart_total, 0, ',', '.') }} VNĐ
                                        </h6>
                                    </span>
                                </li>
                                <li>Shipping
                                    <ul>
                                        @php
                                            $ship = session('ship')['price'];
                                        @endphp
                                        <li>
                                            <label>
                                                <h6 class="shipping" data-price="10">
                                                    {{ number_format($ship, 0, ',', '.') }} VNĐ</h6>
                                                <input type="hidden" value="{{ $ship }}" name="ship">
                                            </label>
                                        </li>
                                    </ul>
                                </li>

                            </ul>
                            <ul class="total__amount">
                                <li>Tổng
                                    <span>
                                        <h5 class="font-weight-bold total-price-all">
                                            {{ number_format($cart_total + $ship, 0, ',', '.') }} VNĐ</h5>
                                        <input type="hidden" id="total" value="{{ $cart_total + $ship }}"
                                            name="total">
                                    </span>
                                </li>
                            </ul>

                        </div>
                        <div id="accordion" class="checkout_accordion mt--30" role="tablist">
                            @if (session('discount'))
                                <input type="hidden" name="code" value="{{ session('discount')['code'] }}">
                                <input type="hidden" name="id_user" value="{{ Auth::user()->id }}">
                                <input type="hidden" name="id_sale" value="{{ session('discount')['id'] }}">
                            @endif
                            <div class="payment px-3">
                                <input class="" type="radio" value="1" name="thanhtoan" checked>
                                <label class="fs-5 p-3" for="">Nhận Hàng
                                    Thanh Toán </label>
                                <br>
                                <input class="" type="radio" value="2" name="thanhtoan"> <label
                                    class="fs-5 px-3"for="">Thanh Toán VNPAY </label>
                            </div>
                            <button name="redirect" class="btn  btn-primary px-5 my-3 py-3 " onclick="submitForm()">Xác
                                Nhận </button>
                </form>
            </div>



        </div>
    </section>

    <!-- End Checkout Area -->
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('form').submit(function() {
            // Tắt nút xác nhận sau khi được nhấp
            $('button[type=submit]', this).prop('disabled', true);
        });
    });
</script>
@section('script')
    <script>
        $(document).ready(function() {
            $('#name_above').on('input', function() {
                var inputValue = $(this).val();
                $('#name_below').text(inputValue);
            })
        })
    </script>
@endsection
<script>
    function submitForm() {
        // Ẩn nút xác nhận
        var submitButton = document.querySelector('button[name="redirect"]');
        submitButton.style.display = 'none';
    }
</script>
