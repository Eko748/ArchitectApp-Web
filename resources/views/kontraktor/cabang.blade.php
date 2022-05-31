@extends('layouts.main')
@section('title')
Kontraktor Cabang
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('node_modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }} ">
<link rel="stylesheet" href="{{ asset('node_modules/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">

@endsection
@section('content')
@include('layouts.topbar')
@include('layouts.sidebar-kontraktor')

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Kontraktor Cabang</h1>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4>Data Cabang</h4>
                    <div class="card-header-action">
                        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#modalCabang"
                        id="tambahCabang">
                        Tambah Cabang
                    </a>
                    <a href="#" class="btn btn-warning">
                        View All
                    </a>
                </div>
            </div>
            <div class="card-body">
                
                <table class="table table-hover" id="table-cabang">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama Tim</th>
                            <th scope="col">Jumlah Tim</th>
                            <th scope="col">Harga Kontrak</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">Deskripsi</th>
                            <th scope="col">Images</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        
    </div>
</div>
</section>
</div>
<div class="modal fade" id="modalEditCabang" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Tambah Cabang</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="" method="post" id="formEditCabang">
                @csrf
                <div class="form-group">
                    <label for="nama_tim">Nama Tim</label>
                    <input type="text" name="nama_tim" class="form-control">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label for="images">Images</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" multiple name="images">
                        <label class="custom-file-label" for="images">Choose file</label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="harga_kontrak">Harga Kontrak Anda</label>
                    <input type="number" name="harga_kontrak" class="form-control">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label for="desc">Deskripsi</label>
                    <textarea name="desc" class="form-control w-100 h-100" rows="5"></textarea>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label for="alamat_cabang">Alamat Lengkap</label>
                    <textarea name="alamat_cabang" class="form-control w-100 h-100" rows="5"></textarea>
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
<div class="modal fade" id="modalCabang" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Cabang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ url('/kontraktor/cabang') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama_tim">Nama Tim</label>
                        <input type="text" name="nama_tim" class="form-control">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="nama_tim">Jumlah Tim</label>
                        <input type="number" name="jumlah_tim" class="form-control">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="nama_tim">Harga Kontrak Anda</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Rp</span>
                            </div>
                            <input type="number" class="form-control" name="harga_kontrak">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="images">Gambar pertama akan menjadi Cover</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" multiple name="images[]">
                            <label class="custom-file-label" for="images">Choose file</label>
                        </div>
                        <small>Gambar minimal 12</small>
                    </div>
                    <div class="form-group">
                        <label for="desc">Deskripsi</label>
                        <textarea name="desc" class="form-control w-100 h-100" rows="5"></textarea>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="alamat_cabang">Alamat Lengkap</label>
                        <textarea name="alamat_cabang" class="form-control w-100 h-100" rows="5"></textarea>
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

@push('js')

<script src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('node_modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('node_modules/datatables.net-select-bs4/js/select.bootstrap4.min.js') }}"></script>
<script>
    $(function() {
        let table = $('#table-cabang').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: "{{ route('kontraktor.allcabang') }}",
            columns: [
            
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex'
            },
            {
                data: 'nama_tim',
                name: 'nama_tim'
            },
            {
                data: 'jumlah_tim',
                name: 'jumlah_tim'
            },
            {
                data: 'harga_kontrak',
                name: 'harga_kontrak'
            },
            {
                data: 'alamat_cabang',
                name: 'alamat_cabang'
            },
            {
                data: 'description',
                name: 'desc'
            },
            {
                data: 'gambar',
                name: 'gambar',
                orderable: false,
                searchable: false
            },
            {
                data: 'aksi',
                name: 'aksi',
                orderable: false,
                searchable: false
            },
            ],
        });
    });
</script>
@include('kontraktor.js.cabang-js')
@include('kontraktor.js.profileJs')
@endpush
@endsection