<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Models\ChooseProject;
use App\Models\Favorit;
use App\Models\ImageOwner;
use App\Models\InspirasiOwner;
use App\Models\Konsultan;
use App\Models\Kontraktor;
use App\Models\LelangImage;
use App\Models\LelangOwner;
use App\Models\Owner;
use App\Models\PaymentKonsultan;
use App\Models\Project;
use App\Models\KontraktorCabang;
use App\Models\ProjectOwner;
use App\Models\Rating;
use App\Models\TenderKonsultan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class  OwnerController extends BaseController
{

    public function getAllProjectKons()
    {
        $project  = Project::with('images', 'konsultan.user', 'projectOwn.ratings', 'projectOwn.owner.user')->where('isLelang', "0")->get();
        return $this->sendResponse($project, 'Data loaded successfully');
    }
    public function detailProjectKons(Project $project)
    {
        $project  = Project::with('images', 'konsultan.user')->where('id', $project->id)->first();
        return $this->sendResponse($project, 'Data loaded successfully');
    }

    public function getProjectByOwn()
    {
        $project = ProjectOwner::with('project.konsultan.user', 'kontrak.payment', 'hasil', 'ratings', 'chooseProject')->where('ownerId', $this->getOwnerId()->owner->id)->orderBy('id', 'DESC')->get();
        return $this->sendResponse($project, 'Data loaded successfully');
    }
    public function chooseProject(Request $request)
    {
        $image = array();
        $validator = Validator::make($request->all(), [
            'rab' => Rule::requiredIf($request->has('rab')),
            'panjang' => 'required',
            'lebar' => 'required',
            'desain' => Rule::requiredIf($request->has('desain')),
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $projectOwner = ProjectOwner::create([
            'ownerId' => $this->getOwnerId()->owner->id,
            'projectId' => $request->projectId,
        ]);
        $input = [
            'projectOwnerId' => $projectOwner->id,
            'panjang' => $request->panjang,
            'lebar' => $request->lebar,
        ];
        if ($request->has('rab')) {
            $input += ['RAB' => $request->rab];
        }
        if ($request->has('desain')) {
            $input += ['desain' => $request->desain];
        }

        $choose = ChooseProject::create($input);

        if ($request->hasFile('image')) {
            $img = $request->file('image');
            $path = 'img/owner/';
            foreach ($img as $key) {
                $filename = $key->hashName();
                $key->storeAs($path, $filename, 'files');
                $image[] = ImageOwner::create([
                    'chooseProjectId' => $choose->id,
                    'image' => $filename,
                ]);
            }
        }

        if ($request->has('telepon')) {
            Owner::firstWhere('id', $this->getOwnerId()->owner->id)->update(['telepon' => $request->telepon]);
        }

        if ($request->has('alamat')) {
            Owner::firstWhere('id', $this->getOwnerId()->owner->id)->update(['alamat' => $request->alamat]);
        }

        $data = ProjectOwner::with('owner.user.owner')->where('id', $projectOwner->id)->get();
        $generate = new GeneratePDFProject();
        $generate->generatePDF($projectOwner->id);

        // Mengirim notifikasi ke konsultan
        $user = User::where('id', $request->userId)->first();
        $owner = User::where('id', Auth::user()->id)->first();

        $SERVER_API_KEY = 'AAAAODXY9xI:APA91bEJBxQ3kKubZRAQTIoCk_2aYGXE-xNUI571Oka9fIKCBwi-J0p4r__syz4_cpJuVTEDzbCSUJ0YdI_hN66KVjk8MmyqgpwBllRTOnhAGe60DgL08q4D0cdyGCGsumJOacD_crt0';
        // $SERVER_API_KEY = 'AAAAe3lvlps:APA91bEg_-VVYnHn12FPjiuyLzvjAaqCiZZHilXP3XImA99x8oEYJU5MEmndXwi3wcoooBlJml3uwXnTucZ0a0w2jvwI2NCLinqjmF7CxyAd8p6cxXOG4Ebjjw_lQdA8hO1PNJQU5fiY';

        $firebase = [
            "to" => $user->fireBaseToken,
            // "registration_ids" => $user->fireBaseToken,
            "notification" => [
                "title" => "Architect App",
                "body" => "$owner->name membeli desain anda",
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

        // dd($response);

        // return $this->sendResponse(compact('data', 'response'), 'Berhasil memilih project');
        return $this->sendResponse($data, 'Berhasil memilih project');
        // return $this->sendResponse(compact('choose', 'image'), 'Berhasil memilih project');
    }

    public function postLelangOwner(Request $request)
    {
        $foto = array();
        $inspirasi = array();
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3|string',
            'description' => 'required|min:3|string',
            'desain' => 'required',
            'budgetFrom' => 'required',
            'budgetTo' => 'required',
            'rab' => 'required',
            // 'kontraktor' => 'required',
            'style' => 'required',
            'panjang' => 'required',
            'lebar' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $input = [
            'title' => $request->title,
            'description' => $request->description,
            'budgetFrom' => $request->budgetFrom,
            'budgetTo' => $request->budgetTo,
            'desain' => $request->desain,
            'RAB' => $request->rab,
            'status' => 0,
            'ownerId' => $this->getOwnerId()->owner->id,
            'gayaDesain' => $request->style,
            'panjang' => $request->panjang,
            'lebar' => $request->lebar
        ];

        if ($request->has('telepon')) {
            Owner::firstWhere('id', $this->getOwnerId()->owner->id)->update(['telepon' => $request->telepon]);
        }

        if ($request->has('alamat')) {
            Owner::firstWhere('id', $this->getOwnerId()->owner->id)->update(['alamat' => $request->alamat]);
        }


        $lelang = LelangOwner::create($input);
        if ($request->hasFile('image')) {
            $img = $request->file('image');
            $path = 'img/lelang/tkp/';
            $no = 1;
            foreach ($img as $key) {
                $filename = $key->hashName();
                $key->storeAs($path, $filename, 'files');
                $image = new ImageOwner(['lelangOwnerId' => $lelang->id, 'image' => $filename]);
                $foto = tap($lelang->image())->save($image)->get();
            }
        }
        if ($request->hasFile('inspirasi')) {
            $ins = $request->file('inspirasi');
            $path = 'img/lelang/tkp/';
            $no = 1;
            foreach ($ins as $key) {
                $filename = $key->hashName();
                $key->storeAs($path, $filename, 'files');
                $inspirasi = InspirasiOwner::create(['inspirasi' => $filename, 'lelangOwnerId' => $lelang->id]);
            }
        }

        $client = Auth::user()->name;

        $SERVER_API_KEY = 'AAAAODXY9xI:APA91bEJBxQ3kKubZRAQTIoCk_2aYGXE-xNUI571Oka9fIKCBwi-J0p4r__syz4_cpJuVTEDzbCSUJ0YdI_hN66KVjk8MmyqgpwBllRTOnhAGe60DgL08q4D0cdyGCGsumJOacD_crt0';
        // $SERVER_API_KEY = 'AAAAe3lvlps:APA91bEg_-VVYnHn12FPjiuyLzvjAaqCiZZHilXP3XImA99x8oEYJU5MEmndXwi3wcoooBlJml3uwXnTucZ0a0w2jvwI2NCLinqjmF7CxyAd8p6cxXOG4Ebjjw_lQdA8hO1PNJQU5fiY';

        $firebase = [
            "to" => "/topics/konsultan",
            // "registration_ids" => $user->fireBaseToken,
            "notification" => [
                "title" => "Architect App",
                "body" => "$client mengusulkan desain custom. Lihat apakah kamu cocok dengan pekerjaannya",
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

        return $this->sendResponse(compact('lelang'), 'Lelang berhasil ditambahkan');
        // return $this->sendResponse(compact('lelang','inspirasi','foto'), 'Lelang berhasil ditambahkan');
    }
    public function putLelangOwner(Request $request, LelangOwner $lelang)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3|string',
            'description' => 'required|min:3|string',
            'desain' => 'required',
            'budget' => 'required',
            'rab' => 'required',
            'kontraktor' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $input = [
            'title' => $request->title,
            'description' => $request->description,
            'desain' => $request->desain,
            'budgetFrom' => $request->budgetFrom,
            'budgetTo' => $request->budgetTo,
            'RAB' => $request->rab,
            'kontraktor' => $request->kontraktor,
            'status' => 0,
            'ownerId' => $this->getOwnerId()->owner->id
        ];
        $data = tap(LelangOwner::where('id', $lelang->id))->update($input)->first();
        return $this->sendResponse($data, 'Lelang berhasil diedit');
    }

    public function deleteLelangOwn(LelangOwner $lelang)
    {
        $delete = LelangOwner::destroy($lelang->id);
        return $this->sendResponse($delete, 'lelang berhasil dihapus');
    }

    public function getLelangByOwn()
    {
        $data = LelangOwner::with('image')->get();
        // return view('public.project', compact('data'));
        // return view('public.mylelang', compact('data'));
        return $this->sendResponse($data, 'Data loaded successfully');
    }

    public function getAllKons()
    {
        $data = Konsultan::with('user', 'files', 'projects.images', 'projects.konsultan.user', 'projects.projectOwn.ratings', 'projects.projectOwn.owner.user')->whereHas('user', function ($q) {
            $q->where('is_active', 1);
        })->get();
        return $this->sendResponse($data, 'Data Loaded successfully');
    }

    public function getProposalByOwn(Request $request)
    {
        $data = TenderKonsultan::with('konsultan.user')->where('lelangOwnerId', $request->lelangId)->get();
        return $this->sendResponse($data, 'Data Loaded successfully');
    }

    public function getProposal()
    {
        $data = TenderKonsultan::with('lelang.owner.user', 'konsultan.user')->get();
        return $this->sendResponse($data, '');
    }

    public function chooseProposal(Request $request)
    {
        $data = tap(TenderKonsultan::where('id', $request->proposalId))->update(['status' => 1])->first();
        TenderKonsultan::where('lelangOwnerId', $request->lelangId)->where('status', 0)->update(['status' => 2]);
        LelangOwner::firstWhere('id', $request->lelangId)->update(['status' => 1]);
        $generate = new GeneratePDF();
        $generate->generatePDF($request->proposalId);

        $proposal = TenderKonsultan::where('id', $request->proposalId)->with('lelang.owner.user', 'konsultan.user')->first();
        $konsToken = $proposal->konsultan->user->fireBaseToken;
        $ownName = $proposal->lelang->owner->user->name;
        $SERVER_API_KEY = 'AAAAODXY9xI:APA91bEJBxQ3kKubZRAQTIoCk_2aYGXE-xNUI571Oka9fIKCBwi-J0p4r__syz4_cpJuVTEDzbCSUJ0YdI_hN66KVjk8MmyqgpwBllRTOnhAGe60DgL08q4D0cdyGCGsumJOacD_crt0';
        // $SERVER_API_KEY = 'AAAAe3lvlps:APA91bEg_-VVYnHn12FPjiuyLzvjAaqCiZZHilXP3XImA99x8oEYJU5MEmndXwi3wcoooBlJml3uwXnTucZ0a0w2jvwI2NCLinqjmF7CxyAd8p6cxXOG4Ebjjw_lQdA8hO1PNJQU5fiY';

        $firebase = [
            "to" => $konsToken,
            // "registration_ids" => $user->fireBaseToken,
            "notification" => [
                "title" => "Architect App",
                "body" => "Proposal anda diterima oleh $ownName",
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

        return $this->sendResponse($data, 'Kontrak Kerja telah dibuat');
    }

    public function uploadPayment(Request $request)
    {
        $bukti = $request->file('bukti');
        $path = 'img/bukti/';
        if ($request->hasFile('bukti')) {

            $filename = $bukti->hashName();
            $bukti->storeAs($path, $filename, 'files');
            $field = [
                'kontrakKonsultanId' => $request->kontrakId,
                'buktiBayar' => $filename,
                'status' => 0
            ];
            $payment = PaymentKonsultan::create($field);
            return $this->sendResponse($payment, 'Mohon menunggu verifikasi');
        }
        return $this->sendError('error', 'Terjadi kesalahan');
    }
    public function rating(Request $request)
    {
        if ($request->has('rating')) {
            $rating = Rating::create([
                'projectOwnerId' => $request->projectOwnerId,
                'rating' => $request->rating
            ]);
            ProjectOwner::firstWhere('id', $request->projectOwnerId)->update(['status' => "1"]);
        } else {
            $rating = ProjectOwner::firstWhere('id', $request->projectOwnerId)->update(['status' => "1"]);
        }
        return $this->sendResponse(compact('rating'), 'Terimakasih');
    }

    public function getDataOwner()
    {
        $data = User::with('owner')->where('id', Auth::user()->id)->first();
        return $this->sendResponse($data, 'Data berhasil diambil');
    }
    public function favorit(Request $request)
    {
        $favorits = Favorit::all();
        foreach ($favorits as $favs) {
            if ($favs->ownerId == $this->getOwnerId()->owner->id && $favs->projectId == $request->projectId) {
                Favorit::where(['ownerId' => $this->getOwnerId()->owner->id, 'projectId' => $request->projectId])->delete();
            } else {
                Favorit::create(['ownerId' => $this->getOwnerId()->owner->id, 'projectId' => $request->projectId]);
            }
        }
        // $favs = Favorit::create(['ownerId'=>$this->getOwnerId()->owner->id,'projectId'=>$request->projectId]);
        return $this->sendResponse($favorits, 'Berhasil menyimpan desain favorit');
    }

    public function hapusFavorit(Request $request)
    {
        $fav = Favorit::destroy($request->idFavorit);
        return $this->sendResponse($fav, 'Berhasil menghapus favorit');
    }

    public function payment_handler(Request $request){
        $json = json_decode($request->getContent());
        $signature_key = hash('sha512',$json->order_id . $json->status_code . $json->gross_amount . env('MIDTRANS_SERVER_KEY'));
        
        if($signature_key != $json->signature_key){
            return abort(404);
        }

        //status berhasil
        $order = PaymentKonsultan::where('order_id', $json->order_id)->first();
        return $order->update(['status'=>$json->transaction_status]);
    }

    public function getAllKontraktor()
    {
        $data = Kontraktor::with('user', 'files', 'cabang.images', 'cabang.kontraktor.user')->whereHas('user', function ($q) {
            $q->where('is_active', 1);
        })->get();
        return $this->sendResponse($data, 'Data Loaded successfully');
    }

    public function getAllCabangKontraktor()
    {
        $cabang  = KontraktorCabang::with('images', 'kontraktor.user')->where('isLelang', "0")->get();
        return $this->sendResponse($cabang, 'Data loaded successfully');
    }
    public function detailCabangKontraktor(KontraktorCabang $cabang)
    {
        $cabang  = KontraktorCabang::with('images', 'kontraktor.user')->where('id', $cabang->id)->first();
        return $this->sendResponse($cabang, 'Data loaded successfully');
    }
}
