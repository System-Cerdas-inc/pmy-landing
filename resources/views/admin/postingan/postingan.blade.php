@extends('admin.template.main')

@section('main_content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Postingan</h1>
</div>

<div class="card shadow mb-4">
    <!-- Card Header - Dropdown -->
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Tabel Postingan</h6>
        <div class="dropdown no-arrow">
            <button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" onclick="modal_tambah();">Tambah Data</button>
        </div>
    </div>
    <!-- Card Body -->
    <div class="card-body">
        <!-- table -->
        <div class="table-responsive">
            <table class="table datatables" id="data_table">
                <thead>
                    <tr>
                        <th>Jenis Postingan</th>
                        <th>Judul</th>
                        <th>Keterangan</th>
                        <th>Video</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<script>
    var table, pesan;
    $(document).ready(function() {
        table = $('#data_table').DataTable({
            ajax: {
                url: "{{ route('table-postingan') }}",
                type: 'GET'
            },
            columns: [{
                    data: 'jenis'
                },
                {
                    data: 'judul'
                },
                {
                    data: 'keterangan'
                },
                {
                    data: 'link_video'
                },
                {
                    data: 'button'
                }
                // Tambahkan kolom lain sesuai kebutuhan
            ],
            'columnDefs': [{
                "targets": [4], // your case first column
                "className": "text-center",
            }],
            processing: true,
            responsive: true
            // serverSide: true
        });
    });

    function modal_tambah() {
        window.location = `{{ route('form-postingan') }}`;
    }

    function reload() {
        table.ajax.reload(null, false); //reload datatable ajax
    }

    function modal_edit(id) {
        window.location = `{{ route('form-postingan', ['id' => '__PLACEHOLDER__']) }}`.replace('__PLACEHOLDER__', id);
    }
</script>
@endsection