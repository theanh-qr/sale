@extends('layouts.app')
@section('content')
    <div class="container">
        <h2>Chỉnh sửa khách hàng</h2>
        <form action="{{ route('customers.update', $customer) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Tên</label>
                <input type="text" name="name" class="form-control" value="{{ $customer->name }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ $customer->email }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Số điện thoại</label>
                <input type="text" name="phone" class="form-control" value="{{ $customer->phone }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Loại thành viên</label>
                <select name="membership_type" class="form-control">
                    <option value="regular" {{ $customer->membership_type == 'regular' ? 'selected' : '' }}>Thường</option>
                    <option value="vip" {{ $customer->membership_type == 'vip' ? 'selected' : '' }}>VIP</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Cập nhật</button>
        </form>
    </div>
@endsection
