@extends('layout.layout')

@section('title', 'Sign In')
@section('content')
    <div class="login-box">
        <div class="login-cart">
            <h3>Quyên mật khẩu</h3>
            @if (session('success'))
                <p class="mt-3 lh-base d-flex justify-content-start ps-3 text-primary fs-4">{{ session('success') }}</p>
            @else
                <form class="login-form" action="{{ route('forget.password.post') }}" method="POST">
                    @csrf
                    <input type="text" placeholder="Nhập email" name="email" value="{{ old('email') }}">
                    @error('email')
                        <p class="d-flex justify-content-start ps-3 text-danger">{{ $message }}</p>
                    @enderror

                    <button type="submit">Xác nhận</button>
                    <p>Bạn chưa có tài khoản? <a Style="color:blue" href="/signup">Đăng kí</a></p>
                </form>
            @endif

        </div>
    </div>
@endsection
