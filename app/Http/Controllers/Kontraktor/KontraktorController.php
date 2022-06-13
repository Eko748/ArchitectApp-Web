<?php

namespace App\Http\Controllers\Kontraktor;

use App\Http\Controllers\Controller;
use App\Models\ChooseKonstruksi;
use App\Models\LelangOwner;
use App\Models\Project;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class KontraktorController extends Controller
{
    public function dashboard()
    {
        return view('kontraktor.dashboard');
    }
    public function lelangKons()
    {
        return view('kontraktor.lelang');

    }
    public function detilLelang(LelangOwner $lelang )
    {
        return view('kontraktor.detil-lelang');
    }
    public function lelangOwner()
    {
        return view('kontraktor.owner-lelang');
    }
    public function archivedJob()
    {
        return view('kontraktor.archived-job');
    }
    public function activeJob()
    {
        // $data = ChooseKonstruksi::where('status', "1")->with('order.owner', 'konstruksiOwner.user.owner', 'cabang.kontraktor')->whereHas('konstruksiOwner', function ($q) {
        //     $q->where('konfirmasi', "0");
        // })->where('status', "1")->get();

        // // $order = ChooseProject::with('owner.user.order')->where('id', "Belum Bayar")->first();
            // dd($data);

            // $data = ChooseKonstruksi::where('id', $this->getKontraktorId()->kontraktor->id)->where('status', "1")->with('order.owner', 'konstruksiOwner.user.owner', 'cabang.kontraktor')->whereHas('konstruksiOwner', function ($q) {
            //     $q->where('status', "Belum Bayar");
            // })->whereHas('konstruksiOwner', function ($q) {
            //     $q->where('konfirmasi', "0");
            // })->get();
            // dd($data);
        return view('kontraktor.active-job');
    }
    public function activeProposal()
    {
        return view('kontraktor.active-proposal');
        
    }
    public function submitProposal()
    {
        return view('kontraktor.submit-proposal');
        
    }
    public function archivedProposal()
    {
        return view('kontraktor.archived-proposal');
        
    }
    public function cabang()
    {

        // return view('konsultan.project');
    
        return view('kontraktor.cabang');
    }

    public function getAllJobKontraktor(Request $request, ChooseKonstruksi $project)
    {
        $data = ChooseKonstruksi::where('status', "1")->with('order.owner', 'konstruksiOwner', 'cabang.kontraktor')->whereHas('konstruksiOwner', function ($q) {
            $q->where('konfirmasi', 0);
        })->get();
        // $order = ChooseProject::with('owner.user.order')->where('id', "Belum Bayar")->first();
            // dd($data);
            return DataTables::of($data)
                ->addIndexColumn()->addColumn('tanggal', function ($data) {
                $tanggal = $data->mulaiKonstruksi;
                $tgl = Carbon::parse($tanggal);
                return $tanggal->format('d M Y');
                })
                ->addIndexColumn()->addColumn('siap', function ($data) {
                    
                    $status = $data->status = "Siap";
                    // $rab = $data->chooseProject->rab = "RAB";
                    // $project = $status && $rab;
                    return $status;
                    })
                
                ->addIndexColumn()->addColumn('alamat', function ($data) {
                    $kota = $data->kota;
                    $kecamatan = $data->kecamatan;
                    $desa = $data->desa;
                    $jalan = $data->jalan;
                    return $kota." Kec. ".$kecamatan." Desa. ". $desa." Jalan. ". $jalan;
                })
                ->addColumn('Aksi', function ($data) {
                    // $download = KontrakKerjaKonsultan::where('kontrakKerja', )
                    // $download = $data->kontrak->kontrakKerja;
                    
                    $btn = '<button type="button" class="btn btn-primary" id="tambahHasil" data-target="#modalHasil"
                    data-toggle="modal" >Kirim
                    File</button> | ';
                    $kontrak = '<button type="button" class="btn btn-warning" id="i" data-target="#a"
                    data-toggle="modal" >Lihat
                    Kontrak</button>';
                    
                    return $btn.$kontrak;
                })->rawColumns(['Aksi'])->make(true);
        
    }
}
