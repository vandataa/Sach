@extends('client.customer.my-Account')
@section('title', 'Edit Account')
@section('myaccount')
    <form action="{{ route('my.account.editDetail.post') }}" method="POST">
        @csrf
        <div class="account__form row">
            <div class="input__box col-12">
                <label class="fs-5">User Name</label>
                <p class="fs-4">{{ $user->username }}</p>
            </div>
            <div class="input__box col-12 col-md-6">
                <label class="fs-5">Full Name <span>*</span></label>
                <input name="name"  type="text" value="{{ old('name') }}" >
                @error('name')
                    <p class="d-flex justify-content-start ps-3 text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="input__box col-12 col-md-6">
                <label class="fs-5">Email <span>*</span></label>
                <input name="email"  type="text" value="{{ old('email') }}" >
                @error('email')
                    <p class="d-flex justify-content-start ps-3 text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="input__box col-12 col-md-6">
                <label class="fs-5">Address</label>
                <input name="address"  type="text" value="{{ old('address') }}" >
            </div>
            <div class="input__box col-12 col-md-6">
                <label class="fs-5">Number Phone</label>
                <input name="phone"  type="text" value="{{ old('phone') }}" >
                @error('phone')
                    <p class="d-flex justify-content-start ps-3 text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="form__btn">
                <button class="btn btn-primary " type="submit" >Xác
                    Nhận</button>
                <a href="{{ route('my.account.detail') }}" class="btn btn-primary ">Hủy</a>
            </div>
        </div>
    </form>
@endsection
