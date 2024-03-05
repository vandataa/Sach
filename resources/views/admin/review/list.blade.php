@extends('layoutadmin.layout')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid my-2">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Bình luận</h1>
                    </div>
                    <div class="col-sm-6 text-right">
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
                        <div class="card-tools">
                            <form action="" role="form">
                                <div class="input-group input-group" style="width: 350px;">
                                    <input type="text" name="table_search" class="form-control float-right"
                                        placeholder="Tìm theo tên tài khoản | sách">

                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <strong>Tìm kiếm</strong>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th width="60">ID</th>
                                    <th>Nội dung</th>
                                    <th>Hình ảnh</th>
                                    <th>Tài khoản</th>
                                    <th width="100">Sách</th>
                                    <th width="100">Ngày</th>
                                    <th width="100">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($review as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->content }}</td>
                                        <td>
                                           @if($item->image)
                                                <img src="@if ($item->image) {{ asset('storage/images/' . $item->image) }} @else  @endif"
                                                     style="width: 50px" alt="">
                                            @else
                                                <p>Không đính kèm ảnh</p>
                                           @endif
                                        </td>
                                        <td>{{ $user->find($item->id_customer)->name }}</td>
                                        <td>{{ $book->find($item->id_book)->title_book }}</td>
                                        <td>{{ $item->created_at->format('j-m-Y - g:i ') }}</td>
                                        <td>
                                            @if($item->deleted_at)
                                                <a href="{{ route('comment.restore', $item->id) }}">Hiện</a>
                                            @else
                                                <a onclick="return confirm('Bạn muốn ẩn bình luận này?')"
                                                   href="{{ route('review.delete', $item->id) }}"
                                                   class="text-danger w-4 h-4 mr-1">
                                                    Ẩn
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer clearfix">
                        <ul class="pagination pagination m-0 float-right">
                            <li class="page-item"><a class="page-link" href="#">«</a></li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">»</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
@endsection
