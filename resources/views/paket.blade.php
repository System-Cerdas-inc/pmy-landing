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
                @foreach ($data_paket as $item)
                    <div class="col-md-3" data-aos="zoom-in" data-aos-delay="200">
                        <div class="pricing-tem">
                            @if ($item->popular == '1' && $item->popular_visible)
                                <span class="featured">Popular</span>
                            @endif

                            @if ($item->nama_visible)
                                <h2 style="color: #0dcaf0;">{{ $item->nama }}</h2>
                            @endif

                            @if ($item->kecepatan_visible && $item->nama != 'Paket Hemat')
                                <h6>{{ $item->kecepatan }} Mbps</h6>
                            @endif

                            @if ($item->harga_visible)
                                <div class="price"><sup>Rp.</sup>{{ number_format($item->harga, 0, ',', '.') }}<span> / bulan</span></div>
                            @endif

                            <ul>
                                @if ($item->kecepatan_visible)
                                    <li>Kecepatan hingga {{ $item->kecepatan }} Mbps</li>
                                @endif

                                @if ($item->device_visible)
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

                                @if ($item->registrasi_visible)
                                    <li>Registrasi Rp.{{ number_format($item->registrasi, 0, ',', '.') }}</li>
                                @endif
                            </ul>

                            <a href="{{ route('register') }}?package={{ Crypt::encrypt($item->id) }}" class="btn-buy">Daftar Sekarang</a>
                        </div>
                    </div><!-- End Pricing Item -->
                @endforeach
            </div><!-- End pricing row -->

        </div>

    </section><!-- /paket Section -->
@endsection