@extends('template.main')

@section('main_content')

<!-- Contact Section -->
<section id="register" class="contact section">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>Register</h2>
        <p>Contact Us</p>
    </div><!-- End Section Title -->

    <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4">
            <form action="{{ route('proses-register') }}" method="post" class="php-email-form">
                @csrf
                <div class="row gy-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama_depan">Nama Depan<c style="color: red;">*</c></label>
                            <input class="form-control @error('nama_depan') is-invalid @enderror" name="nama_depan" id="nama_depan" placeholder="Masukkan nama depan" value="{{ old('nama_depan') }}">
                            @error('nama_depan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama_belakang">Nama Belakang<c style="color: red;">*</c></label>
                            <input class="form-control @error('nama_belakang') is-invalid @enderror" name="nama_belakang" id="nama_belakang" placeholder="Masukkan nama belakang" value="{{ old('nama_belakang') }}">
                            @error('nama_belakang')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="alamat">Alamat<c style="color: red;">*</c></label>
                            <input class="form-control @error('alamat') is-invalid @enderror" name="alamat" id="alamat" placeholder="Masukkan alamat" value="{{ old('alamat') }}">
                            @error('alamat')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="no_wa">Nomor Whatsapp<c style="color: red;">*</c></label>
                            <input class="form-control @error('no_wa') is-invalid @enderror" name="no_wa" id="no_wa" placeholder="Masukkan nomor whatsapp" value="{{ old('no_wa') }}">
                            @error('no_wa')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="kecamatan">Kecamatan<c style="color: red;">*</c></label>
                            <input class="form-control @error('kecamatan') is-invalid @enderror" name="kecamatan" id="kecamatan" placeholder="Masukkan kecamatan" value="{{ old('kecamatan') }}">
                            @error('kecamatan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="kelurahan">Kelurahan<c style="color: red;">*</c></label>
                            <input class="form-control @error('kelurahan') is-invalid @enderror" name="kelurahan" id="kelurahan" placeholder="Masukkan kelurahan" value="{{ old('kelurahan') }}">
                            @error('kelurahan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="paket">Pilih Paket<c style="color: red;">*</c></label>
                            <select class="form-control @error('paket') is-invalid @enderror" id="paket" name="paket">
                                <option value="" selected>Pilih paket internet</option>
                                @foreach($data_paket as $item)
                                <option value="{{ $item->id }}" {{ old("paket") == $item->id ? 'selected' : '' }}>{{ $item->nama }}</option>
                                @endforeach
                            </select>
                            @error('paket')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="syarat_dan_ketentuan" name="syarat_dan_ketentuan">
                        <label class="form-check-label" for="syarat_dan_ketentuan"> Harap Centang Syarat dan Ketentuan sebelum mengirim Formulir</label>
                    </div>
                    <a href="{{ route('syarat-dan-ketentuan') }}">Syarat dan Ketentuan</a>

                    <div class="col-md-12">
                        <button type="button" onclick="btn_submit();">Kirim</button>
                    </div>
                </div>
            </form>
        </div>

    </div>

    <div class="modal fade" id="modal_confirm" tabindex="-1" role="dialog" aria-labelledby="defaultModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_title_confirm">Konfirmasi</h5>
                </div>
                <div class="modal-body">
                    <div>Apakah data yang anda isi sudah benar?</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="tidakSubmitForm();">Tidak</button>
                    <button type="button" class="btn btn-info" style="color: whites;" id="btn_confirm" onclick="submitForm();"><span class="d-none d-sm-block">Ya</span></button>
                </div>
            </div>
        </div>
    </div>

</section><!-- /Contact Section -->

<script>
    function btn_submit() {
        var nama_depan = document.getElementById('nama_depan').value;
        var nama_belakang = document.getElementById('nama_belakang').value;
        var alamat = document.getElementById('alamat').value;
        var no_wa = document.getElementById('no_wa').value;
        var kecamatan = document.getElementById('kecamatan').value;
        var kelurahan = document.getElementById('kelurahan').value;
        var paket = document.getElementById('paket').value;
        var sk = document.getElementById('syarat_dan_ketentuan').checked

        //check data isian
        if (nama_depan === '' && nama_belakang === '' && alamat === '' && no_wa === '' && kecamatan === '' &&
            kelurahan === '' && paket === '') {
            toastr["warning"]("Mohon maaf, terdapat data yang belum terisi lengkap.", "Warning!");
        } else {
            // Cek apakah checkbox "Syarat dan Ketentuan" dicentang
            if (!sk) {
                toastr["warning"]("Mohon maaf anda belum menyetujui Syarat dan Ketentuan yang berlaku.", "Warning!");
            } else {
                $('#modal_confirm').modal('show'); // show bootstrap modal when complete loaded
            }
        }
    }

    function submitForm() {
        $('#modal_confirm').modal('hide'); // Sembunyikan modal konfirmasi
        document.querySelector('.php-email-form').submit(); // Kirim form secara manual
    }

    function tidakSubmitForm() {
        $('#modal_confirm').modal('hide'); // show bootstrap modal when complete loaded
    }
</script>
@endsection