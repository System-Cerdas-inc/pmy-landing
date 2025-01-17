@extends('template.main')

@section('main_content')
    <!-- Hero Section -->
    <section id="hero" class="hero section">

        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center">
                    <h1 data-aos="fade-up">Nikmati Internet Cepat</h1>
                    <p data-aos="fade-up" data-aos-delay="100">Unlimited & Murah</p>
                    <br>
                    <h2 data-aos="fade-up" class="mb-3">Mulai Dari Rp. {{ $data_postingan_harga }}/Bulan*</h2>

                    <p data-aos="fade-up" data-aos-delay="100" style="font-size: 14px;">*Syarat dan Ketentuan Berlaku</p>
                    <div class=" d-flex flex-column flex-md-row" data-aos="fade-up" data-aos-delay="200">
                        <a href="#paket" class="btn-get-started">Cek Paket <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-out">
                    <img src="{{ asset('img/hero-img2.png') }}" class="img-fluid animated" alt="">
                </div>
            </div>
        </div>

    </section><!-- /Hero Section -->

    <!-- About Section -->
    <section id="about" class="about section">

        <div class="container" data-aos="fade-up">
            <div class="row gx-0">

                <div class="col-lg-6 d-flex flex-column justify-content-center" data-aos="fade-up" data-aos-delay="200">
                    <div class="content">
                        <!-- <h3>Who We Are</h3> -->
                        <h3>Welcome To</h3>
                        <p>
                            Digital Jaringan Bersama berdiri sebagai wujud nyata dalam peran aktif memajukan dunia jasa
                            layanan di Indonesia.
                        </p>
                    </div>
                </div>

                <div class="col-lg-6 d-flex align-items-center" data-aos="zoom-out" data-aos-delay="200">
                    <img src="{{ asset('img/about.jpg') }}" class="img-fluid" alt="">
                </div>

            </div>
        </div>

    </section><!-- /About Section -->

    <!-- paket Section -->
    <section id="paket" class="pricing section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Harga</h2>
            <p>Paket Wi-Fi Rumah<br></p>
        </div><!-- End Section Title -->

        <div class="container">
            <div class="row gy-4">
                @foreach ($data_paket as $item)
                    @if ($item->status == '1') <!-- Cek status paket aktif -->
                        <div class="col-md-3" data-aos="zoom-in" data-aos-delay="200">
                            <div class="pricing-tem">
                                @if ($item->popular == '1' && $item->popular_visible) <!-- Cek popular dan visibility -->
                                    <span class="featured">Popular</span>
                                @endif

                                @if ($item->nama_visible) <!-- Cek visibility nama -->
                                    <h2 style="color: #0dcaf0;">{{ $item->nama }}</h2>
                                @endif

                                @if ($item->kecepatan_visible && $item->nama != 'Paket Hemat') <!-- Cek visibility kecepatan -->
                                    <h6>{{ $item->kecepatan }} Mbps</h6>
                                @endif

                                @if ($item->harga_visible) <!-- Cek visibility harga -->
                                    <div class="price"><sup>Rp.</sup>{{ number_format($item->harga, 0, ',', '.') }}<span> / bulan</span></div>
                                @endif

                                <ul>
                                    @if ($item->kecepatan_visible) <!-- Cek visibility kecepatan -->
                                        <li>Kecepatan hingga {{ $item->kecepatan }} Mbps</li>
                                    @endif

                                    @if ($item->device_visible) <!-- Cek visibility device -->
                                        @if ($item->nama == 'Paket Hemat')
                                            <li>Maksimal Untuk 1 - {{ $item->device }} Device</li>
                                            <li>Kuota Unlimited</li>
                                            <li>Sistem Voucher Roaming</li>
                                        @else
                                            <li>Bebas Device / HP yang terhubung</li>
                                            <li>Standar Untuk 1 - {{ $item->device }} Device</li>
                                            <li>Kuota Unlimited</li>
                                        @endif
                                    @endif

                                    @if ($item->registrasi_visible) <!-- Cek visibility registrasi -->
                                        <li>Registrasi Rp.{{ number_format($item->registrasi, 0, ',', '.') }}</li>
                                    @endif
                                </ul>

                                <a href="{{ route('register') }}?package={{ Crypt::encrypt($item->id) }}" class="btn-buy">Daftar Sekarang</a>
                            </div>
                        </div><!-- End Pricing Item -->
                    @endif
                @endforeach
            </div><!-- End pricing row -->
            <br>
            <center>
                <a href="{{ route('paket') }}" class="btn-get-started">Lihat Paket Lain</a>
            </center>
        </div>
    </section><!-- /Paket Section -->

    <!-- Faq Section -->
    <section id="tutorial" class="faq section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Tutorial</h2>
        </div><!-- End Section Title -->

        <div class="container">

            <div class="row">
                @foreach ($data_postingan as $item)
                    <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="faq-container">
                            <div class="faq-item">
                                <h3>{{ $item->judul }}</h3>
                                <div class="faq-content">
                                    <p>
                                        {{ $item->keterangan }}
                                        <br>
                                        <video width="640" height="360" controls="controls" type="video/mp4"
                                            preload="none">
                                            <source src="{{ $item->link_video }}" autostart="false">
                                        </video>
                                    </p>

                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->
                        </div>
                    </div><!-- End Faq Column-->
                @endforeach
            </div>

        </div>

    </section><!-- /Faq Section -->
@endsection
