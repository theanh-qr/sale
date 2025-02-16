@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Tạo đơn hàng</h2>
        <form action="{{ route('orders.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Khách hàng</label>
                <select name="customer_id" class="form-control">
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Sản phẩm</label>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Hành động</th>
                    </tr>
                    </thead>
                    <tbody id="product-list">
                    <tr>
                        <td>
                            <select name="items[0][product_id]" class="form-control">
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="number" name="items[0][quantity]" class="form-control" min="1">
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger remove-product">Xóa</button>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <button type="button" id="add-product" class="btn btn-secondary">Thêm sản phẩm</button>
            </div>
            <button type="submit" class="btn btn-primary">Tạo</button>
        </form>
    </div>
    <script>
        document.getElementById('add-product').addEventListener('click', function () {
            let index = document.querySelectorAll('#product-list tr').length;
            let row = `<tr>
                        <td>
                            <select name="items[${index}][product_id]" class="form-control">
                                @foreach($products as $product)
            <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
            </select>
        </td>
        <td>
            <input type="number" name="items[${index}][quantity]" class="form-control" min="1">
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger remove-product">Xóa</button>
                        </td>
                    </tr>`;
            document.getElementById('product-list').insertAdjacentHTML('beforeend', row);
        });

        document.getElementById('product-list').addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-product')) {
                e.target.closest('tr').remove();
            }
        });
    </script>
@endsection
