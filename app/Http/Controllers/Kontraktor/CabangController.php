<?php

namespace App\Http\Controllers\Kontraktor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use App\Models\KontraktorCabang;
use App\Models\ImageKontraktor;
;


class CabangController extends Controller
{
    public function rules()
    {
        return [
            'nama_tim' => 'required|min:3',
            'desc' => 'required',
            'jumlah_tim' => 'required',
            'harga_kontrak' => 'required',
            'images' => 'required|mimes:jpg,jpeg,png',
        ];
    }

    public function fields($nama_tim, $desc, $slug, $jumlah_tim, $harga_kontrak)
    {
        return [
            'nama_tim' => $nama_tim,
            'description' => $desc,
            'jumlah_tim' => $jumlah_tim,
            'slug' => $slug,
            'kontaktorId' => $this->getKontraktorId()->kontraktor->id,
            'harga_kontrak' => $harga_kontrak,
            'isLelang' => "0"
        ];
    }

    public function getAllCabang(Request $req)
    {
        if ($req->ajax()) {
            $data = KontraktorCabang::with('images')->where('kontraktorId', $this->getKontraktorId()->kontraktor->id)->get();
            return DataTables::of($data)
                ->addIndexColumn()->addColumn('gambar', function ($data, $index = 0, $index2 = 1, $index3 = 2, $index4 = 3) {
                    if ($data->images->count() == 0) {
                        return $gambar = "Gambar belum di upload";
                    }

                    $gambar = "<img src='" . asset('img/cabang/profile/' . $data->images[$index]->image) . "' height='100' width='100'>
                                <img src='" . asset('img/cabang/profile/' . $data->images[$index2]->image) . "' height='100' width='100'>
                                <img src='" . asset('img/cabang/profile/' . $data->images[$index3]->image) . "' height='100' width='100'>
                                <img src='" . asset('img/cabang/profile/' . $data->images[$index4]->image) . "' height='100' width='100'>";

                    return $gambar;
                })->addColumn('aksi', function ($data) {
                    $btn = '<button type="button" class="btn btn-primary btn-sm mr-1 btnEditCabang"  data-toggle="modal" data-target="#modalEditCabang" data-id="' . $data->id . '" onclick="editCabang('.$data->id.')">Edit</button>
                    <a href="#" class="btn btn-warning btn-sm mr-1" data-toggle="modal" data-target="#viewCabang"
                            data-id="' . $data->id . '" id="viewDesign" onclick="view('.$data->id.')">View</a>
                            <a href="#" class="btn btn-danger mr-1 btn-sm" id="hapusCabang" data-name="' . $data->nama_tim . '" data-id="' . $data->id . '">Hapus</a>';
                    return $btn;
                })->rawColumns(['aksi', 'gambar'])->make(true);
        }
    }
    public function tambahCabang(Request $request)
    {

        $slug = Str::of($request->nama_tim)->slug('-');

        $path = 'img/cabang/profile/';
        // $request->validate($this->rules());
        // $data = $this->field($request);
        $request->validate([
            'nama_tim' => 'required',
            'desc' => 'required',
            'jumlah_tim' => 'required',
            'images' => 'required',
            'harga_kontrak' => 'required',
        ]);
        $input = [
            'nama_tim' => $request->nama_tim,
            'description' => $request->desc,
            'jumlah_tim' => $request->jumlah_tim,
            'harga_kontrak' => $request->harga_kontrak,
            'slug' => $slug,
            'isLelang' => "0",
            'kontraktorId' => $this->getKontraktorId()->kontraktor->id,
        ];
        $cabang = KontraktorCabang::create($input);

        if ($request->hasFile('images')) {
            $img = $request->file('images');
            foreach ($img as $key) {
                $filename = $key->hashName();
                $key->storeAs($path, $filename, 'files');
                $images = ImageKontraktor::create(['cabangKontraktorId' => $cabang->id, 'image' => $filename]);
            }
            return redirect()->back();
        }
    }

}

