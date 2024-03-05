@extends('layoutadmin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid my-2">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Nhà xuất bản mới</h1>
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
                        <form action="{{ route('publisher.create') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="name">Tên nhà xuất bản</label>
                                        <input type="text" onkeyup='ChangeToSlug()' id="slug" name="name"
                                            class="form-control" placeholder="Name">

                                    </div>
                                    @error('name')
                                        <p style="font-size: 14px;color:red;float:left">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="name">slug</label>
                                        <input type="text" name="slug" id="convert_slug" class="form-control"
                                            placeholder="Name" >
                                        @error('slug')
                                            <p style="font-size: 14px;color:red;float:left">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                {{-- <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="phone">Thông tin tác giả</label>
                                        <textarea name="info" id="address" class="form-control" cols="30" rows="5"></textarea>
                                    </div>
                                </div> --}}
                            </div>

                            <div class="pb-5 pt-3">
                                <button class="btn btn-primary">Thêm mới</button>
                                <a href="{{ route('publisher.list') }}" class="btn btn-outline-dark ml-3">Hủy</a>
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
