@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Danh sách sản phẩm</h2>

        <form method="GET" action="{{ route('products.index') }}" class="mb-3">
            <div class="row">
                <div class="col-md-4">
                    <input type="text" name="name" class="form-control" placeholder="Tìm theo tên sản phẩm" value="{{ request()->name }}">
                </div>
                <div class="col-md-4">
                    <select name="category_id" class="form-control">
                        <option value="">-- Chọn danh mục --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request()->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                    <a href="{{ route('products.index') }}" class="btn btn-secondary">Reset</a>
                </div>
            </div>
        </form>

        <a href="{{ route('products.create') }}" class="btn btn-success mb-3">Thêm sản phẩm</a>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Giá</th>
                <th>Danh mục</th>
                <th>Khuyến mãi</th>
                <th>Hành động</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ number_format($product->price) }} VNĐ</td>
                    <td>{{ $product->category->name }}</td>
                    <td>
                        @if ($product->discounts->isNotEmpty())
                            <ul>
                                @foreach ($product->discounts as $discount)
                                    <li>{{ $discount->name }}</li>
                                @endforeach
                            </ul>
                        @else
                            <span>Không có</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('products.edit', $product) }}" class="btn btn-warning">Sửa</a>
                        <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $products->links() }}
    </div>
@endsection
