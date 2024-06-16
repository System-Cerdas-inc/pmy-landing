@extends('admin.template.main')

@section('main_content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Postingan</h1>
</div>

<div class="card shadow mb-4">
    <!-- Card Header - Dropdown -->
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Form Postingan</h6>
    </div>
    <!-- Card Body -->
    <form action="{{ route('tambah-postingan') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            <div class="form-group" hidden>
                <label for="id">ID</label>
                <input class="form-control" id="id" readonly name="id" value="{{ $data_postingan->id ?? '' }}">
            </div>
            <div class="form-group">
                <label for="jenis">Jenis*</label>
                <select id="jenis" name="jenis" class="form-control @error('jenis') is-invalid @enderror">
                    <option value="" {{ old('jenis', $data_postingan->jenis ?? '') == '' ? 'selected' : '' }}>Pilih jenis postingan</option>
                    <option value="Video" {{ old('jenis', $data_postingan->jenis ?? '') == 'Video' ? 'selected' : '' }}>Video</option>
                    <option value="Harga Dashboard" {{ old('jenis', $data_postingan->jenis ?? '') == 'Harga Dashboard' ? 'selected' : '' }}>Harga Dashboard</option>
                </select>
                @error('jenis')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="judul">Judul*</label>
                <input class="form-control @error('judul') is-invalid @enderror" id="judul" name="judul" placeholder="Judul postingan" value="{{ old('judul', $data_postingan->judul ?? '') }}">
                @error('judul')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="keterangan">Keterangan</label>
                <textarea class="form-control" id="keterangan" name="keterangan" rows="3" placeholder="Keterangan postingan">{{ old('keterangan', $data_postingan->keterangan ?? '') }}</textarea>
            </div>
            <div class="form-group">
                <label for="video">Upload Video</label>
                <input type="file" class="form-control-file @error('video') is-invalid @enderror" id="video" name="video">
                @error('video')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-sm-6">
                    <button class="btn btn-secondary shadow-sm btn-block" onclick="btn_batal();" type="button">Batal</button>
                </div>
                <div class="col-sm-6">
                    <button class="btn btn-primary shadow-sm btn-block" type="submit">Simpan</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    $(document).ready(function() {

    });

    function btn_batal() {
        window.location = `{{ route('admin-postingan') }}`;
    }
</script>
@endsection