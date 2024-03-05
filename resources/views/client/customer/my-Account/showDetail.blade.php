@extends('client.customer.my-Account')
@section('title', 'Edit Account')
@section('myaccount')
        <div class="account__form row">
            <div class="input__box col-12">
                <label class="fs-5 text-secondary">User Name</label>
                <p class="fs-4">{{ $user->username }}</p>
            </div>
            <div class="input__box col-12 col-md-6">
                <label class="fs-5 text-secondary">Full Name </label>
                <p class="fs-4">{{ $user->name }}</p>
            </div>
            <div class="input__box col-12 col-md-6">
                <label class="fs-5 text-secondary">Email </label>
                <p class="fs-4">{{ $user->email }}</p>
            </div>
            <div class="input__box col-12 col-md-6">
                <label class="fs-5 text-secondary">Address</label>
                <p class="fs-4">{{ $user->address ? $user->address : 'Chưa cập nhật' }}</p>
            </div>
            <div class="input__box col-12 col-md-6">
                <label class="fs-5 text-secondary">Number Phone</label>
                <p class="fs-4">{{ $user->phone ? $user->phone : 'Chưa cập nhật' }}</p>
            </div>
            <div class="form__btn">
                <a href="{{ route('my.account.editDetail') }}" class="btn btn-primary" >Chỉnh Sửa</a>
            </div>
        </div>
@endsection
