@extends('layouts.public-main')
@section('title')
    Project
@endsection
@include('layouts.navbar')

@section('content')
    <br>
    <div class="container">
        <div class="section-body">
            <h2 class="section-title">My Profile</h2>
            <p class="section-lead">
                Hi, {{ Auth::user()->name }}
            </p>
            <div class="row">
                <div class="col-4">

                    <div class="card card-primary">
                        <div class="card-body text-center">
                            <img src="" class="rounded-circle pp" width="80" height="80">
                            <h6 class="my-2" id="inisial"></h6>
                            <button class="btn btn-block btn-primary btn-icon icon-left" id="editProfile"
                                data-toggle="modal" data-target="#modalProfile" data-id="{{ Auth::user()->id }}">
                                <i class="fas fa-user-edit "></i>
                                <span class="d-none d-lg-inline">Edit Profile</span>
                            </button>
                            <button class="btn btn-block btn-warning btn-icon icon-left" id="editAva" data-toggle="modal"
                                data-target="#modalAva" data-id="{{ Auth::user()->id }}">
                                <i class="fas fa-edit "></i>
                                <span class="d-none d-lg-inline">Edit Avatar</span>
                            </button>
                            <button class="btn btn-block btn-success btn-icon icon-left" id="editPass" data-toggle="modal"
                                data-target="#modalPass" data-id="{{ Auth::user()->id }}">
                                <i class="fas fa-user-shield    "></i>
                                <span class="d-none d-lg-inline">Edit Password</span>
                            </button>
                            <button class="btn btn-block btn-danger btn-icon icon-left  " id="hpsAkun"
                                data-id="{{ Auth::user()->id }}">
                                <i class="fas fa-user-times    "></i>
                                <span class="d-none d-lg-inline">Hapus Akun</span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card card-primary">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" class="form-control" id="name-readonly" value="{{ $user->name }}"
                                    readonly>
                            </div>
                            <div class="form-group">
                                <label for="nama">Username</label>
                                <input type="text" class="form-control" id="uname-readonly"
                                    value="{{ $user->username }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="nama">Email</label>
                                <input type="text" class="form-control" id="email-readonly" value="{{ $user->email }}"
                                    readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </section>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalProfile" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Profile</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="formProfile">
                        @csrf
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" name="name" id="name" class="form-control">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="uname">Username</label>
                            <input type="text" name="username" id="username" class="form-control">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" name="email" id="email" class="form-control">
                            <div class="invalid-feedback"></div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Ganti Password --}}

    <div class="modal fade" id="modalPass" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="formPass">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="oldpass">Password Lama</label>
                            <input type="password" name="oldpass" id="oldpass" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="newpass">Password Baru</label>
                            <input type="password" name="newpass" id="newpass" class="form-control">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="conpass">KOnfirmasi Password</label>
                            <input type="password" name="newpass_confirmation" id="newpass_confirmation"
                                class="form-control">
                            <div class="invalid-feedback"></div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" id="save" class="btn btn-primary">Simpan</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    {{-- modal ganti avatar --}}
    <div class="modal fade" id="modalAva" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Avatar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="formAva" enctype="multipart/form-data">
                        @csrf
                        {{-- @method('PUT') --}}
                        <div class="form-group">
                            <label for="avatar">Avatar</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="avatar" name="avatar">
                                <label class="custom-file-label" for="image">Choose file</label>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="simpan">Simpan</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    @push('js')
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
                integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
        </script>
        @include('public.js.profile-ownerJS')
    @endpush
@endsection
