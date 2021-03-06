<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\ChooseProject;
use App\Models\ImageOwner;
use App\Models\Order;
use App\Models\KontrakKerjaKonsultan;
use App\Models\Owner;
use App\Models\PaymentKonsultan;
use App\Models\ProjectOwner;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use PDF;

class ProjectController extends Controller
{
    public function payProject(Request $request)
    {

        $bukti = $request->file('bukti');
        $filename = $bukti->hashName();
        $path = "img/payment/konsultan/";
        $bukti->storeAs($path, $filename, 'files');
        PaymentKonsultan::create([
            'kontrakKonsultanId' => $request->kontrakId,
            'buktiBayar' => $filename,
            'status' => 0,
        ]);
        return 1;
    }

    public function chooseProject(Request $request)
    {
        $request->validate([
            'panjang' => 'required|numeric',
            'lebar' => 'required|numeric',
            'desain' => Rule::requiredIf(!$request->has('rab')),
            'rab' => Rule::requiredIf(!$request->has('desain')),
        ]);

        $projectOwn =  ProjectOwner::create([
            'projectId' => $request->projectId,
            'ownerId' => $this->getOwnerId()->owner->id,
            'status' => "Belum Bayar",
        ]);
        $input = [
            'panjang' => $request->panjang,
            'lebar' => $request->lebar,
            'projectOwnerId' => $projectOwn->id,
        ];
        if ($request->has('rab')) {
            $input['RAB'] = $request->rab;
        }
        if ($request->has('desain')) {
            $input['desain'] = $request->desain;
        }

        $choose = ChooseProject::create($input);
        if ($request->hasFile('image')) {
            $img = $request->file('image');
            foreach ($img as $key) {
                $filename = $key->hashName();
                $path = 'img/owner/';
                $key->storeAs($path, $filename, 'files');
                $image = ImageOwner::create([
                    'chooseProjectId' => $choose->id,
                    'image' => $filename,
                ]);
            }

            $this->generateKontrak($projectOwn->id);
        }
        return 1;
    }

    public function generateKontrak($projectOwnerId)
    {
        $project = ProjectOwner::where('id', $projectOwnerId)->with('chooseProject', 'owner.user', 'project.konsultan.user',)->first();
        $title = $project->project->title;
        $hari = Carbon::now()->isoFormat('dddd');
        $tgl = Carbon::now()->isoFormat('D');
        $bln = Carbon::now()->isoFormat('MMMM');
        $thn = Carbon::now()->isoFormat('YYYY');
        $date = $hari . " tanggal " . $this->terbilang($tgl) . " " . $bln . " tahun " . $this->terbilang($thn);
        $konsName = $project->project->konsultan->user->name;
        $konsTelp = $project->project->konsultan->telepon;
        $konsAlm = $project->project->konsultan->alamat;
        $ownName = Auth::user()->name;
        $ownTelp = Auth::user()->owner->telepon;
        $ownAlm = Auth::user()->owner->alamat;
        $hargaDesain = $project->chooseProject->desain == "1" ? $project->project->harga_desain : 0;
        $hargaRAB = $project->chooseProject->RAB == "1" ? $project->project->harga_rab : 0;
        $harga = $this->penyebut(($hargaDesain + $hargaRAB)) . " rupiah.";
        $path = public_path('pdf/kontrak/');
        $konsUname = $project->project->konsultan->user->username;
        $ownuName = Auth::user()->username;
        $filename = 'Kontrak Kerja ' . $konsUname . ' - ' . $ownuName . ' ' . Carbon::now()->toDateString() . ".pdf";
        $pdf = PDF::loadView('public.mypdf', compact('filename', 'title', 'date', 'konsName', 'konsTelp', 'konsAlm', 'ownName', 'ownTelp', 'ownAlm', 'harga'));
        $createKontrak = $this->createKontrak($projectOwnerId, $filename);
        $pdf->save($path . $filename);
    }

    public function createKontrak($projectOwnid, $fileKontrak)
    {
        KontrakKerjaKonsultan::create([
            'projectOwnerId' => $projectOwnid,
            'kontrakKerja' => $fileKontrak
        ]);
    }

    public function payment (ChooseProject $project, Request $request) {
        
        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;
        
        $data = ChooseProject::with('projectOwner.user', 'projectOwner.owner.user', 'project')->first();
        // dd($data);

        $nama = $data->projectOwner->owner->user->name;
        $email = $data->projectOwner->owner->user->email;
        $telepon = Auth::user()->owner->telepon;
        // dd($nama);
        $hargaRab = $data->project->harga_rab;
        $hargaDesain = $data->project->harga_desain;
        $hargaTotal = $hargaRab + $hargaDesain;
        // $hargaTotal = $data->project->harga_rab;
        // $hargaTotal = $data->project->harga_desain;
        // foreach ($data as $key) {
        //     $hargaRab = $key->project->harga_rab;
        //     $hargaDesain = $key->project->harga_desain;

        //     $hargaTotal = $hargaRab + $hargaDesain;
        // }
        

        // $ambil = 0;
        // $ambil_harga_rab = 0;
        // $ambil_harga_desain = 0;
        // foreach ($data as $s) {
        //     $ambil_harga_rab += $s->project->harga_rab;
        //     $ambil_harga_desain += $s->project->harga_desain;

        //     $ambil = $ambil_harga_rab + $ambil_harga_desain;
        // }
        
        $params = array(
            'transaction_details' => array(
                'order_id' => rand(),
                'gross_amount' => $hargaTotal,
            ),
            'customer_details' => array(
                'first_name' => $nama,
                'last_name' => '',
                'email' => $email,
                'phone' => $telepon,
            ),
        );

        $snapToken = \Midtrans\Snap::getSnapToken($params);
        
        return view('payment.payment', compact('data'), ['snap_token'=>$snapToken]);
        
    }

    public function paymentPost(Request $request)
    {
        // $data = ProjectOwner::with('project.konsultan', 'kontrak')->get();
        $data = ChooseProject::with('project.konsultan', 'projectOwner.user.owner')->get();
        $json = json_decode($request->get('json'));
        $order = new Order();
        $order->kontrakKonsultanId = $data->id;
        $order->ownerId = $data->project->konsultan->id;
        $order->projectId =  $data->project->id;
        $order->status = "Belum Bayar";
        $order->status_order = $json->transaction_status;
        $order->transaction_id = $json->transaction_id;
        $order->order_id = $json->order_id;
        $order->gross_amount = $json->gross_amount;
        $order->payment_type = $json->payment_type;
        $order->payment_code = isset($json->payment_code) ? $json->payment_code : null;
        $order->pdf_url = isset($json->pdf_url) ? $json->pdf_url : null;
        return $order->save() ? redirect('/')->with('alert-success', 'Order berhasil dibuat') : redirect('/')->with('alert-failed', 'Terjadi kesalahan');
    }

    public function viewPayment()
    {
        return view('payment.payment');
    }
}
