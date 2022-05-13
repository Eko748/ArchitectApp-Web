<?php

namespace App\Http\Controllers\Konsultan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\LelangOwner;
Use App\Models\LelangKonsultan;
Use App\Models\ImageLelangKonsultan;
Use App\Models\FileLelangKonsultan;
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
            'images' => 'required|mimes:jpg,jpeg,png',
            'desain' => 'required',
            'rab' => 'required'
        ];
    }

    public function fields($title, $desc, $slug, $budget)
    {
        return [
            'title' => $title,
            'description' => $desc,
            'slug' => $slug,
            'konsultanId' => $this->getKonsultanId()->konsultan->id,
            'budget' => $budget,
            'status' => "0"
        ];
    }

    // public function field(Request $request)
    // {

    //     $data = [
    //         'tenderKonsultanId' => $request->tenderKonsultanId,
    //         'title' => $request->title,
    //         'description' => $request->description,
    //         'budget' => Str::of($request->to)->replace('.', ''),
    //         'rab' => $request->rab,
    //         'desain' => $request->desain,
    //         // 'luas' => $request->luas
    //     ];
        // if ($request->has('rab')) {
        //     $data['RAB'] = $request->rab;
        // }
        // if ($request->has('desain')) {
        //     $data['desain'] = $request->desain;
        // }

    //     return $data;
    // }

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


            $data = LelangKonsultan::with('images')->where('konsultanId', $this->getKonsultanId()->konsultan->id)->get();
            return DataTables::of($data)
                ->addIndexColumn()->addColumn('gambar', function ($data, $index = 0) {
                    if ($data->images->count() == 0) {
                        return $gambar = "Gambar belum di upload";
                    }

                    $gambar = "<img src='" . asset('img/lelang-konsultan/gambar/' . $data->images[$index]->image) . "' height='50' width='50'>";

                    return $gambar;
                })
                ->addColumn('aksi', function ($data) {
                    $btn = 
                    '<button type="button" class="btn btn-primary btn-sm mr-1 btnEditLelang"  data-toggle="modal" data-target="#modalEditLelang" data-id="' . $data->id . '" onclick="editProject('.$data->id.')">Edit</button>
                    <a href="#" class="btn btn-warning btn-sm mr-1" data-toggle="modal" data-target="#viewLelang"
                            data-id="' . $data->id . '" id="viewDesign" onclick="view('.$data->id.')">View</a>
                    <a href="#" class="btn btn-danger mr-1 btn-sm" id="hapusLelang" data-name="' . $data->title . '" data-id="' . $data->id . '">Hapus</a>';
                    return $btn;
                })
                ->rawColumns(['aksi', 'gambar'])->make(true);
        }
    }

    public function tambahLelang(Request $request)
    {

        $slug = Str::of($request->title)->slug('-');

        $path = 'img/lelang-konsultan/gambar/';
        $path2 = 'img/lelang-konsultan/desain/';
        $path3 = 'img/lelang-konsultan/rab/';

        $request->validate([
            'title' => 'required',
            'desc' => 'required',
            'budget' => 'required',
            'images' => 'required',
            'desain' => 'required',
            'rab' => 'required',
        ]);
        $input = [
            'title' => $request->title,
            'description' => $request->desc,
            'budget' => $request->budget,
            'slug' => $slug,
            'status' => "0",
            'konsultanId' => $this->getKonsultanId()->konsultan->id,
        ];
        $lelang = LelangKonsultan::create($input);

        if ($request->hasFile('images')) {
            $img = $request->file('images');
            foreach ($img as $key) {
                $filename = $key->hashName();
                $key->storeAs($path, $filename, 'files');
                $images = ImageLelangKonsultan::create(['LelangKonsultanId' => $lelang->id, 'image' => $filename]);
            }
        }
        
        if ($request->hasFile('desain')) {
            if ($request->hasFile('rab')) {
                $desain = round(microtime(true) * 1000).'-'.str_replace(' ','-',$request->file('desain')->getClientOriginalName());
           
                $request->file('desain')->move(public_path($path2), $desain);

                $rab = round(microtime(true) * 1000).'-'.str_replace(' ','-',$request->file('rab')->getClientOriginalName());
                
                $request->file('rab')->move(public_path($path3), $rab);
                
                FileLelangKonsultan::create([
                    "lelangKonsultanId" => $lelang->id,
                    "desain" => $desain,
                    "rab" => $rab
                ]);

                return 1;
            }
            
            return 0;
        }
        // if ($request->hasFile('rab')) {
        //     $rab = $request->file('rab');
        //     foreach ($rab as $key) {
        //         $filename = $key->hashName();
        //         $key->storeAs($path3, $filename, 'files');
        //         $files2 = FileLelangKonsultan::create(['lelangKonsultanId' => , 'desain' => "Eko" ,'rab' => $filename]);
        //     }

        //     return 1;
        // }
    }

    public function destroy(LelangKonsultan $lelang)
    {
        Storage::disk('files')->delete($lelang);
        ImageLelangKonsultan::where('LelangKonsultanId', $lelang->id)->delete();
        FileLelangKonsultan::where('lelangKonsultanId', $lelang->id)->delete();
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
