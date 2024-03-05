@extends('layout.layout')
@section('content')
    <!-- Start breadcrumb area -->
    <div class="ht__breadcrumb__area bg-image--6">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__inner text-center">
                        <h2 class="breadcrumb-title">Kho Sách</h2>
                        <nav class="breadcrumb-content">
                            <a class="breadcrumb_item" href="index.html">Trang chủ</a>
                            <span class="brd-separator">/</span>
                            <span class="breadcrumb_item active">Kho sách</span>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End breadcrumb area -->
    <!-- Start Shop Page -->
    <div class="page-shop-sidebar left--sidebar bg--white section-padding--lg">
        @if (session('message'))
            <h6 style="color:red; width:100%;text-align:center">{{ session('message') }}</h6>
        @endif
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-12 order-2 order-lg-1 md-mt-40 sm-mt-40">
                    <div class="shop__sidebar">
                        <aside class="widget__categories products--cat">
                            <h3 class="widget__title">Thể loại sách</h3>
                            <ul>
                                @foreach ($cate as $cat)
                                    <li><a href="{{ url('view-category/' . $cat->slug) }}">{{ $cat->cate_Name }}
                                            <span>({{ $categoryCounts[$cat->id] }})</span></a></li>
                                @endforeach
                            </ul>
                        </aside>
                        <aside class="widget__categories products--tag">
                            <h3 class="widget__title">Tác giả</h3>
                            <ul>
                                @foreach ($auth as $au)
                                    <li><a href="{{ url('view-auth/' . $au->slug) }}">{{ $au->name_author }}
                                            <span>({{ $authCounts[$au->id] }})</span></a></li>
                                @endforeach
                            </ul>

                        </aside>
                        <aside class="widget__categories products--tag">
                            <h3 class="widget__title">Nhà xuất bản</h3>
                            <ul>
                                @foreach ($publishers as $au)
                                    <li><a href="{{ url('view-publis/' . $au->id) }}">{{ $au->name }}
                                            <span>({{ $publisherCounts[$au->id] }})</span></a></li>
                                @endforeach
                            </ul>
                        </aside>
                    </div>
                </div>
                <div class="col-lg-9 col-12 order-1 order-lg-2">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="shop__list__wrapper d-flex flex-wrap flex-md-nowrap justify-content-end">
                                <div class="orderby__wrapper">
                                    {{-- <form action="{{ route('fillterByPrice') }}" method="POST"> --}}
                                    <form action="">
                                        <span>Tìm kiếm theo</span>
                                        <select class="shot__byselect" name="fillter">
                                            <option value="0">Lọc sách</option>
                                            <option value="1">Mới nhất </option>
                                            <option value="2">Giá tăng dần </option>
                                            <option value="3">Giá giảm dần</option>
                                        </select>
                                        <button class="btn btn-primary">Tìm</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab__container tab-content">
                        <div class="shop-grid tab-pane fade show active" id="nav-grid" role="tabpanel">
                            <div class="row">
                                @foreach ($datas as $data)
                                    <!-- Start Single Product -->
                                    <div class="product product__style--3 col-lg-4 col-md-4 col-sm-6 col-12">

                                        <div class="product__thumb">
                                            <a class="first__img" href="{{ route('book.detail', $data->id) }}"><img
                                                    style="height: 250px; object-fit: cover"
                                                    src="{{ asset('storage/images/' . $data->book_image) }}"></a>


                                        </div>
                                        <div class="product__content content--center">
                                            <h4><a href="{{ route('book.detail', $data->id) }}">{{ $data->title_book }}</a>
                                            </h4>
                                            <ul class="price d-flex">
                                                <li>{{ number_format($data->price, 0, ',', '.') }} VNĐ</li>
                                            </ul>
                                            @if($data->quantity>0)
                                                <div class="action">
                                                    <div class="actions_inner">
                                                        <ul class="add_to_links">
                                                            <li>
                                                                <form action="{{ route('client.favourite.add') }}" method="POST" >
                                                                    @csrf
                                                                    <input type="hidden" name="book_id" value="{{ $data->id }}">
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
                                                                        value="{{ $data->id }}">
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
                                    <!-- End Single Product -->
                                @endforeach
                            </div>


                            <div class="pagination pagination m-0 float-right">
                                {{ $datas->appends(request()->all())->links() }}
                            </div>


                        </div>
                        <div class="shop-grid tab-pane fade" id="nav-list" role="tabpanel">
                            <div class="list__view__wrapper">

                                <!-- Start Single Product -->
                                <div class="list__view">
                                    <div class="thumb">
                                        <a class="first__img" href="single-product.html"><img src=""
                                                alt="product images"></a>
                                        <a class="second__img animation1" href="single-product.html"><img
                                                src="images/product/2.jpg" alt="product images"></a>
                                    </div>
                                    <div class="content">
                                        <h2><a href="single-product.html">Ali Smith</a></h2>
                                        <ul class="rating d-flex">
                                            <li class="on"><i class="fa fa-star-o"></i></li>
                                            <li class="on"><i class="fa fa-star-o"></i></li>
                                            <li class="on"><i class="fa fa-star-o"></i></li>
                                            <li class="on"><i class="fa fa-star-o"></i></li>
                                            <li><i class="fa fa-star-o"></i></li>
                                            <li><i class="fa fa-star-o"></i></li>
                                        </ul>
                                        <ul class="price__box">
                                            <li>$111.00</li>
                                            <li class="old__price">$220.00</li>
                                        </ul>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam fringilla
                                            augue nec est tristique auctor. Donec non est at libero vulputate
                                            rutrum. Morbi ornare lectus quis justo gravida semper. Nulla tellus mi,
                                            vulputate adipiscing cursus eu, suscipit id nulla.</p>
                                        <ul class="cart__action d-flex">
                                            <li class="cart"><a href="cart.html">Add to cart</a></li>
                                            <li class="wishlist"><a href="cart.html"></a></li>
                                            <li class="compare"><a href="cart.html"></a></li>
                                        </ul>

                                    </div>
                                </div>
                                <!-- End Single Product -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Shop Page -->
@endsection
