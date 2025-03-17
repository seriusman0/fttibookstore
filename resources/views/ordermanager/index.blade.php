@extends('layouts.app')

@section('content')
    <div class="container bg-light">
        <h1>Order Manager</h1>

        @foreach($orders as $username => $userOrders)
            <h2>{{ $username }}</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Menu</th>
                        <th>Jumlah</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($userOrders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->menu->nama }}</td>
                            <td>{{ $order->jumlah }}</td>
                            <td>{{ number_format($order->total_harga, 2) }}</td>
                            <td>
                                <select class="form-control status-dropdown" data-order-id="{{ $order->id }}">
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="diproses" {{ $order->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                    <option value="selesai" {{ $order->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                    <option value="dibatalkan" {{ $order->status == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                    <option value="lunas cash" {{ $order->status == 'lunas cash' ? 'selected' : '' }}>Lunas Cash</option>
                                    <option value="lunas tf" {{ $order->status == 'lunas tf' ? 'selected' : '' }}>Lunas TF</option>
                                </select>
                            </td>
                            <td>
                                <form action="{{ route('orders.destroy', $order->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus order ini?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <a href="{{ route('orders.invoice', ['userId' => $userOrders->first()->user_id]) }}" class="btn btn-primary btn-sm">Cetak Struk</a>
            <hr>
        @endforeach
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const statusDropdowns = document.querySelectorAll('.status-dropdown');

            statusDropdowns.forEach(dropdown => {
                dropdown.addEventListener('change', function () {
                    const orderId = this.dataset.orderId;
                    const newStatus = this.value;

                    fetch(`/orders/${orderId}/update-status`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify({ status: newStatus }),
                    })
                    .then(response => response.json())
                    .then(data => {
                        alert('Status berhasil diperbarui');
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Gagal memperbarui status');
                    });
                });
            });
        });
    </script>
@endsection