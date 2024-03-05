@extends('admin')
@section('title', 'Edit Account')
@section('myaccount')
<section style="margin-top: 75px;">
    <h3 class="text-center">THỐNG KÊ TOP 5 SẢN PHẨM BÁN CHẠY </h3>
    <div style="margin-top: 25px; width: 60%; margin: auto;">
        <form action="{{ route('dashboard.top5sp') }}" method="get"
            class="mt-4 d-flex justify-content-between align-items-center">
            <div class="col-md-4 mb-3">
                <label for="start_date" class="form-label">Ngày bắt đầu:</label>
                <input type="date" id="start_date" name="start_datee" class="form-control" required>
            </div>
            <div class="col-md-4 mb-3">
                <label for="end_date" class="form-label">Ngày kết thúc:</label>
                <input type="date" id="end_date" name="end_datee" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary btn-xl">Thống Kê</button>
        </form>
    </div>

    @if ($selectedDates['start_datee'] === $selectedDates['end_datee'])
        <div class="mt-3">
            <p class="text-center">Ngày {{ $selectedDates['start_datee'] }} </p>
        </div>
    @else
        <p class="text-center">Từ ngày {{ $selectedDates['start_datee'] }} đến ngày
            {{ $selectedDates['end_datee'] }}</p>
    @endif
    @if (count($result) === 0)
        {{-- <h5 class="text-center"> Tháng {{ $parsedDate->format('m') }}</h5> --}}
        <h6 class="text-center">Không có dữ liệu</h6>
    @else
        {{-- <h5 class="text-center"> Tháng {{ $parsedDate->format('m') }}</h5> --}}
        <div class="row" style="margin-top: 20px;">
            @foreach ($result as $book)
                <div class="col-lg-2 col-4">
                    <div class="small-box card">
                        <div class="inner">
                            <img src="{{ asset('storage/images/' . $book->book_image) }}"
                                alt="{{ $book->book_name }}" class="img-fluid">
                            <h5 class="card-title">{{ $book->book_name }}</h5>
                            <p class="card-text">Số lượng đã bán: {{ $book->total_quantity }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</section>
@endsection
