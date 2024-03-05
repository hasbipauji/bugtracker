@extends('layouts.app')

@section('title', 'Edit Profil')

@section('content')

<div class="row">
    <div class="col-12 col-sm-8">
        <div class="card shadow-sm">
            <div class="card-body">

                <form id="form_profil">

                    @csrf
                    <input type="hidden" id="id" value="{{ $id }}" />
                    
                    <div class="form-group mb-2 row">
                        <label for="name" class="col-12 col-sm-4 col-form-label">Nama Lengkap</label>
                        <div class="col-12 col-sm-8">
                            <input type="text" 
                                class="form-control" 
                                id="name" 
                                name="name" 
                                placeholder="Ketikan nama anda disini" 
                                required>
                        </div>
                    </div>

                    <div class="form-group mb-2 row">
                        <label for="username" class="col-12 col-sm-4 col-form-label">Username</label>
                        <div class="col-12 col-sm-8">
                            <input type="text" 
                                class="form-control" 
                                id="username" 
                                name="username" 
                                placeholder="Ketikan nama anda disini" 
                                required>
                        </div>
                    </div>

                    <div class="form-group mb-2 row">
                        <label for="email" class="col-12 col-sm-4 col-form-label">Email</label>
                        <div class="col-12 col-sm-8">
                            <input type="email" 
                                class="form-control" 
                                id="email" 
                                name="email" 
                                placeholder="Ketikan nama anda disini" 
                                required>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-sm-4"></div>
                        <div class="col-12 col-sm-8">
                            <input type="submit" value="Simpan" class="btn btn-primary" />
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

@endsection

@section('js')

<script>
    window.onload = ()=> {
        loadData();
    }

    const loadData = ()=> {
        const id = document.querySelector('#id').value;

        $.ajax({
            url: `${id}`,
            method: 'get',
            dataType: 'json',
            success: (res)=> {
                document.querySelector('#name').value = res.data.name;
                document.querySelector('#username').value = res.data.username;
                document.querySelector('#email').value = res.data.email;
            }
        })
    }

    $('#form_profil').on('submit', function(e) {
        e.preventDefault();
        
        const id = document.querySelector('#id').value;

        $.ajax({
            url: `${id}`,
            method: 'post',
            dataType: 'json',
            data: new FormData(this),
            cahce: false,
            contentType: false,
            processData: false,
            success: (res)=> 
            {
                if( res.status ) 
                {
                    toastr.success('Profil berhasil diperbarui');
                }
                else {
                    toastr.success('Profil gagal diperbarui');
                }
            },
            error: (err)=> 
            {
                console.error(err);
            }
        });
    })

</script>

@endsection