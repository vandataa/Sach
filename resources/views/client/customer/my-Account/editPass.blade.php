@extends('client.customer.my-Account')
@section('title', 'Edit Account')
@section('myaccount')
    <form action="{{ route('my.account.pass.post') }}" method="POST">
        @csrf
        <div class="account__form row">
            
            @if (session('success'))
                <p class="d-flex fw-bold my-3 justify-content-start ps-3 text-danger">{{ session('success') }}</p>
            @endif
            <div class="input__box col-12 col-md-4">
                <label class="fs-5">Mật khẩu cũ <span>*</span></label>
                <input name="password"  type="text" value="{{ old('password') }}">
                @error('password')
                    <p class="d-flex justify-content-start ps-3 text-danger">{{ $message }}</p>
                @enderror
                @if (session('Errorpass1'))
                    <p class="d-flex justify-content-start ps-3 text-danger">{{ session('Errorpass1') }}</p>
                @endif
            </div>
            <div class="input__box col-12 col-md-4">
                <label class="fs-5">Mật khẩu mới <span>*</span></label>
                <input name="newpassword"  type="text" value="{{ old('newpassword') }}">
                @error('newpassword')
                    <p class="d-flex justify-content-start ps-3 text-danger">{{ $message }}
                    </p>
                @enderror
            </div>
            <div class="input__box col-12 col-md-4">
                <label class="fs-5">Nhập lại mật khẩu mới <span>*</span></label>
                <input name="cfpassword"  type="text" value="{{ old('cfpassword') }}">
                @error('cfpassword')
                    <p class="d-flex justify-content-start ps-3 text-danger">{{ $message }}
                    </p>
                @enderror
                @if (session('Errorpass2'))
                    <p class="d-flex justify-content-start ps-3 text-danger">{{ session('Errorpass2') }}</p>
                @endif
            </div>
            <div class="form__btn">
                <button class="btn btn-primary " type="submit">Xác Nhận</button>
                <a href="{{ route('my.account.pass') }}" class="btn btn-primary " >Hủy</a>
            </div>
        </div>
    </form>
@endsection
