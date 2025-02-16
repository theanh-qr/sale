<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Hệ Thống Bán Hàng')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @stack('styles')
    <style>
        html, body {
            height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .content {
            flex: 1;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Bán Hàng</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('categories.index') ? 'active' : '' }}"
                       href="{{ route('categories.index') }}">Danh mục</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('products.index') ? 'active' : '' }}"
                       href="{{ route('products.index') }}">Sản phẩm</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('discounts.index') ? 'active' : '' }}"
                       href="{{ route('discounts.index') }}">Khuyến mại</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('orders.index') ? 'active' : '' }}"
                       href="{{ route('orders.index') }}">Đơn hàng</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('customers.index') ? 'active' : '' }}"
                       href="{{ route('customers.index') }}">Khách hàng</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('reports*') ? 'active' : '' }}"
                       href="#">Báo cáo</a>
                </li>
            </ul>
        </div>
    </div>

</nav>

<div class="container mt-4 content">
    @yield('content')
</div>

<footer class="bg-dark text-white text-center py-3 mt-4">
    &copy; {{ date('Y') }} Hệ Thống Bán Hàng. All rights reserved.
</footer>

<script src="{{ asset('js/script.js') }}"></script>
@stack('scripts')
</body>
</html>
