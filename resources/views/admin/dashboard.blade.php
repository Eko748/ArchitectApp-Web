@extends('layouts.main')
@section('title')
    Dashboard
@endsection
@section('content')
    @include('layouts.topbar')
    @include('layouts.sidebar')

    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Dashboard</h1>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-2">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-file"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Konsultan</h4>
                            </div>
                            <div class="card-body">
                                {{$jumlah_data_konsultan}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-2">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-file"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Owner</h4>
                            </div>
                            <div class="card-body">
                                {{$jumlah_data_owner}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-2">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-file"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Kontraktor</h4>
                            </div>
                            <div class="card-body">
                                {{$jumlah_data_kontraktor}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-2">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-file"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Admin</h4>
                            </div>
                            <div class="card-body">
                                {{$jumlah_data_admin}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            <h4>Statistics</h4>
                            <div class="card-header-action">
                                <div class="btn-group">
                                    <a href="#" class="btn btn-primary">Week</a>
                                    <a href="#" class="btn">Month</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="myChart" height="182"></canvas>
                            <div class="statistic-details mt-sm-4">
                                <div class="statistic-details-item">
                                    <span class="text-muted"><span class="text-primary"><i
                                                class="fas fa-caret-up"></i></span> 7%</span>
                                    <div class="detail-value">$243</div>
                                    <div class="detail-name">Today's Sales</div>
                                </div>
                                <div class="statistic-details-item">
                                    <span class="text-muted"><span class="text-danger"><i
                                                class="fas fa-caret-down"></i></span> 23%</span>
                                    <div class="detail-value">$2,902</div>
                                    <div class="detail-name">This Week's Sales</div>
                                </div>
                                <div class="statistic-details-item">
                                    <span class="text-muted"><span class="text-primary"><i
                                                class="fas fa-caret-up"></i></span>9%</span>
                                    <div class="detail-value">$12,821</div>
                                    <div class="detail-name">This Month's Sales</div>
                                </div>
                                <div class="statistic-details-item">
                                    <span class="text-muted"><span class="text-primary"><i
                                                class="fas fa-caret-up"></i></span> 19%</span>
                                    <div class="detail-value">$92,142</div>
                                    <div class="detail-name">This Year's Sales</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('content')
<?php $sekarang = date("Y");  ?>
<script>
    $(function () {
        var bar_data = {
  data : [
      ['January', <?php $data = DB::table('users')->whereMonth('last_login', "01")->whereYear('last_login', $sekarang)->count(); echo $data ?>],
      ['February',<?php $data = DB::table('users')->whereMonth('last_login', "02")->whereYear('last_login', $sekarang)->count(); echo $data ?>],
      ['March', <?php $data = DB::table('users')->whereMonth('last_login', "03")->whereYear('last_login', $sekarang)->count(); echo $data ?>],
      ['April', <?php $data = DB::table('users')->whereMonth('last_login', "04")->whereYear('last_login', $sekarang)->count(); echo $data ?>],
      ['May', <?php $data = DB::table('users')->whereMonth('last_login', "05")->whereYear('last_login', $sekarang)->count(); echo $data ?>],
      ['June', <?php $data = DB::table('users')->whereMonth('last_login', "06")->whereYear('last_login', $sekarang)->count(); echo $data ?>],
      ['July', <?php $data = DB::table('users')->whereMonth('last_login', "07")->whereYear('last_login', $sekarang)->count(); echo $data ?>],
      ['August', <?php $data = DB::table('users')->whereMonth('last_login', "08")->whereYear('last_login', $sekarang)->count(); echo $data ?>],
      ['September', <?php $data = DB::table('users')->whereMonth('last_login', "09")->whereYear('last_login', $sekarang)->count(); echo $data ?>],
      ['October', <?php $data = DB::table('users')->whereMonth('last_login', "10")->whereYear('last_login', $sekarang)->count(); echo $data ?>],
      ['November', <?php $data = DB::table('users')->whereMonth('last_login', "11")->whereYear('last_login', $sekarang)->count(); echo $data ?>],
      ['Desember', <?php $data = DB::table('users')->whereMonth('last_login', "12")->whereYear('last_login', $sekarang)->count(); echo $data ?>]
    ],
  color: '#3c8dbc'
}
$.plot('#bar-chart', [bar_data], {
  grid  : {
    borderWidth: 1,
    borderColor: '#f3f3f3',
    tickColor  : '#f3f3f3'
  },
  series: {
    bars: {
      show    : true,
      barWidth: 0.5,
      align   : 'center'
    }
  },
  xaxis : {
    mode      : 'categories',
    tickLength: 0
  }
})
    })
</script>
@endsection

@push('js')
    <script src="{{ asset('node_modules/chart.js/dist/Chart.min.js') }}"></script>
    <script src="{{ asset('js/dashboard.js') }}"></script>
    @include('admin.js.profileJs')
@endpush
