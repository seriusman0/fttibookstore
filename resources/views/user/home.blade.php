@extends('layouts.app')

@section('title', 'Home - Toko Buku FTTI')

@section('content')
    <!-- Alert Messages -->
    @if (session('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Search & Tambah -->
    <div class="d-flex flex-wrap justify-content-between mb-3">
<form id="search-form" class="form-inline d-flex">
   <input class="form-control mx-sm-2" type="search" autocomplete="off" name="key-search" id="search-input" placeholder="Cari..." required>
   <button class="btn btn-success mx-2" type="submit">Search</button>
</form>


        @if (auth()->user()->hasRole('admin'))
            <a class="btn btn-success fw-bold mx-2" href="{{ url('tambah') }}">+ Tambah Menu Barang</a>
        @endif
    </div>

    <!-- Menu Cards -->
    <div class="row" id="menu-cards">
       @foreach ($menu as $m)
    <div class="col-sm-4 mb-3 menu-item">
        <div class="card">
            <h5 class="card-header bg-info">{{ htmlspecialchars($m['nama']) }}</h5>
            <div class="card-body">
                <img class="rounded mb-3" src="{{ asset('img/' . htmlspecialchars($m['gambar'])) }}" width="150" alt="{{ htmlspecialchars($m['nama']) }}">
                <form name="tambah_pesanan" action="{{ route('orders.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="menu_id" value="{{ htmlspecialchars($m['id']) }}">
                    <input type="hidden" name="stok" value="{{ htmlspecialchars($m['stok']) }}">
                    <table class="table table-striped">
                        <tr>
                            <td>Harga</td>
                            <td>:</td>
                            <td>Rp{{ number_format($m['harga'], 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>Kategori</td>
                            <td>:</td>
                            <td>{{ htmlspecialchars($m['kategori']) }}</td>
                        </tr>
                        <tr>
                            <td>Stok</td>
                            <td>:</td>
                            <td>{{ htmlspecialchars($m['stok']) }}</td>
                        </tr>
                        <tr>
                            <td>Jumlah</td>
                            <td>:</td>
                            <td>
                                <input min="1" max="{{ htmlspecialchars($m['stok']) }}" type="number" name="jumlah" class="form-control" required>
                            </td>
                        </tr>
                        <tr>
                            <td>Notes</td>
                            <td>:</td>
                            <td>
                                <textarea name="notes" class="form-control" rows="3" placeholder="Tambahkan catatan pesanan..."></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <button type="submit" name="pesan" class="btn btn-primary btn-block">Pesan</button>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <a class="nav-link" href="{{ route('orders.index') }}">Lihat Pesanan Saya</a>
                            </td>
                        </tr>
                    </table>
                </form>

                @if(auth()->user()->hasRole('admin'))
                <div class="mt-3">
                    <a class="btn btn-warning" href="{{ route('menus.edit', ['menu' => $m['id']]) }}">
                        <i class="bi bi-pencil-fill"></i> Edit
                    </a>
                    <form action="{{ route('menus.destroy', ['menu' => $m['id']]) }}" method="POST" style="display:inline;" onsubmit="return confirm('Ingin Menghapus Menu?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash3-fill"></i> Hapus
                        </button>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>
@endforeach
    </div>


<script>


</script>

@endsection