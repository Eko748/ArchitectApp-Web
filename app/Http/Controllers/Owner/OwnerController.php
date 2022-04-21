<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Konsultan;
use App\Models\KontrakKerjaKonsultan;
use App\Models\LelangOwner;
use App\Models\Owner;
use App\Models\Project;
use App\Models\ProjectOwner;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use PDF;

class OwnerController extends Controller
{
    public function index()
    {
        $konsultan = Konsultan::with('user')->get();
        $project = Project::with('konsultan.user', 'images')->where('isLelang', '0')->get();

        return view('public.landing', compact('konsultan', 'project'));
    }

    public function professional()
    {
        $data = User::with('konsultan')->where(['is_active' => 1, 'level' => 'konsultan'])->get();
        return view('public.professionals', compact('data'));
    }
    public function project()
    {
        $data = Project::with('konsultan.user', 'images')->where('isLelang', "0")->get();
        return view('public.project', compact('data'));
    }

    public function detilProfessional(Konsultan $konsultan)
    {
        return Konsultan::with('files', 'user')->find($konsultan->id);
    }
    public function detilProject(Project $project)
    {
        return Project::with('images', 'konsultan.user')->find($project);
    }

    public function lelangOwner()
    {
        return view('public.lelang');
    }

    public function profileOwner(User $user)
    {
        return User::with('owner')->where('id', $user->id)->first();
    }

    public function myLelang()
    {
        $data = LelangOwner::with('image')->get();
        // return view('public.project', compact('data'));
        return view('public.mylelang', compact('data'));
    }
    public function showLelang(LelangOwner $lelang)
    {
        return view('public.single-mylelang');
    }
    public function proposal()
    {
        return view('public.proposal');
    }
    public function myProject(Request $request)
    {

        $data = ProjectOwner::with('hasil', 'owner.user', 'project.konsultan.user', 'kontrak.proposal', 'kontrak.payment')->withCount('hasil')->where('ownerId', $this->getOwnerId()->owner->id)->paginate(8);

        if ($request->ajax()) {
            $view = view('ajax.data', compact('data'))->render();
            return response()->json(['html' => $view]);
        }
        return view('public.myproject', compact('data'));
    }

    public function downloadKontrak(KontrakKerjaKonsultan $kontrak)
    {
        // $kontrak = KontrakKerjaKonsultan::find($kontrak->id);

        $filename = $kontrak->kontrakKerja;

        return Storage::disk('files')->download("kontrak/" . $filename);
    }

    public function updateBio(Request $request)
    {
        $request->validate([
            'telepon' => 'required|unique:owners,telepon|min:12|max:13',
            'alamat' => 'required|min:3|string',
        ]);
        Owner::where('userId', Auth::user()->id)->update([
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
        ]);
        return 1;
    }
    public function getDetilProject(ProjectOwner $project)
    {
        $data = ProjectOwner::with('project.images', 'project.konsultan.user', 'kontrak.proposal.lelang.inspirasi', 'kontrak.payment', 'chooseProject.imageOwner', 'lelang.imageOwner')->withCount('chooseProject.imageOwner')->find($project->id);
        dd($data);
        return view('public.single-myproject', compact('data'));
    }

    public function konsDetil(Konsultan $kons)
    {
        $data = Konsultan::with('user', 'projects.images')->find($kons->id);
        return view('public.detail-professional', compact('data'));
    }
    public function projectDetil(Project $project)
    {
        $data = Project::with('images', 'konsultan.user')->where('slug', $project->slug)->first();
        return view('public.detail-project', compact('data'));
    }

    public function delete($id)
    {
        // $data =
        LelangOwner::where("id", $id)->delete();
        return redirect('/owner/mylelang')->with('success', "<script>alert('Post deleted successfully')</script>");
    }

    public function view($id) {
        $data = [
            "data_lelang" => LelangOwner::where("id", $id)->first(),
        ];

        return view("modal.mylelang.modalviewlelang", $data);
    }

    public function edit($id)
    {
        $data = [
            "data_lelang" => LelangOwner::where("id", $id)->first(),
        ];
        return view("modal.mylelang.editviewlelang", $data);
    }

    public function updatemylelang(Request $request)
    {
        LelangOwner::where("id", $request->id)->update([
            "title" => $request->title,
            "description" => $request->description,
            "budgetFrom" => $request->budgetFrom,
            "budgetTo" => $request->budgetTo,
            "gayaDesain" => $request->gayaDesain,
            // "desain" => $request->desain,
            "luas" => $request->luas
        ]);
        return redirect("/owner/mylelang/")->with("success", "Data Berhasil di Simpan");
    }
}
