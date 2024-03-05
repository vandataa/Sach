@extends('layoutadmin.layout')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid my-2">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Toàn bộ sách</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="{{ route('book.create') }}" class="btn btn-primary">Tạo mới</a>

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
                    <div class="card-header">
                        <div class="card-tools float-right">
                            <form class="row gap-3" method="post" action="{{ route('books.filter') }}" class="form-inline">
                                @csrf
                                @method('POST')
                                <select name="id_cate" class="form-control col-lg-3 col-12 my-2 pr-2">
                                    <option value="">Tìm theo thể loại sách</option>
                                    @foreach ($category as $item)
                                        <option value="{{ $item->id }}">{{ $item->cate_Name }}</option>
                                    @endforeach
                                </select>
                                <select name="status" id="status" class="form-control col-lg-3 col-12 my-2 pr-2">
                                    <option value="">Tìm theo trạng thái</option>

                                    <option value="Còn hàng">Còn Hàng</option>
                                    <option value="Hết hàng">Hết Hàng</option>
                                </select>
                                <div class="col-lg-3 col-12 my-2 pr-2">
                                    <input type="text" class="w-100 form-control float-right pr-5" name="searchInput"
                                        placeholder="Tên sách / NSX">
                                </div>
                                <div class="input-group-append col-lg-3 col-12 my-2">
                                    <button type="submit" class="btn btn-default">
                                        <strong>Tìm kiếm</strong>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th width="60">STT</th>
                                    <th width="80">Ảnh</th>
                                    <th>Tên sách</th>
                                    <th>Giá nhập</th>
                                    <th>Giá bán</th>
                                    <th>Số lượng</th>
                                    <th width="100">Trạng thái</th>
                                    <th width="100">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;

                                @endphp
                                @foreach ($books as $book)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td><img src="{{ asset('storage/images/' . $book->book_image) }}"
                                                class="img-thumbnail" width="50"></td>
                                        <td><a href="{{ route('book.review', $book->id) }}">{{ $book->title_book }}</a></td>

                                        <td>{{ number_format($book->original_price, 0, ',', '.') }} VNĐ</td>
                                        <td> {{ number_format($book->price, 0, ',', '.') }} VNĐ</td>

                                        <td>{{ $book->quantity }}</td>
                                        <td>
                                            {{ $book->quantity > 0 ? 'Còn hàng' : 'Hết hàng' }}
                                        </td>
                                        <td>
                                            <div class="row">
                                                @if ($book->deleted_at)
                                                    <a href="{{ route('books.restore', $book->id) }}">Khôi phục</a>
                                                @else
                                                    <div class="col-6">
                                                        <a href="{{ route('book.edit', $book->id) }}">
                                                            <svg class="filament-link-icon w-4 h-4 mr-1 mt-2"
                                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                                fill="currentColor" aria-hidden="true">
                                                                <path
                                                                    d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                                                </path>
                                                            </svg>
                                                        </a>
                                                    </div>
                                                    <div class="col-6">
                                                        <a>
                                                            <form action="{{ route('book.destroy', $book->id) }}"
                                                                method="post">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn pb-7"
                                                                    onclick="return confirm('Xóa')">
                                                                    <svg wire:loading.remove.delay="" wire:target=""
                                                                        class="filament-link-icon w-4 h-4 mr-5 pb-1 "
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        viewBox="0 0 20 20" fill="currentColor"
                                                                        aria-hidden="true">
                                                                        <path ath fill-rule="evenodd"
                                                                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                                            clip-rule="evenodd"></path>
                                                                    </svg>
                                                                </button>
                                                            </form>
                                                        </a>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <hr>
                    <div class="card-footer clearfix">
                        <ul class="pagination pagination m-0 float-right">
                            {{ $books->appends(request()->all())->links() }}
                        </ul>
                    </div>

                </div>
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
@endsection
