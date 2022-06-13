<?php

namespace App\Http\Controllers\Konsultan;

use App\Http\Controllers\Controller;
use App\Models\HasilDesain;
use App\Models\Image;
use App\Models\KontrakKerjaKonsultan;
use App\Models\Project;
use App\Models\ProjectOwner;
use App\Models\ChooseProject;
use App\Models\Order;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use PDF;

class JobController extends Controller
{
    public function getAllJob(Request $request, ProjectOwner $project)
    {
        // $owner = Owner::where('userId', Auth::user()->id)->first();
        // $data = ProjectOwner::with('owner.user', 'project.konsultan', 'chooseProject.ambil', 'kontrak.proposal')->where('status',0)->get();
        // // dd($data);
        // return $data;
        // return ProjectOwner::with('project','kontrak.proposal.lelang')->whereHas('project',function (Builder $query)
        // {
        //    $query->where('isLelang','1')->where('konsultanId',$this->getKonsultanId()->konsultan->id);
        // // })->get();
        // if ($request->ajax()) {
        //     $data = ProjectOwner::where('status', 0)->with('owner.user', 'project.konsultan', 'chooseProject.ambil', 'kontrak.proposal')->get();
        //     // dd($data);

        //     return DataTables::of($data)
        //         ->addIndexColumn()->addColumn('tanggal', function ($data) {
        //         $createdAt = Carbon::parse($data->updated_at);
        //         return $createdAt->format('d M Y');
        //         })->addColumn('Aksi', function ($data) {
        //             $btn = '<a href="#" class="btn btn-warning btn-sm mr-1" data-toggle="modal" data-target="#modalViewUser"
        //             data-id="' . $data->id . '" id="viewUser">View</a>';
        //             return $btn;
        //         })->rawColumns(['Aksi'])->make(true);
        $data = ProjectOwner::where('status', "Belum Bayar")->with('project.images', 'project.konsultan', 'chooseProject.owner.user.order', 'owner.user', 'owner.lelang.image', 'kontrak.payment', 'kontrak.order', 'chooseProject.ambil', 'chooseProject.imageOwner', 'hasil')->whereHas('project', function ($q) {
            $q->where('id', $this->getKonsultanId()->konsultan->id);
        })->where('status', "Belum Bayar")->orderBy('id', 'DESC')->get();
        // $order = ChooseProject::with('owner.user.order')->where('id', "Belum Bayar")->first();
            // dd($data);
            return DataTables::of($data)
                ->addIndexColumn()->addColumn('tanggal', function ($data) {
                $createdAt = Carbon::parse($data->updated_at);
                return $createdAt->format('d M Y');
                })
                ->addIndexColumn()->addColumn('project', function ($data) {
                    
                    $desain = $data->chooseProject->desain = "Desain";
                    $rab = $data->chooseProject->rab = "RAB";
                    // $project = $desain && $rab;
                    return $desain." & ".$rab;
                    })
                // ->addIndexColumn()->addColumn('gambar', function ($img, $index = 0, $index2 = 1, $index3 = 2, $index4 = 3) {
                //         if ($img->ambil->images->count() == 0) {
                //             return $gambar = "Gambar belum di upload";
                //         }
    
                //         $gambar = "<img src='" . asset('img/owner/' . $img->ambil->images[$index]->image) . "' height='100' width='100'>";
    
                //     return $gambar;
                // })
                // ->addIndexColumn()->addColumn('order', function ($order) {
                //     $order = Order::where('status', "Belum Bayar")->first();
                //     $status = $order->status;
                //     return $status;
                //     })
                ->addIndexColumn()->addColumn('luas', function ($data) {
                    $panjang = $data->chooseProject->panjang;
                    $lebar = $data->chooseProject->lebar;
                    // $luas = $panjang * $lebar;
                    return $panjang." x ".$lebar." M";
                })
                ->addColumn('Aksi', function ($data) {
                    // $download = KontrakKerjaKonsultan::where('kontrakKerja', )
                    $download = $data->kontrak->kontrakKerja;
                    
                    $btn = '<button type="button" class="btn btn-primary" id="tambahHasil" data-target="#modalHasil"
                    data-toggle="modal" >Kirim
                    File</button> | ';
                    $kontrak = '<button type="button" class="btn btn-warning" id="i" data-target="#a"
                    data-toggle="modal" >Lihat
                    Kontrak</button>';
                    
                    return $btn.$kontrak;
                })->rawColumns(['Aksi'])->make(true);
        
    }

