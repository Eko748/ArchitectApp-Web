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

    public function rules()
    {
        return [
            'title' => 'required|min:3',
            'desc' => 'required',
            'budget' => 'required',
            'images' => 'required|mimes:jpg,jpeg,png',
            'desain' => 'required',
            'rab' => 'required'
        ];
    }

    public function fields($title, $desc, $slug, $budget)
    {
        return [
            'title' => $title,
            'description' => $desc,
            'slug' => $slug,
            'konsultanId' => $this->getKonsultanId()->konsultan->id,
            'budget' => $budget,
            'status' => "0"
        ];
    }
    

}
