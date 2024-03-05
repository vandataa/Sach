@extends('layoutadmin.layout')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid my-2">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Quản lý tiền vận chuyển</h1>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="container-fluid">
                <?php 
                    $message = Session::get('message');
                    if($message){
                        echo `<p style="color:green; width:100%;text-align:center">'.$message.'</p>`;
                        Session::put('message',null);
                    }
                ?>
                <div class="col-6 m-auto">
                    <form method="POST">
                        @csrf
                        <div class="">
                            <label for="">Chọn Tỉnh/ Thành Phố</label><br>
                            <select class="ml-3 py-2 fs-5 col-12 choose city" name="id_tp" id="city">
                                <option value="">----Chọn----</option>
                                @foreach ($tinhtp as $item)
                                    <option value="{{$item->id }}">{{$item->name }}</option>
                                @endforeach
                            </select>
                            @error('id_tp')
                                <p style="font-size: 14px;color:red;">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="">
                            <label for="">Chọn Quận/ Huyện</label><br>
                            <select class="ml-3 py-2 fs-5 col-12 choose province" name="id_qh" id="province">
                                <option value="">----Chọn----</option>
                            </select>
                            @error('id_qh')
                                <p style="font-size: 14px;color:red;">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="">
                            <label for="">Chọn Xã/ Phường</label><br>
                            <select class="ml-3 py-2 fs-5 col-12  wards" name="id_xa" id="wards">
                                <option value="">----Chọn----</option>
                            </select>
                            @error('id_xa')
                                <p style="font-size: 14px;color:red;">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="">
                            <label for="">Nhập phí ship </label><br>
                            <input  class="ml-3 py-2 fs-5 col-12 freeship" type="text" name="price" >
                            @error('price')
                                <p style="font-size: 14px;color:red;">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mt-3">
                            <button type="button" name='btn-ship' class="btn-ship btn btn-primary">Thêm</button>
                        </div>
                    </form>
                </div>
                <div id="load_ship">
                    
                </div>
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
@endsection
