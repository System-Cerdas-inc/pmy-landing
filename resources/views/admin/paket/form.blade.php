@extends('admin.template.main')

@section('main_content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Paket</h1>
</div>

<div class="card shadow mb-4">
    <!-- Card Header - Dropdown -->
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Form Paket</h6>
    </div>
    <!-- Card Body -->
    <form action="{{ route('tambah-paket') }}" method="POST">
        @csrf
        <div class="card-body">
            <div class="form-group" hidden>
                <label for="id">ID</label>
                <input class="form-control" id="id" readonly name="id" value="{{ $data_paket->id ?? '' }}">
            </div>
            <div class="form-group">
                <label for="nama">Nama*</label>
                <input class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" placeholder="Nama paket internet" value="{{ old('nama', $data_paket->nama ?? '') }}">
                @error('nama')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="kecepatan">Kecepatan Internet*</label>
                <div class="input-group mb-2 mr-sm-2">
                    <input class="form-control @error('kecepatan') is-invalid @enderror" id="kecepatan" name="kecepatan" placeholder="Kecepatan paket internet" onkeypress="return hanyaAngka(event, true);" value="{{ old('kecepatan', $data_paket->kecepatan ?? '') }}">
                    <div class="input-group-prepend">
                        <div class="input-group-text">Mbps</div>
                    </div>
                </div>
                @error('kecepatan')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="device">Device*</label>
                <input class="form-control @error('device') is-invalid @enderror" id="device" name="device" placeholder="Jumlah device" onkeypress="return hanyaAngka(event, true);" value="{{ old('device', $data_paket->device ?? '') }}">
                @error('device')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="harga">Harga*</label>
                <div class="input-group mb-2 mr-sm-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text">Rp.</div>
                    </div>
                    <input class="form-control @error('harga') is-invalid @enderror" id="harga" name="harga" placeholder="Harga paket internet" onkeypress="return hanyaAngka(event, true);" value="{{ old('harga', $data_paket->harga ?? '') }}">
                    <div class="input-group-prepend">
                        <div class="input-group-text">/bulan</div>
                    </div>
                </div>
                @error('harga')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="registrasi">Harga Registrasi*</label>
                <div class="input-group mb-2 mr-sm-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text">Rp.</div>
                    </div>
                    <input class="form-control @error('registrasi') is-invalid @enderror" id="registrasi" name="registrasi" placeholder="Harga registrasi" onkeypress="return hanyaAngka(event, true);" value="{{ old('registrasi', $data_paket->registrasi ?? '') }}">
                </div>
                @error('registrasi')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="jenis">Jenis*</label>
                <select id="jenis" name="jenis" class="form-control @error('jenis') is-invalid @enderror">
                    <option value="" {{ old('jenis', $data_paket->jenis ?? '') == '' ? 'selected' : '' }}>Pilih jenis paket internet</option>
                    <option value="Regular" {{ old('jenis', $data_paket->jenis ?? '') == 'Regular' ? 'selected' : '' }}>Regular</option>
                    <option value="Promo" {{ old('jenis', $data_paket->jenis ?? '') == 'Promo' ? 'selected' : '' }}>Promo</option>
                </select>
                @error('jenis')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="popular">Popular</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="popular" name="popular" {{ old('popular', $data_paket->popular ?? '') ? 'checked' : '' }}>
                    <label class="form-check-label" for="popular">
                        Ya
                    </label>
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
        var harga = document.getElementById('harga').value;
        var registrasi = document.getElementById('registrasi').value;
        $('#harga').val(formatRupiah(harga));
        $('#registrasi').val(formatRupiah(registrasi));

        $('#harga').keyup(function() {
            var txt = $(this).val();
            $('#harga').val(formatRupiah(txt));
        });
        $('#registrasi').keyup(function() {
            var txt = $(this).val();
            $('#registrasi').val(formatRupiah(txt));
        });
    });

    function btn_batal() {
        window.location = `{{ route('admin-paket') }}`;
    }
</script>
@endsection