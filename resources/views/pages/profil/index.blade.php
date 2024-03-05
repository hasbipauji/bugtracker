@extends('layouts.app')

@section('title', 'Profil')

@section('content')

<div class="row">
    <div class="col-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <!-- begin::nav-tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a href="#tab_data" class="nav-link active" data-bs-toggle='tab' role="tab">
                            <span class="d-block d-sm-none"><i class="bx bx-data"></i></span>
                            <span class="d-none d-sm-block">Data</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#tab_password" class="nav-link" data-bs-toggle="tab" role="tab">
                            <span class="d-block d-sm-none"><i class="bx bx-key"></i></span>
                            <span class="d-none d-sm-block">Password</span>
                        </a>
                    </li>
                </ul>
                <!-- end::nav-tabs -->

                <!-- begin::tab-content -->
                <div class="tab-content pt-3">
                    <div class="tab-pane active" id="tab_data" role="tabpanel">

                        <div class="d-block d-sm-none text-center mb-3">
                            <img src="/assets/images/users/avatar-1.jpg" class="w-25 rounded d-block mx-auto" >
                        </div>

                        <div class="mb-3 mb-sm-2 row">
                            <div class="col-12 col-sm-4 text-muted">Nama Lengkap</div>
                            <div class="col-12 col-sm-8">{{ Auth::user()->name }}</div>
                        </div>

                        <div class="mb-3 mb-sm-2 row">
                            <div class="col-12 col-sm-4 text-muted">Username</div>
                            <div class="col-12 col-sm-8">{{ Auth::user()->username }}</div>
                        </div>

                        <div class="mb-3 mb-sm-2 row">
                            <div class="col-12 col-sm-4 text-muted">Email</div>
                            <div class="col-12 col-sm-8">{{ Auth::user()->email }}</div>
                        </div>

                    </div>

                    <div class="tab-pane" id="tab_password" role="tabpanel">
                        
                        <!-- begin::form_password -->
                        <form id="form_password">
                            @csrf
                            <div class="row mb-2">
                                <label for="password" class="col-form-label col-sm-4">Password</label>
                                <div class="col-sm-8">
                                    <input 
                                        type="password" 
                                        name="password" 
                                        id="password" 
                                        placeholder="Ketikan password anda disini" 
                                        class="form-control"
                                        required>
                                    <div class="text-danger" id="password_pesan"></div>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <label for="ulangi_password" class="col-form-label col-sm-4">Ulangi Password</label>
                                <div class="col-sm-8">
                                    <input 
                                        type="password" 
                                        name="ulangi_password" 
                                        id="ulangi_password" 
                                        placeholder="Ulangi password anda disini" 
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
                        <!-- end::form_password -->

                    </div>
                </div>
                <!-- end::tab-content -->
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')

<script>
    $('#form_password').on('submit', function(e) {
        e.preventDefault();

        const password = $('#password').val();
        const ulangi_password = $('#ulangi_password').val();

        if( password != ulangi_password ) {
            toastr.error('Pastikan kedua form bernilai sama');
        } else {
            $.ajax({
                url: 'profil/changePassword',
                method: 'post',
                dataType: 'json',
                data: new FormData(this),
                cache: false,
                contentType: false,
                processData: false,
                success: (res)=> {
                    if( res.status ) 
                    {
                        toastr.success('Password berhasil diperbarui');
                        document.querySelector('#form_password').reset();
                        $('#password_pesan').html('');
                    }
                    else {
                        toastr.error('Pesword gagal diperbarui');

                        $('#password_pesan').html( res.pesan.password );
                    } 
                },
                error: (err)=> {
                    console.log( err );
                }
            });
        }
    });
</script>

@endsection