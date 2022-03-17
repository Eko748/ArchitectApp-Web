@extends('layouts.main')
@section('title')
    Project
@endsection
@section('css')

@endsection
@section('content')
    @include('layouts.topbar')
    @include('layouts.sidebar-kontraktor')

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
                        <div class="list-group"></div>
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