    public function getAllJobVerify(Request $request, ProjectOwner $project)
    {
        // $owner = Owner::where('userId', Auth::user()->id)->first();
        // $data = ProjectOwner::with('owner.user', 'project.konsultan', 'chooseProject.ambil', 'kontrak.proposal')->where('status',0)->get();
        // // dd($data);
        // return $data;
        // return ProjectOwner::with('project','kontrak.proposal.lelang')->whereHas('project',function (Builder $query)
        // {
        //    $query->where('isLelang','1')->where('konsultanId',$this->getKonsultanId()->konsultan->id);
        // // })->get();
        // if ($request->ajax()) {
        //     $data = ProjectOwner::where('status', 0)->with('owner.user', 'project.konsultan', 'chooseProject.ambil', 'kontrak.proposal')->get();
        //     // dd($data);

        //     return DataTables::of($data)
        //         ->addIndexColumn()->addColumn('tanggal', function ($data) {
        //         $createdAt = Carbon::parse($data->updated_at);
        //         return $createdAt->format('d M Y');
        //         })->addColumn('Aksi', function ($data) {
        //             $btn = '<a href="#" class="btn btn-warning btn-sm mr-1" data-toggle="modal" data-target="#modalViewUser"
        //             data-id="' . $data->id . '" id="viewUser">View</a>';
        //             return $btn;
        //         })->rawColumns(['Aksi'])->make(true);
        $data = ProjectOwner::where('status', "Sudah Bayar")->with('project.images', 'project.konsultan', 'chooseProject.owner.user.order', 'owner.user', 'owner.lelang.image', 'kontrak.payment', 'kontrak.order', 'chooseProject.ambil', 'chooseProject.imageOwner', 'hasil')->whereHas('project', function ($q) {
            $q->where('id', $this->getKonsultanId()->konsultan->id);
        })->where('status', "Sudah Bayar")->orderBy('id', 'DESC')->get();
        // $order = ChooseProject::with('owner.user.order')->where('id', "Belum Bayar")->first();
            // dd($data);
            return DataTables::of($data)
                ->addIndexColumn()->addColumn('tanggal', function ($data) {
                $createdAt = Carbon::parse($data->updated_at);
                return $createdAt->format('d M Y');
                })
                ->addIndexColumn()->addColumn('project', function ($data) {
                    
                    $desain = $data->chooseProject->desain = "Desain";
                    $rab = $data->chooseProject->rab = "RAB";
                    // $project = $desain && $rab;
                    return $desain." & ".$rab;
                    })
                // ->addIndexColumn()->addColumn('gambar', function ($img, $index = 0, $index2 = 1, $index3 = 2, $index4 = 3) {
                //         if ($img->ambil->images->count() == 0) {
                //             return $gambar = "Gambar belum di upload";
                //         }
    
                //         $gambar = "<img src='" . asset('img/owner/' . $img->ambil->images[$index]->image) . "' height='100' width='100'>";
    
                //     return $gambar;
                // })
                // ->addIndexColumn()->addColumn('order', function ($order) {
                //     $order = Order::where('status', "Belum Bayar")->first();
                //     $status = $order->status;
                //     return $status;
                //     })
                ->addIndexColumn()->addColumn('luas', function ($data) {
                    $panjang = $data->chooseProject->panjang;
                    $lebar = $data->chooseProject->lebar;
                    // $luas = $panjang * $lebar;
                    return $panjang." x ".$lebar." M";
                })
                ->addColumn('Aksi', function ($data) {
                    // $download = KontrakKerjaKonsultan::where('kontrakKerja', )
                    $download = $data->kontrak->kontrakKerja;
                    
                    $btn = '<button type="button" class="btn btn-primary" id="tambahHasil" data-target="#modalHasil"
                    data-toggle="modal" >Kirim
                    File</button> | ';
                    $kontrak = '<button type="button" class="btn btn-warning" id="i" data-target="#a"
                    data-toggle="modal" >Lihat
                    Kontrak</button>';
                    
                    return $btn.$kontrak;
                })->rawColumns(['Aksi'])->make(true);
        
    }

