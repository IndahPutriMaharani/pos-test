@extends('layout.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-body">

            <h5 class="mb-3">Tambah Menu</h5>

            @if (session('success'))
            <div id="success-alert"
                class="alert alert-success alert-dismissible fade show shadow-sm">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @if ($errors->any())
            <div id="error-alert"
                class="alert alert-danger alert-dismissible fade show shadow-sm">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <form action="/food" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nama Menu</label>
                    <input type="text" name="name" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Gambar</label>
                    <input type="file" name="image" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Harga</label>
                    <input type="number" name="price" class="form-control">
                </div>

                <button class="btn btn-primary">Simpan</button>
                <a href="/food" class="btn btn-secondary">Kembali</a>

            </form>

        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    setTimeout(function () {
        const successAlert = document.getElementById('success-alert');
        const errorAlert   = document.getElementById('error-alert');

        if (successAlert) {
            successAlert.remove();
        }

        if (errorAlert) {
            errorAlert.remove();
        }
    }, 3000); // 6 detik

});
</script>

@endsection