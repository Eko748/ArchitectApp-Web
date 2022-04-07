@extends('layouts.public-main')
@section('title')
   Pilih Akun
@endsection
@include('layouts.navbar')

@section('content')
  <div class="ms-auto">
      <div class="row justify-content-center mt-5">
          <div class="col-15 col-sm col-md text-center">
             <h3>Sign up</h3>
            <p>Register to gain access to our comprehensive platform of leading construction products and technologies.</p> 
            <div class="px-3 border-bottom bg-white col-md">
                <a href="{{ route('daftar.owner') }}" class="btn btn-primary btn-sm btnChangeTheme btn btn-outline-dark btn-sm border-0 ml-3 shadow-none">Owner</a>
                <a href="{{ route('daftar.konsultan') }}" class="btn btn-success btn-sm btnChangeTheme btn btn-outline-dark btn-sm border-0 ml-3 shadow-none">Konsultan</a>
                <a href="{{ route('daftar.kontraktor') }}" class="btn btn-danger btn-sm btnChangeTheme btn btn-outline-dark btn-sm border-0 ml-3 shadow-none">Kontraktor</a>
            </div>
          </div>
      </div>
  </div>
<br>
  @include('layouts.footer')
@endsection
