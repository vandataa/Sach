@extends('layoutadmin.layout')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid my-2">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Sửa sách</h1>
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
                <form action="{{ route('book.update', $book->id) }}" enctype="multipart/form-data" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="title">Tên sách</label>
                                                <input type="text" name="title_book" id="title"
                                                    value="{{ $book->title_book }}" class="form-control"
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
                                                    placeholder="Thông tin sách ">{{ $book->description }}</textarea>
                                                @error('description')
                                                    <p style="font-size: 14px;color:red;float:left">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Ảnh bìa</h2>
                                    <input class="form-control" id="" name="book_image" type="file">
                                    <br>
                                    <img src="{{ asset('storage/images/' . $book->book_image) }}"
                                        style="width: 200px ; height: 150px; object-fit: cover" alt="">
                                    @error('book_image')
                                        <p style="font-size: 14px;color:red;float:left">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Danh sách ảnh</h2>
                                    <a href="{{ route('book.changeList', $book->id) }}">Thay đổi danh sách ảnh</a>
                                    <div class="row">
                                        @foreach ($listImage as $list)
                                            <div class="col-3 border">
                                                <img src="{{ asset('storage/images/' . $list->image_path) }}"
                                                    style="width: 150px ; height: 100px;object-fit: cover ;margin-left: 20px ;padding: 5px"
                                                    alt="">
                                                <br>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Giá</h2>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="price">Giá gốc</label>
                                                <input type="text" value="{{ $book->original_price }}"
                                                    name="original_price" id="" class="form-control"
                                                    placeholder="Giá Bìa">
                                                @error('original_price')
                                                    <p style="font-size: 14px;color:red;float:left">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for=""> Giá giảm</label>
                                                <input type="text" name="price" value="{{ $book->price }}"
                                                    id="compare_price" class="form-control" placeholder=" Giá">
                                                <p class="text-muted mt-3">
                                                    Original price is the price printed on the copyright cover of the book,
                                                    Price is the actual selling price (sale, price increase,...)
                                                </p>
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
                                                <input type="number" name="quantity" value="{{ $book->quantity }}"
                                                    class="form-control" placeholder="">
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
                                            <option value="" disabled selected>Choose Your option</option>
                                            @foreach ($listCate as $cate)
                                                @if ($book->id_cate === $cate->id)
                                                    <option value="{{ $cate->id }}" selected>{{ $cate->cate_Name }}
                                                    </option>
                                                @else
                                                    <option value="{{ $cate->id }}">{{ $cate->cate_Name }} </option>
                                                @endif
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
                                    <h2 class="h4 mb-3">Tác giả</h2>
                                    <div class="mb-3">
                                        <select name="id_author" id="author" class="form-control">
                                            <option value="">Tác giả</option>
                                            @foreach ($listAuthor as $author)
                                                @if ($book->id_author === $author->id)
                                                    <option value="{{ $author->id }}" selected>
                                                        {{ $author->name_author }} </option>
                                                @else
                                                    <option value="{{ $author->id }}">{{ $author->name_author }}
                                                    </option>
                                                @endif
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
                                                @if ($book->id_publisher === $publisher->id)
                                                    <option value="{{ $publisher->id }}" selected>{{ $publisher->name }}
                                                    </option>
                                                @else
                                                    <option value="{{ $publisher->id }}">{{ $publisher->name }} </option>
                                                @endif
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
                        <button class="btn btn-primary" type="submit">Sửa</button>
                        <a href="{{ route('book.index') }}" class="btn btn-outline-dark ml-3">Hủy</a>
                    </div>
                </form>
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
@endsection
