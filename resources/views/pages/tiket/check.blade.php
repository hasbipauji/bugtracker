@extends('layouts.app')

@section('title', 'Kerjakan Tiket Aplikasi')

@section('content')

<input type="hidden" name="tr_tiket_id" id="tr_tiket_id" value="{{$id}}">

<!-- begin::row -->
<div class="row">
    <div class="col-sm-8">
        <div class="card shadow-sm">
            <div class="card-body">
                <!-- begin::table_modul -->
                <div class="table-responsive">
                    <table id="table_modul" class="table table-bordered table-hover w-100">
                        <thead>
                            <tr>
                                <th style="width: 20px">No</th>
                                <th style="width: 150px">Modul</th>
                                <th style="width: 50px">Lama Pengerjaan</th>
                                <th style="width: 50px">Status</th>
                                <th style="width: 50px">Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <!-- end::table_modul -->

            </div>
        </div>
    </div>

    <div class="col-sm-4">
    <div class="card shadow-sm">
            <div class="card-body">
                <div class="mb-3">
                    <p class="text-secondary m-0">Nama Aplikasi</p>
                    <p class="fw-bold m-0" id="detail_nama">-</p>
                </div>
                <div class="mb-3">
                    <p class="text-secondary m-0">Deskripsi Singkat</p>
                    <p class="fw-bold m-0" id="detail_deskripsi">-</p>
                </div>
                <div class="mb-3">
                    <p class="text-secondary m-0">Dokumen Pendukung</p>
                    <a href="#" target="_blank" class="fw-bold m-0" id="detail_dokumen">-</a>
                </div>
                <div class="mb-3">
                    <p class="text-secondary m-0">URL Pengembangan</p>
                    <a href="#" target="_blank" class="fw-bold m-0" id="detail_url_pengembangan">-</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end::row -->

<!-- begin::modal_url_pengembangan -->
<div id="modal_url_pengembangan" class="modal" tab-index="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">URL Pengembangan</h5>
                <button class="btn-close" data-bs-dismiss='modal' aria-label="close"></button>
            </div>

            <div class="modal-body">
                <form id="form_url_pengembangan">
                    @csrf

                    <div class="row mb-2">
                        <label for="url_pengembangan" class="col-form-label col-sm-4">URL Pengembangan</label>
                        <div class="col-sm-8">
                            <input 
                                type="url" 
                                name="url_pengembangan" 
                                id="url_pengembangan"
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
<!-- end::modal_url_pengembangan -->

<!-- begin::modal_pengujian -->
<div id="modal_pengujian" class="modal" tab-index="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pengujian Aplikasi</h5>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
            </div>

            <div class="modal-body">
                <form id="form_pengujian" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="tr_modul_id" id="tr_modul_id">

                    <div class="row mb-2">
                        <label for="modul_status" class="col-form-label col-sm-4">Status Modul</label>
                        <div class="col-sm-8">
                            <select name="status" id="modul_status" class="form-select">
                                <option value="REVISI">REVISI</option>
                                <option value="SELESAI">SELESAI</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <label for="gambar" class="col-form-label col-sm-4">Gambar</label>
                        <div class="col-sm-8">
                            <input 
                                type="file" 
                                name="gambar" 
                                id="gambar" 
                                class="form-control" 
                                accept=".png, .jpg, .jpeg"
                                >
                        </div>
                    </div>
                    
                    <div class="row mb-2">
                        <label for="catatan" class="col-form-label col-sm-4">Catatan</label>
                        <div class="col-sm-8">
                            <textarea 
                                name="catatan" 
                                id="catatan" 
                                rows="5"
                                class="form-control"
                                ></textarea>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-8">
                            <input type="submit" value="Tambah" class="btn btn-primary">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- end::modal_pengujian -->

<!-- begin::modal_catatan_pengujian -->
<div id="modal_catatan_pengujian" class="modal" tab-index="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Catatan Pengujian</h5>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
            </div>

            <div class="modal-body" id="daftar_catatan_pengujian">
                
            </div>
        </div>
    </div>
</div>
<!-- end::modal_catatan_pengujian -->
@endsection

@section('js')

