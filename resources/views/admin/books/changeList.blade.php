@extends('layoutadmin.layout')

@section('content')
{{-- Đạt change --}}
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid my-2">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Danh sách ảnh</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="{{ route('book.edit', $id) }}" class="btn btn-primary">Quay lại</a>
                    </div>
                    @if ($success = Session::get('success'))
                        <div class="alert alert-success" role="alert">
                            <strong>{{ $success }}</strong>
                        </div>
                    @endif

                </div>
            </div>
        </section>
        <section class="content m-5 grid ">
            <div class="row ">
                <div class="col-6 ml-5">
                    <a href="{{ route('book.newImage', $id) }}" class="btn btn-primary mb-3">Thêm ảnh mới</a>
                    <br>
                </div>
            </div>
            <div class="row">
                @foreach ($image as $list)
                    <div class="col-2 border rounded mr-2 mt-2 ">
                        <img src="{{ asset('storage/images/' . $list->image_path) }}"
                            style="width: 150px ; height: 100px;object-fit: cover ;margin-left: 18px ;padding: 6px"
                           class="rounded" alt="">
                        <br>

                        <div class="row">
                            <div class="col-6">
                                <a href="{{ route('book.change', $list->id) }}">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        width="16" height="15" fill="currentColor" class="bi bi-pencil mt-2 ml-5"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                                    </svg></a>
                            </div>
                            <div class="col-6">
                                <form action="{{ route('book.deleteImage', $list->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="id_book" value="{{ $list->id_book }}" id="">
                                    <input type="hidden" name="old_image" value="{{ $list->image_path }}" id="">
                                    <button type="submit" class="btn">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                            <path
                                                d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>


        </section>
        <!-- /.content -->
    </div>
@endsection
