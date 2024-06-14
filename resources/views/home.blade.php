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
                <h2 data-aos="fade-up" class="mb-3">Mulai Dari Rp. 140.000/Bulan*</h2>

                <p data-aos="fade-up" data-aos-delay="100" style="font-size: 14px;">*Syarat dan Ketentuan Berlaku</p>
                <div class=" d-flex flex-column flex-md-row" data-aos="fade-up" data-aos-delay="200">
                    <a href="#about" class="btn-get-started">Register Sekarang <i class="bi bi-arrow-right"></i></a>
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
                        Digital Jaringan Bersama berdiri sebagai wujud nyata dalam peran aktif memajukan dunia jasa layanan di Indonesia.
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
            @foreach($data_paket as $item)
            <div class="col-md-4" data-aos="zoom-in" data-aos-delay="200">
                <div class="pricing-tem">
                    @if($item->popular == '1')
                    <span class="featured">Popular</span>
                    @endif

                    <h2 style="color: #0dcaf0;">{{ $item->nama }}</h2>
                    <h6>{{ $item->kecepatan }} Mbps</h6>
                    <div class="price"><sup>Rp.</sup>{{ number_format($item->harga) }}<span> / bulan</span></div>
                    <ul>
                        <li>Kecepatan hingga {{ $item->kecepatan }} Mbps</li>
                        <li>Bebas Device / HP yang terhubung</li>
                        <li>Standart Untuk 1 - {{ $item->device }} Device</li>
                        <li>Kuota Unlimited</li>
                        <li class="na">Registrasi Rp.{{ number_format($item->registrasi) }}</li>
                    </ul>
                    <a href="#" class="btn-buy">Daftar Sekarang</a>
                </div>
            </div><!-- End Pricing Item -->
            @endforeach

        </div><!-- End pricing row -->
        <br>
        <center>
            <a href="{{ route('paket') }}" class="btn-get-started">Lihat Paket Lain</a>
        </center>


    </div>

</section><!-- /paket Section -->

<!-- Faq Section -->
<section id="tutorial" class="faq section">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>Tutorial</h2>
        <p>Frequently Asked Questions</p>
    </div><!-- End Section Title -->

    <div class="container">

        <div class="row">

            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">

                <div class="faq-container">

                    <div class="faq-item faq-active">
                        <h3>Non consectetur a erat nam at lectus urna duis?</h3>
                        <div class="faq-content">
                            <p>Feugiat pretium nibh ipsum consequat. Tempus iaculis urna id volutpat lacus laoreet non curabitur gravida. Venenatis lectus magna fringilla urna porttitor rhoncus dolor purus non.</p>
                        </div>
                        <i class="faq-toggle bi bi-chevron-right"></i>
                    </div><!-- End Faq item-->

                    <div class="faq-item">
                        <h3>Feugiat scelerisque varius morbi enim nunc faucibus a pellentesque?</h3>
                        <div class="faq-content">
                            <p>Dolor sit amet consectetur adipiscing elit pellentesque habitant morbi. Id interdum velit laoreet id donec ultrices. Fringilla phasellus faucibus scelerisque eleifend donec pretium. Est pellentesque elit ullamcorper dignissim. Mauris ultrices eros in cursus turpis massa tincidunt dui.</p>
                        </div>
                        <i class="faq-toggle bi bi-chevron-right"></i>
                    </div><!-- End Faq item-->

                    <div class="faq-item">
                        <h3>Dolor sit amet consectetur adipiscing elit pellentesque?</h3>
                        <div class="faq-content">
                            <p>Eleifend mi in nulla posuere sollicitudin aliquam ultrices sagittis orci. Faucibus pulvinar elementum integer enim. Sem nulla pharetra diam sit amet nisl suscipit. Rutrum tellus pellentesque eu tincidunt. Lectus urna duis convallis convallis tellus. Urna molestie at elementum eu facilisis sed odio morbi quis</p>
                        </div>
                        <i class="faq-toggle bi bi-chevron-right"></i>
                    </div><!-- End Faq item-->

                </div>

            </div><!-- End Faq Column-->

            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">

                <div class="faq-container">

                    <div class="faq-item">
                        <h3>Ac odio tempor orci dapibus. Aliquam eleifend mi in nulla?</h3>
                        <div class="faq-content">
                            <p>Dolor sit amet consectetur adipiscing elit pellentesque habitant morbi. Id interdum velit laoreet id donec ultrices. Fringilla phasellus faucibus scelerisque eleifend donec pretium. Est pellentesque elit ullamcorper dignissim. Mauris ultrices eros in cursus turpis massa tincidunt dui.</p>
                        </div>
                        <i class="faq-toggle bi bi-chevron-right"></i>
                    </div><!-- End Faq item-->

                    <div class="faq-item">
                        <h3>Tempus quam pellentesque nec nam aliquam sem et tortor consequat?</h3>
                        <div class="faq-content">
                            <p>Molestie a iaculis at erat pellentesque adipiscing commodo. Dignissim suspendisse in est ante in. Nunc vel risus commodo viverra maecenas accumsan. Sit amet nisl suscipit adipiscing bibendum est. Purus gravida quis blandit turpis cursus in</p>
                        </div>
                        <i class="faq-toggle bi bi-chevron-right"></i>
                    </div><!-- End Faq item-->

                    <div class="faq-item">
                        <h3>Perspiciatis quod quo quos nulla quo illum ullam?</h3>
                        <div class="faq-content">
                            <p>Enim ea facilis quaerat voluptas quidem et dolorem. Quis et consequatur non sed in suscipit sequi. Distinctio ipsam dolore et.</p>
                        </div>
                        <i class="faq-toggle bi bi-chevron-right"></i>
                    </div><!-- End Faq item-->

                </div>

            </div><!-- End Faq Column-->

        </div>

    </div>

</section><!-- /Faq Section -->
@endsection