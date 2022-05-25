<?php

namespace App\Http\Controllers\Konsultan;

use App\Http\Controllers\Controller;
use App\Models\HasilDesain;
use App\Models\Image;
use App\Models\KontrakKerjaKonsultan;
use App\Models\Project;
use App\Models\ProjectOwner;
use App\Models\Rating;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class JobController extends Controller
{
    public function getAllJob()
    {

        return ProjectOwner::with('project','kontrak.proposal.lelang')->whereHas('project',function (Builder $query)
        {
           $query->where('isLelang','1')->where('konsultanId',$this->getKonsultanId()->konsultan->id);
        })->get();
    }

    public function getArchivedJob()
    {
        return Project::with('projectOwner.hasil', 'projectOwner.kontrak.proposal', 'projectOwner.kontrak.payment')->where('isLelang', "1")->where('konsultanId', $this->getKonsultanId()->konsultan->id)->whereHas('projectOwner',function (Builder $query)
        {
            $query->where('status','1');
        })->get();
    }

    public function getDetilJob(Request $request)
    {
        return Project::with('projectOwner.hasil', 'projectOwner.kontrak.proposal.lelang.image', 'projectOwner.kontrak.payment','projectOwner.owner.user')->where('id',$request->id)->first();
    }

    public function uploadHasil(Request $request)
    {
        $projectOwner = ProjectOwner::find($request->projectOwnerId);
        $request->validate([
            'rab'=>'required',
            'softfile'=>'required'
    ]);
        if ($request->hasFile('rab')) {
            $path = 'img/file hasil/rab/';
            $rab = $request->file('rab');
            $filename = $rab->hashName();
            $rab->storeAs($path, $filename, 'files');
            ProjectOwner::find($request->projectOwnerId)->update(['hasil_rab' => $filename]);
        }
        if ($request->hasFile('softfile')) {
            $file = $request->file('softfile');
            foreach ($file as $key) {
                $path = 'img/file hasil/image/';
                $fileName = $key->hashName();
                $key->storeAs($path, $fileName, 'files');
                HasilDesain::create([
                    'projectOwnerId' => $request->projectOwnerId,
                    'softfile' => $fileName
                ]);
            }
            // Project::find($projectOwner->projectId)->update(['status'=>"1"]);
            return 1;
        }
    }
    public function createProject(Request $request)
    {

        $cekProjectOwner = Project::with('projectOwner.rating', 'projectOwner.hasil')->where('id', $request->projectId)->first();
        $path = "img/project/";
        $oldpath = 'img/file hasil/image/';
        $rabpath = 'img/file hasil/rab/';
        $newrabpath = "img/project/rab/";
        $rates = array();

        $input = [
            'gayaDesain' => $cekProjectOwner->gayaDesain,
            'harga_desain' => $cekProjectOwner->harga_desain,
            'harga_rab' => $cekProjectOwner->harga_rab,
            'isLelang' => "0",
            'konsultanId' => $cekProjectOwner->konsultanId
        ];


        $validator = Validator::make($request->all(), [
            'description' => Rule::requiredIf($request->has('description')),
            'title' =>  Rule::requiredIf($request->has('title')),
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        if ($request->has('description') || $request->has('title')) {
            $input += [
                'description' => $request->description,
                'title' => $request->title,
                'slug' => Str::slug($request->title)
            ];
        } else {
            $input += [
                'description' => $cekProjectOwner->description,
                'title' => $cekProjectOwner->title,
                'slug' => Str::slug($cekProjectOwner->title)
            ];
        }
        $project = Project::create($input);
        $projectOwner = new ProjectOwner([
            'ownerId' => $cekProjectOwner->projectOwner[0]->ownerId,
            'projectId' => $project->id,
            'status' => "1"
        ]);

        if ($cekProjectOwner->projectOwner[0]->hasil_rab != null) {
            $file = $cekProjectOwner->projectOwner[0]->hasil_rab;
            $projectOwner->hasil_rab = $cekProjectOwner->projectOwner[0]->hasil_rab;
            Storage::disk('files')->copy($rabpath . $file, $newrabpath . $file);
        }
        $ownProject =  $project->projectOwner()->save($projectOwner);
        if ($cekProjectOwner->projectOwner[0]->rating->count() != 0) {
            $rating = new Rating([
                'projectOwnerId' => $ownProject->id,
                'rating' => $cekProjectOwner->rating->rating
            ]);
            $rates =  $ownProject->rating()->save($rating);
        }
        if ($cekProjectOwner->projectOwner[0]->hasil != null) {

            foreach ($cekProjectOwner->projectOwner[0]->hasil as $key) {
                $image[] =   Image::create([
                    'projectId' => $ownProject->id,
                    'image' => $key->softfile
                ]);
                Storage::disk('files')->copy($oldpath . $key->softfile, $newrabpath . $key->softfile);
            }
        }
        return $this->sendResponse(compact('project', 'ownProject', 'rates', 'image'), 'Hasil sudah menjadi project');
    }
}
