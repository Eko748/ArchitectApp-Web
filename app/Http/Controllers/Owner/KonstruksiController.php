<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\KonstruksiOwner;
use App\Models\KontrakKerjaKontraktor;
use App\Models\ChooseKonstruksi;
use App\Models\OrderKontraktor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use PDF;

class KonstruksiController extends Controller
{
    // public function payProject(Request $request)
    // {

    //     $bukti = $request->file('bukti');
    //     $filename = $bukti->hashName();
    //     $path = "img/payment/konsultan/";
    //     $bukti->storeAs($path, $filename, 'files');
    //     PaymentKonsultan::create([
    //         'kontrakKonsultanId' => $request->kontrakId,
    //         'buktiBayar' => $filename,
    //         'status' => 0,
    //     ]);
    //     return 1;
    // }

    public function chooseKonstruksi(Request $request)
    {
        // $konstruksi_owner = new KonstruksiOwner([
        //     "ownerId" => Auth::user()->id,
        //     "konstruksiId" => $request->konstruksiId,
        //     "konfirmasi" => 0,
        //     "status" => 0
        // ]);
        $request->validate([
            // 'konstruksiOwnerId' => 'required',
            'kota' => 'required',
            'kecamatan' => 'required',
            'desa' => 'required',
            'jalan' => 'required',
            'mulaiKonstruksi' => 'required',
            'desain' => 'required',
            'RAB' => 'required',
            'status' => 'required'
        ]);
        // $choose_konstruksi = new ChooseKonstruksi([
        //     "konstruksiOwnerId" => $konstruksi_owner->id,
        //     "kota" => $request->kota,
        //     "kecamatan" => $request->kecamatan,
        //     "desa" => $request->desa,
        //     "jalan" => $request->jalan,
        //     "mulaiKonstruksi" => $request->mulaiKonstruksi,
        //     "desain" => $request->desain,
        //     "RAB" => $request->rab,
        //     "status" => $request->status
        // ]);      
        // $data = KonstruksiOwner::with('user.owner')->first();
        $konstruksi_owner = new KonstruksiOwner([
            "ownerId" => Auth::user()->id,
            "konstruksiId" => $request->konstruksiId,
            "konfirmasi" => "0",
            "status" => "0"
        ]);

        $konstruksi_owner->save();

        // $choose = ChooseKonstruksi::create([
        //     "konstruksiOwnerId" => $konstruksi_owner->id,
        //     "kota" => $request->kota,
        //     "kecamatan" => $request->kecamatan,
        //     "desa" => $request->desa,
        //     "jalan" => $request->jalan,
        //     "mulaiKonstruksi" => $request->mulaiKonstruksi,
        //     // "desain" => $request->desain,
        //     // "RAB" => $request->rab,
        //     "status" => $request->status
        // ]);
        
        if ($request->hasFile('desain', 'RAB')) {
            $desain = $request->file('desain');
            $rab = $request->file('RAB');
                $filename = $desain->hashName();
                $filename2 = $rab->hashName();
                $path = 'konstruksi/desain/';
                $path2 = 'konstruksi/rab/';
                $desain->storeAs($path, $filename, 'files');
                $rab->storeAs($path2, $filename2, 'files');
                $file = ChooseKonstruksi::create([
                    "konstruksiOwnerId" => $konstruksi_owner->id,
                    "kota" => $request->kota,
                    "kecamatan" => $request->kecamatan,
                    "desa" => $request->desa,
                    "jalan" => $request->jalan,
                    "mulaiKonstruksi" => $request->mulaiKonstruksi,
                    // "desain" => $request->desain,
                    // "RAB" => $request->rab,
                    "status" => $request->status,
                    'desain' => $filename,
                    'RAB' => $filename2
                ]);
            

            $this->generateKontrak($konstruksi_owner->id);
        }
        return 1;
    }

