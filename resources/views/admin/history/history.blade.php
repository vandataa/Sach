@extends('layoutadmin.layout')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid my-2">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Nhật ký hoạt động</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="{{ route('list.authors') }}" class="btn btn-primary">Quay lại</a>
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
                        <div class="card-tools">
                            <div class="card-tools float-right">
                                <form method="post" action="{{ route('history.filter') }}" class="form-inline">
                                    @csrf
                                    @method('POST')
                                    <select name="action" class="form-control col-lg-3 col-12 my-2 pr-2">
                                        <option value="">Hành Động</option>
                                        <option value="Thêm mới">Thêm mới</option>
                                        <option value="Cập nhật">Cập nhật</option>
                                        <option value="Xóa">Xóa</option>
                                        <option value="Khôi phục">Khôi phục</option>
                                    </select>
                                    <select name="table" class="form-control col-lg-3 col-12 my-2 pr-2">
                                        <option value="">Tên Bảng</option>
                                        <option value="App\Models\Author">Tác giả</option>
                                        <option value="App\Models\Sale">Giảm giá</option>
                                        <option value="App\Models\Category">Thể loại</option>
                                        <option value="App\Models\Book">Sách</option>
                                        <option value="App\Models\User">Tài khoản</option>
                                        <option value="App\Models\Review">Bình luận</option>
                                        <option value="App\Models\Order">Đơn hàng</option>
                                    </select>
                                    <div class="form-group">
                                        <input type="text" name="searchInput" class="form-control"
                                               placeholder="Tên tài khoản">
                                    </div>
                                    <div class="form-group">

                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default">
                                                <strong>Tìm kiếm</strong>
                                            </button>
                                        </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>

                            <tr>
                                <th width="60">#</th>
                                <th>Tên tài khoản</th>
                                <th>Email</th>
                                <th>Hoạt động</th>
                                <th>Bảng</th>
                                <th>Thời gian</th>
                                <th>Hành động</th>

                            </tr>
                        </thead>
                        <tbody>
                        @php
                            $key = 1;

                        @endphp
                        @foreach ($his as $key=>$item)

                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $users->find($item->causer_id)->name }}</td>
                                <td>{{ $users->find($item->causer_id)->email }}</td>
                                <td>{{ $item->description }}</td>
                                <td>{{ $subject_type[$item->subject_type] }}</td>
                                    <?php
                                    $formattedDateTime = \Carbon\Carbon::parse($item->created_at)->format('d-m-Y H:i:s');
                                    ?>
                                <td>{{ $formattedDateTime }}</td>
                                <td><a href="{{ route('history.detail', $item->id) }}">Chi tiêt</a></td>


                            </tr>
                        @endforeach
                        </tbody>

                    </table>
                </div>
                <div class="card-footer clearfix">
                    <ul class="pagination pagination m-0 float-right">
                        {{ $his->appends(request()->all())->links() }}
                    </ul>
                </div>
            </div>
    </div>

    <hr>

    </section>

    </div>
@endsection
