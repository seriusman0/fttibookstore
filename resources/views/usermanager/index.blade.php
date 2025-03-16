<!-- resources/views/usermanager/index.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container bg-light">
        <h1>User Manager</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ implode(', ', $user->getRoleNames()->toArray()) }}</td>
<td>
    <!-- Tombol Edit -->
    <a href="{{ route('usermanager.edit', $user->id) }}" class="btn btn-warning btn-sm">Edit</a>

    <!-- Tombol Delete -->
    <form action="{{ route('usermanager.destroy', $user->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">Delete</button>
    </form>
</td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
