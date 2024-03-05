@extends('layouts.app')

@section('title', 'Project Manager')

@section('content')

<!-- begin::card -->
<div class="card shadow-sm">
    <div class="card-body">

        <!-- begin:controller -->
        <button class="btn btn-primary mb-3" onclick="modalUser('Tambah', '-')">Tambah</button>
        <!-- end:controller -->

        <!-- begin::table -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover w-100" id="table_user">
                <thead>
                    <tr>
                        <th style="max-width: 30px;">No</th>
                        <th>Nama Lengkap</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
        <!-- end::table -->

    </div>
</div>
<!-- end::card -->

<!-- begin::modal -->
<div id="modal_user" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_user_title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form_user">
                    @csrf

                    <input type="hidden" name="id" id="id">

                    <div class="row mb-2">
                        <label for="name" class="col-form-label col-sm-4">Nama Lengkap</label>
                        <div class="col-sm-8">
                            <input 
                                type="text" 
                                name="name" 
                                id="name" 
                                class="form-control"
                                placeholder="Isikan nama lengkap disini"
                                required>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <label for="username" class="col-form-label col-sm-4">Username</label>
                        <div class="col-sm-8">
                            <input 
                                type="text" 
                                name="username" 
                                id="username" 
                                class="form-control"
                                placeholder="Isikan username disini"
                                required>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <label for="email" class="col-form-label col-sm-4">Email</label>
                        <div class="col-sm-8">
                            <input
                                type="email"
                                name="email"
                                id="email"
                                class="form-control"
                                placeholder="Isikan email disini"
                                required>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <label for="password" class="col-form-label col-sm-4">Password</label>
                        <div class="col-sm-8">
                            <input
                                type="password"
                                name="password"
                                id="password"
                                class="form-control"
                                placeholder="Isikan password disini"
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
<!-- begin::modal_user -->

<!-- end::modal_user -->
<!-- end::modal -->

@endsection

@section('js')
<script>
    // begin::datatable
    $('#table_user').DataTable({
        ajax: {
            url: 'project_manager/data',
        },
        columns: [
            {data: 'no'},
            {data: 'name'},
            {data: 'username'},
            {data: 'email'},
            {
                render: (data, type, row, meta) => 
                {
                    let buttons = '';
                    buttons += `<button class="btn btn-sm btn-secondary" onclick="modalUser('Ubah', ${row.id})">Ubah</button>`;
                    buttons += `<button class="btn btn-sm btn-danger ms-2" onclick="hapusUser(${row.id})">Hapus</button>`;
                    
                    return buttons;
                }
            }
        ],
    });
    // end::datatable

    // begin::modalUser
    const modalUser = (title, id) => 
    {
        $('#form_user')[0].reset();
        $('#modal_user_title').html(title+' User');
        $('#id').val(id);
        $('#password').attr('required', true);
        
        if( id != '-' ) 
        {
            $.ajax({
                url: 'project_manager/'+id,
                method: 'get',
                dataType: 'json',
                success: (response) =>
                {
                    const data = response.data;

                    $('#name').val(data.name);
                    $('#username').val(data.username);
                    $('#email').val(data.email);
                    $('#password').attr('required', false).val('-');
                }
            })
        }

        $('#modal_user').modal('show');
    }
    // end::modalUser
    
    // begin::form_user
    $('#form_user').on('submit', function(e) 
    {
        e.preventDefault();

        const text = $('#id').val() == '-' ? 'Simpan user baru ?' : 'Simpan perubahan data user ?';

        Swal.fire({
            icon: 'question',
            text: text,
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
                    url: 'project_manager',
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
                            toastr.success('Data user berhasil disimpan');
                            $('#modal_user').modal('hide');
                            $('#table_user').DataTable().ajax.reload();
                        } 
                        else 
                        {
                            toastr.error('Data user gagal disimpan');
                        }
                    }
                })
            }
        })
    })
    // end::form_user

    // begin::hapusUser
    const hapusUser = (id) => 
    {
        Swal.fire({
            icon: 'question',
            text: 'Hapus data user ?',
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
                    url: 'project_manager/'+id,
                    method: 'delete',
                    dataType: 'json',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: (response) =>
                    {
                        if( response.status )
                        {
                            toastr.success('Data user berhasil dihapus');
                            $('#table_user').DataTable().ajax.reload();
                        }
                        else 
                        {
                            toastr.error('Data user gagal dihapus');
                        }
                    }
                })
            }
        })
    }
    // end::hapusUserl
</script>
@endsection