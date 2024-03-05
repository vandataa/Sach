@extends('layout.layout')

@section('title', 'Sign In')
@section('content')
    <div class="login-box">
        <div class="login-cart">
            @if (session('message'))
            <p style="color:green; width:100%;text-align:center">{{ session('message') }}</p>
        @endif
            <h2>Đăng nhập</h2>

            <form class="login-form" action="{{ route('signin.post') }}" method="POST">
                @csrf
                <input type="text" placeholder="Tài khoản" name="username" value="{{ old('username') }}">
                @error('username')
                    <p class="d-flex justify-content-start ps-3 text-danger">{{ $message }}</p>
                @enderror
                <input type="password" placeholder="Mật khẩu" name="password" value="{{ old('password') }}">
                @error('password')
                    <p class="d-flex justify-content-start ps-3 text-danger">{{ $message }}</p>
                @enderror
                @if (session('loginError'))
                    <p class="d-flex justify-content-start ps-3 text-danger">{{ session('loginError') }}</p>
                @endif
                @if (session('success'))
                    <p class="d-flex justify-content-start ps-3 text-primary">{{ session('success') }}</p>
                @endif
                <a href="{{ route('forget.password') }}">Quên mật khẩu?</a>
                <button type="submit">Đăng nhập</button>
                <p>Bạn chưa có tài khoản? <a Style="color:blue" href="/signup">Đăng kí</a></p>
            </form>
        </div>
    </div>
@endsection
