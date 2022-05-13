@extends('layouts.public-main')
@section('title')
    Project
@endsection
@include('layouts.navbar')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-5">
                <div class="my-4">
                    <div class="mt-3 mb-4 text-center">
                        <h5><span class="font-weight-bold">Form Lelang</span> </h5>
                        <hr>

                    </div>
                    <form action="{{ route('owner.lelang.post') }}" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="ownerId" id="ownerId" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="status" value="0">
                        @csrf
                        <div class="mb-3">
                            <label for="title" class="form-label form-label-sm">Judul<span
                                    class="text-danger fw-bolder">*</span></label>
                            <input type="text" class="form-control form-control-sm @error('title') is-invalid @enderror"
                                name="title" id="title" value="{{ old('title') }}">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <tr>
                        <div class="mb-3">
                            <label for="panjang" class="form-label form-label-sm">Panjang<span
                                    class="text-danger fw-bolder">*</span></label>
                            <input type="text" class="form-control form-control-sm @error('panjang') is-invalid @enderror"
                                name="panjang" id="panjang" value="{{ old('panjang') }}">
                            @error('panjang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="lebar" class="form-label form-label-sm">Lebar<span
                                    class="text-danger fw-bolder">*</span></label>
                            <input type="text" class="form-control form-control-sm @error('lebar') is-invalid @enderror"
                                name="lebar" id="lebar" value="{{ old('lebar') }}">
                            @error('lebar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        </tr>
                        <div class="mb-3">
                            <label for="budget" class="form-label form-label-sm">Estimasi Biaya<span
                                    class="text-danger fw-bolder">*</span></label>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="budgetFrom" class="form-label form-label-sm">Mulai</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>

                                        <input type="text"
                                            class="form-control form-control-sm @error('budgetFrom') is-invalid @enderror"
                                            id="budgetFrom" name="budgetFrom" value="{{ old('budgetFrom') }}">

                                        @error('budgetFrom')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <label for="budgetTo" class="form-label form-label-sm">Sampai</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>

                                        <input type="text"
                                            class="form-control form-control-sm @error('budgetTo') is-invalid @enderror" name="budgetTo"
                                            value="{{ old('budgetTo') }}" id="budgetTo">

                                        @error('to')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <label class="form-label" for="gayaDesain">Gaya desain<span
                                class="text-danger fw-bolder">*</span></label>
                        <div class="input-group mb-3">
                            <select class="form-select form-select-sm @error('gayaDesain') is-invalid @enderror"
                                id="gayaDesain" name="gayaDesain">
                                <option selected disabled>Pilih gaya desain</option>
                                <option value="minimalist">Minimalist</option>
                                <option value="traditional">Traditional</option>
                                <option value="modern">Modern</option>
                                <option value="scandinavian">Scandinavian</option>
                            </select>
                            @error('gayaDesain')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi<span
                                    class="text-danger fw-bolder">*</span></label>
                            <textarea type="text" class="form-control form-control-sm @error('description') is-invalid @enderror"
                                name="description" id="description" rows="5" value="">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Foto Ruangan</label>
                            <input class="form-control form-control-sm @error('image') is-invalid @enderror" id="image"
                                name="image[]" multiple type="file">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="desc" class="form-label">Jasa yang dibutuhkan<span
                                    class="text-danger fw-bolder">*</span></label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="RAB" name="RAB">
                                <label class="form-check-label" for="RAB">
                                    Rencana Anggaran Biaya
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="desain" name="desain">
                                <label class="form-check-label" for="desain">
                                    Desain 2D dan 3D
                                </label>
                            </div>

                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-warning btn-sm btn-block">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>


    @include('layouts.footer')

    @push('js')

        <script>
            removeInvalid()
            @auth
                $(function() {
                let url = "{{ route('owner.profile.show', Auth::user()->id) }}"
                SetupAjax();
                $.ajax({
                url: url,
                dataType: "JSON",
                type: "POST",
                success: function(response) {
                $('#ownerId').val(response.owner.id)
            
            
                },
                });
                })
            @endauth
            maskingInput("#from")
            maskingInput("#to")
        </script>
        @if (Auth::user()->owner->alamat == null || Auth::user()->owner->telepon == null)

            <script>
                var myModal = new bootstrap.Modal(document.getElementById('modalOwner'))


                myModal.show()
            </script>
        @endif

        <script>
            $('body').on('submit', '#formAlert', function(e) {
                let form = $('#formAlert');
                e.preventDefault()
                SetupAjax()
                $.ajax({
                    url: "{{ route('owner.update') }}",
                    dataType: "JSON",
                    type: "PUT",
                    data: form.serialize(),
                    cache: false,
                    success: function(response) {
                        myModal.hide()
                        alertSuccess("Profile berhasil diupdate");
                    },
                    error: function(xhr) {
                        var res = xhr.responseJSON;
                        if ($.isEmptyObject(res) == false) {
                            $.each(res.errors, function(key, val) {
                                $("textarea[name=" + key + "],input[name=" + key + "]").addClass(
                                    "is-invalid");
                                $("textarea[name=" + key + "],input[name=" + key + "]")
                                    .next()
                                    .html(val);
                            });
                        }
                    },
                });
            })
        </script>
    @endpush
    <div class="modal fade" id="modalOwner" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Profile</h5>

                </div>
                <div class="modal-body">
                    <form action="" method="POST" id="formAlert">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="nama">Telepon</label>
                            <input type="text" class="form-control" id="telepon" name="telepon">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="nama">Alamat</label>
                            <textarea type="text" class="form-control h-100" id="alamat" name="alamat" rows="3"></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                </div>
                <div class="modal-footer">

                    <a href="javascript:history.back()" type="button" class="btn btn-secondary">Back</a>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection



{{-- @extends('layouts.public-main')
@section('title')
Project
@endsection
@include('layouts.navbar')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-5">
            <div class="my-4">
                <div class="mt-3 mb-4 text-center">
                    <h5><span class="font-weight-bold">Form Lelang</span> </h5>
                    <hr>

                </div>
                <form action="{{ route('owner.lelang.post') }}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="ownerId" id="ownerId">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label form-label-sm">Judul<span
                                class="text-danger fw-bolder">*</span></label>
                        <input type="text" class="form-control form-control-sm @error('title') is-invalid @enderror"
                            name="title" id="title" value="{{ old('title') }}">
                        @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="luas" class="form-label form-label-sm">Luas<span
                                class="text-danger fw-bolder">*</span></label>
                        <input type="text" class="form-control form-control-sm @error('luas') is-invalid @enderror"
                            name="luas" id="luas" value="{{ old('luas') }}">
                        @error('luas')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="budget" class="form-label form-label-sm">Estimasi Biaya<span
                                class="text-danger fw-bolder">*</span></label>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="budgetFrom" class="form-label form-label-sm">Mulai</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>

                                    <input type="text"
                                        class="form-control form-control-sm @error('budgetFrom') is-invalid @enderror"
                                        id="budgetFrom" name="budgetFrom" value="{{ old('budgetFrom') }}">

                                    @error('budgetFrom')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                            <div class="col-md-6">
                                <label for="budgetTo" class="form-label form-label-sm">Sampai</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>

                                    <input type="text"
                                        class="form-control form-control-sm @error('budgetTo') is-invalid @enderror"
                                        name="budgetTo" value="{{ old('budgetTo') }}" id="budgetTo">

                                    @error('budgetTo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <label class="form-label" for="gayaDesain">Gaya desain<span
                            class="text-danger fw-bolder">*</span></label>
                    <div class="input-group mb-3">
                        <select class="form-select form-select-sm @error('gayaDesain') is-invalid @enderror"
                            id="gayaDesain" name="gayaDesain">
                            <option selected disabled>Pilih gaya desain</option>
                            <option value="minimalist">Minimalist</option>
                            <option value="traditional">Traditional</option>
                            <option value="modern">Modern</option>
                            <option value="scandinavian">Scandinavian</option>
                        </select>
                        @error('gayaDesain')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi<span
                                class="text-danger fw-bolder">*</span></label>
                        <textarea type="text"
                            class="form-control form-control-sm @error('description') is-invalid @enderror"
                            name="description" id="description" rows="5" value="">{{ old('description') }}</textarea>
                        @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Foto Ruangan</label>
                        <input class="form-control form-control-sm @error('image') is-invalid @enderror" id="image"
                            name="image[]" multiple type="file">
                        @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="desc" class="form-label">Jasa yang dibutuhkan<span
                                class="text-danger fw-bolder">*</span></label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="rab" name="rab">
                            <label class="form-check-label" for="rab">
                                Rencana Anggaran Biaya
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="desain" name="desain">
                            <label class="form-check-label" for="desain">
                                Desain 2D dan 3D
                            </label>
                        </div>

                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-warning btn-sm btn-block">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>


@include('layouts.footer')

@push('js')

<script>
    removeInvalid()
            @auth
                $(function() {
                let url = "{{ route('owner.profile.show', Auth::user()->id) }}"
                SetupAjax();
                $.ajax({
                url: url,
                dataType: "JSON",
                type: "POST",
                success: function(response) {
                $('#ownerId').val(response.owner.id)


                },
                });
                })
            @endauth
            maskingInput("#from")
            maskingInput("#to")
</script>
@if (Auth::user()->owner->alamat == null || Auth::user()->owner->telepon == null)

<script>
    var myModal = new bootstrap.Modal(document.getElementById('modalOwner'))


                myModal.show()
</script>
@endif

<script>
    $('body').on('submit', '#formAlert', function(e) {
                let form = $('#formAlert');
                e.preventDefault()
                SetupAjax()
                $.ajax({
                    url: "{{ route('owner.update') }}",
                    dataType: "JSON",
                    type: "PUT",
                    data: form.serialize(),
                    cache: false,
                    success: function(response) {
                        myModal.hide()
                        alertSuccess("Profile berhasil diupdate");
                    },
                    error: function(xhr) {
                        var res = xhr.responseJSON;
                        if ($.isEmptyObject(res) == false) {
                            $.each(res.errors, function(key, val) {
                                $("textarea[name=" + key + "],input[name=" + key + "]").addClass(
                                    "is-invalid");
                                $("textarea[name=" + key + "],input[name=" + key + "]")
                                    .next()
                                    .html(val);
                            });
                        }
                    },
                });
            })
</script>
@endpush
<div class="modal fade" id="modalOwner" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Profile</h5>

            </div>
            <div class="modal-body">
                <form action="" method="POST" id="formAlert">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="nama">Telepon</label>
                        <input type="text" class="form-control" id="telepon" name="telepon">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="nama">Alamat</label>
                        <textarea type="text" class="form-control h-100" id="alamat" name="alamat" rows="3"></textarea>
                        <div class="invalid-feedback"></div>
                    </div>
            </div>
            <div class="modal-footer">

                <a href="javascript:history.back()" type="button" class="btn btn-secondary">Back</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection --}}
