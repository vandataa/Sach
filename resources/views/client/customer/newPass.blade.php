@extends('layout.layout')

@section('title', 'Sign In')
@section('content')
    <div class="login-box">
        <div class="login-cart">
            <h3>Mật khẩu mới</h3>
            <form class="login-form" action="{{ route('reset.password.post') }}" method="POST">
                @csrf
                <input type="text" name="token" value="{{ $token }}" hidden>
                <input type="text" placeholder="Nhập email" name="email" value="{{ old('email') }}">
                @error('email')
                    <p class="d-flex justify-content-start ps-3 text-danger">{{ $message }}</p>
                @enderror
                <input type="text" placeholder="Mật khẩu mới" name="password" value="{{ old('password') }}">
                @error('password')
                    <p class="d-flex justify-content-start ps-3 text-danger">{{ $message }}</p>
                @enderror
                <input type="text" placeholder="Xác nhận mật khẩu mới" name="password_confirm"
                    value="{{ old('password_confirm') }}">
                @error('password_confirm')
                    <p class="d-flex justify-content-start ps-3 text-danger">{{ $message }}</p>
                @enderror
                @if (session('error'))
                    <p class="d-flex justify-content-start ps-3 text-danger">{{ session('error') }}</p>
                @enderror
                <button type="submit">Xác nhận</button>
                <p>Bạn đã có tài khoản? <a Style="color:blue" href="/signup">Đăng nhập</a></p>
        </form>
    </div>
</div>
@endsection