    public function downloadKontrak(KontrakKerjaKonsultan $kontrak)
    {
        // $kontrak = KontrakKerjaKonsultan::find($kontrak->id);

        $filename = $kontrak->kontrakKerja;

        return Storage::disk('files')->download("pdf/kontrak/" . $filename);
    }

    public function getArchivedJob()
    {
        $data = ProjectOwner::where('status', "Sudah Bayar")->with('project.images', 'project.konsultan', 'chooseProject.owner.user.order', 'owner.user', 'owner.lelang.image', 'kontrak.payment', 'kontrak.order', 'chooseProject.ambil', 'chooseProject.imageOwner', 'hasil')
        // ->whereHas('project', function (Builder $query, $q) {
        //     $query->where('isLelang', "1");
        // })
        ->whereHas('project', function ($q) {
            $q->where('id', $this->getKonsultanId()->konsultan->id);
        })->where('status', "Sudah Bayar")->orderBy('id', 'DESC')->get();
        
        // $data = Project::with('projectOwner.hasil', 'projectOwner.kontrak.proposal', 'projectOwner.kontrak.payment')->where('isLelang', "1")->where('konsultanId', $this->getKonsultanId()->konsultan->id)->whereHas('projectOwner',function (Builder $query)
        // {
        //     $query->where('status','Sudah Bayar');
        // })->get();
        return DataTables::of($data)
                ->addIndexColumn()->addColumn('tanggal', function ($data) {
                $createdAt = Carbon::parse($data->updated_at);
                return $createdAt->format('d M Y');
                })
                ->addIndexColumn()->addColumn('project', function ($data) {
                    
                    $desain = $data->chooseProject->desain = "Desain";
                    $rab = $data->chooseProject->rab = "RAB";
                    // $project = $desain && $rab;
                    return $desain." & ".$rab;
                    })
                // ->addIndexColumn()->addColumn('gambar', function ($img, $index = 0, $index2 = 1, $index3 = 2, $index4 = 3) {
                //         if ($img->ambil->images->count() == 0) {
                //             return $gambar = "Gambar belum di upload";
                //         }
    
                //         $gambar = "<img src='" . asset('img/owner/' . $img->ambil->images[$index]->image) . "' height='100' width='100'>";
    
                //     return $gambar;
                // })
                // ->addIndexColumn()->addColumn('order', function ($order) {
                //     $order = Order::where('status', "Belum Bayar")->first();
                //     $status = $order->status;
                //     return $status;
                //     })
                ->addIndexColumn()->addColumn('luas', function ($data) {
                    $panjang = $data->chooseProject->panjang;
                    $lebar = $data->chooseProject->lebar;
                    // $luas = $panjang * $lebar;
                    return $panjang." x ".$lebar." M";
                })
                // ->addColumn('Aksi', function ($data) {
                //     // $download = KontrakKerjaKonsultan::where('kontrakKerja', )
                //     $download = $data->kontrak->kontrakKerja;
                    
                //     $btn = '<button type="button" class="btn btn-primary" id="tambahHasil" data-target="#modalHasil"
                //     data-toggle="modal" >Kirim
                //     File</button> | ';
                //     $kontrak = '<button type="button" class="btn btn-warning" id="i" data-target="#a"
                //     data-toggle="modal" >Lihat
                //     Kontrak</button>';
                    
                //     return $btn.$kontrak;
                // })->rawColumns(['Aksi'])
                ->make(true);
    }

    public function getDetilJob(Request $request)
    {
        return Project::with('projectOwner.hasil', 'projectOwner.kontrak.proposal.lelang.image', 'projectOwner.kontrak.payment','projectOwner.owner.user')->where('id',$request->id)->first();
    }

    // public function uploadHasil(Request $request)
    // {
    //     $projectOwner = ProjectOwner::find($request->projectOwnerId);
    //     if ($request->hasFile('rab')) {
    //         $path = 'img/file hasil/rab/';
    //         $rab = $request->file('rab');
    //         $filename = $rab->hashName();
    //         $rab->storeAs($path, $filename, 'files');
    //         ProjectOwner::find($request->projectOwnerId)->update(['hasil_rab' => $filename]);
    //     }
    //     if ($request->hasFile('softfile')) {
    //         $file = $request->file('softfile');
    //         foreach ($file as $key) {
    //             $path = 'img/file hasil/image/';
    //             $fileName = $key->hashName();
    //             $key->storeAs($path, $fileName, 'files');
    //             HasilDesain::create([
    //                 'projectOwnerId' => $request->projectOwnerId,
    //                 'softfile' => $fileName
    //             ]);
    //         }
    //         // Project::find($projectOwner->projectId)->update(['status'=>"1"]);
    //     }
    //     return  $this->sendResponse('', 'berhasil di upload');
    // }

