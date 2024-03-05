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
                        <a href="{{ route('users.list') }}" class="btn btn-primary">Quay lại</a>
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
                            <form role="form">
                                <div class="input-group " style="width: 350px;">
                                    <input type="text" name="table_search" class="form-control float-right"
                                           placeholder="Search by user name">
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
                                <th width="60">STT</th>
                                <th>Quản trị</th>
                                <th>Email</th>
                                <th>Hoạt động</th>
                                <th>Bảng</th>
                                <th>Username</th>

                                <th>Thời gian</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php $i=1; @endphp
                            @foreach ($his as $item)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    @php
                                        $user = $users->find($item->causer_id);
                                    @endphp
                                    <td>{{ optional($user)->name }}</td>
                                    <td>{{ optional($user)->email }}</td>
                                    <td>{{ $event[$item->event] }}</td>
                                    <td>{{ $subject_type[$item->subject_type] }}</td>
                                    <td>{{ optional($user)->username }}</td>
                                    <td>{{ $item->created_at->format('j-m-Y - g:i ') }}</td>
                                </tr>
                            @endforeach()
                        </table>
                    </div>
                    <hr>
                </div>
            </div>
        </section>
    </div>
@endsection
