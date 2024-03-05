@extends('layoutadmin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid my-2">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Tạo tài khoản</h1>
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
                    <div class="card-body">
                        <form action="{{ route('users.create.post') }}" method="POST">
                            @csrf
                            <div class="row">

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="email">Username</label>
                                        <input type="text" name="username" id="email" class="form-control"
                                            placeholder="Username" value="{{ old('username') }}">
                                        @error('username')
                                            <p style="font-size: 14px;color:red;float:left">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="email">Password</label>
                                        <input type="text" name="password" id="email" class="form-control"
                                            placeholder="Password" value="{{ old('password') }}">
                                        @error('password')
                                            <p style="font-size: 14px;color:red;float:left">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="name">Họ và tên</label>
                                        <input type="text" name="name" id="name" class="form-control"
                                            placeholder="Name" value="{{ old('name') }}">
                                        @error('name')
                                            <p style="font-size: 14px;color:red;float:left">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="email">Email</label>
                                        <input type="text" name="email" id="email" class="form-control"
                                            placeholder="Email" value="{{ old('email') }}">
                                        @error('email')
                                            <p style="font-size: 14px;color:red;float:left">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="phone">Số điện thoại</label>
                                        <input type="text" name="phone" id="phone" class="form-control"
                                            placeholder="Phone" value="{{ old('phone') }}">
                                        @error('phone')
                                            <p style="font-size: 14px;color:red;float:left">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                @if (Auth::user()->role === 1)
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="email">Quyền</label><br>
                                            <div class="pt-2 pb-2">
                                                <div class="form-check form-check-inline">
                                                    <input value="1" class="form-check-input" type="radio"
                                                        name="role" id="admin">
                                                    <label class="form-check-label" for="admin">
                                                        Admin
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input value="2" class="form-check-input" type="radio"
                                                        name="role" id="nhanvien" checked>
                                                    <label class="form-check-label" for="nhanvien">
                                                        Nhân viên
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input value="3" class="form-check-input" type="radio"
                                                        name="role" id="nguoidung" checked>
                                                    <label class="form-check-label" for="nguoidung">
                                                        Người dùng
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="phone">Địa chỉ</label>
                                        <textarea name="address" id="address" class="form-control" cols="30" rows="5"> {{ old('address') }}</textarea>
                                        @error('address')
                                            <p style="font-size: 14px;color:red;float:left">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="pb-5 pt-3">
                                <button class="btn btn-primary">Tạo</button>
                                <a href="{{ route('users.list') }}" class="btn btn-outline-dark ml-3">Hủy</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
@endsection
