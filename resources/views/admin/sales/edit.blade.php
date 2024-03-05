@extends('layoutadmin.layout')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid my-2">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Sưa mã giảm giá</h1>
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
                <form action="{{ route('sale.update',$sale->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="title">Mã giảm giá</label>
                                                <input type="text" name="code" value="{{ $sale->code }}"
                                                    id="slug" class="form-control" placeholder="Code Sale">
                                                @error('code')
                                                <p style="font-size: 14px;color:red;float:left">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="mb-3">
                                                <label for="title">Giảm giá</label>
                                                <input type="text" name="discount" value="{{ $sale->discount }}"
                                                    class="form-control" placeholder="Discount price in book">
                                                @error('discount')
                                                <p style="font-size: 14px;color:red;float:left">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="title">Kiểu giảm giá</label>
                                                <select name="typeDiscount" class="form-control" value="">
                                                    @if ($sale->typeOfDiscount === '%')
                                                        <option value="%" selected>%</option>
                                                        <option value="VND">VND</option>
                                                    @else
                                                        <option value="VND" selected>VND</option>
                                                        <option value="%">%</option>
                                                    @endif

                                                </select>

                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="mb-3">
                                                <label for="title">Số lượng</label>
                                                <input type="text" name="count" value="{{ $sale->count }}"
                                                    class="form-control" placeholder="Amount of code">
                                                @error('count')
                                                <p style="font-size: 14px;color:red;float:left">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="title">Trạng thái</label>
                                                <select name="status" class="form-control" value="">
                                                    @if ($sale->status === 1)
                                                        <option value="1" selected>Kích Hoạt</option>
                                                        <option value="2">Hủy Kích Hoạt</option>
                                                    @else
                                                        <option value="2" selected>Hủy Kích Hoạt</option>
                                                        <option value="1" >Kích Hoạt</option>
                                                    @endif
                                                </select>

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="title">Ngày bắt đầu</label>
                                                <input type="datetime-local" name="start" value="{{ $sale->start }}"
                                                    class="form-control">
                                                @error('start')
                                                <p style="font-size: 14px;color:red;float:left">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="title">Ngày kết thúc</label>
                                                <input type="datetime-local" name="end" value="{{ $sale->end }}"
                                                    class="form-control">
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
                                <textarea name="event" id="description" cols="30" rows="10" class="summernote"
                                    placeholder="Nội dung của mã giảm giá nhân sự kiện gì đấy">{{ $sale->event }}</textarea>
                            </div>
                            @error('event')
                            <p style="font-size: 14px;color:red;float:left">{{ $message }}</p>
                        @enderror
                        </div>
                        <div class="pb-5 pt-3">
                            <button class="btn btn-primary" type="submit">Cập nhật</button>
                            <a href="{{ route('sale.list') }}" class="btn btn-outline-dark ml-3">Hủy</a>
                        </div>
                </form>
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
@endsection
