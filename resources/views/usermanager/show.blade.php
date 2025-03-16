@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Detail Pengguna</h1>
        <table class="table">
            <tr>
                <th>ID</th>
                <td>{{ $user->id }}</td>
            </tr>
            <tr>
                <th>Username</th>
                <td>{{ $user->username }}</td>
            </tr>
            <tr>
                <th>Role</th>
                <td>{{ implode(', ', $user->getRoleNames()->toArray()) }}</td>
            </tr>
        </table>
        <a href="{{ route('usermanager.index') }}" class="btn btn-primary">Kembali</a>
    </div>
@endsection
