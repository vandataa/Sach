@extends('layout.layout')

@section('title', 'Sign Up')
@section('content')
    <div class="login-box">
        <div class="login-cart">
            <h2>Đăng kí</h2>

            <form class="login-form" action="{{ route('signup.post') }}" method="POST">
                @csrf
                <input type="text" placeholder="Họ và tên" name="name" value="{{ old('name') }}">
                @error('name')
                    <p class="d-flex justify-content-start ps-3 text-danger">{{ $message }}</p>
                @enderror
                <input type="text" placeholder="Tên đăng nhập" name="username" value="{{ old('username') }}">
                @error('username')
                    <p class="d-flex justify-content-start ps-3 text-danger">{{ $message }}</p>
                @enderror
                <input type="text" placeholder="Email" name="email" value="{{ old('email') }}">
                @error('email')
                    <p class="d-flex justify-content-start ps-3 text-danger">{{ $message }}</p>
                @enderror
                <input type="password" placeholder="Mật khẩu" name="password" value="{{ old('password') }}">
                @error('password')
                    <p class="d-flex justify-content-start ps-3 text-danger">{{ $message }}</p>
                @enderror
                <button type="submit">Đăng kí</button>
                <p>Bạn đã có tài khoản? <a Style="color:blue" href="/signin">Đăng nhập</a></p>
            </form>
        </div>
    </div>
@endsection
