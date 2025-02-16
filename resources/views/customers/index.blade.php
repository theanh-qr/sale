@extends('layouts.app')
@section('content')
    <div class="container">
        <h2>Danh sách khách hàng</h2>
        <form method="GET" action="{{ route('customers.index') }}">
            <div class="row mb-3">
                <div class="col">
                    <input type="text" name="name" class="form-control" placeholder="Tên khách hàng" value="{{ request('name') }}">
                </div>
                <div class="col">
                    <input type="email" name="email" class="form-control" placeholder="Email" value="{{ request('email') }}">
                </div>
                <div class="col">
                    <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                </div>
            </div>
        </form>
        <a href="{{ route('customers.create') }}" class="btn btn-success mb-3">Thêm khách hàng</a>
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Email</th>
                <th>Điện thoại</th>
                <th>Thành viên</th>
                <th>Hành động</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($customers as $customer)
                <tr>
                    <td>{{ $customer->id }}</td>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ $customer->phone }}</td>
                    <td>{{ $customer->membership_type }}</td>
                    <td>
                        <a href="{{ route('customers.edit', $customer) }}" class="btn btn-warning">Sửa</a>
                        <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $customers->links() }}
    </div>
@endsection
