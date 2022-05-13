@extends('layouts.main')
@section('title')
    Project
@endsection
@section('css')

@endsection
@section('content')
    @include('layouts.topbar')
    @include('layouts.sidebar-kontraktor')
    {{-- @include('layouts.assets') --}}
    <script>
        function submit(x) {
            if (x == 'add') {
                $('[name="title"]').val("");
                $('[name="description"]').val("");
                $('[name="budget"]').val("");
                $('[name="image"]').val("");
                $('[name="budget"]').val("");
                $('[name="budget"]').val("");
                $('[name="status"]').val("0");
                $('#modal-add .modal-title').html('Tambah Data Lelang');
                $('#btn-tambah').show();
                $('#btn-ubah').hide();
            } else {
                $('#modal-add .modal-title').html('Ubah Data Lelang')
                $('#image').hide();
                $('#btn-tambah').hide();
                $('#btn-ubah').show();
        
                $.ajax({
                    type: "POST",
                    data: {
                        id: x
                    },
                    url: '',
                    dataType: 'json',
                    success: function(data) {
                        $('[name="title"]').val(data.title);
                        $('[name="description"]').val(data.description);
                        $('[name="budget"]').val(data.budget);
                        $('[name="status"]').val(data.status);
                    }
                });
            }
        }
        
        function modal_import() {
            $('#modal-import').modal('show');
        }
        
        function hapus(x) {
            $('#modal-delete').modal('show');
            $('#deleted').on('click', function() {
                var action = '' + x;
                $('#form-hapus').attr('action', action).submit();
            })
        }
        </script>
        
        <!-- Content Header (Page header) -->
        <div class="main-content">
            <section class="section">
        <section class="content-header">
            <h1>
                Data Guru
            </h1>
            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-home"></i> Beranda</a></li>
                <li><a href="#">Data Master</a></li>
                <li class="active">Guru</li>
            </ol>
        </section>

        <!-- Main content -->
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <a href="#modal-add" class="btn btn-sm btn-primary btn-flat" data-toggle="modal" onclick="submit('add')"><i
                    class="fa fa-plus"></i> Tambah</a>
            <a href="" class="btn btn-sm btn-primary btn-flat pull-right"
                data-toggle="tooltip" data-placement="top" title="Refresh"><i class="fa fa-refresh"></i></a>
            <a href="" class="btn btn-sm btn-primary btn-flat pull-right"
                data-toggle="tooltip" data-toggle="tooltip" data-placement="top" title="Aktifkan akun"><i
                    class="fa fa-key"></i></a>
            <a href="#" class="btn btn-sm btn-primary btn-flat pull-right" data-toggle="tooltip" data-toggle="tooltip"
                data-placement="top" title="Import" onclick="modal_import()"><i class="fa fa-upload"></i></a>
        </div>
        <div class="box-body table-responsive">
            <table class="table table-bordered table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th width="5">NO</th>
                        <th width="5"><i class="fa fa-edit"></i></th>
                        <th>Title</th>
                        <th>Budget</th>
                        <th>TTL</th>
                        <th>JK</th>
                        <th>ALAMAT</th>
                        <th width="5">#</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- <?php 
                    $n=1;
                    foreach ( as $row) :?>
                    <tr>
                        <td><?=$n++.'.';?></td>
                        <td><a href="#modal-add" data-toggle="modal" onclick="submit(<?=$row->idguru;?>)"><i
                                    class="fa fa-edit"></i></a>
                        </td>
                        <td><?=$row->nip;?></td>
                        <td><?=$row->nama;?></td>
                        <td><?=$row->tmp_lhr.', '.date('d M Y',strtotime($row->tgl_lhr));?></td>
                        <td><?=$row->jk=='L'?'Laki-Laki':'Perempuan';?></td>
                        <td><?=$row->alamat;?></td>
                        <td>
                            <?php if(check_user($row->nip)==0):?>
                            <a href=""
                                class="btn btn-xs btn-default text-aqua" data-toggle="tooltip" data-placement="top"
                                data-title="Aktifkan pengguna"><i class="fa fa-key"></i></a>
                            <?php endif;?>
                            <a href="#" class="btn btn-xs btn-default text-red" data-toggle="tooltip"
                                data-placement="top" data-title="Hapus" onclick="hapus(<?=$row->idguru;?>)"><i
                                    class="fa fa-trash"></i></a></td>
                    </tr>
                    <?php endforeach;?> --}}
                </tbody>
            </table>
        </div>
    </div>
