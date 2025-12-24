<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Alan Resto</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://unpkg.com/vue@3/dist/vue.global.prod.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-light">

    <!-- headernya -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">Alan Resto</a>
            <div class="navbar-nav">
                <a class="nav-link {{ request()->is('food') ? 'active' : '' }}" href="/food">Food</a>
                <a class="nav-link {{ request()->is('transaksi') ? 'active' : '' }}" href="/transaksi">Transaksi</a>
            </div>
        </div>
    </nav>

    <!-- contentnya -->
    @yield('content')
    
    @yield('scripts')
    <script>
        axios.defaults.headers.common['X-CSRF-TOKEN'] =
            document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    </script>
    
</body>
</html>
