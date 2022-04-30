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
                            <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#modalProject"
                                id="tambahProject">
                                Tambah Lelang
                            </a>
                            {{-- <a href="#" class="btn btn-warning">
                                View All
                            </a> --}}
                        </div>
                    </div>
                    <div class="card-body">

                        <table class="table table-hover" id="table-project">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Title</th>
                                    {{-- <th scope="col">Description</th> --}}
                                    <th scope="col">Budget</th>
                                    <th scope="col">Desain</th>
                                    <th scope="col">RAB</th>
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
    <div class="modal fade" id="modalProject" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Lelang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="formTambahProject">
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
                            <label for="desain">Desain</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" multiple name="desain">
                                <label class="custom-file-label" for="desain">Unggah File</label>
                            </div>
                            <small>Format PDF</small>
                        </div>
                        <div class="form-group">
                            <label for="rab">RAB</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" multiple name="rab">
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
                let empTable = document.getElementById("table-project").getElementsByTagName("tbody")[0];
                            empTable.innerHTML = "";

                            $.ajax({
                                url: "{{ route('konsultan.all.lelang') }}",
                                success: function(response) {
                                    let no = 1;
                                    for (let key in response.data) {
                                        if (response.data.hasOwnProperty(key)) {
                                            let val = response.data[key];
                                            let NewRow = empTable.insertRow(-1);
                                            let noCell = NewRow.insertCell(0);
                                            let titleCell = NewRow.insertCell(1);
                                            let budgetCell = NewRow.insertCell(2);
                                            let desainCell = NewRow.insertCell(3);
                                            let rabCell = NewRow.insertCell(4);
                                            let opsiCell = NewRow.insertCell(5);

                                            console.log(val['desain']);

                                            noCell.innerHTML = no++;
                                            titleCell.innerHTML = val['title'];
                                            budgetCell.innerHTML = val['title'];
                                            for (let key2 in val['desain']) {
                                                let val2 = val['desain'][key2];
                                                // console.log(val2['desain']);
                                                desainCell.innerHTML = val2['desain'];
                                            }
                                            for (let key2 in val['rab']) {
                                                let val2 = val['rab'][key2];
                                                // console.log(val2['rab']);
                                                desainCell.innerHTML = val2['rab'];
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
