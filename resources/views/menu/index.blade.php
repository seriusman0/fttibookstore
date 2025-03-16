@extends('layouts.app')

@section('content')
<div class="container bg-light">
    <h1>Menu List</h1>
    <a href="{{ route('menus.create') }}" class="btn btn-primary mb-3">Add New Menu</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Code</th>
                <th>Name</th>
                <th>Price</th>
                <th>Category</th>
                <th>Stock</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($menus as $menu)
            <tr>
                <td>{{ $menu->kode_menu }}</td>
                <td>{{ $menu->nama }}</td>
                <td>Rp{{ number_format($menu->harga, 0, ',', '.') }}</td>
                <td>{{ $menu->kategori }}</td>
                <td>{{ $menu->stok }}</td>
                <td>
                    <a href="{{ route('menus.edit', $menu->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('menus.destroy', $menu->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection