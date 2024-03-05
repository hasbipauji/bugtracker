@extends('layouts.app')

@section('title', 'Detail Tiket')

@section('content')

<input type="hidden" name="id_tiket" id="id_tiket" value="{{ $id }}">

<!-- begin::row -->
<div class="row">
    <!-- begin::left -->
    <div class="col-sm-8">

        <div class='card shadow-sm'>
            <div class='card-body'>

                <div class="d-flex mb-3 justify-content-between">
                    <div>
                        <button class="btn btn-primary d-none me-2" onclick="modalModul('Tambah', '-')" id="tombol_tambah">Tambah</button>
                        <button class="btn btn-light" onclick="modalHistori()">Histori</button>
                    </div>
                    <button class="btn btn-danger d-none" onclick="tutupTiket()" id="tombol_tutup">Tutup</button>
                </div>
                
                <div class="table-responsive">
                    <table id="table_modul" class="table table-bordered w-100 table-responsive table-hover">
                        <thead>
                            <tr>
                                <th style="width: 30px">No</th>
                                <th>Modul</th>
                                <th style="width: 250px">Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>

            </div>
        </div>

    </div>
    <!-- end::left -->

    <!-- begin::right -->
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
                <div class="mb-3">
                    <p class="text-secondary m-0">Porgrammaer</p>
                    <div class="d-flex justify-content-between">
                        <p class="fw-bold m-0" id="detail_programmer">-</p>
                        <span role="button" class="text-primary" onclick="modalDetailProgrammer()">Detail</span>
                    </div>
                </div>
                <div class="">
                    <p class="text-secondary m-0">Tester</p>
                    <div class="d-flex justify-content-between">
                    <p class="fw-bold m-0" id="detail_tester">-</p>
                        <span role="button" class="text-primary" onclick="modalDetailTester()">Detail</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end::right -->
</div>
<!-- end::row -->

<!-- begin::modal_modul -->
<div id="modal_modul" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_modul_title"></h5>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
            </div>

            <div class="modal-body">
                <form id="form_modul">
                    @csrf

                    <input type="hidden" name="id" id="modul_id">

                    <div class="row mb-2">
                        <label for="nama" class="col-form-label col-sm-5">Nama Modul</label>
                        <div class="col-sm-7">
                            <input 
                                type="text" 
                                name="nama" 
                                id="modul_nama" 
                                class="form-control" 
                                placeholder="Masukan nama modul disini"
                                required>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <label for="lama_pengerjaan" class="col-form-label col-sm-5">Lama Pengerjaan (hari)</label>
                        <div class="col-sm-7">
                            <input 
                                type="number" 
                                name="lama_pengerjaan" 
                                id="modul_lama_pengerjaan" 
                                class="form-control" 
                                placeholder="Masukan estimasi pengerjaan modul"
                                required>
                        </div>
                    </div>

                    <div class="row mt-3" id="tombol_ubah_modul">
                        <div class="col-sm-5"></div>
                        <div class="col-sm-7">
                            <input type="submit" value="Simpan" class="btn btn-primary">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- end::modal_modul -->

<!-- begin::modal_detail -->
<div id="modal_detail" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_detail_title"></h5>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
            </div>

            <div class="modal-body">
                <form id="form_fitur" class="mb-5">
                    @csrf

                    <input type="hidden" name="tr_modul_id" id="modul_detail_id">

                    <div class="row mb-2">
                        <label for="nama" class="col-form-label col-sm-4">Nama Modul</label>
                        <div class="col-sm-8">
                            <input 
                                type="text" 
                                name="nama" 
                                id="modul_detail_nama" 
                                class="form-control-plaintext" 
                                readonly>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <label for="nama" class="col-form-label col-sm-4">Nama Fitur</label>
                        <div class="col-sm-8">
                            <input 
                                type="text" 
                                name="nama" 
                                id="fitur_nama" 
                                class="form-control" 
                                placeholder="Masukan nama fitur disini"
                                required>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-8">
                            <input type="submit" value="Tambah" class="btn btn-primary">
                        </div>
                    </div>
                </form>

                <h6>Daftar Fitur :</h6>
                <ul class="ps-0 list-unstyled" id="daftar_fitur">
                    
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- end::modal_detail -->

