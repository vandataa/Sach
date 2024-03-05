@extends('layoutadmin.layout')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid my-2">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Tạo mã giảm giá</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="{{ route('sale.list') }}" class="btn btn-primary">Quay lại</a>
                    </div>
                    @if ($success = Session::get('success'))
                        <div class="alert alert-success" role="alert">
                            <strong>{{ $success }}</strong>
                        </div>
                    @endif
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- Main content -->

        <section class="content">
            <!-- Default box -->
            <div class="container-fluid">
                <form action="{{ route('sale.store') }}" enctype="multipart/form-data" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="title">Mã giảm giá</label>
                                                <input type="text" name="code" id="slug" class="form-control"
                                                    placeholder="Code Sale" value="{{ old('code') }}">
                                                @error('code')
                                                    <p style="font-size: 14px;color:red;float:left">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="mb-3">
                                                <label for="title">Giảm giá</label>
                                                <input type="text" name="discount" class="form-control"
                                                    placeholder="Discount price in book" value="{{ old('discount') }}">
                                                @error('discount')
                                                    <p style="font-size: 14px;color:red;float:left">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="title">Kiểu giảm giá</label>
                                                <select name="typeDiscount" class="form-control" value="">
                                                    <option value="%" selected>%</option>
                                                    <option value="VND">VND</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="mb-3">
                                                <label for="title">Số lượng</label>
                                                <input type="text" name="count" class="form-control"
                                                    placeholder="Amount of code" value="{{ old('count') }}">
                                                @error('count')
                                                    <p style="font-size: 14px;color:red;float:left">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="title">Trạng thái</label>
                                                <select name="status" class="form-control" value="">
                                                    <option value="1" selected>Kích hoạt</option>
                                                    <option value="2">Hủy</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="title">Ngày bắt đầu</label>
                                                <input type="datetime-local" name="start" class="form-control"
                                                    placeholder="Amount of code" value="{{ old('start') }}">
                                                @error('start')
                                                    <p style="font-size: 14px;color:red;float:left">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="title">Ngày kết thúc</label>
                                                <input type="datetime-local" name="end" class="form-control"
                                                    placeholder="Amount of code" value="{{ old('end') }}">
                                                @error('end')
                                                    <p style="font-size: 14px;color:red;float:left">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 card card-body">
                            <div class="mb-3">
                                <label for="description">Nội dung giảm giá</label>
                                <textarea name="event" id="description" cols="10" rows="1" class="summernote"
                                    placeholder="Nội dung của mã giảm giá nhân sự kiện gì đấy"></textarea>
                            </div>
                            @error('event')
                                <p style="font-size: 14px;color:red;float:left">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="pb-5 pt-3">
                            <button class="btn btn-primary" type="submit">Tạo mới</button>
                            <a href="{{ route('sale.list') }}" class="btn btn-outline-dark ml-3">Hủy</a>
                        </div>
                </form>
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
@endsection
