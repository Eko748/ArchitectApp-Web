<?php

namespace App\Http\Controllers\Kontraktor;

use App\Http\Controllers\Controller;
use App\Models\ChooseKonstruksi;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use App\Models\KontraktorCabang;
use App\Models\ImageKontraktor;
use App\Models\KonstruksiOwner;
use Carbon\Carbon;

;


class CabangController extends Controller
{
    public function getAllJob(Request $request, ChooseKonstruksi $project)
    {
        $data = ChooseKonstruksi::with('order.owner', 'konstruksiOwner.user.owner', 'cabang.kontraktor')->whereHas('konstruksiOwner', function ($q) {
            $q->where('konfirmasi', "0");
        })
        ->where('status', "1")
        // ->whereHas('cabang', function ($s) {
        //     whereHas('kontraktor', function ($t) {
        //         $t->where('id', $this->getKontraktorId()->kontraktor->id);
        //     })->get();
        // })

        ->orderBy('id', 'DESC')->get();

        // $order = ChooseProject::with('owner.user.order')->where('id', "Belum Bayar")->first();
            // dd($data);
            return DataTables::of($data)
                ->addIndexColumn()->addColumn('tanggal', function ($data) {
                $tanggal = $data->mulaiKonstruksi;
                $tgl = Carbon::parse($tanggal);
                return $tanggal;
                })
                ->addIndexColumn()->addColumn('siap', function ($data) {
                    
                    $status = $data->status = "Siap";
                    // $rab = $data->chooseProject->rab = "RAB";
                    // $project = $status && $rab;
                    return $status;
                    })
                // ->addIndexColumn()->addColumn('tim', function ($data) {
                    
                //     $kons = KonstruksiOwner::with('chooseKonstruksi.cabang')->where('id', $this->getKontraktorId()->kontraktor->id)->get();
                //     $cabang = $kons->chooseKonstruksi->cabang->nama_tim;
                //     // $rab = $data->chooseProject->rab = "RAB";
                //     // $project = $status && $rab;                        
                //     return $cabang;
                //     })
                
                ->addIndexColumn()->addColumn('alamat', function ($data) {
                    $kota = $data->kota;
                    $kecamatan = $data->kecamatan;
                    $desa = $data->desa;
                    $jalan = $data->jalan;
                    $alamat = $kota." Kec. ".$kecamatan." Desa. ". $desa." Jalan. ". $jalan;
                    return $alamat;
                })
                ->addColumn('Aksi', function ($data) {
                    // $download = KontrakKerjaKonsultan::where('kontrakKerja', )
                    // $download = $data->kontrak->kontrakKerja;
                    
                    $btn = '<button class="btn btn-success mr-1 btn-sm" id="verify" data-id="' . $data->id . '">Accept</button> | ';
                    $kontrak = '<button class="btn btn-danger mr-1 btn-sm" id="unverify" data-id="' . $data->id . '">Reject</button>';
                    
                    return $btn.$kontrak;
                })->rawColumns(['Aksi'])->make(true);
        
    }

    public function getAllJobVerify(Request $request, ChooseKonstruksi $project)
    {
        $data = ChooseKonstruksi::where('status', "1")->with('order.owner', 'konstruksiOwner.user.owner', 'cabang.kontraktor')->whereHas('konstruksiOwner', function ($q) {
            $q->where('status', "Belum Bayar");
        })->whereHas('konstruksiOwner', function ($q) {
            $q->where('konfirmasi', "1");
        })
        ->whereHas('cabang.kontraktor', function ($s) {
            $s->where('id', $this->getKontraktorId()->kontraktor->id);
        })->where('status', "1")->orderBy('id', 'DESC')->get();

        // $order = ChooseProject::with('owner.user.order')->where('id', "Belum Bayar")->first();
            // dd($data);
            return DataTables::of($data)
                ->addIndexColumn()->addColumn('tanggal', function ($data) {
                $tanggal = $data->mulaiKonstruksi;
                $tgl = Carbon::parse($tanggal);
                return $tanggal;
                })
                ->addIndexColumn()->addColumn('siap', function ($data) {
                    
                    $status = $data->status = "Siap";
                    // $rab = $data->chooseProject->rab = "RAB";
                    // $project = $status && $rab;
                    return $status;
                    })
                
                ->addIndexColumn()->addColumn('alamat', function ($data) {
                    $kota = $data->kota;
                    $kecamatan = $data->kecamatan;
                    $desa = $data->desa;
                    $jalan = $data->jalan;
                    $alamat = $kota." Kec. ".$kecamatan." Desa. ". $desa." Jalan. ". $jalan;
                    return $alamat;
                })
                ->addColumn('Aksi', function ($data) {
                    // $download = KontrakKerjaKonsultan::where('kontrakKerja', )
                    // $download = $data->kontrak->kontrakKerja;
                    
                    $btn = '<button class="btn btn-primary mr-1 btn-sm" id="verify" data-id="' . $data->id . '">Buat Kontrak</button>';
                    // $kontrak = '<button class="btn btn-danger mr-1 btn-sm" id="unverify" data-id="' . $data->id . '">Reject</button>';
                    
                    return $btn;
                })->rawColumns(['Aksi'])->make(true);
        
    }

