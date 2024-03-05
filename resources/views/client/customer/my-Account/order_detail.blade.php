@extends('client.customer.my-Account')
@section('title', 'Edit Account')
@section('myaccount')

<style>
    .modal-content {
        border-radius: 10px;
    }

    .modal-header {
        background-color: #007bff;
        color: #fff;
        border-radius: 10px 10px 0 0;
    }

    .modal-title {
        font-weight: bold;
    }

    .close {
        color: #fff;
    }

    .modal-body {
        padding: 20px;
    }

    label {
        font-weight: bold;
    }

    textarea {
        width: 100%;
        padding: 8px;
        margin-bottom: 10px;
        resize: none;
    }

    .rating {
    display: flex;
    justify-content: flex-end;
    font-size: 24px;
    flex-direction: row-reverse; 
}

    .rating input {
        display: none;
    }

    .rating label {
        cursor: pointer;
        position: relative;
    }

    .rating label::before {
        content: '\2605'; /* Hiển thị sao trống mặc định */
        position: absolute;
        left: 0;
        top: 0;
        color: #ddd; /* Màu của sao trống */
    }

    .rating label:hover::before,
    .rating label:hover ~ label::before,
    .rating input:checked ~ label::before {
        content: '\2605'; /* Hiển thị sao đầy đủ khi hover hoặc khi được chọn */
        color: #ffc107; /* Màu của sao đầy đủ */
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }
</style>


    <div class="cart-main-area section-padding--lg bg--white">

        <div class="container">
            @if (session('message'))
            <div class="alert alert-danger">
                <h6 class="text-primary text-center my-3">{{ session('message') }}</h6>
            </div>
            @endif
            @if ($errors->any())
            <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li class="text-center">{{ $error }}</li>
            @endforeach
        </ul>
            </div>
        @endif
            <div class="row">
                <div class="col-md-12 col-sm-12 ol-lg-12">


                    <div class="wn__order__box">
                        <h3 class="order__title">Chi Tiết Đơn Hàng</h3>
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
                            <li>Trạng thái đơn hàng:
                                {{ $order->status }}
                            </li>
                        </ul>
                        <ul class="order__total">
                            <li>Trạng thái thanh toán:
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
            <td></td>
        </tr>
    </thead>
    <tbody>
        @foreach ($order_details as $index => $item)
            <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td>{{ $item->title_book }}</td>
                <td>{{ $item->book_quantity }}</td>
                <td>{{ number_format($item->price, 0, ',', '.') }} VNĐ</td>

                <td>
                    @if ($item->order_status === 'Giao hàng thành công')
                        @php
                            $bookNotRated = !isset($ratedBooks[$item->order_detail_id]);
                        @endphp
                        @if ($bookNotRated)
                            <a href="#" class="review-link" data-toggle="modal" data-target="#reviewModal{{ $loop->index  }}">Đánh giá sách</a>
                        @else
                            <p>Bạn đã đánh giá sản phẩm</p>
                        @endif
                    @else
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@foreach ($order_details as $item)
   
        <div class="modal fade" id="reviewModal{{ $loop->index  }}" tabindex="-1" role="dialog" aria-labelledby="reviewModalLabel{{ $loop->index  }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="reviewModalLabel{{ $item->order_detail_id }}">Đánh giá sách: {{ $item->title_book }}</h5>
                        <img src="" alt="">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Form đánh giá -->
                        <form method="post" action="{{ route('add.evaluate') }}">
                            @csrf
                            <input type="hidden" name="book_id" value="{{ $item->book_id }}">
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                            <input type="hidden" name="orderDetail_id" value="{{ $item->order_detail_id }}">
                            <label for="comment">Đánh giá</label>
                            <textarea name="comment" id="comment" required></textarea>
                            @error('comment')
                                <p style="font-size: 14px;color:red;float:left">{{ $message }}</p>
                            @enderror
                            @error('rating')
                                <p style="font-size: 14px;color:red;float:left">{{ $message }}</p>
                            @enderror
                            <div class="rating">
                                <input type="radio" id="star1_{{ $loop->index }}" name="rating" value="5" />
                                <label for="star1_{{ $loop->index }}">&#9733;</label>
                                <input type="radio" id="star2_{{ $loop->index }}" name="rating" value="4" />
                                <label for="star2_{{ $loop->index }}">&#9733;</label>
                                <input type="radio" id="star3_{{$loop->index }}" name="rating" value="3" />
                                <label for="star3_{{ $loop->index }}">&#9733;</label>
                                <input type="radio" id="star4_{{ $loop->index }}" name="rating" value="2" />
                                <label for="star4_{{ $loop->index }}">&#9733;</label>
                                <input type="radio" id="star5_{{ $loop->index }}" name="rating" value="1" />
                                <label for="star5_{{$loop->index }}">&#9733;</label>
                            </div>
                            <button type="submit" class="btn btn-primary">Gửi Đánh Giá</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    
@endforeach
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
                <div class="text-center">
                    @if ($order->status === 'Đang xử lý')
                        
                            <div class="text-center">
                                <form action="{{ route('client.orders.cancel', $order->id) }}"
                                    id="form-cancel{{ $order->id }}" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-cancel btn-danger" data-id={{ $order->id }}
                                        onclick="return confirm('Bạn chắc chắn muốn hủy đơn hàng')">
                                        Hủy đơn hàng
                                    </button>
                                </form>
                            </div>
                        
                    @elseif ($order->status === 'Đang Giao Hàng')
                       
                            <div class="text-center">
                                <form action="{{ route('client.orders.updateSTT', $order->id) }}"
                                    id="form-cancel{{ $order->id }}" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-cancel btn-danger" data-id={{ $order->id }}
                                        onclick="return confirm('Bạn chắc chắn đã nhận được đơn hàng')">
                                        Đã nhận được đơn hàng
                                    </button>
                                </form>
                            </div>
                        
                    @endif
                </div>
            </div>


        </div>
    </div>
    </div>



    <!-- cart-main-area end -->
@endsection

@section('script')
    <script>
        $(function() {
            $(document).on("click", ".btn-cancel", function(e) {
                e.preventDefault();
                let id = $(this).data("id")
                confirmDelete()
                    .then(function() {
                        $(`form-cancel${id}`).submit();
                    })
                    .catch();
            });

        });
    </script>
@endsection
