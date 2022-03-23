<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Konsultan;
use App\Models\KontrakKerjaKonsultan;
use App\Models\Project;
use App\Models\ProjectOwner;
use App\Models\TenderKonsultan;
use Carbon\Carbon;
use PDF;
use App\Http\Controllers\PDFController;
use Illuminate\Support\Str;

class GeneratePDF extends Controller
{
    public function generatePDF($tender)
    {
        $proposal = TenderKonsultan::where('id', $tender)->with('lelang.owner.user', 'konsultan.user')->first();
        $title = $proposal->lelang->title;
        $hari = Carbon::now()->isoFormat('dddd');
        $tgl = Carbon::now()->isoFormat('D');
        $bln = Carbon::now()->isoFormat('MMMM');
        $thn = Carbon::now()->isoFormat('YYYY');
        $date = $hari . " tanggal " . $this->terbilang($tgl) . " " . $bln . " tahun " . $this->terbilang($thn);
        $konsName = $proposal->konsultan->user->name;
        $konsTelp = $proposal->konsultan->telepon;
        $konsAlm = $proposal->konsultan->alamat;
        $ownName = $proposal->lelang->owner->user->name;
        $ownTelp = $proposal->lelang->owner->telepon;
        $ownAlm = $proposal->lelang->owner->alamat;
        $harga = $this->penyebut(($proposal->tawaranDesain + $proposal->tawaranRab)) . " rupiah.";
        $path = public_path('kontrak/');
        $konsUname = $proposal->konsultan->user->username;
        $ownuName = $proposal->lelang->owner->user->username;
        $filename = 'Kontrak Kerja ' . $konsUname . ' - ' . $ownuName . ' ' . Carbon::now()->toDateString() . ".pdf";
        $pdf = PDF::loadView('public.mypdf', compact('filename', 'title', 'date', 'konsName', 'konsTelp', 'konsAlm', 'ownName', 'ownTelp', 'ownAlm', 'harga'));
        // Storage::putFileAs($path,$pdf->output(),$filename,'files');
        $createProject = $this->createProject($title,$proposal->lelang->description, $proposal->lelang->gayaDesain, $proposal->konsultan->id, $proposal->lelang->owner->id, $proposal->tawaranHargaDesain, $proposal->tawaranHargaRab);
        $createKontrak = $this->createKontrak($proposal->id,$createProject->id,$filename);
        $pdf->save($path.$filename);
    }

    public function createProject($title,$desc,$style,$konId,$ownId,$hargaDes,$hargaRab)
    {
        $create = new Project([
            'title'=>$title,
            'description'=>$desc,
            'konsultanId'=>$konId,
            'gayaDesain'=>$style,
            'slug'=>Str::slug($title),
            'harga_desain'=>$hargaDes,
            'harga_rab'=>$hargaRab,
            'isLelang'=>"1"
        ]);
        $kons = Konsultan::find($konId);
        $project = $kons->projects()->save($create);
        $createProOwn = new ProjectOwner([
            'projectId' => $project->id,
            'ownerId' => $ownId,
            'status' => "0"
        ]);
     
        $projectOwn = $project->projectOwn()->save($createProOwn);
        return $projectOwn;
    }

    public function createKontrak($tenderId, $projectOwnid, $fileKontrak)
    {
        KontrakKerjaKonsultan::create([
            'tenderKonsultanId' => $tenderId,
            'projectOwnerId' => $projectOwnid,
            'kontrakKerja' => $fileKontrak
        ]);
    }
}
