@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Menu</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('menus.update', $menu->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="kode_menu">Menu Code</label>
            <input type="text" class="form-control" name="kode_menu" value="{{ old('kode_menu', $menu->kode_menu) }}" required>
        </div>
        <div class="form-group">
            <label for="nama">Name</label>
            <input type="text" class="form-control" name="nama" value="{{ old('nama', $menu->nama) }}" required>
        </div>
        <div class="form-group">
            <label for="harga">Price</label>
            <input type="number" class="form-control" name="harga" value="{{ old('harga', $menu->harga) }}" required>
        </div>
        <div class="form-group">
            <label for="gambar">Image</label>
            <input type="file" class="form-control" name="gambar">
            @if($menu->gambar)
                <img src="{{ asset('img/' . $menu->gambar) }}" alt="Menu Image" class="img-thumbnail mt-2" width="150">
            @endif
        </div>
        <div class="form-group">
            <label for="kategori">Category</label>
            <input type="text" class="form-control" name="kategori" value="{{ old('kategori', $menu->kategori) }}" required>
        </div>
        <div class="form-group">
            <label for="stok">Stock</label>
            <input type="number" class="form-control" name="stok" value="{{ old('stok', $menu->stok) }}" min="1" required>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Update</button>
    </form>
</div>
@endsection