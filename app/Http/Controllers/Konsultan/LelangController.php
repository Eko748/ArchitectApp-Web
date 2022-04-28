<?php

namespace App\Http\Controllers\Konsultan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\LelangOwner;
use App\Models\Owner;
use Illuminate\Support\Facades\Auth;
use App\Models\TenderKonsultan;
use Carbon\Carbon;

class LelangController extends Controller
{
    public function getAllLelangOwner(Request $request)
    {
        if ($request->has('filter')) {
            # code...
        }

        $lelang = LelangOwner::with('owner')->withCount('proposal')->where('status',0)->get();
        return $lelang;
    }

    public function showLelang(LelangOwner $lelang)
    {
        $data = LelangOwner::where('id',$lelang->id)->with('owner','proposal.konsultan')->where('status',0)->first();
        return $data;
    }
    public function showLelangOwner(LelangOwner $lelang)
    {
        $data = LelangOwner::where('id', $lelang->id)->with('owner.user', 'image')->with('proposal.konsultan.user')->withCount('proposal')->first();
        return $data;
    }

    public function allLelangOwner()
    {
        $owner = Owner::where('userId', Auth::user()->id)->first();
        $data = LelangOwner::with('owner.user', 'image')->withCount('proposal')->where('ownerId', $owner->id)->where('status', 0)->get();
        return $data;
    }

}
