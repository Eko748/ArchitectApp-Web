<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Konsultan;
use App\Models\Kontraktor;
use App\Models\KonstruksiOwner;
use App\Models\KontrakKerjaKonsultan;
use App\Models\KontrakKerjaKontraktor;
use App\Models\KontraktorCabang;
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
        $kontraktor = Kontraktor::with('user')->get();
        $project = Project::with('konsultan.user', 'images')->where('isLelang', '0')->get();

        return view('public.landing', compact('konsultan', 'project', 'kontraktor'));
    }

    public function professional()
    {
        $data = User::with('konsultan')->where(['is_active' => 1, 'level' => 'konsultan'])->get();
        return view('public.professionals', compact('data'));
    }
    public function kontraktor()
    {
        $data = User::with('kontraktor')->where(['is_active' => 1, 'level' => 'kontraktor'])->get();
        return view('public.kontraktor', compact('data'));
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

    public function lelangOwner(LelangOwner $owner)
    {
        // $owner = LelangOwner::with('owner')->first();
        // dd($owner);
        return view('public.lelang', compact('owner'));

    }

    public function profileOwner(User $user)
    {
        return User::with('owner')->where('id', $user->id)->first();
    }

    // public function myLelang(LelangOwner $lelang)
    public function profileEdit()
    {
        $user = User::where('id', Auth::user()->id)->first();
        return view('public.profile-owner', compact('user'));
    }

    public function show(User $user)
    {
        return $user;
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string',
            'username' => 'required|unique:users,username,' . Auth::user()->id,
            'email' => 'required|string|email',
        ]);
        $fields = [
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
        ];
        return User::firstWhere('id', $user->id)->update($fields);
    }

    public function gantiAva(Request $request, User $user)
    {
        $img = $request->file('avatar');
        $filename = $img->hashName();
        $path = 'img/avatar/';
        $request->validate([
            'avatar' => 'required|mimes:jpg,jpeg,png'
        ]);
        if ($img) {
            $img->storeAs($path, $filename, 'files');
            if ($user->avatar != "default.png") {
                Storage::disk('files')->delete($path . '/' . $user->avatar);
            }
        }
        return User::firstWhere('id', $user->id)->update(['avatar' => $filename]);
    }

    public function updatePass(Request $request, User $user)
    {
        $pass = Hash::make($request->newpass_confirmation);
        $request->validate([
            'newpass' => 'required|min:8|confirmed',
            'newpass_confirmation' => 'required|min:8'
        ]);
        return User::firstWhere('id', $user->id)->update(['password' => $pass]);
    }

    public function confirmPass(Request $request, User $user)
    {
        if (password_verify($request->oldpass, $user->password)) {
            return response()->json(['status' => true]);
        }
        return response()->json(['status' => false]);
    }

    public function destroy(Request $request, User $user)
    {
        User::destroy($user->id);
        $request->session()->flush();
        Auth::logout();
        return redirect()->intended(route('login'));
    }

    public function myLelang()
    {
        $data = LelangOwner::with('image', 'owner.user')->where('ownerId', Auth::user()->id)->where('status', 0)->get();
        // dd($data);
        // return view('public.project', compact('data'));
        return view('public.mylelang', compact('data'));
    }
    public function showLelang(LelangOwner $lelang)
    {
        $data = LelangOwner::with('image', 'owner.user')->where('ownerId', Auth::user()->id)->where('status', 0)->get();
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

    public function myKonstruksi(Request $request)
    {
        // dd($this->getOwnerId()->owner->id);
        $data = KonstruksiOwner::with('owner.user', 'konstruksi.kontraktor.user')->where('ownerId', Auth::user()->id)->paginate(8);
        // dd($data);
        if ($request->ajax()) {
            $view = view('ajax.konstruksi', compact('data'))->render();
            return response()->json(['html' => $view]);
        }
        return view('public.mykonstruksi', compact('data'));
    }

    public function downloadKontrak(KontrakKerjaKonsultan $kontrak)
    {
        // $kontrak = KontrakKerjaKonsultan::find($kontrak->id);

        $filename = $kontrak->kontrakKerja;

        return Storage::disk('files')->download("pdf/kontrak/" . $filename);
    }

    public function downloadKontrakKontraktor(KontrakKerjaKontraktor $kontrak)
    {
        // $kontrak = KontrakKerjaKonsultan::find($kontrak->id);

        $filename = $kontrak->kontrakKerja;

        return Storage::disk('files')->download("pdf/kontraktor/" . $filename);
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
        
        $data = ProjectOwner::with('project.images', 'owner', 'project.konsultan.user', 'kontrak.proposal.lelang.inspirasi', 'kontrak.order', 'chooseProject.imageOwner')->find($project->id);

        $data = ProjectOwner::with('project.images', 'owner', 'project.konsultan.user', 'kontrak.proposal.lelang.inspirasi', 'kontrak.payment', 'chooseProject.imageOwner')->find($project->id);
        // dd($data);
        // $data = ProjectOwner::where("id", $project->id)->first();

        return view('public.single-myproject', compact('data'));
    }
    public function getDetilKonstruksi(KonstruksiOwner $konstruksi)
    {
        
        $data = KonstruksiOwner::with('owner.user', 'konstruksi.kontraktor.user', 'chooseKonstruksi.order')->find($konstruksi->id);
        // dd($data);
        // $data = ProjectOwner::where("id", $project->id)->first();
        
        return view('public.single-mykonstruksi', compact('data'));
    }

    public function getDetilKonsultan(ProjectOwner $konsultan)
    {
        $data = ProjectOwner::with('project.konsultan.user')->find($konsultan->id);
        return view('public.single-myproject', compact('data'));
    }

    public function getDetilKontraktor(KonstruksiOwner $kontraktor)
    {
        $data = KonstruksiOwner::with('konstruksi.kontraktor.user')->find($kontraktor->id);
        return view('public.single-mykonstruksi', compact('data'));
    }

    public function konsDetil(Konsultan $kons)
    {
        $data = Konsultan::with('user', 'projects.images')->find($kons->id);
        return view('public.detail-professional', compact('data'));
    }
    public function kontraktorDetil(Kontraktor $kontraktor)
    {
        $data = Kontraktor::with('user', 'cabang.images')->find($kontraktor->id);
        return view('public.detail-kontraktor', compact('data'));
    }
    public function cabangDetil(KontraktorCabang $cabang)
    {
        $data = KontraktorCabang::with('images', 'kontraktor.user')->where('slug', $cabang->slug)->first();
        return view('public.detail-cabang', compact('data'));
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
