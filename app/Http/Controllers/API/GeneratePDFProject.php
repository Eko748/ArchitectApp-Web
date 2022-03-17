<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Models\Konsultan;
use App\Models\KontrakKerjaKonsultan;
use App\Models\Project;
use App\Models\ProjectOwner;
use App\Models\TenderKonsultan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PDF;
use Illuminate\Support\Str;

class GeneratePDFProject extends BaseController
{
    public function generatePDF($projectOwnerId)
    {
        $project = ProjectOwner::where('id', $projectOwnerId)->with('chooseProject', 'owner.user', 'project.konsultan.user',)->first();
        $title = $project->project->title;
        $hari = Carbon::now()->isoFormat('dddd');
        $tgl = Carbon::now()->isoFormat('D');
        $bln = Carbon::now()->isoFormat('MMMM');
        $thn = Carbon::now()->isoFormat('YYYY');
        $date = $hari . " tanggal " . $this->terbilang($tgl) . " " . $bln . " tahun " . $this->terbilang($thn);
        $konsName = $project->project->konsultan->user->name;
        $konsTelp = $project->project->konsultan->telepon;
        $konsAlm = $project->project->konsultan->alamat;
        $ownName = $project->owner->user->name;
        $ownTelp = $project->owner->telepon;
        $ownAlm = $project->owner->alamat;
        $hargaDesain = $project->chooseProject->desain == "1" ? $project->project->harga_desain : 0;
        $hargaRAB = $project->chooseProject->RAB == "1" ? $project->project->harga_rab : 0;
        $harga = $this->penyebut(($hargaDesain + $hargaRAB)) . " rupiah.";
        $path = public_path('kontrak/');
        $konsUname = $project->project->konsultan->user->username;
        $ownuName = $project->owner->user->username;
        $filename = 'Kontrak Kerja ' . $konsUname . ' - ' . $ownuName . ' ' . Carbon::now()->toDateString() . ".pdf";
        $pdf = PDF::loadView('public.mypdf', compact('filename', 'title', 'date', 'konsName', 'konsTelp', 'konsAlm', 'ownName', 'ownTelp', 'ownAlm', 'harga'));
        $createKontrak = $this->createKontrak($project->id,$filename);
        $pdf->save($path.$filename);
    }

    public function createKontrak($projectOwnid, $fileKontrak)
    {
        KontrakKerjaKonsultan::create([
            'projectOwnerId' => $projectOwnid,
            'kontrakKerja' => $fileKontrak
        ]);
    }
}
