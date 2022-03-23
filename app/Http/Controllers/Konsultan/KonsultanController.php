<?php

namespace App\Http\Controllers\Konsultan;

use App\Http\Controllers\Controller;
use App\Models\LelangOwner;
use App\Models\Project;
use Illuminate\Http\Request;

class KonsultanController extends Controller
{
    public function dashboard()
    {
        return view('konsultan.dashboard');
    }
    public function project()
    {
     
       return view('konsultan.project');
    }
    public function lelangKons()
    {
        return view('konsultan.lelang');

    }
    public function detilLelang(LelangOwner $lelang )
    {
        
        return view('konsultan.detil-lelang');
    }
    public function lelangOwner()
    {
        return view('konsultan.owner-lelang');
    }
    public function archivedJob()
    {
        return view('konsultan.archived-job');
    }
    public function activeJob()
    {
        return view('konsultan.active-job');
    }
    public function activeProposal()
    {
        return view('konsultan.active-proposal');
        
    }
    public function submitProposal()
    {
        return view('konsultan.submit-proposal');
        
    }
    public function archivedProposal()
    {
        return view('konsultan.archived-proposal');
        
    }
    public function detilJob(Project $project)
    {
    
        return view('konsultan.detil-job');
    }
}
