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
    </div>
    <!-- End breadcrumb area -->
    <!-- cart-main-area start -->
    <div class="cart-main-area section-padding--lg bg--white">

        <div class="container">
            @if (session('success'))
                <h1 class="text-primary text-center">{{ session('success') }}</h1>
            @endif
            <div class="row">
                <div class="col-md-12 col-sm-12 ol-lg-12">


                    <div class="wn__order__box">
                        <h3 class="order__title">Chi Tiết Hóa Đơn</h3>
                        <div class=" ">
                            <h3 class="text-center"> TRI THỨC ONLINE </h3>
                            <h5 class="text-center">0356560121, 098989898</h5>
                            <h4 class="text-center">Số 2, 13 P. Trịnh Văn Bô, Xuân Phương, Nam Từ Liêm, Hà Nội, Việt Nam
                            </h4>
                        </div>

                        <ul class="order__total">

                            <li>Mã đơn hàng: {{ $order->code_bill }}</li>

                        </ul>
                        <ul class="order__total">
                            <?php
                            $formattedDateTime = \Carbon\Carbon::parse($order->date)->format('d-m-Y');
                            ?>
                            <li>Ngày đặt: {{ $formattedDateTime }}</li>

                        </ul>
                        <ul class="order__total">
                            <li>Phương thức thanh toán: {{ $order->payment }}</li>
                        </ul>
                        <ul class="order__total">
                            <li>Tên người nhận: {{ $order->name }} </li>

                        </ul>

                        <ul class="order__total">
                            <li> Số điện thoại: {{ $order->phone }} </li>
                        </ul>
                        <ul class="order__total">
                            <li>Địa chỉ: {{ $order->address }} </li>

                        </ul>
                        <ul class="order__total">
                            <li>Email: {{ $order->email }} </li>
                        </ul>
                        <ul class="order_product">
                            <li>Thông sản phẩm:</li>
                            @php
                                $i = 1;
                            @endphp

                            <table class="table">
                                <thead>
                                    <tr class="title-top">
                                        <td>STT</td>
                                        <td>Tên Sách</td>
                                        <td>Số Lượng</td>
                                        <td>Giá Sách</td>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order_details as $item)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $item->title_book }}</td>
                                            <td>{{ $item->book_quantity }}</td>
                                            <td>{{ number_format($item->price, 0, ',', '.') }} VNĐ</td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </ul>

                        <ul class="shipping__method">
                            <li> Tổng tiền sách <span>
                                    <h6 class="total-price">
                                        {{ number_format($order->total - $order->ship, 0, ',', '.') }} VNĐ
                                    </h6>

                                </span></li>
                            <li>Shipping
                                <ul>

                                    <li>
                                        <label>
                                            <h6 class="shipping"> {{ number_format($order->ship, 0, ',', '.') }} VNĐ</h6>
                                        </label>
                                    </li>
                                </ul>
                            </li>

                        </ul>
                        <ul class="total__amount">
                            <li> Tồng thành tiền: <span>
                                    <h6 class="total-price"> {{ number_format($order->total, 0, ',', '.') }} VNĐ
                                    </h6>

                                </span></li>
                        </ul>

                    </div>
                </div>

            </div>

        </div>
    </div>
    </div>
    <!-- cart-main-area end -->
@endsection
