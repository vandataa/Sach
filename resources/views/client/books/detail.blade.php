@extends('layout.layout')
@section('content')
<style>
.rating-container {
    display: inline-block;
}

.rating-number {
    margin-right: 0px; /* Để tạo khoảng cách giữa số đánh giá và biểu tượng sao */
}

.star-icon {
    color: #FFD700; /* Màu vàng cho ngôi sao */
    font-size: 20px;
}

</style>
    <!-- Start breadcrumb area -->
    <div class="ht__breadcrumb__area bg-image--6">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__inner text-center">
                        <h2 class="breadcrumb-title">Chi tiết sách</h2>
                        <nav class="breadcrumb-content">
                            <a class="breadcrumb_item" href="{{ route('books.show') }}}">Trang chủ</a>
                            <span class="brd-separator">/</span>
                            <span class="breadcrumb_item active">Chi tiết sách</span>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End breadcrumb area -->
    <!-- Start main Content -->
    <div class="maincontent bg--white pt--80 pb--55">
        @if (session('message'))
            <h6 style="color:red; width:100%;text-align:center">{{ session('message') }}</h6>
        @endif
        <div class="container">
            <form action="{{ route('client.carts.add') }}" method="POST">
                @csrf
                <input type="hidden" name="book_id" value="{{ $book->id }}">
                <div class="row">
                    <div class="col-lg-12 col-12">
                        <div class="wn__single__product">
                            <div class="row">
                                <div class="col-lg-6 col-12">
                                    <div class="wn__fotorama__wrapper">
                                        <div class="fotorama wn__fotorama__action" data-nav="thumbs">
                                            @foreach ($image as $image)
                                                <a href=""><img
                                                        src="{{ asset('storage/images/' . $image->image_path) }}"
                                                        alt=""></a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-12">
                                    <div class="product__info__main">
                                        <h1>{{ $book->title_book }}</h1>
                                        <div class="price-box d-flex">
                                            <span>{{ number_format($book->price, 0, ',', '.') }} VNĐ</span>

                                        </div>
                                        {{-- <div class="product__overview">

                                        </div> --}}
                                        <div class="product_meta my-3">
                                            <span class="posted_in">Tác giả:
                                                <a href="#" class="mx-3">{{ $auths->name_author }}</a>
                                            </span>
                                            <br>
                                            <span class="posted_in">Thể loại:
                                                <a href="#" class="mx-3">{{ $cates->cate_Name }}</a>
                                            </span>
                                            <br>
                                            <span class="posted_in">Nhà xuất bản:
                                                <a href="#" class="mx-3">{{ $publis->name }}</a>
                                            </span>
                                            <br>
                                            <span class="posted_in">Số lượng:
                                                <a href="#" class="mx-3">{{ $book->quantity }}</a>
                                            </span>
                                            <br>
                                            <span class="posted_in">Đánh giá:

                                                <a href="#" class="mx-3">
                                                    @if ($numberOfRatings>0)
                                                    {{$averageRating }}/5 <span class="star-icon">&#9733;</span>  Số lượng đánh giá ({{$numberOfRatings}} lượt)</a>
                                                    @else
                                                    Số lượng đánh giá ({{$numberOfRatings}} lượt) </a>
                                                @endif

                                            </span>
                                        </div>
                                        <div class="box-tocart d-flex">
                                            @if ($book->quantity > 0)
                                                <input id="qty" class="input-text qty" name="qty" min="1"
                                                    max="{{ $book->quantity }}" value="1" title="Qty"
                                                    type="number">
                                                    <div class="addtocart__actions">
                                                        <button class="tocart" type="submit" title="Add to Cart"><i
                                                                class="fa fa-shopping-cart mr-1"></i> Thêm giỏ hàng
                                                        </button>
                                                        @if (session('error'))
                                                            <p class="d-flex justify-content-start ps-3 text-danger">
                                                                {{ session('error') }}</p>
                                                        @endif
                                                    </div>
                                            @else
                                                <p class="fs-5 fw-bold text-danger">Sản phẩm này hiện đã hết hàng</p>
                                            @endif


                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
            </form>
            <div class="product__info__detailed">
                <div class="pro_details_nav nav justify-content-start" role="tablist">
                    <a class="nav-item nav-link active" data-bs-toggle="tab" href="#nav-details" role="tab">Mô tả</a>
                    <a class="nav-item nav-link" data-bs-toggle="tab" href="#nav-review" role="tab">Bình luận({{$numberOfReviews}})</a>
                    <a class="nav-item nav-link evaluate" data-bs-toggle="tab" href="#nav-evaluate" role="tab">Đánh giá({{$numberOfRatings}})</a>
                </div>
                <div class="tab__container tab-content">
                    <!-- Start Single Tab Content -->
                    <div class="pro__tab_label tab-pane fade show active" id="nav-details" role="tabpanel">
                        <div class="description__attribute">
                            @php
                                echo $book->description;
                            @endphp
                        </div>
                    </div>
                    <!-- End Single Tab Content -->
                    <!-- Start Single Tab Content -->
                    <div class="pro__tab_label tab-pane fade" id="nav-review" role="tabpanel">
                        <div class="review__attribute">
                            @if ($comment->count() > 0)
                                <div class="px-3"
                                    style="max-height:500px;overflow-y:auto; border:1px solid #efefef;border-radius:5px;">
                                    @foreach ($comment as $cm)
                                        <div class="card-body col-12 "
                                            style="margin-top: 20px;margin-bottom:15px; border:1px solid white ; border-radius:5px ;box-shadow:0 0 3px black;">
                                            <div class="align-items-center">
                                                <div>
                                                    <p class="text-muted small">
                                                        {{ $cm->created_at->format('j-m-Y g:i A') }}
                                                    </p>
                                                </div>
                                            </div>
                                            <h6 class="fw-bold mb-1">
                                                {{ $user->find($cm->id_customer)->name }}
                                            </h6>
                                            <span> Nội dung : <strong>{{ $cm->content }}</strong> </span> <br>
                                            @if ($cm->image)
                                                <img src="@if ($cm->image) {{ asset('storage/hinh/' . $cm->image) }} @else Không có ảnh @endif"
                                                    style="width: 50px" alt="">
                                            @else
                                                <span style=" font-style: italic;">
                                                    <p>*/Không đính kèm hình ảnh</p>
                                                </span>
                                            @endif

                                            @if (Auth::check())
                                                @if ($cm->id_customer == Auth::user()->id)
                                                    <br>
                                                    <div>
                                                        <a href="#" class="btn btn-primary btn-sm" role="button"
                                                            aria-pressed="true" id="edit-button">Sửa</a>
                                                        <a onclick="return confirm('Bạn có chắc muốn xóa?')"
                                                            href="{{ route('delete.comment', $cm->id) }}"
                                                            class="btn btn-primary btn-sm" role="button"
                                                            aria-pressed="true">Xóa</a>
                                                        <div id="comment-form-container" style="display: none;">
                                                            <form action="{{ route('edit.comment', $cm->id) }}"
                                                                enctype="multipart/form-data" method="POST">
                                                                @csrf
                                                                <div class="form-group">
                                                                    <label for="content">Bình luận :</label>
                                                                    <textarea class="form-control" name="content" id="content">{{ $cm->content }}</textarea>
                                                                </div>
                                                                <div class="form-group">
                                                                    <img id="image_preview"
                                                                        src="@if ($cm->image) {{ asset('storage/hinh/' . $cm->image) }} @else https://png.pngtree.com/element_our/png/20181206/users-vector-icon-png_260862.jpg @endif"
                                                                        style="width: 100px" alt=""> <br>
                                                                    <input type="file" accept="image/*" id="image"
                                                                        name="image"
                                                                        class="form-control-file @error('image') is-invalid @enderror">
                                                                    @error('image')
                                                                        <span class="invalid-feedback"
                                                                            role="alert">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                                <input type="hidden" class="form-control" name="id_book"
                                                                    id="id_book" value="{{ $book->id }}">
                                                                <div class="form-group text-right">
                                                                    <button type="button" class="btn btn-secondary" onclick="cancelUpdate()">Hủy</button>
                                                                    <button type="submit" class="btn btn-success">Cập
                                                                        nhật</button>
                                                                </div>
                                                            </form>
                                                        </div>


                                                    </div>
                                                @endif
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="fs-5 text-center text-danger fw-bold">Sản phẩm này hiện chưa có bình luận</p>
                            @endif

                        </div>
                        <div class="review-fieldset">
                            <div class="card-body col-12"
                                style="margin-top: 20px;margin-bottom:15px; border:1px solid white;border-radius:5px ;box-shadow:0 0 3px black;">

                                <div class="align-items-center">
                                    <form action="{{ route('post.comment') }}" enctype="multipart/form-data"
                                        method="POST">
                                        @csrf
                                        <div class="input__box">
                                            <div class="">
                                                <p class="mb-3  fs-4">Viết bình luận:</p>
                                                <textarea class="col-12 " style="height: 100px" name="content"></textarea>
                                            </div>
                                            <div class="my-3">
                                                <p class="mb-3  fs-4">Hình ảnh:</p>

                                                <input type="file" accept="image/*" id="image" name="image"
                                                    class="input-group @error('image') is-invalid @enderror">
                                            </div>
                                        </div>

                                        <input type="hidden" class="form-control" name="id_book" id="id_book"
                                            value="{{ $book->id }}">
                                        <div class="review-form-actions">
                                            <button class="btn btn-primary">Bình luận</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="pro__tab_label tab-pane fade show evaluate" id="nav-evaluate" role="tabpanel">
                        <div class="review__attribute">
                            @if ($evaluate->count() > 0)
                                <div class="px-3"
                                    style="max-height:500px;overflow-y:auto; border:1px solid #efefef;border-radius:5px;">
                                    @foreach ($evaluate as $evaluate)
                                        <div class="card-body col-12 "
                                            style="margin-top: 20px;margin-bottom:15px; border:1px solid white ; border-radius:5px ;box-shadow:0 0 3px black;">
                                            <div class="align-items-center">
                                                <div>
                                                    <p class="text-muted small">
                                                        {{ $evaluate->created_at->format('j-m-Y g:i A') }}
                                                    </p>
                                                </div>
                                            </div>
                                            <h6 class="fw-bold mb-1">
                                                {{ $user->find($evaluate->user_id)->name }}
                                            </h6>
                                            <Span>Đánh giá: </Span>
                                            <div class="rating-container">
                                                <span class="rating-number">{{ $evaluate->rating }}/5</span>
                                                <span class="star-icon">&#9733;</span>
                                            </div>
                                            <br>
                                            <span>Nội dung: {{ $evaluate->comment }} </span> <br>

                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="fs-5 text-center text-danger fw-bold">Sản phẩm này hiện chưa có đánh giá</p>
                            @endif

                        </div>
                    </div>
                    <!-- End Single Tab Content -->
                </div>
            </div>
            <div class="wn__related__product pt--80 pb--50">
                <div class="section__title text-center">
                    <h2 class="title__be--2">Sách cùng thể loại</h2>
                </div>
                <div class="row mt--60">
                    <div class="productcategory__slide--2 arrows_style owl-carousel owl-theme">
                        @foreach ($same as $same)
                            <div class="product product__style--3 col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="product__thumb">
                                    <a class="first__img" href="{{ route('book.detail', $same->id) }}"><img
                                            style="height: 250px; object-fit: cover"
                                            src="{{ asset('storage/images/' . $same->book_image) }}"
                                            alt="product image"></a>

                                </div>
                                <div class="product__content content--center">
                                    <h4><a href="{{ route('book.detail', $same->id) }}">{{ $same->title_book }}</a></h4>
                                    <ul class="price d-flex">
                                        <li>{{ number_format($same->price, 0, ',', '.') }} VNĐ</li>
                                    </ul>
                                    @if($same->quantity>0)
                                    <div class="action">
                                        <div class="actions_inner">
                                            <ul class="add_to_links">
                                                <li>
                                                    <form action="{{ route('client.carts.add.nhanh') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="book_id"
                                                            value="{{ $same->id }}">
                                                        <button type="submit"
                                                            class="btn border-0 text-danger bg-light fs-5 rounded-circle">
                                                            <i class="bi bi-shopping-bag4"></i>
                                                        </button>
                                                    </form>
                                                </li>

                                            </ul>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="wn__related__product">
                <div class="section__title text-center">
                    <h2 class="title__be--2">Top bán chạy</h2>
                </div>
                <div class="row mt--60">
                    <div class="productcategory__slide--2 arrows_style owl-carousel owl-theme">
                        @foreach ($upsells as $upsell)
                            <div class="product product__style--3 col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="product__thumb">
                                    <a class="first__img" href="{{ route('book.detail', $upsell->id) }}"><img
                                            style="height: 250px; object-fit: cover"
                                            src="{{ asset('storage/images/' . $upsell->book_image) }}"
                                            alt="product image"></a>

                                </div>
                                <div class="product__content content--center">
                                    <h4><a href="{{ route('book.detail', $upsell->id) }}">{{ $upsell->title_book }}</a>
                                    </h4>
                                    <ul class="price d-flex">
                                        <li>{{ number_format($upsell->price, 0, ',', '.') }} VNĐ</li>
                                    </ul>
                                    @if($upsell->quantity>0)
                                    <div class="action">
                                        <div class="actions_inner">
                                            <ul class="add_to_links">
                                                <li>
                                                    <form action="{{ route('client.carts.add.nhanh') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="book_id"
                                                            value="{{ $upsell->id }}">
                                                        <button type="submit"
                                                            class="btn border-0 text-danger bg-light fs-5 rounded-circle">
                                                            <i class="bi bi-shopping-bag4"></i>
                                                        </button>

                                                    </form>
                                                </li>

                                            </ul>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End main Content -->
    <!-- Start Search Popup -->

    <!-- End Search Popup -->
    <script>
        const editButton = document.getElementById('edit-button');
        const commentFormContainer = document.getElementById('comment-form-container');

        editButton.addEventListener('click', () => {
            commentFormContainer.style.display = 'block'; // Hiện container form khi người dùng nhấn vào nút "Sửa"
        });
    </script>
<script>
    function cancelUpdate() {
        document.getElementById('comment-form-container').style.display = 'none';
    }
</script>

@endsection