<script>
    $('#table_modul').DataTable({
        ajax: '../../modul/'+$('#tr_tiket_id').val(),
        columns: [
            {data: 'no'},
            {
                data: 'id',
                render: (data, type, row) => 
                {
                    let fitur = row.nama;
                    row.fitur.forEach( e => {
                        fitur += `<li>${e.nama}</li>`;
                    });

                    return fitur;
                }
            },
            {
                data: 'id',
                render: (data, type, row) => 
                {
                    return row.lama_pengerjaan + ' Hari'
                }
            },
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
                        case 'REVISI':
                            warna = 'badge bg-warning';
                            break;
                        case 'TES':
                            warna = 'badge bg-info';
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
                    let buttons = `<button class="btn btn-sm btn-info" onClick='modalCatatanPengujian(${row.id})'>Catatan Pengujian</button>`;
                    if( row.status == 'TES' )
                    {
                        buttons += `<button class='btn btn-sm btn-primary w-100 mt-2' onClick='modalPengujian(${row.id})'>Uji Aplikasi</button>`;
                    }
                    
                    return buttons;
                }
            },
        ]
    });

    // begin::onload
    window.onload = () =>
    {
        getDetail();
    }
    // end::onload

    // begin::getDetail
    const getDetail = () => 
    {
        const id = $('#tr_tiket_id').val();
        $.ajax({
            url: `../../tiket/${id}/detail`,
            method: 'get',
            success: (response) =>
            {
                const data = response.data;

                $('#detail_nama').html( data.nama );
                $('#detail_deskripsi').html( data.deskripsi );
                $('#detail_dokumen').attr('href', '/'+data.dokumen ).html('Lihat Dokumen');
                $('#detail_url_pengembangan').attr('href', data.url_pengembangan ).html('Lihat Aplikasi');
            }
        })
    }
    // end::getDetail

    // begin::modalUrlPengembangan
    const modalUrlPengembangan = () => 
    {
        $('#modal_url_pengembangan').modal('show');

        $.ajax({
            url: '../../tiket/'+$('#tr_tiket_id').val()+'/detail',
            method: 'get',
            success: (response) => 
            {
                const data =  response.data;
                $('#url_pengembangan').val( data.url_pengembangan );
            }
        })
    }
    // end::modalUrlPengembangan

    // begin::form_url_pengembangan
    $('#form_url_pengembangan').on('submit', function(e) 
    {
        e.preventDefault();

        Swal.fire({
            icon: 'question',
            text: 'Simpan URL Pengembangan ?',
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
                let form_data = new FormData(this);
                form_data.append('tr_tiket_id', $('#tr_tiket_id').val());

                $.ajax({
                    url: '../../tiket/url_pengembangan',
                    method: 'post',
                    dataType: 'json',
                    data: form_data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: (response) =>
                    {
                        if( response.status )
                        {
                            toastr.success("URL pengembangan berhasil disimpan");
                            getDetail();
                        }
                    }
                })
            }
        })
    });
    // end::form_url_pengembangan

    // begin::serahkan
    const serahkan = (id) => 
    {
        Swal.fire({
            icon: 'question',
            text: 'Serahkan hasil pengerjaan kepada tester ?',
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
                let form_data = new FormData();
                form_data.append('_token', "{{ csrf_token() }}");

                $.ajax({
                    url: `../../modul/${id}/serahkan`,
                    method: 'post',
                    dataType: 'json',
                    data: form_data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: (response) =>
                    {
                        if( response.status )
                        {
                            toastr.success("Hasil pengerjaan modul berhasil diserahkan");
                            $('#table_modul').DataTable().ajax.reload();
                        }
                    }
                })
            }
        })
    }
    // end::serahkan

    // begin::modalPengujian
    const modalPengujian = (id) =>
    {
        $('#modal_pengujian').modal('show');
        $('#form_pengujian').trigger('reset');
        $('#daftar_fitur').html( '' );
        $('#tr_modul_id').val(id);
    }
    // end::modalPengujian

    // begin::form_pengujian
    $('#form_pengujian').on('submit', function(e) 
    {
        e.preventDefault();

        Swal.fire({
            icon: 'question',
            text: 'Tambah hasil pengujian ?',
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
                    url: '../../modul_viewer',
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
                            toastr.success('Hasil pengujian berhasil ditambahkan');
                            $('#modal_pengujian').modal('hide');
                            $('#table_modul').DataTable().ajax.reload();
                        }
                        else 
                        {
                            toastr.error('Hasil pengujian gagal ditambahkan');
                        }
                    }
                })
            }
        })
    })
    // end::form_pengujian

    // begin::modalCatatanPengujian
    const modalCatatanPengujian = (id) =>
    {
        $('#modal_catatan_pengujian').modal('show');

        $.ajax({
            url: `../../modul_viewer/${id}`,
            method: 'get',
            success: (response) =>
            {
                const data = response.data;

                let rows = '';
                data.forEach( e => 
                {
                    rows += `
                    <div class="border-bottom pb-2 mb-3">
                        <p class="mb-2">${e.catatan}</p>
                        <a href="../../${e.gambar}" target="_blank" class="btn btn-link px-0">Lihat Gambar</a>
                    </div>
                    `;
                });

                $('#daftar_catatan_pengujian').html(rows);
            }
        })
    }
    // end::modalCatatanPengujian
</script>

@endsection