@extends('layoutadmin.layout')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid my-2">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Xem trước sách</h1>
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
                <div class="row">
                    <div class="col-12">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <h3 style="">Ảnh bìa</h3>
                                        <img style="width: 300px;margin-left:20px ;"
                                            src="{{ asset('storage/images/' . $review->book_image) }}" alt="">
                                    </div>
                                    <div class="col-6 ">
                                        <h3>Tiêu đề sách : {{ $review->title_book }}</h3>
                                        <h5>Giá hiện tại:{{ $review->price }}</h5>
                                        <h5>Giá gốc:{{ $review->origin_price }}</h5>
                                        <h5>Nhà phát hành: {{ $review->public_house }}</h5>
                                        <h5>Số lượng: {{ $review->quantity }}</h5>
                                        <h5>Ngày tạo sách: {{ $review->created_at }}</h5>
                                        <h5>Mô tả: @php echo $review->description ; @endphp</h5>

                                    </div>

                                </div>
                                <h2 style="margin-top: 20px">Danh sách ảnh</h2>

                                <div class="row">

                                    @foreach ($image as $image)
                                        <div class="col-3" style="margin: 20px">
                                            <img style="width: 300px; height: 280px;object-fit: cover;"
                                                src="{{ asset('storage/images/' . $image->image_path) }}" alt="">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>


                    </div>

                </div>


            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
@endsection
