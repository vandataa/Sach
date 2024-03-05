@extends('client.customer.my-Account')
@section('title', 'Edit Account')
@section('myaccount')

<h4 class="text-center" style="margin-top: 25px;">Danh sách sách yêu thích của bạn</h4>
    @if (session('success'))
                <h6 class="text-danger text-center" style="margin-top: 25px; margin-bottom: 25px">{{ session('success') }}</h6>
            @endif
    @if ($favourites->isEmpty())
        <p class="text-center">Không có sách nào trong danh sách yêu thích của bạn.</p>
    @else
    <div class="row justify-content-center" style="margin-top: 25px;">
        @foreach ($favourites as $data)
            <!-- Start Single Product -->
            <div class="product product__style--3 col-lg-4 col-md-4 col-sm-6 col-12">
                <div class="product__thumb">
                    <a class="first__img" href="{{ route('book.detail', $data->book_id) }}"><img style="height: 250px; object-fit: cover" src="{{ asset('storage/images/' . $data->book->book_image) }}"></a>
                </div>
                <div class="product__content content--center text-center"> <!-- Thêm class text-center để căn giữa nội dung -->
                    <h4><a href="{{ route('book.detail', $data->book_id) }}">{{ $data->book->title_book }}</a></h4>
                    <ul class="price d-flex">
                        <li>{{ number_format($data->book->price, 0, ',', '.') }} VNĐ</li>
                    </ul>

                        <div class="action">
                            <div class="actions_inner">
                                <ul class="add_to_links">
                                    <li>
                                        <form action="{{ route('client.favourite.delete') }}" method="POST" >
                                            @csrf
                                            <input type="hidden" name="book_id" value="{{ $data->book->id }}">
                                            <button type="submit" class="btn border-0 text-danger bg-light fs-5 rounded-circle"  onclick="return confirm('Bạn có chắc muốn xóa')">
                                                <i class="fa fa-remove" style="font-size:24px"></i>
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>

                </div>
            </div>
            <!-- End Single Product -->
        @endforeach
    </div>

    @endif

@endsection
