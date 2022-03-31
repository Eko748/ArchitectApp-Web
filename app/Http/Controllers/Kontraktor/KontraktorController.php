<?php

namespace App\Http\Controllers\Kontraktor;

use App\Http\Controllers\Controller;
use App\Models\LelangOwner;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class KontraktorController extends Controller
{
    public function dashboard()
    {
        return view('kontraktor.dashboard');
    }
    public function lelangKons()
    {
        return view('kontraktor.lelang');

    }
    public function detilLelang(LelangOwner $lelang )
    {
        return view('kontraktor.detil-lelang');
    }
    public function lelangOwner()
    {
        return view('kontraktor.owner-lelang');
    }
    public function archivedJob()
    {
        return view('kontraktor.archived-job');
    }
    public function activeJob()
    {
        return view('kontraktor.active-job');
    }
    public function activeProposal()
    {
        return view('kontraktor.active-proposal');
        
    }
    public function submitProposal()
    {
        return view('kontraktor.submit-proposal');
        
    }
    public function archivedProposal()
    {
        return view('kontraktor.archived-proposal');
        
    }
}
