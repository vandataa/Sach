@extends('layoutadmin.layout')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid my-2">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Tác giả</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="{{ route('list.authors') }}" class="btn btn-primary">Quay lại</a>
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
                                        <img style="width: 300px;margin-left:20px ;"
                                            src="{{ asset('storage/images/' . $detail->author_image) }}" alt="">
                                    </div>
                                    <div class="col-6 ">
                                        <h3> {{ $detail->name_author }}</h3>
                                        <h5>
                                        <p> {{ $detail->info }}</p></h5>



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
