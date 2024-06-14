@extends('template.main')

@section('main_content')

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


    </div>

</section><!-- /paket Section -->
@endsection