    public function generateKontrak($konstruksiOwnerId)
    {
        $konstruksi = KonstruksiOwner::where('id', $konstruksiOwnerId)->with('chooseKonstruksi', 'owner.user', 'konstruksi.kontraktor.user',)->first();
        $nama_tim = $konstruksi->konstruksi->nama_tim;
        $hari = Carbon::now()->isoFormat('dddd');
        $tgl = Carbon::now()->isoFormat('D');
        $bln = Carbon::now()->isoFormat('MMMM');
        $thn = Carbon::now()->isoFormat('YYYY');
        $date = $hari . " tanggal " . $this->terbilang($tgl) . " " . $bln . " tahun " . $this->terbilang($thn);
        $kontraktorName = $konstruksi->konstruksi->kontraktor->user->name;
        $kontraktorTelp = $konstruksi->konstruksi->kontraktor->telepon;
        $kontraktorAlm = $konstruksi->konstruksi->kontraktor->alamat;
        $ownName = $konstruksi->owner->user->name;
        $ownTelp = $konstruksi->owner->telepon;
        $ownAlm = $konstruksi->owner->alamat;
        $hargaDesain = $konstruksi->chooseKonstruksi->desain == "1" ? $konstruksi->konstruksi->harga_desain : 0;
        $hargaRAB = $konstruksi->chooseKonstruksi->RAB == "1" ? $konstruksi->konstruksi->harga_rab : 0;
        $harga = $this->penyebut(($hargaDesain + $hargaRAB)) . " rupiah.";
        $path = public_path('pdf/kontraktor/');
        $kontraktorUname = $konstruksi->konstruksi->kontraktor->user->username;
        $ownuName = $konstruksi->owner->user->username;
        $filename = 'Kontrak Kerja ' . $kontraktorUname . ' - ' . $ownuName . ' ' . Carbon::now()->toDateString() . ".pdf";
        $pdf = PDF::loadView('public.surat-konstruksi', compact('filename', 'nama_tim', 'date', 'kontraktorName', 'kontraktorTelp', 'kontraktorAlm', 'ownName', 'ownTelp', 'ownAlm', 'harga'));
        $createKontrak = $this->createKontrak($konstruksiOwnerId, $filename);
        $pdf->save($path . $filename);
    }

    public function createKontrak($konstruksiOwnId, $fileKontrak)
    {
        KontrakKerjaKontraktor::create([
            'konstruksiOwnerId' => $konstruksiOwnId,
            'kontrakKerja' => $fileKontrak
        ]);
    }

    public function transaksi (ChooseKonstruksi $konstruksi) {
        
        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;
        
        $data = ChooseKonstruksi::with('cabang', 'konstruksiOwner.user.owner')->first();

        // $harga = $data->cabang->harga_kontrak;
        $harga = $data->cabang->harga_kontrak;
        $name = $data->konstruksiOwner->user->name;
        $email = $data->konstruksiOwner->user->email;
        $telepon = $data->konstruksiOwner->user->owner->telepon;
        // dd($owner);


        // $ambil = $data->chooseKonstruksi->cabang->harga_kontrak;
        // $ambil = 1;
        // $ambil_harga_kontrak = 0;
        // foreach ($data as $s) {
        //     $ambil_harga_kontrak += $s->konstruksi->harga_kontrak;
        //     $ambil = $ambil_harga_kontrak + $ambil_harga_kontrak;
        // }
        // dd($ambil);
        $params = array(
            'transaction_details' => array(
                'order_id' => rand(),
                'gross_amount' => $harga,
            ),
            'customer_details' => array(
                'first_name' => $name,
                'last_name' => '',
                'email' => $email,
                'phone' => $telepon,
            ),
        );

        $snapToken = \Midtrans\Snap::getSnapToken($params);
        
        return view('payment.transaksi', compact('data'), ['snap_token'=>$snapToken]);
        
    }

    public function transaksiPost(Request $request, ChooseKonstruksi $choose)
    {
        $data = ChooseKonstruksi::with('cabang.kontraktor', 'konstruksiOwner.user.owner')->first();
        $json = json_decode($request->get('json'));
        $order = new OrderKontraktor();
        $order->konstruksiOwnerId = $data->konstruksiOwner->id;
        $order->ownerId = $data->konstruksiOwner->user->owner->id;
        $order->kontraktorId = $data->cabang->kontraktor->id;
        $order->konstruksiId = $data->cabang->id;
        $order->status = 0;
        $order->status_order = $json->transaction_status;
        $order->transaction_id = $json->transaction_id;
        $order->order_id = $json->order_id;
        $order->gross_amount = $json->gross_amount;
        $order->payment_type = $json->payment_type;
        $order->payment_code = isset($json->payment_code) ? $json->payment_code : null;
        $order->pdf_url = isset($json->pdf_url) ? $json->pdf_url : null;
        return $order->save() ? redirect('/')->with('alert-success', 'Order berhasil dibuat') : redirect('/')->with('alert-failed', 'Terjadi kesalahan');
    }

    public function viewTransaksi()
    {
        return view('payment.transaksi');
    }
}