    public function uploadHasil(Request $request)
    {
        $projectOwner = ProjectOwner::where('id', $this->getOwnerId()->id)->with('hasil')->get();
        
        $request->validate([
            'hasil_rab'=>'required',
            'softfile'=>'required'
        ]);

        // $input = [
        //     'hasil_rab' => $request->hasil_rab,
        //     'softfile' => $request->softfile,
        // ];
        // $hasil = HasilDesain::create($input);

        if ($request->hasFile('hasil_rab')) {
            $path = 'img/file hasil/rab/';
            $rab = $request->file('hasil_rab');
            $filename = $rab->hashName();
            $rab->storeAs($path, $filename, 'files');
            ProjectOwner::where('ownerId', $this->getOwnerId()->id)->update(['hasil_rab' => $filename]);
        }
        if ($request->hasFile('softfile')) {
            $file = $request->file('softfile');
            foreach ($file as $key) {
                $path = 'img/file hasil/image/';
                $fileName = $key->hashName();
                $key->storeAs($path, $fileName, 'files');
                HasilDesain::create([
                    'projectOwnerId' => $projectOwner->id,
                    'softfile' => $fileName
                ]);
            }
            // Project::find($projectOwner->projectId)->update(['status'=>"1"]);
            return 1;
        }
    }
    public function createProject(Request $request)
    {

        $cekProjectOwner = Project::with('projectOwner.rating', 'projectOwner.hasil')->where('id', $request->projectId)->first();
        $path = "img/project/";
        $oldpath = 'img/file hasil/image/';
        $rabpath = 'img/file hasil/rab/';
        $newrabpath = "img/project/rab/";
        $rates = array();

        $input = [
            'gayaDesain' => $cekProjectOwner->gayaDesain,
            'harga_desain' => $cekProjectOwner->harga_desain,
            'harga_rab' => $cekProjectOwner->harga_rab,
            'isLelang' => "0",
            'konsultanId' => $cekProjectOwner->konsultanId
        ];


        $validator = Validator::make($request->all(), [
            'description' => Rule::requiredIf($request->has('description')),
            'title' =>  Rule::requiredIf($request->has('title')),
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        if ($request->has('description') || $request->has('title')) {
            $input += [
                'description' => $request->description,
                'title' => $request->title,
                'slug' => Str::slug($request->title)
            ];
        } else {
            $input += [
                'description' => $cekProjectOwner->description,
                'title' => $cekProjectOwner->title,
                'slug' => Str::slug($cekProjectOwner->title)
            ];
        }
        $project = Project::create($input);
        $projectOwner = new ProjectOwner([
            'ownerId' => $cekProjectOwner->projectOwner[0]->ownerId,
            'projectId' => $project->id,
            'status' => "1"
        ]);

        if ($cekProjectOwner->projectOwner[0]->hasil_rab != null) {
            $file = $cekProjectOwner->projectOwner[0]->hasil_rab;
            $projectOwner->hasil_rab = $cekProjectOwner->projectOwner[0]->hasil_rab;
            Storage::disk('files')->copy($rabpath . $file, $newrabpath . $file);
        }
        $ownProject =  $project->projectOwner()->save($projectOwner);
        if ($cekProjectOwner->projectOwner[0]->rating->count() != 0) {
            $rating = new Rating([
                'projectOwnerId' => $ownProject->id,
                'rating' => $cekProjectOwner->rating->rating
            ]);
            $rates =  $ownProject->rating()->save($rating);
        }
        if ($cekProjectOwner->projectOwner[0]->hasil != null) {

            foreach ($cekProjectOwner->projectOwner[0]->hasil as $key) {
                $image[] =   Image::create([
                    'projectId' => $ownProject->id,
                    'image' => $key->softfile
                ]);
                Storage::disk('files')->copy($oldpath . $key->softfile, $newrabpath . $key->softfile);
            }
        }
        return compact('project', 'ownProject', 'rates', 'image');
    }
}
