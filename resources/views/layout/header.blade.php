<!-- Header -->
<header id="wn__header" class=" header__area header__absolute sticky__header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 col-sm-6 col-6 col-lg-2">
                <div class="logo">
                    <a href="/">
                        <img src="{{ asset('assets/images/logo.png') }}" style="width:130px; height:auto"
                            alt="logo images">
                    </a>
                </div>
            </div>
            <div class="col-lg-8 d-none d-lg-block">
                <nav class="mainmenu__nav">
                    <ul class="meninmenu d-flex justify-content-start">
                        <li class="drop with--one--item"><a href="{{ route('home') }}">Trang chủ</a>

                        </li>
                        <li class="drop"><a href="{{ route('books.show') }}">Sách</a>
                        </li>

                        <li class="drop"><a href="#">Thể loại</a>
                            <div class="megamenu dropdown">
                                <ul class="item item01">
                                    @foreach ($cate as $cat)
                                        <li>
                                            <a href="{{ url('view-category/' . $cat->slug) }}">{{ $cat->cate_Name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                        <li class="drop"><a href="#">Tác giả</a>
                            <div class="megamenu dropdown">
                                <ul class="item item01 ">
                                    @foreach ($auth as $au)
                                        <li class=""><a
                                                href="{{ url('view-auth/' . $au->slug) }}">{{ $au->name_author }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                        <li class="drop"><a href="#">Nhà xuất bản</a>
                            <div class="megamenu dropdown">
                                <ul class="item item01 ">
                                    @foreach ($publishers as $au)
                                        <li class=""><a
                                                href="{{ url('view-publis/' . $au->id) }}">{{ $au->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                        <li><a href="{{ route('contact') }}">Liên hệ</a></li>
                    </ul>
                </nav>
            </div>
            <div class="col-md-6 col-sm-6 col-6 col-lg-2">
                <ul class="header__sidebar__right d-flex justify-content-end align-items-center">
                    <li class="shop_search me-4 ">
                        <a class="search__active" href="#"></a>

                    </li>
                    <li class="shopcart"><a class="cartbox_active" href="#"><span class="product_qun">
                                @php
                                    $carts = [];
                                    $cart_total = 0;
                                    if (Auth::check()) {
                                        $carts = DB::table('carts')
                                            ->select('carts.quantity', 'carts.money', 'books.title_book', 'books.book_image', 'carts.id', 'carts.book_id')
                                            ->join('books', 'books.id', '=', 'carts.book_id')
                                            ->where('carts.user_id', '=', Auth::user()->id)
                                            ->get();

                                        echo $carts->count();
                                    } else {
                                        echo 0;
                                    }

                                @endphp
                                @if ($carts)
                                    @foreach ($carts as $cart)
                                        @php
                                            $cart_total += $cart->money * $cart->quantity;
                                        @endphp
                                    @endforeach

                                @endif


                            </span></a>
                        <!-- Start Shopping Cart -->
                        <div class="block-minicart minicart__active">
                            <div class="minicart-content-wrapper">
                                <div class="micart__close">
                                    <span>Đóng</span>
                                </div>
                                @if ($carts && $carts->count() > 0)
                                    <div class="single__items">
                                        <div class="miniproduct">
                                            @foreach ($carts as $cart)
                                                <div class="item01 d-flex mt--10">
                                                    <div class="thumb">
                                                        <a href="{{ route('book.detail', $cart->book_id) }}"><img
                                                                src="{{ asset('storage/images/' . $cart->book_image) }}"
                                                                alt="product images" style="width:80px"></a>
                                                    </div>
                                                    <div class="content">
                                                        <h6><a class="custom-p"
                                                                href="{{ route('book.detail', $cart->book_id) }}">{{ $cart->title_book }}</a>
                                                        </h6>
                                                        <span
                                                            style="font-size: 14px;font-weight:600">{{ number_format($cart->money, 0, ',', '.') }}
                                                            VNĐ</span>
                                                        <span class="qun">x {{ $cart->quantity }}</span>
                                                        <div class="product_price d-flex justify-content-between">
                                                            <span class="price">
                                                                Tổng:
                                                                {{ number_format($cart->money * $cart->quantity, 0, ',', '.') }}
                                                                VNĐ</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                        </div>
                                    </div>
                                @else
                                    <div class="single__items">
                                        <div class="miniproduct">
                                            Bạn chưa thêm sản phẩm nào vào giỏ hàng
                                        </div>
                                    </div>
                                @endif
                                <div class="mt-3 d-flex justify-content-between">
                                    <span class="fs-4">Tổng tiền</span>
                                    <span class="fs-5 fw-bold">{{ number_format($cart_total, 0, ',', '.') }} VNĐ</span>
                                </div>
                                <div class="mini_action cart">
                                    <a class="cart__btn" href="{{ route('cart.index') }}">Xem giỏ hàng</a>
                                </div>
                                {{-- <div class="mini_action checkout">
                                    <a class="checkout__btn" href="{{ route('cart.checkout') }}">Mua</a>
                                </div> --}}
                            </div>
                        </div>
                        <!-- End Shopping Cart -->
                    </li>
                    @if (Auth::check())
                        <li class="setting__bar__icon">
                            <a class="setting__active" href="#"></a>
                            <div class="searchbar__content setting__block">
                                <div class="content-inner">
                                    <div class="switcher-currency" style="font-size: 16px">
                                        <span class="d-flex justify-content-start">Xin chào</span>
                                        <strong class="label switcher-label">
                                            <span style="font-size: 20px">{{ Auth::user()->name }}</span>
                                        </strong>
                                        <div class="switcher-options">
                                            <div class="switcher-currency-trigger">
                                                @if (Auth::user()->role == 1 || Auth::user()->role == 2)
                                                    <span class="currency-trigger"><a href="/admin">Trang Quản
                                                            Trị</a></span>
                                                @elseif (Auth::user()->role == 3)
                                                    <span class="currency-trigger"><a
                                                            href="{{ route('my.account.detail') }}">Tài
                                                            khoản</a></span>
                                                @endif
                                                <span class="currency-trigger"><a href="{{ route('logout') }}">Đăng
                                                        xuất</a></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @else
                        <li class="">
                            <a class="text-danger fw-bold" style="width: 100px" href="{{ route('signin') }}">Đăng
                                nhập</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
        <!-- Start Mobile Menu -->
        <div class="row d-none">
            <div class="col-lg-12 d-none">
                <nav class="mobilemenu__nav">
                    <ul class="meninmenu ">
                        <li class="px-3 w-75"><a href="{{ route('home') }}">Trang chủ</a></li>
                        <li class="px-3 w-75"><a href="{{ route('books.show') }}">Sách</a></li>
                        <li class="px-3 w-75"><a href="{{ route('contact') }}">Liên hệ</a></li>
                    </ul>
                </nav>
            </div>
        </div>
        <!-- End Mobile Menu -->
        <div class="mobile-menu d-block d-lg-none">
        </div>
        <!-- Mobile Menu -->
    </div>
</header>
<!-- //Header -->
<!-- Start Search Popup -->
<div class="container-fluid box-search-content search_active block-bg close__top" style="height: 25%">
    <form class="mt-5" action="{{ route('search.key') }}" method="get">
        <div class="d-flex justify-content-center field__search p-5">
            <input class="border border-secondary-subtle col-3 px-3 " type="text" name="keyword"
                placeholder="Tên Sách ">
            <div class="action col-1">
                <button class="btn btn-secondary mx-3 w-100">Search</button>
            </div>
        </div>
    </form>
    <div class="close__wrap">
        <span>Đóng</span>
    </div>
</div>
<!-- End Search Popup -->
