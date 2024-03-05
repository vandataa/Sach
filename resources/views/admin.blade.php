@extends('layoutadmin.layout')

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Thống kê</h1>
                    </div>
                    <div class="col-sm-6">

                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-4 col-6">
                        <div class="small-box card">
                            <div class="inner">
                                <h3>{{ $books }}</h3>
                                <p>Số lượng sách</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-6">
                        <div class="small-box card">
                            <div class="inner">
                                <h3>{{ $user }}</h3>
                                <p>Số lượng khách hàng</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-6">
                        <div class="small-box card">
                            <div class="inner">
                                <h3>{{ $review }}</h3>
                                <p>Tổng bình luận từ khách hàng</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4 col-6">
                        <div class="small-box card">
                            <div class="inner">
                                <h3>{{ $order }}</h3>
                                <p>Tổng số đơn đặt hàng</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-6">
                        <div class="small-box card">
                            <div class="inner">
                                <h3>{{ $processOrders }}</h3>
                                <p>Tổng số đơn chờ xử lí</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-6">
                        <div class="small-box card">
                            <div class="inner">
                                <h3>{{ number_format($totalRevenuees, 0, ',', '.') }} VNĐ</h3>
                                <p>Tổng doanh thu</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="my__account__wrapper">
                <nav>
                    <div class="d-flex border-bottom">
                        <button class="nav-link fs-4 fw-bold border-0 bg-white" id="btn-home"><a id="home"
                                href="{{ route('dashboard.topds') }}">THỐNG KÊ DOANH SỐ</a></button>
                        <button class="nav-link fs-4 fw-bold border-0 bg-white" id="btn-pass"><a class=""
                                id="pass" href="{{ route('dashboard.top5sp') }}">Top 5 Sản Phẩm Bán Chạy</a></button>
                        <button class="nav-link fs-4 fw-bold border-0 bg-white" id="btn-history"><a class=""
                                id="history" href="{{ route('dashboard.topnsx') }}">Thống kê NSX</a></button>
                        <button class="nav-link fs-4 fw-bold border-0 bg-white" id="btn-history"><a class=""
                                ="favourite" href="{{ route('dashboard.topuser') }}">Top 5 Khách Hàng Mua Nhiều Nhất</a></button>
                    </div>
                </nav>
                <div>
                    @yield('myaccount')
                </div>


            </div>
            


            

           
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

            <script>
                var dailyRevenue = @json($dailyRevenue);
                var ctx = document.getElementById('bieudo-ngay').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: dailyRevenue.map(item => item.date),
                        datasets: [{
                            label: 'Doanh thu hàng ngày',
                            data: dailyRevenue.map(item => item.revenue),
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            </script>
        </section>
        <!-- /.content -->
    </div>
@endsection
