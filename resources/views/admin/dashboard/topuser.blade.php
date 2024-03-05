@extends('admin')
@section('title', 'Edit Account')
@section('myaccount')
<section style="margin-top: 75px;">
    <div class="col-10 mx-auto">
        <h4 class="text-center">THỐNG KÊ TOP 5 KHÁCH HÀNG MUA NHIỀU NHẤT</h4>
        <form action="{{ route('dashboard.topuser') }}" method="get" class="mt-4">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="start_date" class="form-label">Ngày bắt đầu:</label>
                    <input type="date" id="start_date" name="start_date" class="form-control">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="end_date" class="form-label">Ngày kết thúc:</label>
                    <input type="date" id="end_date" name="end_date" class="form-control">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Thống Kê</button>
        </form>

        @if ($selectedDatess['start_date'] === $selectedDatess['end_date'])
            <div class="mt-3">
                <p class="text-center">Ngày {{ $selectedDatess['start_date'] }} </p>
            </div>
        @else
            <p class="text-center">Từ ngày {{ $selectedDatess['start_date'] }} đến ngày
                {{ $selectedDatess['end_date'] }}</p>
        @endif

        @if (count($topUser) === 0)
            {{-- <h5 class="text-center"> Tháng {{ $userdMonth }}</h5> --}}
            <h6 class="text-center">Không có dữ liệu</h6>
        @else
            {{-- <h5 class="text-center"> Tháng {{ $userdMonth }}</h5> --}}
            <div class="row" style="margin-top: 20px;">
                @foreach ($topUser as $user1)
                    <div class="col-lg-4 col-4 mb-2">
                        <div class="small-box card">
                            <div class="inner">
                                <h5 class="card-title"> Tên khách hàng: {{ $user1->name }}</h5>
                                <h5 class="card-title"> Email: {{ $user1->email }}</h5>
                                <p class="card-text">Số lượng đã mua: {{ $user1->total_books_ordered }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection
