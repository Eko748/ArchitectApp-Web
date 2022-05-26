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
        
    <div class="main-content">
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
    </div>
    </section>
    </div>

    @push('js')
        {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script> --}}
        {{-- @include('konsultan.js.lelang-js')
        @include('konsultan.js.profileJs') --}}

    @endpush
@endsection
