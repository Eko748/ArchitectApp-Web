<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\KonstruksiOwner;
use App\Models\KontrakKerjaKontraktor;
use App\Models\ChooseKonstruksi;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use PDF;

class KonstruksiController extends Controller
{
    // public function payProject(Request $request)
    // {

    //     $bukti = $request->file('bukti');
    //     $filename = $bukti->hashName();
    //     $path = "img/payment/konsultan/";
    //     $bukti->storeAs($path, $filename, 'files');
    //     PaymentKonsultan::create([
    //         'kontrakKonsultanId' => $request->kontrakId,
    //         'buktiBayar' => $filename,
    //         'status' => 0,
    //     ]);
    //     return 1;
    // }

    public function chooseKonstruksi(Request $request)
    {
        $request->validate([
            'kota' => 'required',
            'kecamatan' => 'required',
            'desa' => 'required',
            'jalan' => 'required',
            'mulaiKonstruksi' => 'required',
            'desain' => 'required',
            'rab' => 'required',
        ]);

        $konstruksiOwn =  KonstruksiOwner::create([
            'konstruksiId' => $request->projectId,
            'ownerId' => $this->getOwnerId()->owner->id,
            'status' => "0",
        ]);
        $input = [
            'panjang' => $request->panjang,
            'lebar' => $request->lebar,
            'konstruksiOwnerId' => $konstruksiOwn->id,
        ];
        $this->generateKontrak($konstruksiOwn->id);
        // if ($request->has('rab')) {
        //     $input['RAB'] = $request->rab;
        // }
        // if ($request->has('desain')) {
        //     $input['desain'] = $request->desain;
        // }

        // $choose = ChooseKonstruksi::create($input);
        // if ($request->hasFile('image')) {
        //     $img = $request->file('image');
        //     foreach ($img as $key) {
        //         $filename = $key->hashName();
        //         $path = 'img/owner/';
        //         $key->storeAs($path, $filename, 'files');
        //         $image = ImageOwner::create([
        //             'chooseProjectId' => $choose->id,
        //             'image' => $filename,
        //         ]);
        //     }

        //     $this->generateKontrak($projectOwn->id);
        // }
        return 1;
    }

    public function generateKontrak($konstruksiOwnerId)
    {
        $konstruksi = KonstruksiOwner::where('id', $konstruksiOwnerId)->with('chooseKonstruksi', 'owner.user', 'konstruksi.kontraktor.user',)->first();
        $title = $konstruksi->konstruksi->title;
        $hari = Carbon::now()->isoFormat('dddd');
        $tgl = Carbon::now()->isoFormat('D');
        $bln = Carbon::now()->isoFormat('MMMM');
        $thn = Carbon::now()->isoFormat('YYYY');
        $date = $hari . " tanggal " . $this->terbilang($tgl) . " " . $bln . " tahun " . $this->terbilang($thn);
        $kontraktorName = $konstruksi->konstruksi->kontraktor->user->name;
        $kontraktorTelp = $konstruksi->konstruksi->kontraktor->telepon;
        $kontraktorAlm = $konstruksi->konstruksi->kontraktor->alamat;
        $ownName = $konstruksi->owner->user->name;
        $ownTelp = $konstruksi->owner->telepon;
        $ownAlm = $konstruksi->owner->alamat;
        $hargaDesain = $konstruksi->chooseKonstruksi->desain == "1" ? $konstruksi->konstruksi->harga_desain : 0;
        $hargaRAB = $konstruksi->chooseKonstruksi->RAB == "1" ? $konstruksi->konstruksi->harga_rab : 0;
        $harga = $this->penyebut(($hargaDesain + $hargaRAB)) . " rupiah.";
        $path = public_path('pdf/kontrak/');
        $kontraktorUname = $konstruksi->konstruksi->kontraktor->user->username;
        $ownuName = $konstruksi->owner->user->username;
        $filename = 'Kontrak Kerja ' . $kontraktorUname . ' - ' . $ownuName . ' ' . Carbon::now()->toDateString() . ".pdf";
        $pdf = PDF::loadView('public.surat-konstruksi', compact('filename', 'title', 'date', 'kontraktorName', 'kontraktorTelp', 'kontraktorAlm', 'ownName', 'ownTelp', 'ownAlm', 'harga'));
        $createKontrak = $this->createKontrak($konstruksiOwnerId, $filename);
        $pdf->save($path . $filename);
    }

    public function createKontrak($konstruksiOwnId, $fileKontrak)
    {
        KontrakKerjaKontraktor::create([
            'konstruksiOwnerId' => $konstruksiOwnId,
            'kontrakKerja' => $fileKontrak
        ]);
    }
}
