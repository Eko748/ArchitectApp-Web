<?php

namespace App\Http\Controllers\Kontraktor;

use App\Http\Controllers\Controller;
use App\Models\TenderKontraktor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProposalController extends Controller
{
    public function getAllProposalAktif(Request $request)
    {
        if ($request->ajax()) {
            $data = TenderKontraktor::with('lelang.owner.user','kontraktor.user')->where('status',0)->get();
            return DataTables::of($data)
                ->addIndexColumn()->addColumn('cv', function ($data) {
                    $gambar = "<img src='" . asset('img/tender/kontraktor/cv/' . $data->cv) . "' height='50' width='50'>";
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
            $data = TenderKontraktor::with('kontraktor.user')->where('status',1)->get();
            return DataTables::of($data)
                ->addIndexColumn()->addColumn('cv', function ($data, $index = 0) {
                    $gambar = "<img src='" . asset('img/tender/kontraktor/cv/' . $data->cv) . "' height='50' width='50'>";
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
        $data = TenderKontraktor::with('lelang','kontraktor.user')->where('status', 2)->get();
        return $data;
    }
    public function postProposal(Request $request)
    {
        $cv = $request->file('cv');
        $path = 'img/tender/kontraktor/cv/';
        if ($request->hasFile('cv')) {
            # code...
            $filename = $request->user()->name . '-' . Carbon::now()->toDateString() . '.' . $cv->getClientOriginalExtension();
            $cv->storeAs($path, $filename, 'files');
        }
        $request->validate([
            'coverLetter' => 'required|min:50|string',
            'cv' => 'mimes:pdf,jpg,png,jpeg',
        ]);
        $input = [
            'lelangOwnerId' => $request->lelangId,
            'kontraktorId' => $this->getkontraktorId()->kontraktor->id,
            'coverLetter' => $request->coverLetter,
            'status' => 0,
            'cv' => $filename
        ];
        $data = TenderKontraktor::create($input);
        return 1;
    }
}
