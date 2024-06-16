@extends('admin.template.main')

@section('main_content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Profil</h1>
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Data Diri</h6>
            </div>
            <!-- Card Body -->
            <form action="{{ route('datadiri-profil') }}" method="POST">
                <div class="card-body">
                    @csrf
                    <div class="form-group">
                        <label for="nama">Nama*</label>
                        <input class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" placeholder="Nama user" value="{{ old('nama', $data_user->full_name ?? '') }}">
                        @error('nama')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email*</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Email user" value="{{ old('email', $data_user->email ?? '') }}">
                        @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-6"></div>
                        <div class="col-sm-6">
                            <button class="btn btn-primary shadow-sm btn-block" type="submit">Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Password</h6>
            </div>
            <!-- Card Body -->
            <form action="{{ route('password-profil') }}" method="POST">
                <div class="card-body">
                    @csrf
                    <div class="form-group">
                        <label for="password">Password Baru*</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password baru" value="{{ old('password') }}">
                        @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="konfirm_password">Konfirmasi Password*</label>
                        <input type="password" class="form-control @error('konfirm_password') is-invalid @enderror" id="konfirm_password" name="konfirm_password" placeholder="Konfirmasi password baru" value="{{ old('konfirm_password') }}">
                        @error('konfirm_password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-6"></div>
                        <div class="col-sm-6">
                            <button class="btn btn-primary shadow-sm btn-block" type="submit">Ubah Password</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection