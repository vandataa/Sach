@extends('layoutadmin.layout')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid my-2">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Sửa ảnh</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        @foreach ($book as $book)
                            <a href="{{ route('book.changeList', $book->id_book) }}" class="btn btn-primary">Back</a>
                        @endforeach
                    </div>
                    @if ($success = Session::get('success'))
                        <div class="alert alert-success" role="alert">
                            <strong>{{ $success }}</strong>
                        </div>
                    @endif
                </div>
            </div>
        </section>

        {{-- Đat commit --}}
        <section class="content ml-5">
            <div class="row">
                @foreach ($list as $list)
                    <div class="col-6">
                        <form action="{{ route('book.change_image', $list->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <img src="{{ asset('storage/images/' . $list->image_path) }}"
                                style="width: 500px;height: 480px; object-fit: contain;" alt="">
                            <br>
                            <input type="file" name="images" class="form-control">
                            <input type="hidden" name="old_image" value="$list->image_path" id="">
                            <input type="hidden" name="id" value="{{ $list->id }}" id="">
                            <input type="hidden" name="id_book" value="{{ $list->id_book }}" id="">
                            <br>
                            <button type="submit" class="btn btn-primary mt-2">Sửa</button>
                        </form>
                    </div>
                @endforeach
            </div>

        </section>
        <!-- /.content -->
    </div>
@endsection
