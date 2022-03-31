<?php

namespace App\Http\Controllers\Kontraktor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\LelangOwner;
use App\Models\TenderKontraktor;
use Carbon\Carbon;

class LelangController extends Controller
{
    public function getAllLelangOwner(Request $request)
    {
        if ($request->has('filter')) {
            # code...
        }

        $lelang = LelangOwner::with('owner')->withCount('proposal')->get();
        return $lelang;
    }

    public function showLelang(LelangOwner $lelang)
    {
        $data = LelangOwner::where('id',$lelang->id)->with('owner')->first();
        return $data;
    }
   
}
