@extends('admin.template.main')

@section('main_content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Pendaftaran</h1>
    </div>

    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Tabel Pendaftaran</h6>
            <button class="btn btn-danger btn-sm" id="deleteSelected"><i class="fa fa-trash"></i> Hapus Data</button>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <!-- table -->
            <div class="table-responsive">
                <table class="table datatables" id="data_table">
                    <thead style="font-size: 14px;">
                        <tr>
                            <th><input type="checkbox" id="selectAll"></th>
                            <th>Pelanggan</th>
                            <th>Paket</th>
                            <th>Rekomendasi</th>
                            <th>Tgl Daftar</th>
                            <th>Detail Pasang</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 12px;"></tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_confirm" tabindex="-1" role="dialog" aria-labelledby="defaultModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_title_confirm">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form_confirm">
                        {{ csrf_field() }}
                        <input readonly hidden class="form-control" id="id_confirm" name="id_confirm">
                        <input readonly hidden class="form-control" id="kondisi" name="kondisi">
                        <div id="text_confirm"></div>
                        <div id="date_pasang_container" class="form-group" style="display: none;">
                            <label for="tanggal_pasang">Tanggal Pasang</label>
                            <input type="date" class="form-control" id="tanggal_pasang" name="tanggal_pasang" required>
                        </div>
                        <div id="date_terpasang_container" class="form-group" style="display: none;">
                            <label for="tanggal_terpasang">Tanggal Terpasang</label>
                            <input type="date" class="form-control" id="tanggal_terpasang" name="tanggal_terpasang" required>
                        </div>
                        <div id="nama_terpasang_container" class="form-group" style="display: none;">
                            <label for="nama_teknisi_terpasang" class="mt-2">Nama Teknisi</label>
                            <input type="text" class="form-control" id="nama_teknisi_terpasang" name="nama_teknisi_terpasang" required>
                        </div>
                        <div id="date_keterangan_container" class="form-group" style="display: none;">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" required></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                    <button type="button" class="btn btn-primary" id="btn_confirm" onclick="confirm_hapus();"><span class="d-none d-sm-block">Ya</span></button>
                </div>
            </div>
        </div>
    </div>

    <script>
        var table, pesan;
        $(document).ready(function() {
            table = $('#data_table').DataTable({
                ajax: {
                    url: "{{ route('table-pendaftaran') }}",
                    type: 'GET'
                },
                columns: [
                    { data: 'id', name: 'ID', orderable: false, searchable: false},
                    { data: 'nama', name: 'Name' },
                    { data: 'paket', name: 'Description' },
                    { data: 'rekomendasi', name: 'Description' },
                    { data: 'created_at', name: 'Created At' },
                    { data: 'detail_pasang', name: 'Detail Pasang' },
                    { data: 'status', name: 'Status' },
                    { data: 'button', name: 'Button' }
                ],
                'columnDefs': [{
                    "targets": [7],
                    "className": "text-center",
                }],
                // order: [[0, 'desc']],
                processing: true,
                responsive: true,
                autoWidth: true
            });

            $('#selectAll').on('click', function() {
                $('.selectRow').prop('checked', this.checked);
            });

            $('#deleteSelected').on('click', function() {
                var ids = [];
                $('.selectRow:checked').each(function() {
                    ids.push($(this).val());
                });

                if (ids.length > 0) {
                    if (confirm('Apakah Anda yakin ingin menghapus data yang dipilih?')) {
                        $.ajax({
                            url: "{{ route('delete-masal-pendaftaran') }}",
                            type: 'POST',
                            data: {
                                ids: ids,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(data) {
                                table.ajax.reload();
                                toastr["success"]("Data pendaftaran berhasil dihapus.", "Success");
                            },
                            error: function(data) {
                                toastr["error"]("Terjadi kesalahan saat menghapus data.", "Failed");
                            }
                        });
                    }
                } else {
                    alert('Silakan pilih data yang ingin dihapus.');
                }
            });
        });

        function confirm_hapus() {
            $.ajax({
                url: "{{ route('status-pendaftaran') }}", //link access data
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }, //Ini akan menambahkan token CSRF pada CUD
                type: "POST", //action in form
                dataType: "JSON", //accepted data types
                data: $('#form_confirm').serialize(), //retrieve data from form
                success: function(data) {
                    //show notification
                    if (data.status === "success") {
                        toastr["success"]("Data register berhasil dilakukan " + pesan + ".", "Success");

                        $('#form_confirm')[0].reset(); // reset form on modals
                        $('#modal_confirm').modal('hide'); // show bootstrap modal
                        reload();
                    } else {
                        toastr["error"]("Data register gagal dilakukan " + pesan + ", try again!", "Failed");
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    toastr["error"]("check your internet connection and refresh this page again!" + jqXHR
                        .responseText, "Failed");
                }
            });
        }

        function reload() {
            table.ajax.reload(null, false); //reload datatable ajax
        }

        function modal_edit(id) {
            window.location = `{{ route('form-pendaftaran', ['id' => '__PLACEHOLDER__']) }}`.replace('__PLACEHOLDER__', id);
        }

        function btn_aktif(id, nama) {
            $('#form_confirm')[0].reset(); // reset form on modals
            $('#modal_confirm').modal('show'); // show bootstrap modal when complete loaded
            $('#modal_title_confirm').html('Konfirmasi'); //ganti nama label pada modal

            $('#text_confirm').html('Anda yakin ingin mengaktifkan user dengan nama <b>' + nama + '</b>?');
            $('[name="id_confirm"]').val(id);
            $('[name="kondisi"]').val('1');
            $('#date_pasang_container').hide(); // Hide the date input
            $('#date_terpasang_container').hide(); // Hide the terpasang container
            $('#nama_terpasang_container').hide(); // Hide the nama terpasang container
            $('#date_keterangan_container').hide(); // Hide the keterangan input
            pesan = 'aktifasi';
        }

        function btn_nonaktif(id, nama) {
            $('#form_confirm')[0].reset(); // reset form on modals
            $('#modal_confirm').modal('show'); // show bootstrap modal when complete loaded
            $('#modal_title_confirm').html('Konfirmasi'); //ganti nama label pada modal

            $('#text_confirm').html('Anda yakin ingin menghapus user dengan nama <b>' + nama + '</b>?');
            $('[name="id_confirm"]').val(id);
            $('[name="kondisi"]').val('0');
            $('#date_pasang_container').hide(); // Hide the date input
            $('#date_terpasang_container').hide(); // Hide the terpasang container
            $('#nama_terpasang_container').hide(); // Hide the nama terpasang container
            $('#date_keterangan_container').hide(); // Hide the keterangan input
            pesan = 'penghapusan';
        }

        function btn_pasang(id, nama) {
            $('#form_confirm')[0].reset(); // reset form on modals
            $('#modal_confirm').modal('show'); // show bootstrap modal when complete loaded
            $('#modal_title_confirm').html('Konfirmasi'); //ganti nama label pada modal

            $('#text_confirm').html('Anda yakin ingin proses instalasi paket dengan nama <b>' + nama + '</b>?');
            $('[name="id_confirm"]').val(id);
            $('[name="kondisi"]').val('2');
            $('#date_pasang_container').show(); // Show the date input
            $('#date_terpasang_container').hide(); // Hide the terpasang container
            $('#nama_terpasang_container').show(); // Show the nama terpasang container
            $('#date_keterangan_container').hide(); // Hide the keterangan input
            pesan = 'proses instalasi';
        }

        function btn_terpasang(id, nama) {
            $('#form_confirm')[0].reset(); // reset form on modals
            $('#modal_confirm').modal('show'); // show bootstrap modal when complete loaded
            $('#modal_title_confirm').html('Konfirmasi Terpasang'); //ganti nama label pada modal

            $('#text_confirm').html('Anda yakin ingin menandai <b>' + nama + '</b> sebagai terpasang?');
            $('[name="id_confirm"]').val(id);
            $('[name="kondisi"]').val('5'); // Kondisi untuk terpasang
            $('#date_pasang_container').hide(); // Hide the pasang container
            $('#date_terpasang_container').show(); // Show the terpasang container
            $('#nama_terpasang_container').show(); // Show the nama terpasang container
            $('#date_keterangan_container').hide(); // Hide the keterangan input
            pesan = 'menandai sebagai terpasang';
        }

        function btn_tidak_pasang(id, nama) {
            $('#form_confirm')[0].reset(); // reset form on modals
            $('#modal_confirm').modal('show'); // show bootstrap modal when complete loaded
            $('#modal_title_confirm').html('Konfirmasi'); //ganti nama label pada modal

            $('#text_confirm').html('Anda yakin ingin tidak memproses instalasi paket dengan nama <b>' + nama + '</b>?');
            $('[name="id_confirm"]').val(id);
            $('[name="kondisi"]').val('3');
            $('#date_pasang_container').hide(); // Hide the date input
            $('#date_terpasang_container').hide(); // Hide the terpasang container
            $('#nama_terpasang_container').hide(); // Hide the nama terpasang container
            $('#date_keterangan_container').show(); // Show the keterangan input
            pesan = 'tidak memproses instalasi';
        }

        function btn_pending(id, nama) {
            $('#form_confirm')[0].reset(); // reset form on modals
            $('#modal_confirm').modal('show'); // show bootstrap modal when complete loaded
            $('#modal_title_confirm').html('Konfirmasi'); //ganti nama label pada modal

            $('#text_confirm').html('Anda yakin ingin pending instalasi paket dengan nama <b>' + nama + '</b>?');
            $('[name="id_confirm"]').val(id);
            $('[name="kondisi"]').val('4');
            $('#date_pasang_container').hide(); // Hide the date input
            $('#date_terpasang_container').hide(); // Hide the terpasang container
            $('#nama_terpasang_container').show(); // Show the nama terpasang container
            $('#date_keterangan_container').show(); // Show the keterangan input
            pesan = 'pending instalasi';
        }
    </script>
@endsection
