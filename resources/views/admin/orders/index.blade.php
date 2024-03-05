@extends('layoutadmin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid my-2">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Đơn hàng</h1>
                    </div>
                    <div class="col-sm-6 text-right">

                        <a href="{{ route('order.category') }}" class="btn btn-primary">Nhật ký hoạt động</a>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">

                        <div class="card-tools float-right">
                            <form method="post" action="{{ route('order.filter') }}" class="form-inline">
                                @csrf
                                @method('POST')
                                <div class="form-group">
                                    <select name="status" class="form-control">
                                        <option value="">Tìm theo trạng thái đơn hàng</option>
                                        <option value="Đang xử lý">Đang xử lý</option>
                                        <option value="Đang giao hàng">Đang giao hàng</option>
                                        <option value="Giao hàng thành công">Giao hàng thành công</option>
                                        <option value="Hủy đơn hàng">Hủy đơn hàng</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input type="text" name="searchInput" class="form-control" placeholder="Tìm kiếm theo Username">
                                </div>
                                <div class="form-group">
                                <input type="text" name="code_bill" class="form-control float-right"
                                    placeholder="Tìm kiếm theo mã đơn hàng">
                                </div>
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <strong>Tìm kiếm</strong>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>STT </th>
                                    <th>Mã đơn hàng </th>
                                    <th style="max-width: 135px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Tên khách hàng</th>
                                    <th>Số điện thoại</th>
                                    <th style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Địa chỉ nhận hàng</th>
                                    <th>Tổng tiền</th>
                                    <th>Trạng thái</th>
                                    <th>Phương thức thanh toán</th>
                                    <th>Ngày đặt hàng</th>
                                </tr>
                            </thead>
                            @php $i =1; @endphp
                            <tbody>
                                @foreach ($orders as $key => $item)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td><a href="{{ route('order.detail', $item->id) }}">{{ $item->code_bill }}</a></td>
                                        <td style="max-width: 135px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{  $item->name}}</td>
                                        <td>{{ $item->phone }}</td>
                                        <td style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $item->address }}</td>
                                        <td>{{ number_format( $item->total, 0, ',', '.') }} VNĐ</td>
                                        <td>
                                            <select name="status" class="form-control select-status"
                                                data-action="{{ route('admin.orders.update_status', $item->id) }}">
                                                @if($item->status=="Đang xử lý")
                                                    <option value="Đang xử lý" selected > Đang xử lý</option>
                                                    <option value="Đang Giao Hàng"  > Đang Giao Hàng</option>
                                                    <option value="Giao hàng thành công"  > Giao hàng thành công</option>
                                                    <option value="Hủy đơn hàng"  > Hủy đơn hàng</option>
                                                @elseif($item->status=="Đang Giao Hàng")
                                                    <option value="Đang Giao Hàng" selected > Đang Giao Hàng</option>
                                                    <option value="Giao hàng thành công"  > Giao hàng thành công</option>
                                                    <option value="Hủy đơn hàng"  > Hủy đơn hàng</option>
                                                @elseif($item->status=="Giao hàng thành công")
                                                    <option value="Giao hàng thành công" selected > Giao hàng thành công</option>
                                                @elseif($item->status=="Hủy đơn hàng")
                                                    <option value="Hủy đơn hàng"  selected> Hủy đơn hàng</option>
                                                @endif
                                            </select>
                                        </td>
                                        <td>{{ $item->payment }}</td>
                                        <?php
                                            $date = \Carbon\Carbon::parse($item->date)->format('d/m/Y');
                                        ?>
                                        <td>{{ $date }}</td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer clearfix">
                        <ul class="pagination pagination m-0 float-right">
                            <ul class="pagination pagination m-0 float-right">
                                {{ $orders->appends(request()->all())->links() }}
                            </ul>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
@endsection
@section('script')
@endsection
