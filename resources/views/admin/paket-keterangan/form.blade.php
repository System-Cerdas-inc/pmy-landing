@extends('admin.template.main')

@section('main_content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Keterangan Paket</h1>
</div>

<div class="card shadow mb-4">
    <!-- Card Header - Dropdown -->
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Form Keterangan Paket</h6>
    </div>
    <!-- Card Body -->
    <form action="{{ route('tambah-paket-keterangan') }}" method="POST">
        @csrf
        <div class="card-body">
            <div class="form-group" hidden>
                <label for="id">ID</label>
                <input class="form-control" id="id" readonly name="id" value="{{ $data_paket_keterangan->id ?? '' }}">
            </div>
            <div class="form-group">
                <label for="paket">Paket*</label>
                <select class="form-control" id="paket" name="paket">
                    @foreach ($data_paket as $item)
                    @if (old('paket', $item->id ?? '') == $item->id)
                    <option value="{{ $item->id }}" selected>{{ $item->nama }}</option>
                    @else
                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                    @endif
                    @endforeach
                </select>
                @error('paket')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="judul">Judul Keterangan Paket*</label>
                <textarea class="form-control" id="judul_keterangan_paket" name="judul_keterangan_paket" rows="3" placeholder="Judul Keterangan postingan">{{ old('judul_keterangan_paket', $data_paket_keterangan->title ?? '') }}</textarea>
                @error('judul')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="judul_visible">Tampilkan Judul</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <input type="checkbox" name="judul_visible" {{ old('judul_visible', $data_paket_keterangan->judul_visible ?? true) ? 'checked' : '' }}>
                        </div>
                    </div>
                </div>
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
        window.location = `{{ route('admin-paket-keterangan') }}`;
    }
</script>
@endsection