<!-- begin::modal_detail_programmer -->
<div id="modal_detail_programmer" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Programmer</h5>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
            </div>

            <div class="modal-body">
                <form id="form_programmer" class="mb-5">
                    @csrf

                    <div class="row mb-2">
                        <label for="programmer_user_id" class="col-form-label col-sm-4">Programmer</label>
                        <div class="col-sm-8">
                            <select name="user_id" id="programmer_user_id" class="form-select" required>

                            </select>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-8">
                            <input type="submit" value="Tambah" class="btn btn-primary">
                        </div>
                    </div>
                </form>

                <h6>Daftar Programmer :</h6>
                <ul class="ps-0 list-unstyled" id="daftar_programmer">
                    
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- end::modal_detail_programmer -->

<!-- begin::modal_detail_tester -->
<div id="modal_detail_tester" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Tester</h5>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
            </div>

            <div class="modal-body">
                <form id="form_tester" class="mb-5">
                    @csrf

                    <div class="row mb-2">
                        <label for="tester_user_id" class="col-form-label col-sm-4">Tester</label>
                        <div class="col-sm-8">
                            <select name="user_id" id="tester_user_id" class="form-select" required>

                            </select>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-8">
                            <input type="submit" value="Tambah" class="btn btn-primary">
                        </div>
                    </div>
                </form>

                <h6>Daftar Tester :</h6>
                <ul class="ps-0 list-unstyled" id="daftar_tester">
                    
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- end::modal_detail_tester -->

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

<!-- begin::modal_histori -->
<div id="modal_histori" class="modal" tab-index="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Histori Tiket</h5>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
            </div>

            <div class="modal-body" id="daftar_histori">
                
            </div>
        </div>
    </div>
</div>
<!-- end::modal_histori -->
@endsection

@section('js')