</section>
<div class="modal fade" id="modal-add" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <p class="text-red">* Wajib diisi <br>Note: Jika belum memiliki NIP harap diisi dengan NIK</p>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="nip">NIP<span class="text-red">*</span></label>
                                <input type="hidden" name="idguru">
                                <input type="text" class="form-control" id="nip" name="nip"
                                    placeholder="Ex: 198609262015051001" required>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="nama_lengkap">Nama Lengkap<span class="text-red">*</span></label>
                                <input type="text" class="form-control" id="nama_lengkap" name="nama"
                                    placeholder="Ex: John Andy" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="tempat_lahir">Tempat Lahir<span class="text-red">*</span></label>
                                <input type="text" class="form-control" id="tempat_lahir" name="tmp_lhr"
                                    placeholder="Ex: Manokwari" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Tanggal Lahir<span class="text-red">*</span></label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right datepicker" name="tgl_lhr"
                                        required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Jenis Kelamin<span class="text-red">*</span></label>
                                <select class="form-control select2" style="width: 100%;" name="jk" required>
                                    <option value="L">Laki-Laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Alamat Lengkap<span class="text-red">*</span></label>
                                <textarea class="form-control" name="alamat" rows="5" required></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-flat btn-sm pull-left" data-dismiss="modal"><i
                            class="fa fa-remove"></i> Batal</button>
                    <button type="submit" class="btn btn-success btn-flat btn-sm" id="btn-tambah"><i
                            class="fa fa-save"></i>
                        Simpan</button>
                    <button type="submit" class="btn btn-success btn-flat btn-sm" id="btn-ubah"><i
                            class="fa fa-save"></i>
                        Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-import" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Import Data Guru</h4>
                </div>
                <div class="modal-body">
                    <h5>Panduan Import :</h5>
                    <ol>
                        <li>Copy dan paste <strong>[NIP] [NAMA LENGKAP] [TEMPAT LAHIR] [TANGGAL LAHIR] [JENIS KELAMIN]
                                [ALAMAT]</strong> dari Ms. Excel pada Text Area dibawah.</li>
                        <li>Kolom <strong>NIP</strong> dapat diisi dengan <strong>NIK</strong> jika belum memiliki
                            <strong>NIP</strong>.</li>
                        <li>Kolom <strong>JENIS KELAMIN</strong> diisi huruf <strong>"L"</strong> jika Laki-laki dan
                            <strong>"P"</strong> jika Perempuan.</li>
                        <li>Kolom <strong>TANGGAL LAHIR</strong> diisi dengan format <strong>"YYYY-MM-DD"</strong>.
                            Contoh : <strong>1991-03-15</strong></li>
                    </ol>
                    <div class="form-group">
                        <textarea class="form-control" rows="15" name="guru" placeholder="Paste here..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-flat btn-sm pull-left" data-dismiss="modal"><i
                            class="fa fa-remove"></i> Batal</button>
                    <button type="submit" class="btn btn-success btn-flat btn-sm"><i class="fa fa-save"></i>
                        Import Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal konfirmasi delete -->
<div class="modal fade" id="modal-delete" role="dialog" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="form-hapus">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Konfirmasi</h4>
                </div>
                <div class="modal-body bg-red">
                    <p>Anda yakin ingin menghapus data ini ? </p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-default btn-flat pull-left" data-dismiss="modal"><i
                            class="fa fa-remove"></i> Batal</button>
                    <button class="btn btn-sm btn-danger btn-flat" id="deleted"><i class="fa fa-trash"></i> Iya,
                        Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>

    {{-- <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Proposal Project</h1>
            </div>

            <div class="section-body">
                <div class="card">
                    <div class="card-header">
                        <h4>List Proposal</h4>
                    </div>
                    <div class="card-footer">
                    </div>
                </div>

            </div>
    </div> --}}
    </section>
    </div>

    @push('js')
        {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script> --}}
        {{-- @include('konsultan.js.lelang-js')
        @include('konsultan.js.profileJs') --}}

    @endpush
@endsection
