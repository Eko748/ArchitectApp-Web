<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Kontraktor;
use App\Models\LelangKonsultan;
use App\Models\Project;
use App\Models\TenderKontraktor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KontraktorController extends Controller
{
    public function getProjectByKontra(Request $request)
    {
        $data = Project::where('konsultanId', $this->getKonsId($request))->get();
        return $this->sendResponse($data, 'data loaded successfully');
    }

    public function getAllLelangKons()
    {
        $data = LelangKonsultan::all();
        return $this->sendResponse($data, 'data loaded successfully');
    }
    public function postProposal(Request $request)
    {
        $cv = $request->file('cv');
        $path = 'img/tender/kontraktor/cv/';
        $filename = $request->user()->name . '-' . Carbon::now()->toDateString() . '.' . $cv->getClientOriginalExtension();
        $validator = Validator::make($request->all(), [

            'coverLetter' => 'required|min:50|string',
            'cv' => 'mimes:pdf,jpg,png,jpeg',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $input = [
            'lelangKonsultanId' => $request->lelangId,
            'kontraktorId' => $this->getKontraId($request)->id,
            'coverLetter' => $request->coverLetter,
            'status' => 0,
            'cv' => $filename
        ];
        $cv->storeAs($path, $filename, 'files');
        $data = TenderKontraktor::create($input);
        return $this->sendResponse($data, 'Lelang berhasil ditambahkan');
    }
    public function getKontraId(Request $request)
    {
        return Kontraktor::where('userId', $request->user()->id)->first();
    }
}
