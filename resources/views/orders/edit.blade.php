@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Chỉnh sửa đơn hàng</h2>
        <form action="{{ route('orders.update', $order) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Khách hàng</label>
                <select name="customer_id" class="form-control">
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}" {{ $order->customer_id == $customer->id ? 'selected' : '' }}>{{ $customer->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Sản phẩm</label>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                        <th>Hành động</th>
                    </tr>
                    </thead>
                    <tbody id="product-list">
                    @foreach($order->items as $index => $item)
                        <tr>
                            <td>
                                <select name="items[{{ $index }}][product_id]" class="form-control product-select">
                                    <option value="">Chọn sản phẩm</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" data-price="{{ $product->price }}"
                                            {{ $item->product_id == $product->id ? 'selected' : '' }}>
                                            {{ $product->name }} ({{ number_format($product->price, 0, ',', '.') }}đ)
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="product-price">
                                {{ number_format($item->product->price, 0, ',', '.') }}đ
                            </td>
                            <td>
                                <input type="number" name="items[{{ $index }}][quantity]" class="form-control quantity"
                                       value="{{ $item->quantity }}" min="1">
                            </td>
                            <td class="total-price">
                                {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}đ
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger remove-product">Xóa</button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <button type="button" id="add-product" class="btn btn-secondary">Thêm sản phẩm</button>
            </div>

            <div class="mb-3">
                <h4>Tổng tiền: <span id="order-total">0đ</span></h4>
            </div>

            <button type="submit" class="btn btn-primary">Cập nhật</button>
        </form>
    </div>

    <script>
        function updateTotalPrice() {
            let total = 0;
            document.querySelectorAll('#product-list tr').forEach(row => {
                let price = parseFloat(row.querySelector('.product-select')?.selectedOptions[0]?.dataset.price || 0);
                let quantity = parseInt(row.querySelector('.quantity')?.value || 1);
                let totalPrice = price * quantity;

                row.querySelector('.product-price').innerText = price.toLocaleString() + 'đ';
                row.querySelector('.total-price').innerText = totalPrice.toLocaleString() + 'đ';

                total += totalPrice;
            });

            document.getElementById('order-total').innerText = total.toLocaleString() + 'đ';
        }

        document.getElementById('add-product').addEventListener('click', function () {
            let index = document.querySelectorAll('#product-list tr').length;
            let row = `<tr>
                        <td>
                            <select name="items[${index}][product_id]" class="form-control product-select">
                                <option value="">Chọn sản phẩm</option>
                                @foreach($products as $product)
            <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                        {{ $product->name }} ({{ number_format($product->price, 0, ',', '.') }}đ)
                                    </option>
                                @endforeach
            </select>
        </td>
        <td class="product-price">0đ</td>
        <td>
            <input type="number" name="items[${index}][quantity]" class="form-control quantity" min="1" value="1">
                        </td>
                        <td class="total-price">0đ</td>
                        <td>
                            <button type="button" class="btn btn-danger remove-product">Xóa</button>
                        </td>
                    </tr>`;
            document.getElementById('product-list').insertAdjacentHTML('beforeend', row);
        });

        document.getElementById('product-list').addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-product')) {
                e.target.closest('tr').remove();
                updateTotalPrice();
            }
        });

        document.getElementById('product-list').addEventListener('change', function (e) {
            if (e.target.classList.contains('product-select') || e.target.classList.contains('quantity')) {
                updateTotalPrice();
            }
        });

        // Cập nhật tổng tiền ngay khi trang load
        document.addEventListener("DOMContentLoaded", function () {
            updateTotalPrice();
        });
    </script>
@endsection
