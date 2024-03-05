@extends('layoutadmin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid my-2">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Sửa thông tin tác giả</h1>
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
                        <form action="{{ route('authors.edit.post', ['id' => $authors->id]) }}" enctype="multipart/form-data"
                            method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="name">Tên tác giả</label>
                                        <input type="text" onkeyup='ChangeToSlug()' id="slug" name="name_author"
                                            class="form-control" value="{{ $authors->name_author }}" placeholder="Name">
                                        @error('name_author')
                                            <p style="font-size: 14px;color:red;float:left">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="name">slug</label>
                                        <input type="text" name="slug" id="convert_slug" class="form-control"
                                            value="{{ $authors->slug }}" placeholder="Name">
                                        @error('slug')
                                            <p style="font-size: 14px;color:red;float:left">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>Ảnh tác giả</label> <br>
                                        <img id="image_preview"
                                            src="@if ($authors->author_image) {{ asset('storage/images/' . $authors->author_image) }} @else https://png.pngtree.com/element_our/png/20181206/users-vector-icon-png_260862.jpg @endif"
                                            style="width: 100px" alt="">
                                        <br>
                                        <input type="file" accept="image/*" id="img" name="author_image"
                                            value="{{ $authors->author_image }}"
                                            class="form-control-file @error('image') is-invalid @enderror">
                                        @error('author_image')
                                            <p style="font-size: 14px;color:red;float:left">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>



                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="phone">Thông tin tác giả</label>
                                        <textarea name="info" id="address" class="form-control" cols="30" rows="5">{{ $authors->info }}</textarea>
                                        @error('info')
                                            <p style="font-size: 14px;color:red;float:left">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="pb-5 pt-3">
                                <button class="btn btn-primary">Cập nhật</button>
                                <a href="{{ route('list.authors') }}" class="btn btn-outline-dark ml-3">Hủy</a>
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
