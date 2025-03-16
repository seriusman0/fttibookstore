<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-5.2.0/css/bootstrap.min.css') }}">
    <title>@yield('title', 'Toko Buku FTTI')</title>
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            background-image: url('img/ftti-bg.jpeg');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">Toko Buku FTTI</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('orders.index') }}">Orders</a>
                    </li>
                    @auth
                        @if(auth()->user()->hasRole('admin'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('menus.index') }}">Menus</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('ordermanager.index') }}">Order Manager</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('usermanager.index') }}">User Manager</a>
                            </li>
                        @endif
                    @endauth
                </ul>
                <ul class="navbar-nav">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}">Logout</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container p-4">
        @yield('content')
    </div>

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
  <script>
       $(document).ready(function() {
           $('#search-input').on('input', function() {
               let query = $(this).val();
               if (query.length > 0) {
                   $.ajax({
                       url: "",
                       method: "GET",
                       { query: query },
                       success: function(data) {
                           $('#menu-cards').empty(); // Clear the current cards
                           if (data.length > 0) {
                               data.forEach(function(item) {
                                   $('#menu-cards').append(`
                                       <div class="col-sm-4 mb-3 menu-item">
                                           <div class="card">
                                               <h5 class="card-header bg-info">${item.nama}</h5>
                                               <div class="card-body">
                                                   <img class="rounded mb-3" src="{{ asset('img/') }}/${item.gambar}" width="150" alt="${item.nama}">
                                                   <table class="table table-striped">
                                                       <tr>
                                                           <td>Harga</td>
                                                           <td>:</td>
                                                           <td>Rp${item.harga}</td>
                                                       </tr>
                                                       <tr>
                                                           <td>Kategori</td>
                                                           <td>:</td>
                                                           <td>${item.kategori}</td>
                                                       </tr>
                                                       <tr>
                                                           <td>Stok</td>
                                                           <td>:</td>
                                                           <td>${item.stok}</td>
                                                       </tr>
                                                       <tr>
                                                           <td colspan="3">
                                                               <a class="btn btn-primary btn-block" href="#">Pesan</a>
                                                           </td>
                                                       </tr>
                                                   </table>
                                               </div>
                                           </div>
                                       </div>
                                   `);
                               });
                           } else {
                               $('#menu-cards').append('<p>No results found.</p>');
                           }
                       }
                   });
               } else {
                   $('#menu-cards').empty(); // Clear the current cards if input is empty
               }
           });
       });
   </script> 
</body>
</html>