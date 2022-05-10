@extends('layouts.main')
@section('title')
    Lelang Saya
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('node_modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }} ">
    <link rel="stylesheet" href="{{ asset('node_modules/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">

@endsection
@section('content')
    @include('layouts.topbar')
    @include('layouts.sidebar-konsultan')
    {{-- @include('layouts.assets') --}}

    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Lelang Saya</h1>
            </div>

            <div class="section-body">
                <div class="card">
                    <div class="card-header">
                        <h4>Data Lelang</h4>
                        <div class="card-header-action">
                            <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#modalLelang"
                                id="tambahLelang">
                                Tambah Lelang
                            </a>
                            {{-- <a href="#" class="btn btn-warning">
                                View All
                            </a> --}}
                        </div>
                    </div>
                    <div class="card-body">

                        <table class="table table-hover" id="table-lelang">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Budget</th>
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
    <div class="modal fade" id="modalEditProject" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Lelang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="" id="editProject">

                </div>
            </div>
        </div>
    </div>
    {{-- <div class="modal fade" id="viewProject" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">View Project</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="" id="view">

                </div>
            </div>
        </div>
    </div> --}}
    <div class="modal fade" id="modalLelang" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Lelang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="formTambahLelang" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" class="form-control">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="desc">Deskripsi</label>
                            <textarea name="desc" class="form-control w-100 h-100" rows="5"></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="budget">Budget</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Rp</span>
                                </div>
                                <input type="text" class="form-control" name="budget">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="images">4 Gambar Utama</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="images[]" multiple>
                                <label class="custom-file-label" for="images">Choose file</label>
                            </div>
                            <small>Gambar minimal 4 desain</small>
                        </div>
                        <div class="form-group">
                            <label for="desain">Desain</label>
                            <div class="custom-file">
                                <input type="file" name="desain" class="custom-file-input">
                                <label class="custom-file-label" for="desain">Unggah File</label>
                            </div>
                            <small>Format PDF</small>
                        </div>
                        <div class="form-group">
                            <label for="rab">RAB</label>
                            <div class="custom-file">
                                <input type="file" name="rab" class="custom-file-input">
                                <label class="custom-file-label" for="rab">Unggah File</label>
                            </div>
                            <small>Format PDF</small>
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

            function editProject(id) {
            $.ajax({
            url : "{{ url('/konsultan/lelang-konsultan/') }}/"+id,
            type : 'get',
            success : function(data) {
            console.log(id);
            $("#editProject").html(data);
            return true;
            }
            });
            }

            function view(id) {
            $.ajax({
            url : "{{ url('/konsultan/lelang/view/') }}/"+id,
            type : 'get',
            success : function(data) {
            console.log(id);
            $("#view").html(data);
            return true;
            }
            });
            }

            $(function() {
                // let table = $('#table-project').DataTable({
                //     processing: true,
                //     serverSide: true,
                //     autoWidth: false,
                //     ajax: "{{ route('konsultan.allproject') }}",
                //     columns: [

                //         {
                //             data: 'DT_RowIndex',
                //             name: 'DT_RowIndex'
                //         },
                //         {
                //             data: 'title',
                //             name: 'title'
                //         },
                //         {
                //             data: 'gambar',
                //             name: 'gambar',
                //             orderable: false,
                //             searchable: false
                //         },
                //         {
                //             data: 'aksi',
                //             name: 'aksi',
                //             orderable: false,
                //             searchable: false
                //         },
                //     ],
                // });
                let empTable = document.getElementById("table-lelang").getElementsByTagName("tbody")[0];
                            empTable.innerHTML = "";

                            $.ajax({
                                url: "{{ route('konsultan.all.Lelang.Konsultan') }}",
                                success: function(response) {
                                    let no = 1;
                                    for (let key in response.data) {
                                        if (response.data.hasOwnProperty(key)) {
                                            let val = response.data[key];
                                            let NewRow = empTable.insertRow(-1);
                                            let noCell = NewRow.insertCell(0);
                                            let titleCell = NewRow.insertCell(1);
                                            let budgetCell = NewRow.insertCell(2);
                                            let imagesCell = NewRow.insertCell(3);
                                            let opsiCell = NewRow.insertCell(4);

                                            console.log(val['images']);

                                            noCell.innerHTML = no++;
                                            titleCell.innerHTML = val['title'];
                                            budgetCell.innerHTML = val['budget'];
                                            for (let key2 in val['images']) {
                                                let val2 = val['images'][key2];
                                                // console.log(val2['desain']);
                                                imagesCell.innerHTML = val2['images'];
                                            }
                                            
                                            opsiCell.innerHTML = val['aksi'];
                                        }
                                    }
                                }
                            })
                        });


        </script>
        @include('konsultan.js.lelang-konsultan-js')
        @include('konsultan.js.profileJs')
    @endpush
@endsection
