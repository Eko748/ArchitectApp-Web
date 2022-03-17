@extends('layouts.public-main')
@section('title')
   Pilih Akun
@endsection
@include('layouts.navbar')

@section('content')
  <div class="container">
      <div class="row justify-content-center mt-5">
          <div class="col-6 col-sm col-md text-center">
             <h3>Sign up</h3>
            <p>Register to gain access to our comprehensive platform of leading construction products and technologies.</p> 
            <div class="button-group">
                <a href="{{ route('daftar.owner') }}" class="btn btn-secondary btn-sm">Owner</a>
                <a href="{{ route('daftar.konsultan') }}" class="btn btn-secondary btn-sm">Konsultan</a>
                <a href="{{ route('daftar.kontraktor') }}" class="btn btn-secondary btn-sm">Kontraktor</a>
            </div>
          </div>
      </div>
  </div>

  @include('layouts.footer')
@endsection
