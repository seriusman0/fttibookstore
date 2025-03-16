@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Menu Details</h1>
    <a href="{{ route('menus.index') }}" class="btn btn-secondary mb-3">Back to List</a>

    <table class="table table-bordered">
        <tr>
            <th>Code</th>
            <td>{{ $menu->kode_menu }}</td>
        </tr>
        <tr>
            <th>Name</th>
            <td>{{ $menu->nama }}</td>
        </tr>
        <tr>
            <th>Price</th>
            <td>Rp{{ number_format($menu->harga, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th>Category</th>
            <td>{{ $menu->kategori }}</td>
        </tr>
        <tr>
            <th>Stock</th>
            <td>{{ $menu->stok }}</td>
        </tr>
        <tr>
            <th>Image</th>
            <td><img src="{{ asset('img/' . $menu->gambar) }}" width="150" alt="{{ $menu->nama }}"></td>
        </tr>
    </table>
</div>
@endsection