<?php

namespace App\Http\Controllers\Konsultan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LelangOwner;

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
}
