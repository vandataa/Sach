@extends('layoutadmin.layout')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid my-2">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Nhật ký hoạt động</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="{{ route('history.index') }}" class="btn btn-primary">Quay lại</a>
                    </div>
                </div>

                <!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="container-fluid">

                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>

                        <tr>
                            <th>Tên tài khoản</th>
                            <th>Email</th>
                            <th>Hoạt động</th>
                            <th>Bảng</th>
                            <th style="width: 15px;">Chi tiết</th>
                            <th>Thời gian</th>
                        </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <td>{{ $users->find($his->causer_id)->name }}</td>
                                <td>{{ $users->find($his->causer_id)->email }}</td>
                                <td>{{ $his->description }}</td>
                                <td>{{ $subject_type[$his->subject_type] }}</td>
                                    <?php
                                    $formattedDateTime = \Carbon\Carbon::parse($his->created_at)->format('d-m-Y H:i:s');
                                    ?>

                                @php
                                    $oldData = json_decode($his->old_data, true);
                                     $newData = json_decode($his->new_data, true);
                                @endphp
                                <td>
                                    @if ($his->description === 'Thêm mới')
                                        <!-- Hiển thị chi tiết sản phẩm sau khi thêm mới -->
                                        <table>

                                            <tr>
                                                <td>
                                                    <ul>
                                                        @foreach ($newData as $key => $value)
                                                            @if ($key === 'Ảnh')
                                                                <li>{{ $key }}: <br> <img src="{{ asset('storage/images/' . $value) }}" alt="New Image" style=" width: 100px; /* Đặt chiều rộng cố định */
        height: 100px; /* Đặt chiều cao cố định */
        object-fit: cover; "></li>
                                                            @elseif($key ==='Mô tả')
                                                                <li>
                                                                    <div style="  white-space: pre-line;;width: 500px">{{ $key }} : {!! strip_tags($value) !!}</div>
                                                                </li>
                                                            @elseif($key ==='Tiêu đề')
                                                                <li>
                                                                    <div style="  white-space: pre-line;;width: 500px">{{ $key }} : {!! strip_tags($value) !!}</div>
                                                                </li>
                                                            @else

                                                                <li>
                                                                    {{ $key }}:
                                                                    {!! strip_tags($value) !!}
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                </td>
                                            </tr>
                                        </table>
                                    @elseif($his->description === 'Khôi phục')
                                        @if($oldData)
                                            <table>
                                                <tr>
                                                    <td>

                                                        <ul>
                                                            @foreach ($oldData as $key => $value)
                                                                @if ($key === 'Ảnh')
                                                                    <li>{{ $key }}: <br> <img src="{{ asset('storage/images/' . $value) }}" alt="Old Image" style=" width: 100px; /* Đặt chiều rộng cố định */
        height: 100px; /* Đặt chiều cao cố định */
        object-fit: cover; "></li>
                                                                @elseif($key ==='Mô tả')
                                                                    <li>
                                                                        <div style="  white-space: pre-line;;width: 500px">{{ $key }} : {!! strip_tags($value) !!}</div>
                                                                    </li>
                                                                @elseif($key ==='Tiêu đề')
                                                                    <li>
                                                                        <div style="  white-space: pre-line;;width: 500px">{{ $key }} : {!! strip_tags($value) !!}</div>
                                                                    </li>
                                                                @else
                                                                    <li>
                                                                        {{ $key }}: {!! strip_tags($value) !!}
                                                                    </li>
                                                                @endif
                                                            @endforeach
                                                        </ul>
                                                    </td>
                                                </tr>
                                            </table>
                                        @endif
                                    @elseif($his->description === 'Xóa')
                                        @if($oldData)

                                            <table>
                                                <tr>
                                                    <td>

                                                        <ul>
                                                            @foreach ($oldData as $key => $value)
                                                                @if ($key === 'Ảnh')
                                                                    <li>{{ $key }}: <br> <img src="{{ asset('storage/images/' . $value) }}" alt="Old Image" style=" width: 100px; /* Đặt chiều rộng cố định */
        height: 100px; /* Đặt chiều cao cố định */
        object-fit: cover; "></li>
                                                                @elseif($key ==='Mô tả')
                                                                    <li>
                                                                        <div style="  white-space: pre-line;;width: 500px">{{ $key }} : {!! strip_tags($value) !!}</div>
                                                                    </li>
                                                                @elseif($key ==='Tiêu đề')
                                                                    <li>
                                                                        <div style="  white-space: pre-line;;width: 500px">{{ $key }} : {!! strip_tags($value) !!}</div>
                                                                    </li>
                                                                @else
                                                                    <li>
                                                                        {{ $key }}: {!! strip_tags($value) !!}
                                                                    </li>
                                                                @endif
                                                            @endforeach
                                                        </ul>
                                                    </td>
                                                </tr>
                                            </table>
                                        @endif
                                    @elseif($his->description === 'Ẩn')
                                        @if($oldData)

                                            <table>
                                                <tr>
                                                    <td>

                                                        <ul>
                                                            @foreach ($oldData as $key => $value)
                                                                @if ($key === 'Ảnh')
                                                                    <li>{{ $key }}: <br> <img src="{{ asset('storage/images/' . $value) }}" alt="Old Image" style=" width: 100px; /* Đặt chiều rộng cố định */
        height: 100px; /* Đặt chiều cao cố định */
        object-fit: cover; "></li>
                                                                @else
                                                                    <li>
                                                                        {{ $key }}: {!! strip_tags($value) !!}
                                                                    </li>
                                                                @endif
                                                            @endforeach
                                                        </ul>
                                                    </td>
                                                </tr>
                                            </table>
                                        @endif
                                    @elseif($his->description === 'Hiện')
                                        @if($oldData)

                                            <table>
                                                <tr>
                                                    <td>

                                                        <ul>
                                                            @foreach ($oldData as $key => $value)
                                                                @if ($key === 'Ảnh')
                                                                    <li>{{ $key }}: <br>
                                                                        @if (isset($value))
                                                                            <img src="{{ asset('storage/images/' . $value) }}" alt="Image" style=" width: 100px; /* Đặt chiều rộng cố định */
        height: 100px; /* Đặt chiều cao cố định */
        object-fit: cover; ">
                                                                        @else
                                                                            <span>Không có ảnh</span>
                                                                        @endif
                                                                    </li>
                                                                @else
                                                                    <li>
                                                                        {{ $key }}: {!! strip_tags($value) !!}
                                                                    </li>
                                                                @endif
                                                            @endforeach
                                                        </ul>
                                                    </td>
                                                </tr>
                                            </table>
                                        @endif
                                    @elseif ($his->description === 'Cập nhật')

                                        @if ($oldData && $newData)

                                            <table>
                                                <tr>
                                                    <td>
                                                        <p>Dữ liệu cũ</p>
                                                        <ul>
                                                            @foreach ($oldData as $key => $value)
                                                                @if ($key === 'Ảnh')
                                                                    <li>{{ $key }}: <br> <img src="{{ asset('storage/images/' . $value) }}" alt="Old Image" style=" width: 100px; /* Đặt chiều rộng cố định */
        height: 100px; /* Đặt chiều cao cố định */
        object-fit: cover; "></li>
                                                                @elseif($key ==='Trạng thái mã')
                                                                    <li>
                                                                        {{ $key }}:
                                                                        @if ($oldData['Trạng thái mã'] == 1)
                                                                            Kích hoạt

                                                                        @else
                                                                            Hủy kích hoạt
                                                                        @endif
                                                                    </li>
                                                                @elseif($key ==='Mô tả')
                                                                    <li>
                                                                        <div style="  white-space: pre-line;;width: 200px">{{ $key }} : {!! strip_tags($value) !!}</div>
                                                                    </li>
                                                                @elseif($key ==='Tiêu đề')
                                                                    <li>
                                                                        <div style="  white-space: pre-line;;width: 200px">{{ $key }} : {!! strip_tags($value) !!}</div>
                                                                    </li>
                                                                @else
                                                                    <li>
                                                                        {{ $key }}: {!! strip_tags($value) !!}
                                                                    </li>
                                                                @endif
                                                            @endforeach
                                                        </ul>
                                                    </td>
                                                    <td>
                                                        <p>Dữ liệu mới</p>
                                                        <ul>
                                                            @foreach ($newData as $key => $value)
                                                                @if ($key === 'Ảnh')
                                                                    <li>{{ $key }}: <br> <img src="{{ asset('storage/images/' . $value) }}" alt="New Image" style=" width: 100px; /* Đặt chiều rộng cố định */
        height: 100px; /* Đặt chiều cao cố định */
        object-fit: cover; "></li>

                                                                @elseif($key ==='Trạng thái mã')
                                                                    <li>
                                                                        {{ $key }}:
                                                                        @if ($newData['Trạng thái mã'] == 1)
                                                                            Kích hoạt

                                                                        @else
                                                                            Hủy kích hoạt
                                                                        @endif
                                                                    </li>
                                                                @elseif($key ==='Mô tả')
                                                                    <li>
                                                                        <div style="  white-space: pre-line;;width: 200px">{{ $key }} : {!! strip_tags($value) !!}</div>
                                                                    </li>
                                                                @elseif($key ==='Tiêu đề')
                                                                    <li>
                                                                        <div style="  white-space: pre-line;;width: 200px">{{ $key }} : {!! strip_tags($value) !!}</div>
                                                                    </li>
                                                                @else
                                                                    <li>
                                                                        {{ $key }}:
                                                                        @if ($oldData[$key] !== $value)
                                                                            <strong style="color: red">  {!! strip_tags($value) !!}</strong>
                                                                        @else
                                                                            {!! strip_tags($value) !!}
                                                                        @endif
                                                                    </li>
                                                                @endif
                                                            @endforeach
                                                        </ul>
                                                    </td>
                                                </tr>
                                            </table>
                                        @else
                                            <p>Không có dữ liệu để hiển thị</p>
                                        @endif
                                    @endif
                                </td>
                                <td>{{ $formattedDateTime }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
    </div>
    <hr>
    </section>
    </div>
@endsection
