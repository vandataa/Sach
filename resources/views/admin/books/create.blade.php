@extends('layoutadmin.layout')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid my-2">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Thêm sách mới</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="{{ route('book.index') }}" class="btn btn-primary">Quay lại</a>
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
                <form action="{{ route('book.store') }}" enctype="multipart/form-data" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="title">Tiêu đề sách</label>
                                                <input type="text" name="title_book" id="title" class="form-control"
                                                    placeholder="Tên Sách">
                                                @error('title_book')
                                                    <p style="font-size: 14px;color:red;float:left">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="description">Mô tả</label>
                                                <textarea name="description" id="description" cols="30" rows="10" class="summernote"
                                                    placeholder="Thông tin sách "></textarea>
                                            </div>
                                            @error('description')
                                                <p style="font-size: 14px;color:red;float:left">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-3">

                                <div class="card-body">
                                    <h2 class="h4 mb-3">Ảnh bìa</h2>
                                    <input class="form-control " id="" name="book_image" type="file">

                                </div>
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Một Số Hình ảnh xem thử:</h2>
                                    <input class="form-control-file " id="" name="image_detail[]" type="file"
                                        multiple>

                                </div>
                                @error('book_image')
                                    <p style="font-size: 14px;color:red;float:left">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Giá</h2>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="price">Giá nhập</label>
                                                <input type="text" name="original_price" id=""
                                                    class="form-control" placeholder="Giá nhập">
                                                @error('original_price')
                                                    <p style="font-size: 14px;color:red;float:left">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for=""> Giá bán</label>
                                                <input type="text" name="price" id="compare_price" class="form-control"
                                                    placeholder=" Giá bán">
                                                @error('price')
                                                    <p style="font-size: 14px;color:red;float:left">{{ $message }}</p>
                                                @enderror

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Số lượng</h2>
                                    <div class="row">

                                        <div class="col-md-12">

                                            <div class="mb-3">
                                                <input type="number" min="0" name="quantity" id="qty"
                                                    class="form-control" placeholder="Qty">
                                                @error('quantity')
                                                    <p style="font-size: 14px;color:red;float:left">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">

                            <div class="card">
                                <div class="card-body">
                                    <h2 class="h4  mb-3">Thể loại sách</h2>
                                    <div class="mb-3">
                                        <label for="category">Thể loại</label>
                                        <select name="id_cate" id="category" class="form-control" value="">
                                            <option value="" disabled selected>Lựa chọn</option>
                                            @foreach ($listCate as $cate)
                                                <option value="{{ $cate->id }}">{{ $cate->cate_name }} </option>
                                            @endforeach

                                        </select>
                                        @error('id_cate')
                                            <p style="font-size: 14px;color:red;float:left">{{ $message }}</p>
                                        @enderror
                                    </div>

                                </div>
                            </div>
                            <div class="card mb-3">
                                <div class="card-body">

                                    <div class="mb-3">
                                        <label for="author">Tác giả</label>
                                        <select name="id_author" id="author" class="form-control">
                                            <option value="">Lựa chọn</option>

                                            @foreach ($listAuthor as $author)
                                                <option value="{{ $author->id }}">{{ $author->name_author }} </option>
                                            @endforeach
                                        </select>
                                        @error('id_author')
                                            <p style="font-size: 14px;color:red;float:left">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="publisher">Nhà xuất bản</label>
                                        <select name="id_publisher" id="publisher" class="form-control">
                                            <option value="">Lựa chọn</option>

                                            @foreach ($listPublishers as $publisher)
                                                <option value="{{ $publisher->id }}">{{ $publisher->name }} </option>
                                            @endforeach
                                        </select>
                                        @error('id_publisher')
                                            <p style="font-size: 14px;color:red;float:left">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                            </div>


                        </div>
                    </div>

                    <div class="pb-5 pt-3">
                        <button class="btn btn-primary" type="submit">Tạo mới</button>
                        <a href="#" class="btn btn-outline-dark ml-3">Hủy</a>
                    </div>
                </form>
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
@endsection
