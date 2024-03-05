@extends('layoutadmin.layout')

@section('content')
    {{-- đạt update --}}
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid my-2">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Thêm ảnh mới</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="{{ route('book.changeList', $id) }}" class="btn btn-primary">Quay lại</a>
                    </div>
                    @if ($success = Session::get('success'))
                        <div class="alert alert-success" role="alert">
                            <strong>{{ $success }}</strong>
                        </div>
                    @endif
                </div>
            </div>
        </section>
        <section class="content ml-5">
            <div class="row">
                <div class="col-6">
                    <form action="{{ route('book.addImage') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="card-body">
                            <h2 class="h4 mb-3">Thêm 1 hoặc nhiều ảnh mới</h2>
                            <input class="form-control" id="" name="image_detail[]" type="file" multiple>
                        </div>
                        <input type="hidden" name="id_book" value="{{ $id }}" id="">
                        <button type="submit" class="btn btn-primary mt-2">Thêm mới</button>
                    </form>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
@endsection
