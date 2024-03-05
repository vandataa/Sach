@extends('layout.layout')

@section('title', 'Home')
@section('content')
    <!-- Start Search Popup -->
    <!-- End Search Popup -->
    <!-- Start Slider area -->
    <div class="slider-area brown__nav slider--15 slide__activation slide__arrow01 owl-carousel owl-theme">
        <!-- Start Single Slide -->
        <div class="slide animation__style10 bg-image--8 fullscreen align__center--left">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="slider__content">
                            <div class="contentbox">
                                <h3>Tri Thức online</h3>
                                <h2>Cửa Hàng <span>Tri Thức</span></h2>
                                <h2 class="another">Của <span>Người Việt </span></h2>
                                <p>Tri thức Online , nơi mang đến cho bạn những đầu sách mới , đầy đủ ,chất lượng nhất
                                </p>
                                <a class="shopbtn" href="{{ route('books.show') }}">Mua ngay</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Single Slide -->
        <!-- Start Single Slide -->
        <div class="slide animation__style10 bg-image--9 fullscreen align__center--left">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="slider__content">
                            <div class="contentbox">
                                <h3>Tri thức online</h3>
                                <h2>Cửa Hàng <span>Tri Thức</span></h2>
                                <h2 class="another">Của <span>Người Việt </span></h2>
                                <p>Tri thức Online , nơi mang đến cho bạn những đầu sách mới , đầy đủ ,chất lượng nhất
                                </p>
                                <a class="shopbtn" href="{{ route('books.show') }}">Mua ngay</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Single Slide -->
    </div>
    <!-- End Slider area -->
    <!-- Start BEst Seller Area -->
    <section class="wn__product__area brown--color pt--80  pb--30">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section__title text-center">
                        <h2 class="title__be--2">Sách <span class="color--theme">Mới</span></h2>
                        <p>Điều tồi tệ nhất với những cuốn sách mới là chúng ngăn ta đọc những cuốn sách cũ.</p>
                        <p>(John Wooden)</p>
                    </div>
                </div>
            </div>
            <!-- Start Single Tab Content -->
            <div class="furniture--4 border--round arrows_style owl-carousel owl-theme mt--50 ">
                <!-- Start Single Product -->
                @foreach ($products as $item)
                    <div class="product product__style--3">
                        <div class="product__thumb">
                            <a class="first__img" href="{{ route('book.detail', $item->id) }}"><img class="img-fluid"
                                    style="height:300px" src="{{ asset('storage/images/' . $item->book_image) }}"></a>
                        </div>
                        <div class="product__content content--center">
                            <h4><a href="{{ route('book.detail', $item->id) }}">{{ $item->title_book }}</a></h4>
                            <ul class="price d-flex">
                                <li>{{ number_format($item->price, 0, ',', '.') }} VNĐ</li>
                            </ul>
                            @if($item->quantity>0)
                            <div class="action">
                                <div class="actions_inner">
                                    <ul class="add_to_links">
                                        <li>
                                            <form action="{{ route('client.favourite.add') }}" method="POST" >
                                                @csrf
                                                <input type="hidden" name="book_id" value="{{ $item->id }}">
                                                <button type="submit" class="btn border-0 text-danger bg-light fs-5 rounded-circle">
                                                    <i class="bi bi-heart-beat"></i>
                                                </button>
                                            </form>
                                        </li>
                                        <li>
                                            <form action="{{ route('client.carts.add.nhanh') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="book_id" value="{{ $item->id }}">
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
                <!-- Start Single Product -->
                <!-- Start Single Product -->
            </div>
            <!-- End Single Tab Content -->
        </div>
    </section>
    <!-- Start Testimonial Area -->
    <section class="wn__testimonial__area bg--gray ptb--80">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-12">
                    <div class="testimonial__container text-center">
                        <div class="tes__img__slide thumb_active">
                            <div class="testimonial__img">
                                <span><img style="width: 100px;height: 100px; object-fit: cover"
                                        src="{{ asset('assets/images/testimonial/1.jpg') }}" alt="testimonial image"></span>
                            </div>
                            <div class="testimonial__img">
                                <span><img style="width: 100px;height: 100px; object-fit: cover"
                                        src="{{ asset('assets/images/testimonial/2.jpg') }}"
                                        alt="testimonial image"></span>
                            </div>
                            <div class="testimonial__img">
                                <span><img style="width: 100px;height: 100px; object-fit: cover"
                                        src="{{ asset('assets/images/testimonial/3.jpg') }}"
                                        alt="testimonial image"></span>
                            </div>
                            <div class="testimonial__img">
                                <span><img style="width: 100px;height: 100px; object-fit: cover"
                                        src="{{ asset('assets/images/testimonial/4.jpg') }}"
                                        alt="testimonial image"></span>
                            </div>
                        </div>
                        <div class="testimonial__text__slide testext_active">
                            <div class="clint__info">
                                <p>Việc đọc rất quan trọng. Nếu bạn biết cách đọc, cả thế giới sẽ mở ra cho bạn.</p>
                                <div class="name__post">
                                    <span>Barack Obama

                                    </span>
                                    <h6>Tổng thống thứ 44 của Hoa Kỳ</h6>
                                </div>
                            </div>
                            <div class="clint__info">
                                <p>Tôi đọc lòi cả mắt và vẫn không đọc được tới một nửa… người ta càng đọc nhiều, người ta
                                    càng thấy còn nhiều điều cần phải đọc.

                                </p>
                                <div class="name__post">
                                    <span>John Adams</span>
                                    <h6>Tổng thống thứ hai của Hoa Kỳ</h6>
                                </div>
                            </div>
                            <div class="clint__info">
                                <p>Tất cả những gì con người làm, nghĩ hoặc trở thành: được bảo tồn một cách kỳ diệu trên
                                    những trang sách.

                                </p>
                                <div class="name__post">
                                    <span>Thomas Carlyle</span>
                                    <h6>Một nhà tiểu luận, nhà sử học và triết gia người Anh đến từ vùng đất thấp Scotland
                                    </h6>
                                </div>
                            </div>
                            <div class="clint__info">
                                <p>Chỉ trong sách, con người mới biết đến sự thật, tình yêu và cái đẹp hoàn hảo.

                                </p>
                                <div class="name__post">
                                    <span>George Bernard Shaw</span>
                                    <h6>Một nhà viết kịch, nhà phê bình, nhà bút chiến và nhà hoạt động chính trị người
                                        Ireland</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Testimonial Area -->
    <!-- Start Best Seller Area -->
    <section class="wn__product__area brown--color pt--80  pb--30">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section__title text-center">
                        <h2 class="title__be--2">Top sách <span class="color--theme">Bán chạy</span></h2>
                        <p>Điều tồi tệ nhất với những cuốn sách mới là chúng ngăn ta đọc những cuốn sách cũ.</p>
                        <p>(John Wooden)</p>
                    </div>
                </div>
            </div>
            <!-- Start Single Tab Content -->
            <div class="furniture--4 border--round arrows_style owl-carousel owl-theme mt--50">
                <!-- Start Single Product -->
                @foreach ($topSellingBooks as $item)
                    <div class="product product__style--3">
                        <div class="product__thumb">
                            <a class="first__img" href="{{ route('book.detail', $item->id) }}"><img class="img-fluid"
                                    style="height:300px" src="{{ asset('storage/images/' . $item->book_image) }}"></a>

                        </div>
                        <div class="product__content content--center">
                            <h4><a href="{{ route('book.detail', $item->id) }}">{{ $item->title_book }}</a></h4>
                            <ul class="price d-flex">
                                <li>{{ number_format($item->price, 0, ',', '.') }} VNĐ</li>
                            </ul>
                            @if($item->quantity>0)
                            <div class="action">
                                <div class="actions_inner">
                                    <ul class="add_to_links">
                                        <li>
                                            <form action="{{ route('client.favourite.add') }}" method="POST" >
                                                @csrf
                                                <input type="hidden" name="book_id" value="{{ $item->id }}">
                                                <button type="submit" class="btn border-0 text-danger bg-light fs-5 rounded-circle">
                                                    <i class="bi bi-heart-beat"></i>
                                                </button>
                                            </form>
                                        </li>


                                        <li>
                                            <form action="{{ route('client.carts.add.nhanh') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="book_id" value="{{ $item->id }}">
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
                <!-- Start Single Product -->
                <!-- Start Single Product -->
            </div>
            <!-- End Single Tab Content -->
        </div>
    </section>
    <section class="wn__bestseller__area bg--white pt--80  pb--30">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section__title text-center">
                        <h2 class="title__be--2">Sách <span class="color--theme"></span></h2>
                        <p>Một vài người nói họ chỉ sống có một lần trong đời. Đó là vì họ đã không đọc sách

                        </p>
                    </div>
                </div>
            </div>


            <div class="tab__container tab-content mt--60">
                <!-- Start Single Tab Content -->
                <div class=" single__tab tab-pane fade show active" id="nav-all" role="tabpanel">
                    <div class="product__indicator--4 arrows_style owl-carousel owl-theme">
                        @foreach ($product as $item)
                            <!-- Start Single Product -->
                            <div class="single__product__inner">

                                <div class="product product__style--3">

                                    <div class="product__thumb">
                                        <a class="first__img" href="{{ route('book.detail', $item->id) }}"><img
                                                class="img-fluid" style="height:300px"
                                                src="{{ asset('storage/images/' . $item->book_image) }}"></a>


                                    </div>
                                    <div class="product__content content--center content--center">
                                        <h4><a href="{{ route('book.detail', $item->id) }}">{{ $item->title_book }}</a>
                                        </h4>
                                        <ul class="price d-flex">
                                            <li>{{ number_format($item->price, 0, ',', '.') }} VNĐ</li>
                                        </ul>
                                        @if($item->quantity>0)
                                        <div class="action">
                                            <div class="actions_inner">
                                                <ul class="add_to_links">
                                                    <li>
                                                        <form action="{{ route('client.favourite.add') }}" method="POST" >
                                                            @csrf
                                                            <input type="hidden" name="book_id" value="{{ $item->id }}">
                                                            <button type="submit" class="btn border-0 text-danger bg-light fs-5 rounded-circle">
                                                                <i class="bi bi-heart-beat"></i>
                                                            </button>
                                                        </form>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('client.carts.add.nhanh') }}"
                                                            method="POST">
                                                            @csrf
                                                            <input type="hidden" name="book_id"
                                                                value="{{ $item->id }}">
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

                            </div>

                            <!-- Start Single Product -->
                        @endforeach
                    </div>
                </div>

                <!-- End Single Tab Content -->

                <!-- End Single Tab Content -->
            </div>
        </div>
    </section>

    <!-- End Recent Post Area -->
@endsection
