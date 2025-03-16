@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create New Menu</h1>

    <form action="{{ route('menus.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="kode_menu">Menu Code</label>
            <input type="text" class="form-control" name="kode_menu" required>
        </div>
        <div class="form-group">
            <label for="nama">Name</label>
            <input type="text" class="form-control" name="nama" required>
        </div>
        <div class="form-group">
            <label for="harga">Price</label>
            <input type="number" class="form-control" name="harga" required>
        </div>
        <div class="form-group">
            <label for="gambar">Image</label>
            <input type="file" class="form-control" name="gambar">
        </div>
        <div class="form-group">
            <label for="kategori">Category</label>
            <input type="text" class="form-control" name="kategori" required>
        </div>
        <div class="form-group">
            <label for="stok">Stock</label>
            <input type="number" class="form-control" name="stok" min="1" required>
        </div>
        <button type="submit" class="btn btn-success mt-3">Save</button>
    </form>
</div>
@endsection