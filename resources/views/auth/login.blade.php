@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="box">
    <div class="box-header">
        <div class="box-label">
            <p>Selamat datang di aplikasi</p>
            <h5>{{ env('APP_NAME') }}</h5>
        </div>
        <img src="assets/images/profile-img.png" alt="" class="img-fluid">
    </div>

    <div class="box-content">
        <!-- begin::form_login -->
        <form id="form_login">
            @csrf

            <div class="form-group mb-3">
                <label for="username">Username</label>
                <input 
                    type="text" 
                    name="username" 
                    id="username" 
                    class="form-control" 
                    placeholder="Isikan username anda disini"
                    required>
            </div>

            <div class="form-group mb-3">
                <label for="password">Password</label>
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    class="form-control" 
                    placeholder="Isikan password anda disini"
                    required>
            </div>
    
            <input type="submit" value="Masuk" class="btn btn-primary w-100 mt-2">
        </form>
        <!-- end::form_login -->
    </div>
</div>
@endsection

@section('js')
<script>
    $('#form_login').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: 'login/process',
            method: 'post',
            dataType: 'json',
            data: new FormData(this),
            cache: false,
            contentType: false,
            processData: false,
            success: (res)=> {
                if( res.status ) {
                    toastr.success('Selamat datang');
                    setTimeout(()=> {
                        window.location.reload();
                    }, 1000)
                } else {
                    toastr.error('Username / Password salah');
                }
            }
        })
    })
</script>
@endsection