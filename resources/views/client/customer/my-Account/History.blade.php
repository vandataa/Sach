@extends('client.customer.my-Account')
@section('title', 'Edit Account')
@section('myaccount')
    <div class="cart-main-area section-padding--lg bg--white">
        <div class="container">
            @if (session('message'))
                <h6 class="text-primary text-center">{{ session('message') }}</h6>
            @endif
            @if ($orders->isEmpty())
                <h6 class="text-center">Chưa có đơn đặt hàng nào</h6>
            @else
                <div class="row">
                    <div class="col-md-12 col-sm-12 ol-lg-12">

                        <div class="table-content wnro__table table-responsive">
                            <table>
                                <thead>
                                    <tr class="title-top">
                                        <th class="product-thumbnail">STT</th>
                                        {{-- <th class="product-thumbnail">Tên Khách Hàng</th> --}}
                                        {{-- <th class="product-name">Địa chỉ nhận hàng</th>
                                    <th class="product-name">Email</th>
                                    <th class="product-price">Phone</th> --}}
                                        {{-- <th class="product-quantity">Ship</th> --}}
                                        <th class="product-subtotal">Mã đơn hàng</th>
                                        <th class="product-subtotal">Phương thức thanh toán</th>
                                        <th class="product-subtotal">Date</th>
                                        {{-- <th class="product-subtotal">Note</th> --}}
                                        <th class="product-subtotal">Trạng thái đơn hàng</th>
                                        <th class="product-subtotal">Hành động</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            {{-- <td>{{ $item->name }}</td> --}}
                                            {{-- <td>{{ $item->address }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->phone }}</td> --}}
                                            {{-- <td>{{ $item->ship }}</td> --}}
                                            <td>{{ $item->code_bill }}</td>
                                            <td>{{ $item->payment }}</td>
                                            <?php
                                            $formattedDateTime = \Carbon\Carbon::parse($item->date)->format('d-m-Y');
                                            ?>
                                            <td>{{ $formattedDateTime }}</td>
                                            {{-- <td>{{ $item->note }}</td> --}}
                                            <td>{{ $item->status }}</td>
                                            <td>
                                                <a class="btn btn-primary"
                                                    href="{{ route('client.order.detail', $item->id) }}">
                                                    Xem đơn hàng</a>
                                            </td>

                                </tbody>
            @endforeach
            </table>

        </div>
    </div>

    </div>
    @endif
    </div>

@endsection
