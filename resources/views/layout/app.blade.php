<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Alan Resto</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- HEADER -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">Alan Resto</a>
            <div class="navbar-nav">
                <a class="nav-link {{ request()->is('food') ? 'active' : '' }}" href="/food">Food</a>
                <a class="nav-link {{ request()->is('transaksi') ? 'active' : '' }}" href="/transaksi">Transaksi</a>
            </div>
        </div>
    </nav>

    <!-- CONTENT -->
    <div class="container mt-4">
        @yield('content')
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
