@extends('admin.template.main')

@section('main_content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Paket</h1>
    </div>

    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Tabel Paket</h6>
            <div class="dropdown no-arrow">
                <button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" onclick="modal_tambah();">Tambah
                    Data</button>
            </div>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <!-- table -->
            <div class="table-responsive">
                <table class="table datatables" id="data_table">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Kecepatan</th>
                            <th>Device</th>
                            <th>Harga</th>
                            <th>Popular</th>
                            <th>Urutan</th>
                            <th>Status</th>
                            <th>Visibility</th> <!-- Kolom baru untuk Visibility -->
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_confirm" tabindex="-1" role="dialog" aria-labelledby="defaultModalLabel"
        aria-hidden="true">
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
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                    <button type="button" class="btn btn-primary" id="btn_confirm" onclick="confirm();"><span
                            class="d-none d-sm-block">Ya</span></button>
                </div>
            </div>
        </div>
    </div>

    <script>
        var table, pesan;
        $(document).ready(function() {
            table = $('#data_table').DataTable({
                ajax: {
                    url: "{{ route('table-paket') }}",
                    type: 'GET'
                },
                columns: [{
                        data: 'nama',
                        name: 'Name'
                    },
                    {
                        data: 'kecepatan',
                        name: 'Description'
                    },
                    {
                        data: 'device',
                        name: 'Description'
                    },
                    {
                        data: 'harga',
                        name: 'Description'
                    },
                    {
                        data: 'popular',
                        name: 'Description'
                    },
                    {
                        data: 'urutan',
                        name: 'Urutan'
                    },
                    {
                        data: 'status',
                        name: 'Status'
                    },
                    {
                        data: 'visibility',
                        name: 'Visibility'
                    }, // Kolom Visibility
                    {
                        data: 'button',
                        name: 'Button'
                    }
                ],
                'columnDefs': [{
                    "targets": [4, 5], // Kolom Popular dan Urutan
                    "className": "text-center",
                }],
                columnDefs: [{
                    targets: 5, // Indeks kolom urutan
                    render: function(data, type, row) {
                        return data !== '-' ? data : 999; // Berikan nilai besar untuk NULL
                    },
                    type: 'num'
                }],
                order: [
                    [5, 'asc'] // Urutkan berdasarkan kolom urutan
                ],
                processing: true,
                responsive: true
            });
        });

        function modal_tambah() {
            window.location = `{{ route('form-paket') }}`;
        }

        function reload() {
            table.ajax.reload(null, false); //reload datatable ajax
        }

        function modal_edit(id) {
            window.location = `{{ route('form-paket', ['id' => '__PLACEHOLDER__']) }}`.replace('__PLACEHOLDER__', id);
        }

        function btn_aktif(id, nama) {
            $('#form_confirm')[0].reset(); // reset form on modals
            $('#modal_confirm').modal('show'); // show bootstrap modal when complete loaded
            $('#modal_title_confirm').html('Konfirmasi'); //ganti nama label pada modal

            $('#text_confirm').html('Anda yakin ingin mengaktifkan paket dengan nama <b>' + nama + '</b>?');
            $('[name="id_confirm"]').val(id);
            $('[name="kondisi"]').val('aktif');
            pesan = 'aktifasi';
        }

        function btn_nonaktif(id, nama) {
            $('#form_confirm')[0].reset(); // reset form on modals
            $('#modal_confirm').modal('show'); // show bootstrap modal when complete loaded
            $('#modal_title_confirm').html('Konfirmasi'); //ganti nama label pada modal

            $('#text_confirm').html('Anda yakin ingin menonaktifkan paket dengan nama <b>' + nama + '</b>?');
            $('[name="id_confirm"]').val(id);
            $('[name="kondisi"]').val('nonaktif');
            pesan = 'nonaktif';
        }

        function btn_delete(id, nama) {
            $('#form_confirm')[0].reset(); // reset form on modals
            $('#modal_confirm').modal('show'); // show bootstrap modal when complete loaded
            $('#modal_title_confirm').html('Konfirmasi Hapus'); //ganti nama label pada modal

            $('#text_confirm').html('Anda yakin ingin menghapus paket dengan nama <b>' + nama + '</b>?');
            $('[name="id_confirm"]').val(id);
            $('[name="kondisi"]').val('hapus');
            pesan = 'hapus';
        }

        function confirm() {
            var url, data;

            if ($('#kondisi').val() === 'hapus') {
                url = "{{ route('delete-paket') }}"; // Route untuk delete
            } else {
                url = "{{ route('status-paket') }}"; // Route untuk aktif/nonaktif
            }

            data = $('#form_confirm').serialize(); // Ambil data dari form

            $.ajax({
                url: url, // Link access data
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }, // Token CSRF
                type: "POST", // Action in form
                dataType: "JSON", // Accepted data types
                data: data, // Retrieve data from form
                success: function(response) {
                    // Show notification
                    if (response.status === "success") {
                        toastr["success"]("Paket berhasil di" + pesan + ".", "Success");

                        $('#form_confirm')[0].reset(); // Reset form on modals
                        $('#modal_confirm').modal('hide'); // Hide bootstrap modal
                        reload(); // Reload datatable
                    } else {
                        toastr["error"]("Paket gagal di" + pesan + ", coba lagi!", "Failed");
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    toastr["error"]("Cek koneksi internet Anda dan muat ulang halaman ini! " + jqXHR
                        .responseText, "Failed");
                }
            });
        }
    </script>
@endsection
