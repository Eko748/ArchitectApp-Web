<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\ChooseProject;
use App\Models\ImageOwner;
use App\Models\KontrakKerjaKonsultan;
use App\Models\Owner;
use App\Models\PaymentKonsultan;
use App\Models\ProjectOwner;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use PDF;

class ProjectController extends Controller
{
    public function payProject(Request $request)
    {

        $bukti = $request->file('bukti');
        $filename = $bukti->hashName();
        $path = "img/payment/konsultan/";
        $bukti->storeAs($path, $filename, 'files');
        PaymentKonsultan::create([
            'kontrakKonsultanId' => $request->kontrakId,
            'buktiBayar' => $filename,
            'status' => 0,
        ]);
        return 1;
    }

    public function chooseProject(Request $request)
    {
        $request->validate([
            'panjang' => 'required|numeric',
            'lebar' => 'required|numeric',
            'desain' => Rule::requiredIf(!$request->has('rab')),
            'rab' => Rule::requiredIf(!$request->has('desain')),
        ]);

        $projectOwn =  ProjectOwner::create([
            'projectId' => $request->projectId,
            'ownerId' => $this->getOwnerId()->owner->id,
            'status' => "0",
        ]);
        $input = [
            'panjang' => $request->panjang,
            'lebar' => $request->lebar,
            'projectOwnerId' => $projectOwn->id,
        ];
        if ($request->has('rab')) {
            $input['RAB'] = $request->rab;
        }
        if ($request->has('desain')) {
            $input['desain'] = $request->desain;
        }
        $choose = ChooseProject::create($input);
        if ($request->hasFile('image')) {
            $img = $request->file('image');
            foreach ($img as $key) {
                $filename = $key->hashName();
                $path = 'img/owner/';
                $key->storeAs($path, $filename, 'files');
                $image = ImageOwner::create([
                    'chooseProjectId' => $choose->id,
                    'image' => $filename,
                ]);
            }

            $this->generateKontrak($projectOwn->id);
        }
        return 1;
    }

    public function generateKontrak($projectOwnerId)
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
        $createKontrak = $this->createKontrak($projectOwnerId, $filename);
        $pdf->save($path . $filename);
    }

    public function createKontrak($projectOwnid, $fileKontrak)
    {
        KontrakKerjaKonsultan::create([
            'projectOwnerId' => $projectOwnid,
            'kontrakKerja' => $fileKontrak
        ]);
    }
}
