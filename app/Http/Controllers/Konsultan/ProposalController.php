<?php

namespace App\Http\Controllers\Konsultan;

use App\Http\Controllers\Controller;
use App\Models\TenderKonsultan;
use App\Models\Konsultan;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ProposalController extends Controller
{
    public function getAllProposalAktif(Request $request)
    {
        if ($request->ajax()) {
            $data = TenderKonsultan::with('lelang.owner.user','konsultan.user')->where('status',0)->get();
            return DataTables::of($data)
                ->addIndexColumn()->addColumn('cv', function ($data) {
                    $gambar = "<img src='" . asset('img/tender/konsultan/cv/' . $data->cv) . "' height='50' width='50'>";
                    return $gambar;
                })->addColumn('aksi', function ($data) {
                    $btn = '<a href="#" class="btn btn-warning btn-sm mr-1" data-toggle="modal" data-target="#modalViewDesign"
                            data-id="' . $data->id . '" id="viewDesign">View</a><a href="#" class="btn btn-danger mr-1 btn-sm" id="hapusProject" data-name="' . $data->id . '" data-id="' . $data->id . '">Hapus</a>';
                    return $btn;
                })->rawColumns(['aksi', 'cv'])->make(true);
        }
    }
    public function getAllProposalSubmit(Request $request)
    {
        if ($request->ajax()) {
            $data = TenderKonsultan::with('lelang.owner.user', 'konsultan.user')->where('status',1)->get();
            return DataTables::of($data)
                ->addIndexColumn()->addColumn('cv', function ($data, $index = 0) {
                    $gambar = "<img src='" . asset('img/tender/konsultan/cv/' . $data->cv) . "' height='50' width='50'>";
                    return $gambar;
                })->addColumn('aksi', function ($data) {
                    $btn = '<a href="#" class="btn btn-warning btn-sm mr-1" data-toggle="modal" data-target="#modalViewDesign"
                            data-id="' . $data->id . '" id="viewDesign">View</a><a href="#" class="btn btn-danger mr-1 btn-sm" id="hapusProject" data-name="' . $data->title . '" data-id="' . $data->id . '">Hapus</a>';
                    return $btn;
                })->rawColumns(['aksi', 'cv'])->make(true);
        }
    }
    public function getAllProposalArchived()
    {
        $data = TenderKonsultan::with('lelang','konsultan.user')->where('status', 2)->get();
        return $data;
    }
    public function postProposal(Request $request)
    {
        $cv = $request->file('cv');
        $path = 'img/tender/konsultan/cv/';
        if ($request->hasFile('cv')) {
            # code...
            $filename = $request->user()->name . '-' . Carbon::now()->toDateString() . '.' . $cv->getClientOriginalExtension();
            $cv->storeAs($path, $filename, 'files');
        }
       
        $request->validate($this->rules($request));
        $hargaDesain=$request->hargaDesain;
        $hargaRab=$request->hargaRab;
        if (Str::contains($request->hargaRab,'.')) {
            $hargaRab = Str::of($request->hargaRab)->replace('.','');
        }
        if (Str::contains($request->hargaDesain,'.')) {
            $hargaDesain = Str::of($request->hargaDesain)->replace('.','');
        }
        $isi = $this->fields($request->lelangId, $request->coverLetter, $filename,$hargaRab,$hargaDesain );
        $data = TenderKonsultan::create($isi);
        return 1;
    }

    public function rules(Request $request)
    {
      return $rules =[
            'coverLetter' => 'required|min:50|string',
            'cv' => 'mimes:pdf,jpg,png,jpeg',
            'hargaRab'=> [Rule::requiredIf($request->has('hargaRab'))],
            'hargaDesain'=> [Rule::requiredIf($request->has('hargaDesain'))],
      ];
    }

    public function fields($lelangId,$coverLetter,$cvName,$hargaRab = 0,$hargaDesain = 0)
    {
      return  $field = [
            'lelangOwnerId' => $lelangId,
            'konsultanId' => $this->getKonsultanId()->konsultan->id,
            'coverLetter' => $coverLetter,
            'status' => 0,
            'cv' => $cvName,
            'tawaranHargaRab' => $hargaRab,
            'tawaranHargaDesain'=>$hargaDesain
        ];
    }
}