<script>
    $('#table_modul').DataTable({
        ajax: '../modul/'+$('#id_tiket').val(),
        columns: [
            {data: 'no'},
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

                    return `<span class='d-block'>${row.nama}</span>
                            <div class='${warna}'>${row.status}</div>
                            <div class='mt-3'>Selesaikan sebelum tanggal :<br>${row.waktu_tutup == null ? '-' : row.waktu_tutup}</div>
                            `;
                }
            },
            {
                data: 'id',
                render: (data, type, row) =>
                {
                    let buttons = '';
                    buttons += `<button class='btn btn-sm btn-secondary me-2' onclick="modalModul('Ubah', ${row.id})">Ubah</button>`;
                    buttons += `<button class='btn btn-sm btn-warning me-2' onclick="modalDetail(${row.id})">Detail</button>`;
                    buttons += `<button class="btn btn-sm btn-info me-2" onClick='modalCatatanPengujian(${row.id})'>Catatan</button>`;
                    if( row.status == 'MENUNGGU' ) 
                    {
                        buttons += `<button class='btn btn-sm btn-danger me-2' onclick='deleteModul(${row.id})'>Hapus</button>`;
                        buttons += `<button class='btn btn-sm btn-success mt-2' onclick='openAccess(${row.id})'>Buka Akses</button>`;
                    } 
                    else if(row.status == 'PROSES' )
                    {
                        buttons += `<button class='btn btn-sm btn-danger mt-2' onclick='endAccess(${row.id})'>Akhiri Akses</button>`;
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
        const id = $('#id_tiket').val();
        $.ajax({
            url: `/tiket/${id}/detail`,
            method: 'get',
            success: (response) =>
            {
                const data = response.data;

                $('#detail_nama').html( data.nama );
                $('#detail_deskripsi').html( data.deskripsi );
                $('#detail_dokumen').attr('href', '/'+data.dokumen ).html('Lihat Dokumen');
                $('#detail_url_pengembangan').attr('href', data.url_pengembangan ).html('Lihat Aplikasi');
                $('#detail_programmer').html( data.programmer + ' orang');
                $('#detail_tester').html( data.tester + ' orang');

                if( data.modul_status != 'SELESAI' ) 
                {
                    $('#tombol_tambah').removeClass('d-none');
                    $('#tombol_tutup').addClass('d-none');
                    $('#form_fitur').removeClass('d-none');
                    $('#form_programmer').removeClass('d-none');
                    $('#form_tester').removeClass('d-none');
                    $('#tombol_ubah_modul').removeClass('d-none');
                } 
                else if( data.modul_status == 'SELESAI' && data.status != 'SELESAI' )
                {
                    $('#tombol_tambah').addClass('d-none');
                    $('#tombol_tutup').removeClass('d-none');
                }
                else if( data.status == 'SELESAI' ) 
                {
                    $('#tombol_tambah').addClass('d-none');
                    $('#tombol_tutup').addClass('d-none');
                    $('#form_fitur').addClass('d-none');
                    $('#form_programmer').addClass('d-none');
                    $('#form_tester').addClass('d-none');
                    $('#tombol_ubah_modul').addClass('d-none');
                }
            }
        })
    }
    // end::getDetail

    // begin::modalModul
    const modalModul = (title, id) =>
    {
        $('#form_modul').trigger('reset');
        $('#modul_id').val(id);
        $('#modal_modul_title').html(title+' Modul Aplikasi');
        $('#modal_modul').modal('show');

        if( id != '-' )
        {
            $.ajax({
                url: `../modul/${id}/show`,
                method: 'get',
                dataType: 'json',
                success: (response)=> 
                {
                    const data = response.data;

                    $('#modul_nama').val(data.nama);
                    $('#modul_lama_pengerjaan').val(data.lama_pengerjaan);
                }
            })
        }
    }
    // end::modalModul

    // begin::modalDetail
    const modalDetail = (id) =>
    {
        $('#form_fitur').trigger('reset');
        $('#modal_detail_title').html('Detail Modul');
        $('#modal_detail').modal('show');

        $.ajax({
            url: `../modul/${id}/show`,
            method: 'get',
            dataType: 'json',
            success: (response)=> 
            {
                const data = response.data;

                $('#modul_detail_id').val(data.id);
                $('#modul_detail_nama').val(data.nama);
            }
        });

        getsFitur(id);
    } 
    // end::modalDetail

    // begin::getsFitur
    const getsFitur = (id)=>
    {
        $('#daftar_fitur').html('');

        $.ajax({
            url: `../fitur/${id}`,
            method: 'get',
            dataType: 'json',
            success: (response)=> 
            {
                const data = response.data;
                
                let rows = '';

                data.forEach(e => {

                    rows += `
                    <li class='mb-2'>
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="m-0">${e.nama}</p>
                            <button class="btn btn-sm btn-danger" onClick='deleteFitur(${e.id})'>Hapus</button>
                        </div>
                    </li>`;
                });

                $('#daftar_fitur').html(rows);
            }
        });
    }
    // end::getsFitur

    // begin::form_modul
    $('#form_modul').on('submit', function(e) 
    {
        e.preventDefault();

        Swal.fire({
            icon: 'question',
            text: 'Simpan modul aplikasi ?',
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
                const modul_id = $('#modul_id').val();
                let form_data = new FormData(this);

                if( modul_id == '-' )
                {
                    form_data.append('tr_tiket_id', $('#id_tiket').val());
    
                    $.ajax({
                        url: '../modul',
                        method: 'post',
                        dataType: 'json',
                        data: form_data,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: (response)=>
                        {
                            if( response.status )
                            {
                                toastr.success('Modul aplikasi berhasil disimpan');
                                $('#table_modul').DataTable().ajax.reload();
                                $('#modal_modul').modal('hide');
                            }
                            else
                            {
                                toastr.error('Modul aplikasi gagal disimpan');
                            }
                        }
                    })
                }
                else
                {
                    $.ajax({
                        url: `../modul/${modul_id}`,
                        method: 'post',
                        dataType: 'json',
                        data: form_data,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: (response)=>
                        {
                            if( response.status )
                            {
                                toastr.success('Modul aplikasi berhasil disimpan');
                                $('#table_modul').DataTable().ajax.reload();
                                $('#modal_modul').modal('hide');
                            }
                            else
                            {
                                toastr.error('Modul aplikasi gagal disimpan');
                            }
                        }
                    })
                }
            }
        })
    });
    // end::form_modul

    // begin::deleteModul
    const deleteModul = (id) =>
    {
        Swal.fire({
            icon: 'question',
            text: 'Hapus modul ?',
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
                    url: `../modul/${id}`,
                    method: 'delete',
                    dataType: 'json',
                    data: {
                        _token: `{{ csrf_token() }}`
                    },
                    success: (response) =>
                    {
                        if( response.status )
                        {
                            toastr.success('Modul berhasil dihapus');
                            $('#table_modul').DataTable().ajax.reload();
                        }
                    }
                })
            }
        })
    }
    // end::deleteModul

    // begin::form_fitur
    $('#form_fitur').on('submit', function(e)
    {
        e.preventDefault();

        let form_data = new FormData(this);

        Swal.fire({
            icon: 'question',
            text: 'Tambahkan fitur ?',
            showCancelButton: true,
            cancelButtonText: 'Batal',
            confirmButtonText: 'Tambah',
            buttonsStyling: false,
            customClass: {
                confirmButton: 'btn btn-primary',
                cancelButton: 'btn btn-secondary ms-2'
            }
        }).then( result => {
            if( result.isConfirmed )
            {
                $.ajax({
                    url: '../fitur',
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
                            toastr.success('Fitur berhasil ditambahkan');
                            $('#fitur_nama').val('');
                            getsFitur($('#modul_detail_id').val());
                        }
                    }
                })
            }
        })
    })
    // end::form_fitur

    // begin::deleteFitur
    const deleteFitur = (id) =>
    {
        Swal.fire({
            icon: 'question',
            text: 'Hapus fitur ?',
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
                    url: `../fitur/${id}`,
                    method: 'delete',
                    dataType: 'json',
                    data: {
                        _token: `{{ csrf_token() }}`
                    },
                    success: (response) =>
                    {
                        if( response.status )
                        {
                            toastr.success('Fitur berhasil dihapus');
                            getsFitur($('#modul_detail_id').val());
                        }
                    }
                })
            }
        })
    }
    // end::deleteFitur

    // begin::modalDetailProgrammer
    const modalDetailProgrammer = () => 
    {
        $('#modal_detail_programmer').modal('show');
        
        $.ajax({
            url: '../programmer/data',
            method: 'get',
            success: (response) =>
            {
                const data = response.data;

                let rows = '<option></option>';
                data.forEach( e => {
                    rows += `<option value='${e.id}'>${e.name}</option>`;
                });

                $('#programmer_user_id').html(rows);
                getsProgrammer();
            }
        })
    }
    // end::modalDetailProgrammer

    // begin::form_programmer
    $('#form_programmer').on('submit', function(e) 
    {
        e.preventDefault();

        Swal.fire({
            icon: 'question',
            text: 'Tambah programmer ?',
            showCancelButton: true,
            cancelButtonText: 'Batal',
            confirmButtonText: 'Tambah',
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
                form_data.append('tr_tiket_id', $('#id_tiket').val());

                $.ajax({
                    url: '../programmer_tiket',
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
                            toastr.success('Programmer berhasil ditambahkan');
                            $('#form_programmer').trigger('reset');
                            getDetail();
                            getsProgrammer();
                        }
                    }
                })
            }
        })
    })
    // end::form_programmer

    // begin::getsProgrammer
    const getsProgrammer = () => {
        const tr_tiket_id = $('#id_tiket').val();

        $.ajax({
            url: `../programmer_tiket/${tr_tiket_id}`,
            method: 'get',
            success: (response) =>
            {
                const data = response.data;

                let rows = '';
                data.forEach( e => 
                {
                    rows += `
                    <li class='mb-2'>
                        <div class="d-flex justify-content-between">
                            <p class="m-0">${e.nama}</p>
                            <button class="btn btn-sm btn-danger" onClick='deleteProgrammer(${e.id})'>Hapus</button>
                        </div>
                    </li>`;
                });

                $('#daftar_programmer').html( rows );
            }
        })
    }
    // end::getsProgrammer

    // begin::deleteProgrammer
    const deleteProgrammer = (id) =>
    {
        Swal.fire({
            icon: 'question',
            text: 'Hapus programmer ?',
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
                    url: `../programmer_tiket/${id}`,
                    method: 'delete',
                    dataType: 'json',
                    data: {
                        _token: `{{ csrf_token() }}`
                    },
                    success: (response) =>
                    {
                        if( response.status )
                        {
                            toastr.success('Programmer berhasil dihapus');
                            getDetail();
                            getsProgrammer();
                        }
                    }
                })
            }
        })
    }
    // end::deleteProgrammer

    // begin::modalDetailTester
    const modalDetailTester = () => 
    {
        $('#modal_detail_tester').modal('show');
        
        $.ajax({
            url: '../tester/data',
            method: 'get',
            success: (response) =>
            {
                const data = response.data;

                let rows = '<option></option>';
                data.forEach( e => {
                    rows += `<option value='${e.id}'>${e.name}</option>`;
                });

                $('#tester_user_id').html(rows);
                getsTester();
            }
        })
    }
    // end::modalDetailTester

    // begin::form_tester
    $('#form_tester').on('submit', function(e) 
    {
        e.preventDefault();

        Swal.fire({
            icon: 'question',
            text: 'Tambah tester ?',
            showCancelButton: true,
            cancelButtonText: 'Batal',
            confirmButtonText: 'Tambah',
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
                form_data.append('tr_tiket_id', $('#id_tiket').val());

                $.ajax({
                    url: '../tester_tiket',
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
                            toastr.success('Tester berhasil ditambahkan');
                            $('#form_tester').trigger('reset');
                            getDetail();
                            getsTester();
                        }
                    }
                })
            }
        })
    })
    // end::form_tester

    // begin::getsTester
    const getsTester = () => {
        const tr_tiket_id = $('#id_tiket').val();

        $.ajax({
            url: `../tester_tiket/${tr_tiket_id}`,
            method: 'get',
            success: (response) =>
            {
                const data = response.data;

                let rows = '';
                data.forEach( e => 
                {
                    rows += `
                    <li class='mb-2'>
                        <div class="d-flex justify-content-between">
                            <p class="m-0">${e.nama}</p>
                            <button class="btn btn-sm btn-danger" onClick='deleteTester(${e.id})'>Hapus</button>
                        </div>
                    </li>`;
                });

                $('#daftar_tester').html( rows );
            }
        })
    }
    // end::getsTester

    // begin::deleteTester
    const deleteTester = (id) =>
    {
        Swal.fire({
            icon: 'question',
            text: 'Hapus tester ?',
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
                    url: `../tester_tiket/${id}`,
                    method: 'delete',
                    dataType: 'json',
                    data: {
                        _token: `{{ csrf_token() }}`
                    },
                    success: (response) =>
                    {
                        if( response.status )
                        {
                            toastr.success('tester berhasil dihapus');
                            getDetail();
                            getsTester();
                        }
                    }
                })
            }
        })
    }
    // end::deleteTester

    // begin::openAccess
    const openAccess = (id) => 
    {
        Swal.fire({
            icon: 'question',
            text: 'Buka akses modul ?',
            showCancelButton: true,
            cancelButtonText: 'Batal',
            confirmButtonText: 'Buka',
            buttonsStyling: false,
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-secondary ms-2'
            }
        }).then( result => 
        {
            if( result.isConfirmed )
            {
                $.ajax({
                    url: `../modul/${id}/openAccess`,
                    method: 'post',
                    dataType: 'json',
                    data: {
                        _token: `{{ csrf_token() }}`
                    },
                    success: (response) =>
                    {
                        if( response.status )
                        {
                            toastr.success('Akses modul berhasil dibuka');
                            $('#table_modul').DataTable().ajax.reload();
                        }
                    }
                })
            }
        })
    }
    // end::openAccess

    // begin::endAccess
    const endAccess = (id) => 
    {
        Swal.fire({
            icon: 'question',
            text: 'Akhiri akses modul ?',
            showCancelButton: true,
            cancelButtonText: 'Batal',
            confirmButtonText: 'Akhiri',
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
                    url: `../modul/${id}/endAccess`,
                    method: 'post',
                    dataType: 'json',
                    data: {
                        _token: `{{ csrf_token() }}`
                    },
                    success: (response) =>
                    {
                        if( response.status )
                        {
                            toastr.success('Akses modul berhasil diakhiri');
                            $('#table_modul').DataTable().ajax.reload();
                        }
                    }
                })
            }
        })
    }
    // end::endAccess

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

    // begin::tutupTiket
    const tutupTiket = () => 
    {
        Swal.fire({
            icon: 'question',
            text: 'Tutup tiket sekarang ?',
            showCancelButton: true,
            cancelButtonText: 'Batal',
            confirmButtonText: 'Tutup',
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
                    url: '../../tiket/end',
                    method: 'post',
                    dataType: 'json',
                    data: {
                        tr_tiket_id: $('#id_tiket').val(),
                        _token: "{{ csrf_token() }}"
                    },
                    success: (response)=> 
                    {
                        if( response.status )
                        {
                            toastr.success('Tiket berhasil ditutup');
                            getDetail();
                        }
                    }
                })
            }
        })
    }
    // end::tutupTiket

    // begin::modalHistori
    const modalHistori = () =>
    {
        const id_tiket = $('#id_tiket').val();
        $.ajax({
            url: `../../histori/${id_tiket}`,
            method: 'get',
            dataType: 'json',
            success: (response)=> 
            {
                let rows = '';
                response.data.forEach(e => 
                {
                    rows += `
                    <div class="mb-2 bg-light p-2">
                        <p class="m-0">
                            ${e.keterangan}
                        </p>
                        <span class="mt-2 d-block">${e.waktu}</span>
                    </div>
                    `;
                })

                $('#daftar_histori').html(rows);
            }
        });

        $('#modal_histori').modal('show');
    }
    // end::modalHistori
</script>

@endsection