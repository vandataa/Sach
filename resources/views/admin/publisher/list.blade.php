@extends('layoutadmin.layout')

@section('content')
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="product__info__detailed">
                <div class="container-fluid my-2">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Danh sách nhà xuất bản</h1>
                        </div>

                        <div class="col-sm-6 text-right">
                            <a href="{{ route('publisher.create') }}" class="btn btn-primary">Thêm mới</a>

                        </div>


                    </div>


                </div>
                <!-- /.container-fluid -->
        </section>
        <div class="tab__container tab-content">
            <!-- Start Single Tab Content -->
            <div class="pro__tab_label tab-pane fade show active" id="nav-details" role="tabpanel">
                <div class="description__attribute">
                    <section class="content">
                        <!-- Default box -->
                        <div class="container-fluid">
                            @if (session('success'))
                                <p style="color:green; width:100%;text-align:center">{{ session('success') }}</p>
                            @endif
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-tools">
                                        <form action="" role="form">
                                            <div class="input-group input-group" style="width: 350px;">
                                                <input type="text" name="table_search" class="form-control float-right"
                                                    placeholder="Tìm theo tên tác giả">

                                                <div class="input-group-append">
                                                    <button type="submit" class="btn btn-default">
                                                        <strong>Tìm kiếm</strong>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-hover text-nowrap">
                                        <thead>
                                            <tr>
                                                <th width="60">ID</th>
                                                <th>Tên nhà sản xuất</th>
                                                <th>Số lượng sách</th>
                                                <th>Trạng thái</th>
                                                <th width="100">Hành động</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($publishers as $key => $auth)
                                                <tr>
                                                    <td>{{ $key+1 }}</td>
                                                    <td><a href="{{ route('publisher.detail', $auth->id) }}">{{ $auth->name }}</a></td>

                                                    <td>{{ $authCounts[$auth->id] }}</td>
                                                    <td>  @if ($auth->deleted_at)
                                                       <p> Không hoạt động</p>
                                                        @else
                                                       <p> Hoạt động</p>
                                                        @endif
                                                    </td>
                                                    <td>
                                            <div class="row">
                                               @if($auth->deleted_at)
                                                    <a href="{{route('publisher.restore', $auth->id)}}">Khôi phục</a>
                                                @else
                                                    <div class="col-6">
                                                        <a href="{{  route('publisher.edit', $auth->id) }}">
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
                                                            <form action="{{ route('publisher.delete', $auth->id) }}"
                                                                  method="post">
                                                                @csrf

                                                                <button type="submit" class="btn pb-7"
                                                                        onclick="return confirm('Xóa')">
                                                                    <svg wire:loading.remove.delay="" wire:target=""
                                                                         class="filament-link-icon w-4 h-4 mr-5 pb-1 "
                                                                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                                         fill="currentColor" aria-hidden="true">
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
                                <div class="card-footer clearfix">
                                    <ul class="pagination pagination m-0 float-right">
                                        {{ $publishers->appends(request()->all())->links() }}
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- /.card -->
                    </section>
                </div>
            </div>
            <!-- End Single Tab Content -->
            <!-- Start Single Tab Content -->
            <div class="pro__tab_label tab-pane fade" id="nav-review" role="tabpanel">
                ds
            </div>
            <!-- End Single Tab Content -->
        </div>
        <!-- Main content -->

        <!-- /.content -->
    </div>
    </div>
@endsection
