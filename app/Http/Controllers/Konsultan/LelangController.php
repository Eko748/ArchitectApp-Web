<?php

namespace App\Http\Controllers\Konsultan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\LelangOwner;
Use App\Models\LelangKonsultan;
use App\Models\Owner;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\TenderKonsultan;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class LelangController extends Controller
{
    public function getAllLelangOwner(Request $request)
    {
        if ($request->has('filter')) {
            # code...
        }

        $lelang = LelangOwner::with('owner')->withCount('proposal')->where('status',0)->get();
        return $lelang;
    }

    public function showLelang(LelangOwner $lelang)
    {
        $data = LelangOwner::where('id',$lelang->id)->with('owner','proposal.konsultan')->where('status',0)->first();
        return $data;
    }
    public function showLelangOwner(LelangOwner $lelang)
    {
        $data = LelangOwner::where('id', $lelang->id)->with('owner.user', 'image')->with('proposal.konsultan.user')->withCount('proposal')->first();
        return $data;
    }

    public function allLelangOwner()
    {
        $owner = Owner::where('userId', Auth::user()->id)->first();
        $data = LelangOwner::with('owner.user', 'image')->withCount('proposal')->where('ownerId', $owner->id)->where('status', 0)->get();
        return $data;
    }

    public function rules()
    {
        return [
            'title' => 'required|min:3',
            'desc' => 'required',
            'budget' => 'required',
            'desain' => 'required|mimes:pdf,docx,doc',
            'rab' => 'required|mimes:pdf,docx,doc'
        ];
    }
    public function field(Request $request)
    {

        $data = [
            'tenderKonsultanId' => $request->tenderKonsultanId,
            'title' => $request->title,
            'description' => $request->description,
            'budget' => Str::of($request->to)->replace('.', ''),
            'rab' => $request->rab,
            'desain' => $request->desain,
            // 'luas' => $request->luas
        ];
        // if ($request->has('rab')) {
        //     $data['RAB'] = $request->rab;
        // }
        // if ($request->has('desain')) {
        //     $data['desain'] = $request->desain;
        // }

        return $data;
    }

    public function postLelangKonsultan(Request $request)
    {
        $lelang = LelangKonsultan::create($request->all());
        if ($request->hasFile('desain')) {
            $img = $request->file('desain');
            $path = 'img/lelang-konsultan/desain/';
            $no = 1;
            foreach ($img as $key) {
                $filename = Str::slug($request->title) . '-' . Carbon::now()->toDateString() . '-' . $no++ . '.' . $key->getClientOriginalExtension();
                $key->storeAs($path, $filename, 'files');
                $desain = new LelangKonsultan(['lelangOwnerId' => $lelang->id, 'desain' => $filename]);
                $lelang->desain()->save($desain);
            }
            // return redirect(route('konsultan.lelang-konsultan'))->with('msg', 'Lelang sukses ditambahkan');
        }
        if ($request->hasFile('rab')) {
            $img = $request->file('rab');
            $path = 'img/lelang-konsultan/rab/';
            $no = 1;
            foreach ($img as $key) {
                $filename = Str::slug($request->title) . '-' . Carbon::now()->toDateString() . '-' . $no++ . '.' . $key->getClientOriginalExtension();
                $key->storeAs($path, $filename, 'files');
                $rab = new LelangKonsultan(['lelangOwnerId' => $lelang->id, 'rab' => $filename]);
                $lelang->rab()->save($rab);
            }
            // return redirect(route('konsultan.lelang-konsultan'))->with('msg', 'Lelang sukses ditambahkan');
        }
        return redirect(route('konsultan.lelang-konsultan'))->with('msg', 'Lelang sukses ditambahkan');
    }

    
    public function updateLelangKonsultan(Request $request)
    {
        LelangKonsultan::where("id", $request->id)->update([
            "title" => $request->title,
            "description" => $request->description,
            "budget" => $request->budget,
            "desain" => $request->desain,
            "rab" => $request->rab,

        ]);
        return redirect("/konsultan/lelang-konsultan/")->with("success", "Data Berhasil di Ubah");
    }

    public function showLelangKonsultan(LelangKonsultan $lelang)
    {
        $data = LelangKonsultan::where('id', $lelang->id)->with('konsultan.user')->with('proposal.konsultan.user')->withCount('proposal')->first();
        return $data;
    }

    // public function view($id) {
    //     $data = [
    //         "data_lelang" => LelangOwner::where("id", $id)->first(),
    //     ];

    //     return view("modal.mylelang.modalviewlelang", $data);
    // }

    public function editLelang($id)
    {
        $data = [
            "data_lelang" => LelangKonsultan::where("id", $id)->first(),
        ];
        return view("konsultan.js.edit-lelang", $data);
    }

    public function getAllKonsLelang(Request $req)
    {

        if ($req->ajax()) {


            $data = LelangKonsultan::where('konsultanId', $this->getKonsultanId()->konsultan->id)->get();
            return DataTables::of($data)
                ->addIndexColumn()->addColumn('gambar', function ($data, $index = 0) {
                    if ($data->images->count() == 0) {
                        return $gambar = "Gambar belum di upload";
                    }

                    $gambar = "<img src='" . asset('img/lelang-konsultan/desain/' . $data->images[$index]->image) . "' height='50' width='50'>";

                    return $gambar;
                })->addColumn('aksi', function ($data) {
                    $btn = '<button type="button" class="btn btn-primary btn-sm mr-1 btnEditProject"  data-toggle="modal" data-target="#modalEditProject" data-id="' . $data->id . '" onclick="editProject('.$data->id.')">Edit</button>
                    <a href="#" class="btn btn-warning btn-sm mr-1" data-toggle="modal" data-target="#viewProject"
                            data-id="' . $data->id . '" id="viewDesign" onclick="view('.$data->id.')">View</a>
                            <a href="#" class="btn btn-danger mr-1 btn-sm" id="hapusProject" data-name="' . $data->title . '" data-id="' . $data->id . '">Hapus</a>';
                    return $btn;
                })->rawColumns(['aksi'])->make(true);
        }
    }
    public function destroy(LelangKonsultan $lelang)
    {
        Storage::disk('files')->delete($lelang);
        LelangKonsultan::destroy($lelang->id);
        return 1;
    }

    public function view($id) {
        $data = [
            "data_project" => LelangKonsultan::where("id", $id)->first(),
        ];

        return view("modal.project_konsultan.view_project", $data);
    }

}
