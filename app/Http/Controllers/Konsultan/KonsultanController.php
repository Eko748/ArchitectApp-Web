<?php

namespace App\Http\Controllers\Konsultan;

use App\Http\Controllers\Controller;
use App\Models\ChooseProject;
use App\Models\LelangOwner;
use App\Models\ProjectOwner;
use App\Models\Project;
use App\Models\LelangKonsultan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class KonsultanController extends Controller
{
    // public function index()
    // {
    //     $data = [
    //         // "jumlah_data_desain" => Admin::count(),
    //         // "jumlah_data_lelang_owner" => Konsultan::count(),
    //         "jumlah_data_project" => Project::count(),
    //         // "jumlah_data_proposal" => Kontraktor::count(),

    //     ];
    //     return view('konsultan.dashboard', $data);
    // }
    public function getAllLelang()
    {
        $data = LelangOwner::with('owner.user', 'image', 'inspirasi', 'proposal.konsultan')->where('status', 0)->get();
        return view('konsultan.lelang', $data);
    }

    public function dashboard()
    {
        $data = [
            "jumlah_data_desain" => Project::where('id', Auth::user()->id)->count(),
            "jumlah_data_lelang_owner" => LelangOwner::where('status', 0)->count(),
            "jumlah_data_lelang_konsultan" => LelangKonsultan::count(),
            // "jumlah_data_proposal" => ::count(),

        ];
        return view('konsultan.dashboard', $data);
    }
    public function project()
    {

        // return view('konsultan.project');
    
        return view('konsultan.project');
    }
    public function lelangKonsultan()
    {
        return view('konsultan.lelang-konsultan');
    }
    public function lelangKons()
    {
        return view('konsultan.lelang');

    }
    public function detilLelang(LelangOwner $lelang )
    {

        return view('konsultan.detil-lelang');
    }
    public function lelangOwner()
    {
        $data = LelangOwner::with('image')->get();
        // return view('public.project', compact('data'));
        return view('konsultan.lelang', compact('data'));
    }
    public function archivedJob()
    {
        return view('konsultan.archived-job');
    }
    public function activeJob()
    {
        // if ($request->ajax()) {
            // $data = ChooseProject::with('projectOwner.user.owner', 'projectOwner.kontrak.proposal', 'project.konsultan.user', 'imageOwner')->get();
            // dd($data);
            // $data = ProjectOwner::with('project.images', 'project.konsultan', 'owner.user', 'owner.lelang.image', 'kontrak.payment', 'chooseProject.imageOwner', 'hasil')->where('status', "0")->get();
            // // dd($data);
            // return DataTables::of($data)
            //     ->addIndexColumn()->addColumn('tanggal', function ($data) {
            //     $createdAt = Carbon::parse($data->updated_at);
            //     return $createdAt->format('d M Y');
            //     })->addColumn('Aksi', function ($data) {
            //         $btn = '<a href="#" class="btn btn-warning btn-sm mr-1" data-toggle="modal" data-target="#modalViewUser"
            //         data-id="' . $data->id . '" id="viewUser">View</a>';
            //         return $btn;
            //     })->rawColumns(['Aksi'])->make(true);
        // }
        // dd($request);

        return view('konsultan.active-job');
    }
    public function activeProposal()
    {
        return view('konsultan.active-proposal');

    }
    public function submitProposal()
    {
        return view('konsultan.submit-proposal');

    }
    public function archivedProposal()
    {
        return view('konsultan.archived-proposal');

    }
    public function detilJob(Project $project)
    {

        return view('konsultan.detil-job');
    }
    public function detailLelangOwner($id) {
        $data = [
            "data_lelang" => LelangOwner::where("id", $id)->first(),
        ];

        return view("modal.lelang-owner.detail-lelang", $data);
    }
}
