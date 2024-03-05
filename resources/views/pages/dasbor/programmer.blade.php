@extends('layouts.app')

@section('title', 'Dasbor')

@section('content')

<div class="row">

    <div class="col-6">
        <div class="card shadow-none">
            <div class="card-body bg-danger text-white d-flex">
                <div class="avatar-sm d-flex align-items-center justify-content-center me-2">
                    <i class="bx bx-file bx-md"></i>
                </div>
                <div>
                    <span class="d-block">Belum Selesai</span>
                    <span class="fs-5">{{ $jumlah_tiket_belum_selesai }} Tiket</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6">
        <div class="card shadow-none">
            <div class="card-body bg-success text-white d-flex">
                <div class="avatar-sm d-flex align-items-center justify-content-center me-2">
                    <i class="bx bx-task bx-md"></i>
                </div>
                <div>
                    <span class="d-block">Sudah Selesai</span>
                    <span class="fs-5">{{ $jumlah_tiket_selesai }} Tiket</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover w-100" id="table_pengingat">
                <thead>
                    <tr>
                        <th>Tenggat Waktu</th>
                        <th>Tiket Aplikasi</th>
                        <th>Modul</th>
                        <th>Target Aplikasi Selesai</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

@endsection

@section('js')

<script>
    $('#table_pengingat').DataTable({
        ajax: '../dasbor/pengingat',
        columns: [
            {
                data: 'id',
                render: (data, type, row) => 
                {
                    let warna = 'text-secondary';
                    if( row.sisa_level < 2 ) 
                    {
                        warna = 'text-danger';
                    }
                    else if( row.sisa_level < 4 )
                    {
                        warna = 'text-warning';
                    }

                    return `<span class='${warna}'>${row.sisa_hari}</span>`
                }
            },
            {
                data: 'id',
                render: (data, type, row) => 
                {
                    let warna = 'text-secondary';
                    if( row.sisa_level < 2 ) 
                    {
                        warna = 'text-danger';
                    }
                    else if( row.sisa_level < 4 )
                    {
                        warna = 'text-warning';
                    }

                    return `<span class='${warna}'>${row.nama_tiket}</span>`
                }
            },
            {
                data: 'id',
                render: (data, type, row) => 
                {
                    let warna = 'text-secondary';
                    if( row.sisa_level < 2 ) 
                    {
                        warna = 'text-danger';
                    }
                    else if( row.sisa_level < 4 )
                    {
                        warna = 'text-warning';
                    }

                    return `<span class='${warna}'>${row.nama}</span>`
                }
            },
            {
                data: 'id',
                render: (data, type, row) => 
                {
                    let warna = 'text-secondary';
                    if( row.sisa_level < 2 ) 
                    {
                        warna = 'text-danger';
                    }
                    else if( row.sisa_level < 4 )
                    {
                        warna = 'text-warning';
                    }

                    return `<span class='${warna}'>${row.waktu_tutup}</span>`
                }
            },
            {
                data: 'id',
                render: (data, type, row) => 
                {
                    let warna = 'text-secondary';
                    if( row.sisa_level < 2 ) 
                    {
                        warna = 'text-danger';
                    }
                    else if( row.sisa_level < 4 )
                    {
                        warna = 'text-warning';
                    }

                    return `<a href='../../tiket/${row.tr_tiket_id}/do' class='${warna}'>Detail</a>`
                }
            },
        ]
    });
</script>

@endsection