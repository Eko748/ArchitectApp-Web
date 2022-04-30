@extends('layouts.main')
@section('title')
    Project
@endsection
@section('css')

@endsection
@section('content')
    @include('layouts.topbar')
    @include('layouts.sidebar-konsultan')

    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Lelang Project</h1>
            </div>

            <div class="section-body">
                <div class="card">
                    <div class="card-header">
                        <h4>List Lelang</h4>
                    </div>
                    <div class="card-body">
                        <div class="main">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Title</th>
                                            <th scope="col">Gaya Desain</th>
                                            <th scope="col">Owner</th>
                                            <th scope="col">Aksi</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>

                        <div class="list-group">
                        </div>
                    </div>
                    <div class="card-footer">
                    </div>
                </div>

            </div>
    </div>
    </section>
    </div>

    @push('js')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
        @include('konsultan.js.lelang-js')
         @include('konsultan.js.profileJs')

    @endpush
@endsection
