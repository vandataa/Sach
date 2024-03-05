@extends('layoutadmin.layout')
@section('content')
    <div class="content-wrapper">
        <div class="cart-main-area section-padding--lg bg--white">

            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 ol-lg-12">


                        <div class="wn__order__box">
                            <h3 class="order__title text-center">Chi Tiết Đơn Hàng</h3>

                            <ul class="order__total">

                                <li>Mã đơn hàng: {{ $order->code_bill }}</li>

                            </ul>
                            <ul class="order__total">
                                <?php
                                $date = \Carbon\Carbon::parse($order->date)->format('d/m/Y');
                                ?>
                                <li>Ngày đặt: {{ $date }}</li>

                            </ul>
                            <ul class="order__total">
                                <li>Phương thức thanh toán : {{ $order->payment }}</li>
                            </ul>
                            <ul class="order__total">
                                <li>Trạng thái đơn hàng:
                                    {{ $order->status }}
                                </li>
                            </ul>
                            <ul class="order__total">
                                <li>Trạng thái thanh toán :
                                    @if ($order->status === 'Hủy đơn hàng' && $order->payment === 'Đã Thanh Toán VNPAY')
                                        Hủy đơn hàng - Đang hoàn tiền
                                    @elseif ($order->status === 'Giao hàng thành công' || $order->payment === 'Đã Thanh Toán VNPAY')
                                        Đã thanh toán
                                    @else
                                        Chưa thanh toán
                                    @endif
                                </li>
                            </ul>
                            <ul class="order__total">
                                <li>Tên người nhận: {{ $order->name }} </li>

                            </ul>
                            <ul class="order__total">
                                <li>Địa chỉ: {{ $order->address }} </li>

                            </ul>
                            <ul class="order__total">
                                <li> Số điện thoại: {{ $order->phone }} </li>
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
                                        <h6>
                                            {{ number_format($order->total - $order->ship, 0, ',', '.') }} VNĐ
                                        </h6>
                                    </span></li>
                            </ul>
                            <ul>
                                <li> Phí ship <span>
                                        <h6> {{ number_format($order->ship, 0, ',', '.') }} VNĐ</h6>
                                    </span></li>
                            </ul>
                            <ul>
                                <li> Tổng thành tiền
                                    <span>
                                        <h6> {{ number_format($order->total, 0, ',', '.') }} VNĐ</h6>
                                    </span>
                                </li>
                            </ul>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    </div>
    <!-- cart-main-area end -->
@endsection
