@extends('layoutadmin.layout')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid my-2">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Mã giảm giá</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="{{ route('sale.add') }}" class="btn btn-primary">Tạo mới</a>
                        <a href="{{ route('history.sale') }}" class="btn btn-primary">Nhật ký hoạt động</a>
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
                        <div class="card-tools">

                            <form action="" role="form">
                                <div class="input-group input-group" style="width: 350px;">
                                    <input type="text" name="table_search" class="form-control float-right"
                                        placeholder="Tìm kiếm theo mã giảm giá">

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
                                    <th width="60">#</th>
                                    <th>Mã giảm giá</th>
                                    <th>Giảm giá</th>
                                    <th>Kiểu</th>
                                    <th width="100">Thời gian sử dụng</th>
                                    <th>Số lượng</th>
                                    <th width="100">Trạng thái</th>
                                    <th width="100">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;

                                @endphp
                                @foreach ($sales as $sale)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td><a href="#">{{ $sale->code }}</a></td>
                                        <td><a href="#">{{ $sale->discount }}</a></td>
                                        <td><a href="#">{{ $sale->typeOfDiscount }}</a></td>
                                        <td>
                                            @php
                                                $startDateTime = \Carbon\Carbon::parse($sale->start);
                                                $endDateTime = \Carbon\Carbon::parse($sale->end);
                                            @endphp

                                            {{ $startDateTime->format('d-m-Y H:i:s') }} -
                                            {{ $endDateTime->format('d-m-Y H:i:s') }}
                                        </td>
                                        <td><a href="#">{{ $sale->count }}</a></td>
                                        <td>
                                            @php
                                                date_default_timezone_set('Asia/Bangkok');
                                                $date = date('Y-m-d H:i:s');
                                            @endphp
                                            @if (strtotime($date) >= strtotime($sale->start) && strtotime($date) <= strtotime($sale->end) && $sale->status == 1)
                                                <svg class="text-success-500 h-6 w-6 text-success"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="2" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            @else
                                                <svg class="text-success-500 h-6 w-6 text-dangre "
                                                    xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                                                    <path
                                                        d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                                    <path
                                                        d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                                                </svg>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($sale->deleted_at)
                                                <span><a href="{{ route('sale.restore', $sale->id) }}">Kích hoạt</a></span>
                                            @else
                                                <form action="{{ route('sale.destroy', $sale->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href="{{ route('sale.edit', $sale->id) }}">
                                                        <svg class="filament-link-icon w-4 h-4 mr-1"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor" aria-hidden="true">
                                                            <path
                                                                d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                                            </path>
                                                        </svg>
                                                    </a>
                                                    <button style="border: none" type="submit"
                                                        onclick="return confirm('Xóa')">
                                                        <a href="" type="submit" class="text-danger w-4 h-4 mr-1">
                                                            <svg wire:loading.remove.delay="" wire:target=""
                                                                class="filament-link-icon w-4 h-4 mr-1"
                                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                                fill="currentColor" aria-hidden="true">
                                                                <path ath fill-rule="evenodd"
                                                                    d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                                    clip-rule="evenodd"></path>
                                                            </svg>
                                                        </a>
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer clearfix">
                        <ul class="pagination pagination m-0 float-right">
                            {{ $sales->appends(request()->all())->links() }}
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
@endsection
