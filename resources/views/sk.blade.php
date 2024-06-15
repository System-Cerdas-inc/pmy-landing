@extends('template.main')

@section('main_content')

<style>
    tr {
        margin-top: 20px;
    }
</style>

<!-- Contact Section -->
<section id="register" class="contact section">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>Syarat dan Ketentuan</h2>
        <p>Syarat Dan Ketentuan Layanan DjB By PMYNet.</p>
    </div><!-- End Section Title -->

    <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4">
            <table style="width: 100%;">
                <tr>
                    <td style="vertical-align:top;">1.</td>
                    <td>Layanan DjBHome diberikan kepada Pelanggan sebagai layanan “up to” sehingga DjB Home tidak memberikan jaminan kecepatan sesuai dengan paket layanan yang di gunakan oleh pelanggan.</td>
                </tr>
                <tr>
                    <td style="vertical-align:top;">2.</td>
                    <td>Layanan DjB Home merupakan layanan berbasis Internet , dimana akses dan penggunaan data Internet disesuaikan dengan jumlah Kecepatan yang ditentukan oleh paket yang dipilih. Apabila pemakaian kecepatan telah memenuhi batas maksimum, Pelanggan tetap dapat menikmati layanan internet dengan penyesuaian kecepatan yang telah ditentukan.</td>
                </tr>
                <tr>
                    <td style="vertical-align:top;">3.</td>
                    <td>Pelanggan mengetahui bahwa Layanan DjBHome tidak dapat mengeluarkan invoice fisik atau bukti bayar yang setara dengan faktur pajak.</td>
                </tr>
                <tr>
                    <td style="vertical-align:top;">4.</td>
                    <td>Pelanggan mengetahui bahwa Layanan merupakan layanan Prabayar dan untuk berlangganan Pelanggan harus melakukan pembayaran bulanan atau tahunan untuk memperpanjang masa aktif sesuai paket Layanan yang dipilih.</td>
                </tr>
                <tr>
                    <td style="vertical-align:top;">5.</td>
                    <td>Layanan DjB Home hanya tersedia di area yang tercakup Jaringan The New DjBHome Fiber. Cakupan area tersebut dapat di cek ke CS / Sales kami.</td>
                </tr>
                <tr>
                    <td style="vertical-align:top;">6.</td>
                    <td>IP yang diberikan layanan DjBHome Home adalah IP Private DHCP/ PPPOE.</td>
                </tr>
                <tr>
                    <td style="vertical-align:top;">7.</td>
                    <td>Layanan DjBHome hanya diperuntukan untuk konsumen pribadi/perumahan/apartemen, tidak diperkenankan untuk badan usaha.</td>
                </tr>
                <tr>
                    <td style="vertical-align:top;">8.</td>
                    <td>Pelanggan mengetahui bahwa 1 (satu) akun Layanan DjBHome terdiri dari 1 (satu) akses Broadband Internet. Akses Broadband Internet disediakan oleh PT Sakti Wijaya Network (PMYNet).</td>
                </tr>
                <tr>
                    <td style="vertical-align:top;">9.</td>
                    <td>Pelanggan mengetahui bahwa kualitas Layanan yang diterima tergantung pada perangkat Layanan dengan perangkat penerima baik secara langsung dan/atau tidak langsung.</td>
                </tr>
                <tr>
                    <td style="vertical-align:top;">10.</td>
                    <td>Layanan diberikan tanpa jaminan tertentu, tanpa jaminan gangguan Layanan dan tanpa jaminan ketersedian Layanan dimana Layanan dapat diakses secara bersamaan oleh semua Pelanggan tanpa pengaturan, alokasi dan/atau prioritas tertentu. Pelanggan berhak memperoleh dukungan teknis dan/atau non-teknis dari DjBHome care yang dapat dihubungi 24 x 7 terkait dengan Layanan melalui Whatsapp CS : 085-700-600-177.</td>
                </tr>
                <tr>
                    <td style="vertical-align:top;">11.</td>
                    <td>Pelanggan akan memberi izin kepada pegawai atau kontraktor Layanan memasuki wilayah milik Pelanggan untuk melakukan instalasi, aktivasi, konfigurasi, dan/atau pemeliharaan Layanan pada saat yang telah disepakati Pelanggan.</td>
                </tr>
                <tr>
                    <td style="vertical-align:top;">12.</td>
                    <td>Biaya penggunaan Layanan Prabayar dan/atau biaya paket-paket tambahan lain yang berlaku hanya dapat dilihat pada situs resmi DjBHome.</td>
                </tr>
                <tr>
                    <td style="vertical-align:top;">13.</td>
                    <td>Selama berlangganan perangkat Modem, atau alat pendukung lainnya statusnya di pinjamkan, bila pelanggan tidak melakukan perpanjangan paket selama 3bulan berturut-turut maka perangkat akan di ambil kembali.</td>
                </tr>
                <tr>
                    <td style="vertical-align:top;">14.</td>
                    <td>DjBHome berhak untuk mengganti, merubah dan/atau menambah biaya berlangganan dari waktu ke waktu tanpa membutuhkan persetujuan dari Pelanggan.</td>
                </tr>
                <tr>
                    <td style="vertical-align:top;">15.</td>
                    <td>DjBHome berhak untuk menambahkan dan atau mengakhiri kerjasama denganContent Provider saat ini, Pelanggan mengetahui dan menyetujui bahwa setiap perubahan yang dilakukan tersebut tidak merubah biaya berlangganan atas layanan DjBHome yang digunakan.</td>
                </tr>
                <tr>
                    <td style="vertical-align:top;">16.</td>
                    <td>Pelanggan menyatakan bahwa informasi yang telah diberikan kepada DjBHome adalah benar dan sepakat untuk terikat dengan Syarat dan Ketentuan Layanan. Setiap perubahan terhadap informasi yang telah diberikan wajib disampaikan kepada DjBHome selama berlangganan Layanan.</td>
                </tr>
                <tr>
                    <td style="vertical-align:top;">17.</td>
                    <td>Pelanggan mengetahui dan menyetujui bahwa DjBHome dapat menggunakan dan memberikan data nomor handphone pelanggan DjBHome yang terdaftar kepada pihak ketiga, untuk kepentingan kerjasama sebagai upaya peningkatan layanan sistem pembayaran DjBHome ke pelanggan.</td>
                </tr>
                <tr>
                    <td style="vertical-align:top;">18.</td>
                    <td>DjBHome tidak bertanggung jawab atas pembayaran yang dilakukan oleh pelanggan ke rekening selain rekening resmi DjBHome (melalui Akun BRIVA). Karyawan DjBHome tidak diperbolehkan menerima imbalan atau pembayaran dalam bentuk apapun yang diberikan oleh pelanggan.</td>
                </tr>
            </table>
        </div>

    </div>

</section><!-- /Contact Section -->
@endsection