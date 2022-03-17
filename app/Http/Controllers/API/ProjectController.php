<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProjectController extends BaseController
{
    public function getAllProject(Request $request)
    {
        if($request->has('filter')){
            $data = Project::where('gayaDesain',$request->filter)->get();         
            return $this->sendResponse($data, 'All project success loaded');
        }
        return $this->sendResponse(Project::all(), 'All project success loaded');
    }

    public function showProject(Project $project)
    {
        $data = Project::where('slug', $project->slug)->orWhere('userId', $project->userId)->get();
        return $this->sendResponse($data, 'project success loaded');
    }

    public function postProject(Request $request)
    {
        $path = 'img/project/';
        $img = $request->file('images');
        $slug= Str::slug($request->title);
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3|string|unique:projects,title',
            'desc' => 'required|min:3|string',
            'images' => 'required|mimes:jpg,png,jpeg',
            'style' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $input = [
            'title' => $request->title,
            'desc' => $request->desc,
            'designStyle' => $request->style,
            'slug' => $slug,
        ];
        if($request->hasFile('images')){
            $img->storeAs($path,$img->hashName(),'files');
            $data = Project::create($input)->get();
            return $this->sendResponse($data,'Project berhasil diupload');
        }
    }
    public function putProject(Request $request,Project $project)
    {
        $path = 'img/project/';
        $img = $request->file('images');
        $slug= Str::slug($request->title);
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3|string|unique:projects,title,'.$project->id,
            'desc' => 'required|min:3|string',
            'images' => 'required|mimes:jpg,png,jpeg',
            'style' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $input = [
            'title' => $request->title,
            'desc' => $request->desc,
            'images' => $img->hashName(),
            'designStyle' => $request->style,
            'slug' => $slug,
            'userId' => $request->user()->id
        ];
        if($request->hasFile('images')){
            $img->storeAs($path,$img->hashName(),'files');
            $data = Project::where('id',$project->id)->update($input)->get();
            return $this->sendResponse($data,'Project berhasil diupdate');
        }
    }

    public function destroy(Project $project)
    {
      
        return $this->sendResponse($project->destroy($project->id),'Project berhasil dihapus');
    }
}
