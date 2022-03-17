<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Konsultan;
use App\Models\KontrakKerjaKonsultan;
use App\Models\LelangOwner;
use App\Models\Project;
use App\Models\ProjectOwner;
use App\Models\TenderKonsultan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PDF;
use Illuminate\Support\Str;

class GeneratePDFController extends Controller
{
    public function generatePDF(TenderKonsultan $tender)
    {
        $proposal = TenderKonsultan::where('id', $tender->id)->with('lelang.owner.user', 'konsultan.user')->first();
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
        $path = public_path('kontrak/');
        $konsUname = $proposal->konsultan->user->username;
        $ownuName = $proposal->lelang->owner->user->username;
        $filename = 'Kontrak_Kerja_' . $konsUname . '-' . $ownuName . '_' . Carbon::now()->toDateString() . ".pdf";
        $gaya = $proposal->lelang->gayaDesain;
        $hargaDesain = $proposal->tawaranHargaDesain;

        $hargarab = $proposal->tawaranHargaRab;
        $harga = $this->penyebut(($hargarab + $hargaDesain)) . " rupiah.";

        $createProject = $this->createProject($title, $proposal->lelang->description, $proposal->konsultan->id, $proposal->lelang->owner->id, $gaya, $hargarab, $hargaDesain);
        $createKontrak = $this->createKontrak($proposal->id, $createProject->id, $filename);
        $pdf = PDF::loadView('public.mypdf', compact('filename', 'title', 'date', 'konsName', 'konsTelp', 'konsAlm', 'ownName', 'ownTelp', 'ownAlm', 'harga'));
        $pdf->save($path . $filename);
        // return $pdf->stream($filename);
    }

    public function createProject($title, $desc, $konId, $ownId, $gaya, $hargarab = 0, $hargaDesain = 0)
    {
        $create = new Project([
            'title' => $title,
            'description' => $desc,
            'konsultanId' => $konId,
            'slug' => Str::slug($title),
            'gayaDesain' => $gaya,
            'harga_rab' => $hargarab,
            'harga_desain' => $hargaDesain,
            'isLelang' => "1"
        ]);
        $kons = Konsultan::find($konId);
        $project = $kons->projects()->save($create);
        $createProOwn = new ProjectOwner([
            'projectId' => $project->id,
            'ownerId' => $ownId,
            'status' => "0"
        ]);
        $projectOwner = $project->projectOwner()->save($createProOwn);
        return $projectOwner;
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
