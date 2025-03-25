@extends('admin.template.main')

@section('main_content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Keterangan Paket</h1>
    </div>

    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Tabel Keterangan Paket</h6>
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
                            <th>Id</th>
                            <th>Judul</th>
                            <th>#</th>
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
                    url: "{{ route('table-paket-keterangan') }}",
                    type: 'GET'
                },
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'title'
                    },
                    {
                        data: 'button'
                    }
                    // Tambahkan kolom lain sesuai kebutuhan
                ],
                'columnDefs': [{
                    "targets": [0], // your case first column
                    "className": "text-center",
                }],
                processing: true,
                responsive: true
                // serverSide: true
            });
        });

        function modal_tambah() {
            window.location = `{{ route('form-paket-keterangan') }}`;
        }

        function reload() {
            table.ajax.reload(null, false); //reload datatable ajax
        }

        function modal_edit(id) {
            window.location = `{{ route('form-paket-keterangan', ['id' => '__PLACEHOLDER__']) }}`.replace('__PLACEHOLDER__',
                id);
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
                url = "{{ route('delete-paket-keterangan') }}"; // Route untuk delete
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
