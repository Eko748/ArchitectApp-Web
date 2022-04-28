@extends('layouts.main')
@section('title')
    Proposal
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
                <h1>My Proposal</h1>
            </div>

            <div class="section-body">
                <div class="card">
                    <div class="card-header">
                        <h4>My Proposal - Active</h4>
                    </div>
                    <div class="card-header-action">
                        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#modalProposal"
                            id="postProposal">
                            Tambah Proposal
                        </a>
                        {{-- <a href="#" class="btn btn-warning">
                            View All
                        </a> --}}
                    </div>
                    <div class="card-body">

                        <table class="table table-hover" id="table-proposal">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Cover Letter</th>
                                    <th scope="col">CV</th>
                                    <th scope="col">Harga RAB</th>
                                    <th scope="col">Harga Desain</th>
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
    <div class="modal fade" id="modalEditProposal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Proposal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="formEditProposal">
                        @csrf
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title"  class="form-control">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="owner">Owner</label>
                            <input type="text" name="owner"  class="form-control">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="images">CV</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" multiple  name="cv">
                                <label class="custom-file-label" for="cv">Choose file</label>
                            </div>
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
    <div class="modal fade" id="modalProposal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Project</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="formTambahProposal">
                        @csrf
                        <div class="form-group">
                            <label for="coverLetter">Cover Letter</label>
                            <input type="textArea" name="coverLetter"  class="form-control">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="cv">CV</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="cv">
                                <label class="custom-file-label" for="cv">Choose file</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tawaranHargaRab">Harga RAB</label>
                            <input type="text" name="tawaranHargaRab"  class="form-control">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="tawaranHargaDesain">Harga Desain</label>
                            <input type="text" name="tawaranHargaDesain"  class="form-control">
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
                // let table = $('#table-project').DataTable({
                //     processing: true,
                //     serverSide: true,
                //     autoWidth: false,
                //     ajax: "{{ route('konsultan.proposal.data.active') }}",
                //     columns: [

                //         {
                //             data: 'DT_RowIndex',
                //             name: 'DT_RowIndex'
                //         },
                //         {
                //             data: 'lelang.title',
                //             name: 'title'
                //         },
                //         {
                //             data: 'lelang.owner.user.name',
                //             name: 'owner'
                //         },
                //         {
                //             data: 'cv',
                //             name: 'cv',
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
                let empTable = document.getElementById("table-proposal").getElementsByTagName("tbody")[0];
                empTable.innerHTML = "";

                $.ajax({
                    url: "{{'konsultan.proposal.add'}}",
                    success: function (response) {
                        let no = 1;
                        for (let key in response.data) {
                            if (response.data.hasOwnProperty(key)) {
                                let val = response.data[key];
                                let NewRow = empTable.insertRow(-1);
                                let noCell = NewRow.insertCell(0);
                                let coverLetterCell = NewRow.insertCell(1);
                                let cvCell = NewRow.insertCell(2);
                                let hargaRabCell = NewRow.insertCell(2);
                                let hargaDesainCell = NewRow.insertCell(2);
                                let opsiCell = NewRow.insertCell(2);

                                console.log(val['cv']);

                                noCell.innerHTML = no++;
                                coverLetterCell.innerHTML = val['coverLetter'];
                                cvCell.innerHTML = val['cv'];
                                hargaRabCell.innerHTML = val['tawaranHargaRab'];
                                hargaDesainCell.innerHTML = val['tawaranHargaDesain'];
                                opsiCell.innerHTML = val['aksi'];
                            }
                        }
                    }
                })
            });
        </script>
        @include('konsultan.js.proposal-js')
        @include('konsultan.js.profileJs')
    @endpush
@endsection
