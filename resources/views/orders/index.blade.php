@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Danh sách đơn hàng</h1>
        <a href="{{ route('orders.create') }}" class="btn btn-primary">Thêm đơn hàng</a>
        <table class="table mt-3">
            <thead>
            <tr>
                <th>ID</th>
                <th>Khách hàng</th>
                <th>Tổng giá</th>
                <th>Hành động</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->customer->name }}</td>
                    <td>{{ number_format($order->total_price, 0, ',', '.') }} VNĐ</td>
                    <td>
                        <a href="{{ route('orders.edit', $order) }}" class="btn btn-warning">Sửa</a>
                        <form action="{{ route('orders.destroy', $order) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $orders->links() }}
    </div>
@endsection
