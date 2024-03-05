@extends('layouts.app')

@section('title', 'Tiket Aplikasi')

@section('content')

<!-- begin::card -->
<div class="card shadow-sm">
    <div class="card-body">

        <!-- begin::table -->
        <div class="table-responsive">
            <table id="table_tiket" class="table table-bordered table-hover w-100">
                <thead>
                    <tr>
                        <th style="width: 30px">No</th>
                        <th style="width: 150px;">Nama Aplikasi</th>
                        <th>Deskripsi Singkat</th>
                        <th style="width: 100px">Status</th>
                        <th style="width: 100px">Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
        <!-- end::table -->

    </div>
</div>
<!-- end::card -->

@endsection

@section('js')

<script>
    // begin::table_tiket
    $('#table_tiket').DataTable({
        ajax: '/tiket/data',
        sorting: false,
        columns: [
            {data: 'no'},
            {
                data: 'id',
                render: (data, type, row) =>
                {
                    return `<span class='text-primary d-block'>${row.nama}</span><a href='${row.dokumen}' class='text-dark'>Lihat Dokumen</a>`;
                }
            },
            {data: 'deskripsi'},
            {
                data: 'id',
                render: (data, type, row) => 
                {
                    let warna = '';
                    switch ( row.status ) {
                        case 'SELESAI':
                            warna = 'badge bg-success';
                            break;
                        case 'PROSES':
                            warna = 'badge bg-warning';
                            break;
                        default:
                            warna = 'badge bg-danger';
                            break;
                    }

                    return `<div class='${warna}'>${row.status}</div>`;
                }
            },
            {
                data: 'id',
                render: (data, type, row) =>
                {
                    let buttons = '';
                    if( row.status != 'MENUNGGU' ) {
                        buttons += `<a href='../tiket/${row.id}/do' class='btn btn-sm btn-primary ms-2'>Kerjakan</a>`;
                    }

                    return buttons;
                }
            },
        ]
    });
    // end::table_tiket
</script>

@endsection