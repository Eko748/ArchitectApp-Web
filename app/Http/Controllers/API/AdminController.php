<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Models\Konsultan;
use App\Models\Kontraktor;
use App\Models\PaymentKonsultan;
use App\Models\ProjectOwner;
use App\Models\TenderKonsultan;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends BaseController
{
    public function getAllPro()
    {
        $data = User::with('konsultan')->where('level', 'konsultan')->with('kontraktor')->orWhere('level', 'kontraktor')->get();
        return $this->sendResponse($data, 'data loaded successfully');
    }
    public function getAllKonsultan()
    {
        $data = Konsultan::with('user', 'files')->orderBy('id', 'DESC')->get();
        return $this->sendResponse($data, 'data loaded successfully');
    }
    public function getAllKontraktor()
    {
        $data = Kontraktor::with('user', 'files')->orderBy('id', 'DESC')->get();
        return $this->sendResponse($data, 'data loaded successfully');
    }

    public function verifikasiPro(Request $request, User $user)
    {
        $input = [
            'is_active' => $request->isActive,
        ];
        $user = User::firstWhere('id', $user->id)->update($input);
        if ($user) {
            return $this->sendResponse($user, 'Berhasil memverifikasi data');
        }
        return $this->sendError('', ['error' => 'Gagal memverifikasi data'], 400);
    }

    public function verifikasiLelang(Request $request)
    {
        $data = TenderKonsultan::where('lelangOwnerId',$request->lelangOwnerId)->update(['status'=> 2]);
        return $this->sendResponse($data,'Sudah ter acc');
    }
    
    public function getAllProposal()
    {
        $data = TenderKonsultan::where('status',1)->with('lelang.owner.user','lelang.image')->get();
        return $this->sendResponse($data,'Data Proposal');

    }
    public function getPaymentKonsultan()
    {
        $data = PaymentKonsultan::with('kontrak.projectOwner.owner.user', 'kontrak.projectOwner.project.konsultan.user')->orderBy('id', 'DESC')->get();
        return $this->sendResponse($data, 'data loaded successfully');
    }
    public function verifPayment(Request $request)
    {
        $payment = tap(PaymentKonsultan::find($request->paymentId))->update(['status'=>1])->first();

        return $this->sendResponse($payment,'verifikasi berhasil');
    }
}
