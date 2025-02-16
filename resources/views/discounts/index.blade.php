@extends('layouts.app')
@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Discounts</h1>
        <form method="GET" action="{{ route('discounts.index') }}" class="mb-4">
            <div class="row g-3">
                <div class="col-md-4">
                    <input type="text" class="form-control" name="name" value="{{ request('name') }}" placeholder="Search by name">
                </div>
                <div class="col-md-3">
                    <input type="date" class="form-control" name="start_date" value="{{ request('start_date') }}">
                </div>
                <div class="col-md-3">
                    <input type="date" class="form-control" name="end_date" value="{{ request('end_date') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </div>
        </form>
        <a href="{{ route('discounts.create') }}" class="btn btn-success mb-3">Create New Discount</a>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
            <tr>
                <th>Name</th>
                <th>Type</th>
                <th>Value</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($discounts as $discount)
                <tr>
                    <td>{{ $discount->name }}</td>
                    <td>{{ ucfirst($discount->discount_type) }}</td>
                    <td>{{ number_format($discount->value, 2) }}</td>
                    <td>{{ $discount->start_date }}</td>
                    <td>{{ $discount->end_date }}</td>
                    <td>
                        <a href="{{ route('discounts.edit', $discount) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('discounts.destroy', $discount) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
