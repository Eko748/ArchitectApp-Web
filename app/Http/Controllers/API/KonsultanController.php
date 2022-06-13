<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Models\HasilDesain;
use App\Models\Image;
use App\Models\Konsultan;
use App\Models\LelangKonsultan;
use App\Models\LelangOwner;
use App\Models\Project;
use App\Models\ProjectOwner;
use App\Models\Rating;
use App\Models\TenderKonsultan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class KonsultanController extends BaseController
{
    public function getAllLelang()
    {
        $data = LelangOwner::with('owner.user', 'image', 'inspirasi', 'proposal.konsultan')->where('status', 0)->withCount('proposal')->orderBy('id', 'DESC')->get();
        return $this->sendResponse($data, 'data loaded successfully');
    }
    public function getProjectByKons()
    {
        // $data = Project::with('projectOwn.owner.user', 'projectOwn.kontrak.payment', 'konsultan', 'images')->where([['konsultanId', $this->getKonsultanId()->konsultan->id], ['isLelang', "1"]])->get();
        $data = ProjectOwner::with('project.images', 'project.konsultan', 'owner.user', 'owner.lelang.image', 'kontrak.payment', 'chooseProject.imageOwner', 'hasil')->whereHas('project', function ($q) {
            $q->where('id', $this->getKonsultanId()->konsultan->id);
        })->where('status', "Belum Bayar")->orderBy('id', 'DESC')->get();
        return $this->sendResponse($data, 'data loaded successfully');
    }
    public function getAllProjectByKons(Request $request)
    {
        $data = Project::with('projectOwn.owner.user', 'projectOwn.kontrak.payment', 'projectOwn.hasil', 'konsultan', 'images')->where([['konsultanId', $this->getKonsultanId()->konsultan->id], ['isLelang', $request->isLelang]])->get();
        return $this->sendResponse($data, 'data loaded successfully');
    }
    public function postProposal(Request $request)
    {
        $cv = $request->file('cv');
        $path = 'img/tender/konsultan/cv/';
        $filename = $request->user()->name . '-' . Carbon::now()->toDateString() . '.' . $cv->getClientOriginalExtension();
        $validator = Validator::make($request->all(), [
            'tawaranDesain' => 'required',
            'tawaranRab' => 'required',
            'coverLetter' => 'required|string',
            // 'coverLetter' => 'required|min:50|string',
            'cv' => 'mimes:pdf,jpg,png,jpeg',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $input = [
            'lelangOwnerId' => $request->lelangId,
            'konsultanId' => $this->getKonsultanId()->konsultan->id,
            'coverLetter' => $request->coverLetter,
            'status' => 0,
            'cv' => $filename,
            'tawaranHargaDesain' => $request->tawaranDesain,
            'tawaranHargaRab' => $request->tawaranRab,
        ];
        if ($request->has('telepon')) {
            Konsultan::firstWhere('id', $this->getKonsultanId()->konsultan->id)->update(['telepon' => $request->telepon]);
        }

        if ($request->has('alamat')) {
            Konsultan::firstWhere('id', $this->getKonsultanId()->konsultan->id)->update(['alamat' => $request->alamat]);
        }
        $cv->storeAs($path, $filename, 'files');
        $data = TenderKonsultan::create($input);

        $proposal = TenderKonsultan::where('id', $data->id)->with('lelang.owner.user', 'konsultan.user')->first();
        $konsName = $proposal->konsultan->user->name;
        $ownToken = $proposal->lelang->owner->user->fireBaseToken;
        $lelangName = $proposal->lelang->title;
        $SERVER_API_KEY = 'AAAAODXY9xI:APA91bEJBxQ3kKubZRAQTIoCk_2aYGXE-xNUI571Oka9fIKCBwi-J0p4r__syz4_cpJuVTEDzbCSUJ0YdI_hN66KVjk8MmyqgpwBllRTOnhAGe60DgL08q4D0cdyGCGsumJOacD_crt0';
        // $SERVER_API_KEY = 'AAAAe3lvlps:APA91bEg_-VVYnHn12FPjiuyLzvjAaqCiZZHilXP3XImA99x8oEYJU5MEmndXwi3wcoooBlJml3uwXnTucZ0a0w2jvwI2NCLinqjmF7CxyAd8p6cxXOG4Ebjjw_lQdA8hO1PNJQU5fiY';

        $firebase = [
            "to" => $ownToken,
            // "registration_ids" => $user->fireBaseToken,
            "notification" => [
                "title" => "Architect App",
                "body" => "$konsName mengajukan proposal pada lelang $lelangName",
            ]
        ];
        $dataString = json_encode($firebase);

        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        // curl_exec($ch);
        $response = curl_exec($ch);
        return $this->sendResponse($data, 'Lelang berhasil ditambahkan');
    }
    public function postLelangKons(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3|string',
            'description' => 'required|min:3|string',
            'desain' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $input = [
            'title' => $request->title,
            'description' => $request->description,
            'desain' => $request->desain,
            'status' => 0,
            'tenderKonsultanId' => $request->tenderId
        ];
        $data = LelangKonsultan::create($input);
        return $this->sendResponse($data, 'Lelang berhasil ditambahkan');
    }
    public function putLelangKons(Request $request, LelangKonsultan $lelang)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3|string',
            'description' => 'required|min:3|string',
            'desain' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $input = [
            'title' => $request->title,
            'description' => $request->description,
            'desain' => $request->desain,
            'status' => 0,
            'tenderKonsultanId' => $request->tenderId
        ];
        $data = tap(LelangKonsultan::where('id', $lelang->id))->update($input)->first();
        return $this->sendResponse($data, 'Lelang berhasil ditambahkan');
    }
    public function deleteLelangKons(LelangOwner $lelang)
    {
        $delete = LelangKonsultan::destroy($lelang->id);
        return $this->sendResponse($delete, 'lelang berhasil dihapus');
    }

    public function postProject(Request $request)
    {
        $slug = Str::of($request->title)->slug('-');
        $img = $request->file('images');
        $path = 'img/project/';

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'desc' => 'required',
            'gayaDesain' => 'required',
            // 'images' => 'required|mimes:jpg,jpeg,png',
            'harga_rab' => 'required',
            'harga_desain' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $input = [
            'title' => $request->title,
            'description' => $request->desc,
            'gayaDesain' => $request->gayaDesain,
            'harga_desain' => $request->harga_desain,
            'harga_rab' => $request->harga_rab,
            'slug' => $slug,
            'isLelang' => "0",
            'konsultanId' => $this->getKonsultanId()->konsultan->id,
        ];

        $project = Project::create($input);

        if ($request->hasFile('images')) {
            foreach ($img as $key) {
                $filename = $key->hashName();
                $key->storeAs($path, $filename, 'files');
                $images = Image::create(['projectId' => $project->id, 'image' => $filename]);
            }
        }
        return $this->sendResponse(compact('project', 'images'), 'Project berhasil ditambahkan');
    }
    public function putProject(Request $req, Project $project)
    {
        $slug = Str::of($req->title)->slug('-');
        $img = $req->file('images');
        $path = 'img/project/';
        $images = Project::with('images')->find($project->id)->get();
        $validator = Validator::make($req->all(), [
            'title' => 'required|unique:projects,title,' . $project->id,
            'desc' => 'required',
            'images' => 'required|mimes:jpg,jpeg,png',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        if ($req->hasFile('images')) {
            // Storage::disk('files')->delete($path.$images->images[0]->image);
            $filename = $img->hashName();
            $img->storeAs($path, $filename, 'files');
            $input = [
                'title' => $req->title,
                'description' => $req->desc,
                'slug' => $slug,
                'konsultanId' => $this->getKonsultanId()->konsultan->id,
            ];
            $data = Project::where('id', $project->id)->update($input);
            Image::where('projectId', $data->id)->update(['projectId' => $data->id, 'image' => $filename]);
        }
        return $this->sendResponse($images, 'Project berhasil diupdate');
    }

    public function deleteProject(Project $project)
    {
        $img = Image::where('projectId', $project->id);
        Storage::disk('files')->delete('img/project/' . $img->image);
        $img->delete();
        Project::destroy($project->id);


        return $this->sendResponse('', 'Project berhasil dihapus');
    }

    public function uploadHasil(Request $request)
    {
        $projectOwner = ProjectOwner::find($request->projectOwnerId);
        if ($request->hasFile('rab')) {
            $path = 'img/file hasil/rab/';
            $rab = $request->file('rab');
            $filename = $rab->hashName();
            $rab->storeAs($path, $filename, 'files');
            ProjectOwner::find($request->projectOwnerId)->update(['hasil_rab' => $filename]);
        }
        if ($request->hasFile('softfile')) {
            $file = $request->file('softfile');
            foreach ($file as $key) {
                $path = 'img/file hasil/image/';
                $fileName = $key->hashName();
                $key->storeAs($path, $fileName, 'files');
                HasilDesain::create([
                    'projectOwnerId' => $request->projectOwnerId,
                    'softfile' => $fileName
                ]);
            }
            // Project::find($projectOwner->projectId)->update(['status'=>"1"]);
        }
        return  $this->sendResponse('', 'berhasil di upload');
    }

    public function getAllProposal(Request $request)
    {
        $data = TenderKonsultan::with('konsultan.user', 'lelang')->where([['status', $request->status], ['konsultanId', $this->getKonsultanId()->konsultan->id]])->get();
        return $this->sendResponse($data, 'Data berhasil diambil');
    }

    public function createProject(Request $request)
    {

        $cekProjectOwner = Project::with('projectOwn.ratings', 'projectOwn.hasil')->where('id', $request->projectId)->first();
        // return $this->sendResponse($cekProjectOwner->projectOwn[0]->ownerId,'');
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
                'slug' => STR::slug($request->title)
            ];
        } else {
            $input += [
                'description' => $cekProjectOwner->description,
                'title' => $cekProjectOwner->title,
                'slug' => STR::slug($cekProjectOwner->title)
            ];
        }
        $project = Project::create($input);
        $projectOwner = new ProjectOwner([
            'ownerId' => $cekProjectOwner->projectOwn[0]->ownerId,
            'projectId' => $project->id,
            'status' => "1"
        ]);

        if ($cekProjectOwner->projectOwn[0]->hasil_rab != null) {
            $file = $cekProjectOwner->projectOwn[0]->hasil_rab;
            $projectOwner->hasil_rab = $cekProjectOwner->projectOwn[0]->hasil_rab;

            $ext = pathinfo(asset('img/file hasil/rab/' . $file), PATHINFO_EXTENSION);

            $fileName = Hash::make($file) . $ext;
            Storage::disk('files')->copy($rabpath . $file, $newrabpath . $fileName);
        }
        $ownProject =  $project->projectOwn()->save($projectOwner);
        if ($cekProjectOwner->projectOwn[0]->ratings->count() != 0) {
            $rating = new Rating([
                'projectOwnerId' => $ownProject->id,
                'rating' => $cekProjectOwner->projectOwn[0]->ratings->rating
            ]);
            $rates =  $ownProject->ratings()->save($rating);
        }
        if ($cekProjectOwner->projectOwn[0]->hasil != null) {

            foreach ($cekProjectOwner->projectOwn[0]->hasil as $key) {
                $image[] =   Image::create([
                    'projectId' => $ownProject->id,
                    'image' => $key->softfile
                ]);
                Storage::disk('files')->copy($oldpath . $key->softfile, $newrabpath . $key->softfile);
            }
        }
        return $this->sendResponse(compact('project', 'ownProject', 'rates', 'image'), 'Hasil sudah menjadi project');
    }

    public function getDataKonsultan()
    {
        $data = User::with('konsultan')->where('id', Auth::user()->id)->first();
        return $this->sendResponse($data, 'Data berhasil diambil');
    }
}
