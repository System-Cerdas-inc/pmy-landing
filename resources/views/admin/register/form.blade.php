@extends('admin.template.main')

@section('main_content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Registrasi User</h1>
</div>

<div class="card shadow mb-4">
    <!-- Card Header - Dropdown -->
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Form Registrasi User</h6>
    </div>
    <!-- Card Body -->
    <form action="{{ route('update-paket') }}" method="POST">
        @csrf
        <div class="card-body">
            <div class="form-group" hidden>
                <label for="id">ID</label>
                <input class="form-control" id="id" readonly name="id" value="{{ $data_register->id ?? '' }}">
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="nama_depan">Nama Depan*</label>
                        <input class="form-control @error('nama_depan') is-invalid @enderror" id="nama_depan" name="nama_depan" placeholder="Nama depan" value="{{ old('nama_depan', $data_register->nama_depan ?? '') }}">
                        @error('nama_depan')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="nama_belakang">Nama Belakang*</label>
                        <input class="form-control @error('nama_belakang') is-invalid @enderror" id="nama_belakang" name="nama_belakang" placeholder="Nama belakang" value="{{ old('nama_belakang', $data_register->nama_belakang ?? '') }}">
                        @error('nama_belakang')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="alamat">Alamat*</label>
                        <input class="form-control @error('alamat') is-invalid @enderror" name="alamat" id="alamat" placeholder="Masukkan alamat" value="{{ old('alamat', $data_register->alamat ?? '') }}">
                        @error('alamat')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="no_wa">Nomor Whatsapp*</label>
                        <input class="form-control @error('no_wa') is-invalid @enderror" name="no_wa" id="no_wa" placeholder="Masukkan nomor whatsapp" value="{{ old('no_wa', $data_register->no_wa ?? '') }}" onkeypress="return hanyaAngka(event, true);">
                        @error('no_wa')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="kecamatan">Kecamatan*</label>
                        <input class="form-control @error('kecamatan') is-invalid @enderror" name="kecamatan" id="kecamatan" placeholder="Masukkan kecamatan" value="{{ old('kecamatan', $data_register->kecamatan ?? '') }}">
                        @error('kecamatan')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="kelurahan">Kelurahan*</label>
                        <input class="form-control @error('kelurahan') is-invalid @enderror" name="kelurahan" id="kelurahan" placeholder="Masukkan kelurahan" value="{{ old('kelurahan', $data_register->kelurahan ?? '') }}">
                        @error('kelurahan')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="paket">Pilih Paket*</label>
                        <select class="form-control @error('paket') is-invalid @enderror" id="paket" name="paket">
                            <option value="" selected>Pilih paket internet</option>
                            @foreach($data_paket as $item)
                            <option value="{{ $item->id }}" data-harga="{{ $item->registrasi }}" {{ old("paket", $data_register->paket ?? '') == $item->id ? 'selected' : '' }}>{{ $item->nama }} - Rp. {{ number_format($item->harga, 0, ',', '.') }}/bulan</option>
                            @endforeach
                        </select>
                        @error('paket')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                        <small id="harga-registrasi" style="display: none;">Harga Registrasi: </small>
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
        window.location = `{{ route('admin-pendaftaran') }}`;
    }
</script>
@endsection