    public function getAllJobArchived(Request $request, ChooseKonstruksi $project)
    {
        $data = ChooseKonstruksi::where('status', "2")->with('order.owner', 'konstruksiOwner.user.owner', 'cabang.kontraktor')->whereHas('konstruksiOwner', function ($q) {
            $q->where('status', "Sudah Bayar");
        })->whereHas('konstruksiOwner', function ($q) {
            $q->where('konfirmasi', "1");
        })
        ->whereHas('cabang.kontraktor', function ($s) {
            $s->where('id', $this->getKontraktorId()->kontraktor->id);
        })->where('status', "2")->orderBy('id', 'DESC')->get();

        // $order = ChooseProject::with('owner.user.order')->where('id', "Belum Bayar")->first();
            // dd($data);
            return DataTables::of($data)
                ->addIndexColumn()->addColumn('tanggal', function ($data) {
                $tanggal = $data->mulaiKonstruksi;
                $tgl = Carbon::parse($tanggal);
                return $tanggal;
                })
                ->addIndexColumn()->addColumn('siap', function ($data) {
                    
                    $status = $data->status = "Siap";
                    // $rab = $data->chooseProject->rab = "RAB";
                    // $project = $status && $rab;
                    return $status;
                    })
                
                ->addIndexColumn()->addColumn('alamat', function ($data) {
                    $kota = $data->kota;
                    $kecamatan = $data->kecamatan;
                    $desa = $data->desa;
                    $jalan = $data->jalan;
                    $alamat = $kota." Kec. ".$kecamatan." Desa. ". $desa." Jalan. ". $jalan;
                    return $alamat;
                })
                // ->addColumn('Aksi', function ($data) {
                //     // $download = KontrakKerjaKonsultan::where('kontrakKerja', )
                //     // $download = $data->kontrak->kontrakKerja;
                    
                //     $btn = '<button class="btn btn-primary mr-1 btn-sm" id="verify" data-id="' . $data->id . '">Buat Kontrak</button>';
                //     // $kontrak = '<button class="btn btn-danger mr-1 btn-sm" id="unverify" data-id="' . $data->id . '">Reject</button>';
                    
                //     return $btn;
                // })->rawColumns(['Aksi'])
                ->make(true);
        
    }

    public function rules()
    {
        return [
            'nama_tim' => 'required|min:3',
            'desc' => 'required',
            'alamat_cabang' => 'required',
            'jumlah_tim' => 'required',
            'harga_kontrak' => 'required',
            'images' => 'required|mimes:jpg,jpeg,png',
        ];
    }

    public function fields($nama_tim, $desc, $alamat_cabang, $slug, $jumlah_tim, $harga_kontrak)
    {
        return [
            'nama_tim' => $nama_tim,
            'description' => $desc,
            'alamat_cabang' => $alamat_cabang,
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
            'alamat_cabang' => 'required',
            'jumlah_tim' => 'required',
            'images' => 'required',
            'harga_kontrak' => 'required',
        ]);
        $input = [
            'nama_tim' => $request->nama_tim,
            'description' => $request->desc,
            'alamat_cabang' => $request->alamat_cabang,
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

    public function verifyProject(Request $request)
    {
        $project = KonstruksiOwner::find($request->id)->update(['konfirmasi' => "1"]);
        return $project;
    }
    public function unVerifyProject(Request $request)
    {
        $project = KonstruksiOwner::find($request->id)->update(['konfirmasi' => "2"]);
        return $project;
    }
    public function verifyProjectActive(Request $request)
    {
        $project = ChooseKonstruksi::find($request->id)->update(['status' => "2"]);
        return $project;
    }

}

