@extends('layout.layout')
@section('content')
    <!-- Start breadcrumb area -->
    <div class="ht__breadcrumb__area bg-image--6">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__inner text-center">
                        <h2 class="breadcrumb-title">Giỏ hàng</h2>
                        <nav class="breadcrumb-content">
                            <a class="breadcrumb_item" href="{{ route('home') }}">Trang chủ</a>
                            <span class="brd-separator">/</span>
                            <span class="breadcrumb_item active">Giỏ hàng</span>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End breadcrumb area -->
    <!-- cart-main-area start -->
    <div class="cart-main-area section-padding--lg bg--white">
        @if ($carts->count() > 0)
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 ol-lg-12">

                        <div class="table-content wnro__table table-responsive">
                            @if (session('message'))
                                <h4 style="color:black; width:100%;text-align:center">{{ session('message') }}</h4>'
                            @endif
                            <div class="text-center" id="error-message" style="color: red;"></div>
                            <table>
                                <thead>
                                    <tr class="title-top">
                                        <th class="product-thumbnail">Ảnh</th>
                                        <th class="product-name">Tên sách</th>
                                        <th class="product-price">Giá</th>
                                        <th class="product-quantity">Số lượng</th>
                                        <th class="product-subtotal">Tổng</th>
                                        <th class="product-remove">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($carts as $cart)
                                        <tr data-id="{{ $cart->id }}">
                                            <td class="product-thumbnail"><a href="#"><img
                                                        src="{{ asset('storage/images/' . $cart->book_image) }}"
                                                        style="width: 146px;height: 200px;object-fit: cover"
                                                        alt="product img"></a></td>

                                            <td style="padding-top: 20px" class="product-name"><a
                                                    href="#">{{ $cart->title_book }}</a>
                                            </td>
                                            <td class="product-price"><span
                                                    class="amount">{{ number_format($cart->money, 0, ',', '.') }} VNĐ</span>
                                            </td>
                                            <td data-th="Quantity" class="product-quantity">
                                                <input type="number" min="1" class="quantity cart_update"
                                                    name="quantity" value="{{ $cart->quantity }}"
                                                    data-id="{{ $cart->id }}">
                                            </td>
                                            <td class="product-subtotal" id="qty">
                                                {{ number_format($cart->money * $cart->quantity, 0, ',', '.') }} VNĐ</td>

                                            <td class="product-remove">
                                                <a href="{{ route('cart.delete', $cart->id) }}">X</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="cartbox__btn">
                            <ul>
                                <li class="my-3 fs-4">Tính phí vận chuyển</li>
                            </ul>
                            <ul class="cart__btn__list my-5">
                                <li>
                                    <form method="POST" class="row col-12">
                                        @csrf
                                        <div class="col">
                                            <label for="">Chọn Tỉnh/ Thành Phố</label><br>
                                            <select class="ml-3 py-2 fs-5 col-12 choose city" name="id_tp" id="city">
                                                <option value="">----Chọn----</option>
                                                @foreach ($tinhtp as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('id_tp')
                                                <p style="font-size: 14px;color:red;">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="col">
                                            <label for="">Chọn Quận/ Huyện</label><br>
                                            <select class="ml-3 py-2 fs-5 col-12 choose province" name="id_qh"
                                                id="province">
                                                <option value="">----Chọn----</option>
                                            </select>
                                            @error('id_qh')
                                                <p style="font-size: 14px;color:red;">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="col">
                                            <label for="">Chọn Xã/ Phường</label><br>
                                            <select class="ml-3 py-2 fs-5 col-12  wards" name="id_xa" id="wards">
                                                <option value="">----Chọn----</option>
                                            </select>
                                            @error('id_xa')
                                                <p style="font-size: 14px;color:red;">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="col mt-4">
                                            <input type="button" name='btn-ship' class="btn-ship btn btn-primary py-2"
                                                value="Tính phí">
                                        </div>
                                    </form>
                                </li>
                            </ul>
                            <ul
                                class="cart__btn__list d-flex flex-wrap flex-md-nowrap flex-lg-nowrap justify-content-between">
                                <li>
                                    @if (session('discount'))
                                        <form action="{{ route('sale.disable') }}" method="post">
                                            @csrf
                                            <button class="code" type="submit">Bỏ mã giảm giá</button>
                                        </form>
                                    @else
                                        <form action="{{ route('sale.code') }}" method="post">
                                            @csrf
                                            <input type="text" class="codeInput" name="code" id="">

                                            <button class="code" type="submit">Nhập mã giảm giá</button>
                                        </form>
                                        @if (session('messes'))
                                            <p class="d-flex justify-content-start ps-3 text-danger">
                                                {{ session('messes') }}</p>
                                        @endif
                                    @endif
                                </li>
                                @if (Session::get('ship'))
                                    <li><a class="bg-primary text-light px-5" href="{{ route('cart.checkout') }}">Mua</a>
                                    </li>
                                @else
                                    <li><span>Vui lòng chọn địa chỉ của bạn</span></li>
                                @endif
                            </ul>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 offset-lg-6">
                        <div class="cartbox__total__area">
                            <div class="cartbox-total d-flex justify-content-between">
                                @php
                                    $total = 0;
                                    $discount = 0;
                                    $ship = 0;

                                @endphp
                                @if (Session::get('ship'))
                                    @php
                                        $ship = session('ship')['price'];
                                    @endphp
                                @endif
                                @foreach ($carts as $cart)
                                    @php
                                        $total += $cart->money * $cart->quantity;
                                    @endphp
                                @endforeach
                                <ul class="cart__total__list">
                                    <li>Tổng tiền</li>
                                    @if (session('discount'))
                                        <div>
                                            @php
                                                $discount = session('discount')['sale'];
                                                $totalDis = 0;
                                            @endphp
                                        </div>
                                        <li>Số tiền được giảm</li>
                                    @endif

                                    <li>Ship</li>
                                    <li>Tổng</li>
                                </ul>

                                <ul class="cart__total__tk">
                                    <li id="total-price">
                                        <span class="price">{{ number_format($total, 0, ',', '.') }}</span> VNĐ
                                    </li>


                                    @if (session('discount'))
                                        @if (session('discount')['type'] == '%')
                                            @php
                                                $discount = $discount * $total;
                                            @endphp
                                        @else
                                            @php
                                                $discount = $discount;
                                            @endphp
                                        @endif
                                        <li id="total-discount-price"> <span
                                                class="price">{{ number_format($discount, 0, ',', '.') }}</span> VNĐ</li>
                                    @endif

                                    <li id="shipping"><span class="price">{{ number_format($ship, 0, ',', '.') }}
                                        </span><span>VNĐ</span></li>
                                    <li id="total-amount"><span
                                            class="price">{{ number_format($total + $ship - $discount, 0, ',', '.') }}</span>
                                        VNĐ</li>
                                </ul>


                            </div>
                            <div class="cart__total__amount">
                                <span>Giá phải trả</span>
                                <span id="total-amount-price">
                                    <span
                                        class="price">{{ number_format($total + $ship - $discount, 0, ',', '.') }}</span>
                                    VNĐ
                                </span>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="container">
                <p class="fs-5 text-center text-danger fw-bold">Bạn Chưa Thêm Sản Phẩm nào vào giỏ hàng!</p>
            </div>
        @endif
    </div>
    <!-- cart-main-area end -->
@endsection
