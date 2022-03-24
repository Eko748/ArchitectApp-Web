<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\LelangOwner;
use App\Models\Owner;
use App\Models\TenderKonsultan;
use Illuminate\Http\Request;

class ProposalController extends Controller
{
    public function checkProposal(TenderKonsultan $proposal)
    {
        $data = TenderKonsultan::with('konsultan.user','konsultan.projects.image','konsultan.files')->where('id',$proposal->id)->first();
        return $data;
    }
    public function chooseProposal(Request $request,TenderKonsultan $proposal)
    {
       
        $data = TenderKonsultan::where('id',$proposal->id)->update(['status'=>1]);
        TenderKonsultan::where('lelangOwnerId', $proposal->lelangOwnerId)->where('status',0)->update(['status' => 3]);
        LelangOwner::where('id',$request->lelangId)->update(['status'=>1]);
        $kontrak = new GeneratePDFController();
        $kontrak->generatePDF($proposal);
        return 1;
    }
}
