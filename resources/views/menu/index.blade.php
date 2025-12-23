@extends('layout.app')

@section('content')

@if (session('success'))
<div id="success-alert"
     class="alert alert-success alert-dismissible fade show shadow-sm">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif
    <div class="card shadow-sm">
        <div class="card-body">

            <h5 class="mb-3">Daftar Menu</h5>

            <a href="/food/create" class="btn btn-primary mb-3">
                + Tambah Menu
            </a>

            <table class="table table-bordered table-striped align-middle">
                <thead class="table-light text-center">
                    <tr>
                        <th width="60">#</th>
                        <th>Nama</th>
                        <th>Foto</th>
                        <th>Harga</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($menus as $menu)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $menu->name }}</td>
                        <td class="text-center">
                            <img src="{{ asset($menu->image) }}" width="60" class="rounded">
                        </td>
                        <td>Rp {{ number_format($menu->price) }}</td>
                        <td class="text-center">
                            <a href="/food/{{ $menu->id }}/edit" class="btn btn-sm btn-warning">
                                Edit
                            </a>

                            <button type="button"
                                    class="btn btn-sm btn-danger"
                                    onclick="confirmDelete({{ $menu->id }})">
                                Hapus
                            </button>

                            <form id="delete-form-{{ $menu->id }}"
                                action="/food/{{ $menu->id }}"
                                method="POST" class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="modal fade" id="deleteModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus menu ini?
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button class="btn btn-danger" id="confirm-delete-btn">
                        Ya
                    </button>
                </div>
                </div>
            </div>
        </div>
    </div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    setTimeout(function () {
        const alert = document.getElementById('success-alert');
        if (alert) alert.remove();
    }, 3000);
});
</script>

<script>
let deleteId = null;

function confirmDelete(id) {
    deleteId = id;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}

document.getElementById('confirm-delete-btn').onclick = function () {
    if (deleteId) {
        document.getElementById('delete-form-' + deleteId).submit();
    }
};

// auto hide alert success 6 detik
document.addEventListener('DOMContentLoaded', function () {
    const alert = document.getElementById('success-alert');
    if (alert) {
        setTimeout(() => {
            alert.classList.remove('show');
            alert.classList.add('hide');
            setTimeout(() => alert.remove(), 300);
        }, 6000);
    }
});
</script>
@endsection