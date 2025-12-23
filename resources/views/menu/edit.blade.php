@extends('layout.app')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">

        <h5 class="mb-3">Edit Menu</h5>

        <form action="/food/{{ $menu->id }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Nama Menu</label>
                <input type="text"
                       name="name"
                       class="form-control"
                       value="{{ $menu->name }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Gambar Saat Ini</label><br>
                <img src="{{ asset($menu->image) }}"
                     width="120"
                     class="rounded border mb-2">
            </div>

            <div class="mb-3">
                <label class="form-label">Ganti Gambar (Opsional)</label>
                <input type="file"
                       name="image"
                       class="form-control">
                <small class="text-muted">
                    Kosongkan jika tidak ingin mengganti gambar
                </small>
            </div>

            <div class="mb-3">
                <label class="form-label">Harga</label>
                <input type="number"
                       name="price"
                       class="form-control"
                       value="{{ $menu->price }}">
            </div>

            <button class="btn btn-primary">Update</button>
            <a href="/food" class="btn btn-secondary">Batal</a>
        </form>

    </div>
</div>
@endsection