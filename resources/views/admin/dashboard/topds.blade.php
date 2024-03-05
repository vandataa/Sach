@extends('admin')
@section('title', 'Edit Account')
@section('myaccount')
<div style="width: 70%; margin: auto;" class="mt-3">
    <h3 class="text-center">BIỂU ĐỒ THỐNG KÊ DOANH SỐ</h3>
    <form action="{{ route('dashboard.topds') }}" method="get" class="mt-4">
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="start_date" class="form-label">Ngày bắt đầu:</label>
                <input type="date" id="start_date" name="start_datet"
                    class="form-control"value="{{ old('start_datet') }}" required>
            </div>
            <div class="col-md-4 mb-3">
                <label for="end_date" class="form-label">Ngày kết thúc:</label>
                <input type="date" id="end_date" name="end_datet"
                    class="form-control"value="{{ old('end_datet') }}" required>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Thống Kê</button>
    </form>
    @if ($selectedDatesst['start_datet'] === $selectedDatesst['end_datet'])
        <div class="mt-3">
            <p class="text-center">Ngày {{ $selectedDatesst['start_datet'] }} </p>
        </div>
    @else
        <p class="text-center">Từ ngày {{ $selectedDatesst['start_datet'] }} đến ngày
            {{ $selectedDatesst['end_datet'] }}</p>
    @endif
    <canvas id="bieudo-ngay"></canvas>
</div>
@endsection
