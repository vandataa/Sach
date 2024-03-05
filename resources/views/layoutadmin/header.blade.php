<ul class="navbar-nav ml-auto">
    <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="{{ route('dashboard.topds') }}" role="button">
            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512">
                <path
                    d="M200 32H56C42.7 32 32 42.7 32 56V200c0 9.7 5.8 18.5 14.8 22.2s19.3 1.7 26.2-5.2l40-40 79 79-79 79L73 295c-6.9-6.9-17.2-8.9-26.2-5.2S32 302.3 32 312V456c0 13.3 10.7 24 24 24H200c9.7 0 18.5-5.8 22.2-14.8s1.7-19.3-5.2-26.2l-40-40 79-79 79 79-40 40c-6.9 6.9-8.9 17.2-5.2 26.2s12.5 14.8 22.2 14.8H456c13.3 0 24-10.7 24-24V312c0-9.7-5.8-18.5-14.8-22.2s-19.3-1.7-26.2 5.2l-40 40-79-79 79-79 40 40c6.9 6.9 17.2 8.9 26.2 5.2s14.8-12.5 14.8-22.2V56c0-13.3-10.7-24-24-24H312c-9.7 0-18.5 5.8-22.2 14.8s-1.7 19.3 5.2 26.2l40 40-79 79-79-79 40-40c6.9-6.9 8.9-17.2 5.2-26.2S209.7 32 200 32z" />
            </svg>
        </a>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link p-0 pr-3" data-toggle="dropdown" href="#">
            <img src="{{ asset('assets/img/avatar5.png') }}" class='img-circle elevation-2' width="40"
                height="40" alt="">
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-3">
            <?php $user = Auth::user(); ?>
            <h4 class="h4 mb-0"><strong>{{ $user->name }}</strong></h4>
            <div class="mb-3">{{ $user->email }}</div>
            <div class="dropdown-divider"></div>
            <a href="{{ route('logoutAdmin') }}" class="dropdown-item text-danger">
                <i class="fas fa-sign-out-alt mr-2"></i> Đăng xuất
            </a>
        </div>
    </li>
</ul>
</nav>
<!-- /.navbar -->
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="{{ asset('assets/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Thống kê admin</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ route('dashboard.topds') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Thống kê</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('category.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>Thể loại</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('list.authors')}}" class="nav-link">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>Tác giả</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('publisher.list')}}" class="nav-link">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>Nhà xuất bản</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('book.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-tag"></i>
                        <p>Sách</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('users.list') }}" class="nav-link">
                        <i class="nav-icon  fas fa-users"></i>
                        <p>Tài khoản</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('sale.list') }}" class="nav-link">
                        <i class="nav-icon  fas fa-users"></i>
                        <p>Giảm giá</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('order.index') }}" class="nav-link">
                        <i class="nav-icon  fas fa-users"></i>
                        <p>Đơn hàng</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('review.index') }}" class="nav-link">
                        <i class="nav-icon  fas fa-users"></i>
                        <p>Bình luận</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('freeship.index') }}" class="nav-link">
                        <i class="nav-icon  fas fa-users"></i>
                        <p>Quản lý phí vận chuyển</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('history.index') }}" class="nav-link">
                        <i class="nav-icon  fas fa-users"></i>
                        <p>Nhật ký hoạt động </p>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
