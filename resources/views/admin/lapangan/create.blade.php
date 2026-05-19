@extends('layouts.admin')

@section('title', 'Tambah Lapangan')
@section('page-title', 'Tambah Lapangan')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-4">
                    <i class="fas fa-plus-circle me-2 text-success"></i>Form Tambah Lapangan
                </h6>

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        @foreach($errors->all() as $error)
                            {{ $error }}<br>
                        @endforeach
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('admin.lapangan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Lapangan <span class="text-danger">*</span></label>
                        <input type="text" name="nama_lapangan" class="form-control"
                               placeholder="cth: Lapangan A" value="{{ old('nama_lapangan') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="3"
                                  placeholder="Deskripsi lapangan (opsional)">{{ old('deskripsi') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Harga per Jam (Rp) <span class="text-danger">*</span></label>
                        <input type="number" name="harga_per_jam" class="form-control"
                               placeholder="cth: 100000" value="{{ old('harga_per_jam') }}">
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Gambar Lapangan</label>
                        <input type="file" name="gambar" class="form-control"
                               accept="image/jpg,image/jpeg,image/png,image/webp"
                               onchange="previewImage(this)">
                        <small class="text-muted">Format: jpg, jpeg, png, webp. Maks: 2MB</small>
                        <div class="mt-2">
                            <img id="preview" src="" alt="Preview"
                                 class="rounded d-none"
                                 style="max-height:200px; object-fit:cover;">
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success px-4">
                            <i class="fas fa-save me-2"></i>Simpan
                        </button>
                        <a href="{{ route('admin.lapangan.index') }}" class="btn btn-secondary px-4">
                            <i class="fas fa-arrow-left me-2"></i>Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function previewImage(input) {
        const preview = document.getElementById('preview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('d-none');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush