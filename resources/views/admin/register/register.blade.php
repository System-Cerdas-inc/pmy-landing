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
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <!-- table -->
            <div class="table-responsive">
                <table class="table datatables" id="data_table">
                    <thead style="font-size: 14px;">
                        <tr>
                            <th>Pelanggan</th>
                            <th>Paket</th>
                            <th>Rekomendasi</th>
                            <th>Tgl Registrasi</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 12px;"></tbody>
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
                    url: "{{ route('table-pendaftaran') }}",
                    type: 'GET'
                },
                columns: [{
                        data: 'nama',
                        name: 'Name'
                    },
                    {
                        data: 'paket',
                        name: 'Description'
                    },
                    {
                        data: 'rekomendasi',
                        name: 'Description'
                    },
                    {
                        data: 'created_at',
                        name: 'Created At'
                    },
                    {
                        data: 'status',
                        name: 'Status'
                    },
                    {
                        data: 'button',
                        name: 'Button'
                    }
                    // Tambahkan kolom lain sesuai kebutuhan
                ],
                'columnDefs': [{
                    "targets": [4], // your case first column
                    "className": "text-center",
                }],
                order: [
                    [3, 'desc']
                ],
                processing: true,
                responsive: true,
                autoWidth: true
                // serverSide: true
            });
        });

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
            $('[name="kondisi"]').val('aktif');
            pesan = 'aktifasi';
        }

        function btn_nonaktif(id, nama) {
            $('#form_confirm')[0].reset(); // reset form on modals
            $('#modal_confirm').modal('show'); // show bootstrap modal when complete loaded
            $('#modal_title_confirm').html('Konfirmasi'); //ganti nama label pada modal

            $('#text_confirm').html('Anda yakin ingin menghapus user dengan nama <b>' + nama + '</b>?');
            $('[name="id_confirm"]').val(id);
            $('[name="kondisi"]').val('nonaktif');
            pesan = 'penghapusan';
        }

        function confirm() {
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
    </script>
@endsection
