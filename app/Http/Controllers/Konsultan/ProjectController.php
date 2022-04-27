<?php

namespace App\Http\Controllers\Konsultan;

use App\Http\Controllers\Controller;
use App\Models\Design;
use App\Models\Image;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class ProjectController extends Controller
{

    public function getAllProject(Request $req)
    {

        if ($req->ajax()) {


            $data = Project::with('images')->where('konsultanId', $this->getKonsultanId()->konsultan->id)->get();
            return DataTables::of($data)
                ->addIndexColumn()->addColumn('gambar', function ($data, $index = 0) {
                    if ($data->images->count() == 0) {
                        return $gambar = "Gambar belum di upload";
                    }

                    $gambar = "<img src='" . asset('img/project/' . $data->images[$index]->image) . "' height='50' width='50'>";

                    return $gambar;
                })->addColumn('aksi', function ($data) {
                    $btn = '<button type="button" class="btn btn-primary btn-sm mr-1 btnEditProject"  data-toggle="modal" data-target="#modalEditProject" data-id="' . $data->id . '" onclick="editProject('.$data->id.')">Edit</button><a href="#" class="btn btn-warning btn-sm mr-1" data-toggle="modal" data-target="#modalViewDesign"
                            data-id="' . $data->id . '" id="viewDesign">View</a><a href="#" class="btn btn-danger mr-1 btn-sm" id="hapusProject" data-name="' . $data->title . '" data-id="' . $data->id . '">Hapus</a>';
                    return $btn;
                })->rawColumns(['aksi', 'gambar'])->make(true);
        }
    }
    public function tambahProject(Request $request)
    {

        $slug = Str::of($request->title)->slug('-');

        $path = 'img/project/';

        $request->validate([
            'title' => 'required',
            'desc' => 'required',
            'gayaDesain' => 'required',
            'images' => 'required',
            'harga_rab' => 'required',
            'harga_desain' => 'required',
        ]);
        $input = [
            'title' => $request->title,
            'description' => $request->desc,
            'gayaDesain' => $request->gayaDesain,
            'harga_desain' => $request->harga_desain,
            'harga_rab' => $request->harga_rab,
            'slug' => $slug,
            'isLelang' => "0",
            'konsultanId' => $this->getKonsultanId()->konsultan->id,
        ];
        $project = Project::create($input);

        if ($request->hasFile('images')) {
            $img = $request->file('images');
            foreach ($img as $key) {
                $filename = $key->hashName();
                $key->storeAs($path, $filename, 'files');
                $images = Image::create(['projectId' => $project->id, 'image' => $filename]);
            }

            return 1;
        }
    }

    public function editProject(Request $req, Project $design)
    {
        $slug = Str::of($req->title)->slug('-');
        $img = $req->file('images');
        $path = 'img/project/';
        $filename = $img;
        $req->validate([
            'title' => 'required|unique:designs,title,' . $design->id,
            'desc' => 'required',
            'images' => 'required||mimes:jpg,jpeg,png',
        ]);
        if ($req->hasFile('images')) {
            $img->storeAs($path, $filename, 'files');
        }
        $input = [
            'title' => $req->title,
            'desc' => $req->desc,
            'images' => $filename,
            'slug' => $slug,
            'userId' => Auth::user()->id,
        ];
        return Project::where('userId', Auth::user()->id)->update($input);
    }

    public function destroy(Project $project)
    {
        Storage::disk('files')->delete($project);
        Image::where('projectId', $project->id)->delete();
        Project::destroy($project->id);
        return 1;
    }

    public function show(Project $design)
    {
        return $design;
    }

    public function fields($title, $desc, $slug, $rabPrice, $designPrice)
    {
        return [
            'title' => $title,
            'description' => $desc,
            'slug' => $slug,
            'konsultanId' => $this->getKonsultanId()->konsultan->id,
            'harga_rab' => $rabPrice,
            'harga_desain' => $designPrice,
            'isLelang' => "0"
        ];
    }

    public function rules()
    {
        return [
            'title' => 'required|unique:projects,title',
            'desc' => 'required',
            'images' => 'required|mimes:jpg,jpeg,png',
            'desainPrice' => 'required|numeric',
            'rabPrice' => 'required|numeric',
            'gayaDesain' => 'required'
        ];
    }

    public function edit($id)
    {
        $data = [
            "data_project" => Project::where("id", $id)->first(),
        ];
        return view("modal.project_konsultan.edit_project", $data);
    }

    // public function updateproject(Request $request)
    // {
    //     Project::where("id", $request->id)->update([
    //         "title" => $request->title,
    //         "desc" => $request->description
    //         //image

    //     ]);
    //     return redirect("/konsultan/project")->with("success", "Data Berhasil di Simpan");
    // }
}
