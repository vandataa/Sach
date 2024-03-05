@extends('admin')
@section('title', 'Edit Account')
@section('myaccount')
<section style="margin-top: 75px;">
    <div class="col-10 mx-auto">
        <h3 class="text-center">BẢNG THÔNG KÊ DOANH THU THEO NHÀ XUẤT BẢN</h3>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Nhà xuất bản</th>
                        <th>Doanh thu</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($revenueByPublisher as $key => $revenue)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $revenue->publisher_name }}</td>
                            <td>{{ number_format($revenue->total_revenue, 0, ',', '.') }} VNĐ</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
