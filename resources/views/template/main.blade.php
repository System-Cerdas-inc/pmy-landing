<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Digital Jaringan Bersama</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('img/logo.png') }}" rel="icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">

    <!-- =======================================================
  * Template Name: FlexStart
  * Template URL: https://bootstrapmade.com/flexstart-bootstrap-startup-template/
  * Updated: Jun 06 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="index-page">

    <header id="header" class="header d-flex align-items-center fixed-top">
        <div class="container-fluid container-xl position-relative d-flex align-items-center">

            <a href="{{ route('home') }}" class="logo d-flex align-items-center me-auto">
                <!-- Uncomment the line below if you also wish to use an image logo -->
                <img src="{{ asset('img/logo.png') }}" alt="">
                <!-- <h1 class="sitename">FlexStart</h1> -->
                <img src="{{ asset('img/logo_text.png') }}" alt="" width="150px" height="auto">
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="{{ route('home') }}" class="active">Home<br></a></li>
                    @if($nama_menu == 'Home')
                    <li><a href="#paket">Paket</a></li>
                    <li><a href="#tutorial">Tutorial</a></li>
                    <li><a href="{{ route('register') }}">Register</a></li>
                    @else
                    <li><a href="{{ route('paket') }}">Paket</a></li>
                    <li><a href="{{ route('home') }}/#tutorial">Tutorial</a></li>
                    @endif
                    <li><a href="{{ route('auth') }}">Admin Panel</a></li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>

            <button type="button" class="btn-getstarted flex-md-shrink-0" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Client Area
            </button>

        </div>
    </header>

    <main class="main">
        @yield('main_content')
    </main>

    <!-- ======= Modal ======= -->

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Informasi</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <p>Khusus untuk customer yang sudah berlangganan, bila belum mengetahui user dan password client area silahkan hubungi cs, Whatsapp: <a href="https://wa.me/6285700600177" target="_blank">085-700-600-177</a> (chat only)</p>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
            <button type="button" class="btn btn-primary" onclick="window.open('http://area.digitaljb.com', '_blank')">Lanjut</button>
            </div>
        </div>
        </div>
    </div>

    <footer id="footer" class="footer">

        <div class="footer-newsletter">
            <div class="container">
                <div class="row justify-content-center text-center">
                    <div class="col-lg-6">
                        <h4>Buktikan Hebatnya</h4>
                        <p>daftar dan pasang wifi rumah anda disini</p>
                        <center>
                            <a href="{{ route('register') }}" class="btn-read-more d-inline-flex align-items-center justify-content-center align-self-center">
                                <span>Daftar Sekarang </span>
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </center>
                    </div>
                </div>
            </div>
        </div>

        <div class="container footer-top">
            <div class="row gy-4">
                <div class="col-lg-4 col-md-6 footer-about">
                    <a href="{{ route('home') }}" class="d-flex align-items-center">
                        <span class="sitename"><img src="{{ asset('img/logo&text.png') }}" alt=""></span>
                    </a>
                    <div class="footer-contact pt-3">
                        <p style="font-size: 10px;">Alamat HO : Desa Sindangagung Blok Pahing - Kuningan, Jawa Barat.</p>
                        <p style="font-size: 10px;">Alamat Cabang Pelayanan : Jl. Siliwangi RT007 RW002, Karamatmulya, Ciawigebang, Kab. Kuningan.</p>
                        <p style="font-size: 11px;"><strong>Email:</strong> <span>djb@digitaljb.com</span></p>
                        <p style="font-size: 11px;"><strong>WA CS:</strong> <span>085700600177</span></p>
                        <p style="font-size: 11px;"><strong>Call CS:</strong> <span>085133339355</span></p>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 footer-links">

                </div>

                <div class="col-lg-2 col-md-3 footer-links">

                </div>

                <div class="col-lg-4 col-md-12">
                    <h4>Support By :</h4>
                    <img src="{{ asset('img/picture4.png') }}" alt="" width="150px" height="100px">
                </div>

            </div>
        </div>

        <div class="container copyright text-center mt-4">
            <p>© <span>Copyright - {{ $year }}</span> <strong class="px-1 sitename">DjB</strong> <span>Supported By PT Sakti Wijaya Network (PMYNet) </span></p>
        </div>

    </footer>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="{{ asset('admin/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- <script src="{{ asset('vendor/php-email-form/validate.js') }}"></script> -->
    <script src="{{ asset('vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('vendor/purecounter/purecounter_vanilla.js') }}"></script>
    <script src="{{ asset('vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('vendor/swiper/swiper-bundle.min.js') }}"></script>

    <!-- Toastr -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- Main JS File -->
    <script src="{{ asset('js/main.js') }}"></script>

    <script>
        @if(Session::has('message'))
        var type = "{{ Session::get('alert-type', 'info') }}";
        switch (type) {
            case 'info':
                toastr["info"]("{{ Session::get('message') }}", "Information");
                break;

            case 'warning':
                toastr["warning"]("{{ Session::get('message') }}", "Warning!");
                break;

            case 'success':
                toastr["success"]("{{ Session::get('message') }}", "Success");
                break;

            case 'error':
                toastr["error"]("{{ Session::get('message') }}", "Error");
                break;
        }
        @endif

        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }

        function hanyaAngka(e, decimal) {
            var key;
            var keychar;
            if (window.event) {
                key = window.event.keyCode;
            } else if (e) {
                key = e.which;
            } else {
                return true;
            }
            keychar = String.fromCharCode(key);
            if ((key === null) || (key === 0) || (key === 8) || (key === 9) || (key === 13) || (key === 27)) {
                return true;
            } else if ((("+0123456789").indexOf(keychar) > -1)) {
                return true;
            } else if (decimal && (keychar === ".")) {
                return true;
            } else {
                return false;
            }
        }

        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            // tambahkan titik jika yang di input sudah menjadi angka satuan ribuan
            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix === undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }
    </script>

</body>

</html>