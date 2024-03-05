@extends('client.customer.my-Account')
@section('title', 'Edit Account')
@section('myaccount')

    <div class="cart-main-area section-padding--lg bg--white">

        <div class="col-6">
            <div class="fs-5 fw-bold">Xác nhận hủy đơn hàng</div>
            <div class="col-6 mx-auto">
                <label for="">Lý do</label>
                <textarea name="note" class="col-12" style="height: 100px"></textarea>
            </div>
            <div class="col-md-6 my-3">
                <form action="{{ route('client.orders.cancelYes', $id) }}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-cancel btn-danger shop_search">
                        Xác nhận
                    </button>
                    <a href="{{ route('client.order.index') }}">Hủy</a>
                </form>
            </div>

        </div>
    </div>
    <!-- cart-main-area end -->
@endsection
