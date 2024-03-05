@extends('layouts.app')

@section('title', 'Tiket Aplikasi')

@section('content')

<!-- begin::card -->
<div class="card shadow-sm">
    <div class="card-body">

        <!-- begin::conroller -->
        <button class="btn btn-primary mb-3" onclick="modalTiket('Tambah', '-')">Tambah</button>
        <!-- end::conroller -->

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

<!-- begin::modal -->
<!-- begin::modal_tiket -->
<div id="modal_tiket" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_tiket_title"></h5>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form_tiket" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="id" id="id">

                    <div class="row mb-2">
                        <label for="nama" class="col-form-label col-sm-4">Nama Aplikasi</label>
                        <div class="col-sm-8">
                            <input 
                                type="text" 
                                name="nama" 
                                id="nama"
                                class="form-control"
                                placeholder="Isikan nama aplikasi disini"
                                required>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <label for="deskripsi" class="col-form-label col-sm-4">Deskripsi Singkat</label>
                        <div class="col-sm-8">
                            <textarea 
                                name="deskripsi" 
                                id="deskripsi" 
                                rows="5"
                                class="form-control"
                                placeholder="Isikan deskripsi singkat aplikasi disini"
                                required></textarea>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <label for="dokumen" class="col-form-label col-sm-4">Dokumen</label>
                        <div class="col-sm-8">
                            <input 
                                type="file" 
                                name="dokumen" 
                                id="dokumen"
                                accept=".pdf"
                                class="form-control"
                                required>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-8">
                            <input type="submit" value="Simpan" class="btn btn-primary">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- end::modal_tiket -->
<!-- end::modal -->

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
                    return `<span class='text-primary d-block'>${row.nama}</span><a href='${row.dokumen}' target='_blank' class='text-dark'>Lihat Dokumen</a>`;
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
                    buttons += `<a class='btn btn-sm btn-info' href="/tiket/${row.id}">Detail</a>`;
                    if( row.status == 'MENUNGGU' ) {
                        buttons += `<button class='btn btn-sm btn-danger ms-2' onclick='deleteTiket(${row.id})'>Hapus</button>`;
                    } else {
                        buttons += '';
                    }

                    return buttons;
                }
            },
        ]
    });
    // end::table_tiket

    // begin::modalTiket
    const modalTiket = (title, id) => 
    {
        $('#form_tiket').trigger('reset');
        $('#id').val(id);
        $('#modal_tiket_title').html(title+' Tiket');
        $('#modal_tiket').modal('show');
    }
    // end::modalTiket

    // begin::form_tiket
    $('#form_tiket').on('submit', function(e) 
    {
        e.preventDefault();

        Swal.fire({
            icon: 'question',
            text: 'Simpan tiket ?',
            showCancelButton: true,
            cancelButtonText: 'Batal',
            confirmButtonText: 'Simpan',
            buttonsStyling: false,
            customClass: {
                confirmButton: 'btn btn-primary',
                cancelButton: 'btn btn-secondary ms-2'
            }
        }).then( result => 
        {
            if( result.isConfirmed )
            {
                $.ajax({
                    url: '/tiket',
                    method: 'post',
                    dataType: 'json',
                    data: new FormData(this),
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: (response) =>
                    {
                        if( response.status )
                        {
                            toastr.success("Tiket berhasil disimpan");
                            $('#modal_tiket').modal('hide');
                            $('#table_tiket').DataTable().ajax.reload();
                            $('#form_tiket').trigger('reset');
                        }
                    }
                })
            }
        })
    });
    // end::form_tiket
    
    // begin::deleteTiket
    const deleteTiket = (id) =>
    {
        Swal.fire({
            icon: 'question',
            text: 'Hapus tiket ?',
            showCancelButton: true,
            cancelButtonText: 'Batal',
            confirmButtonText: 'Hapus',
            buttonsStyling: false,
            customClass: {
                confirmButton: 'btn btn-danger',
                cancelButton: 'btn btn-secondary ms-2'
            }
        }).then( result => 
        {
            if( result.isConfirmed )
            {
                $.ajax({
                    url: `/tiket/${id}`,
                    method: 'delete',
                    data: {
                        _token: `{{ csrf_token() }}`
                    },
                    success: (response) =>
                    {
                        if( response.status )
                        {
                            toastr.success('Tiket berhasil dihapus');
                            $('#table_tiket').DataTable().ajax.reload();
                        }
                    }
                })
            }
        })
    }
    // end::deleteTiket
</script>

@endsection