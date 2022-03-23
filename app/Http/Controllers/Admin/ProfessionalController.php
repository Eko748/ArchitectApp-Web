<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\Datatables\Facades\Datatables;

class ProfessionalController extends Controller
{
    public function getAllKontraktor(Request $req)
    {
        if ($req->ajax()) {
            $data = User::with('kontraktor.files')->where('level', 'kontraktor')->get();
            return DataTables::of($data)
                ->addIndexColumn()->addColumn('Aksi', function ($data) {
                $btn = '<a href="#" class="btn btn-warning btn-sm mr-1" data-toggle="modal" data-target="#modalViewUser"
                    data-id="' . $data->id . '" id="viewUser">View</a>';
                if ($data->is_active != 0) {
                    return $btn .= '<button href="#" class="btn btn-primary mr-1 btn-sm" disabled>Terverifikasi</button>';
                }
                $btn .= '<a href="#" class="btn btn-primary mr-1 btn-sm" id="verify" data-id="' . $data->id . '">Verifikasi</a>';
                    return $btn;
                })->rawColumns(['Aksi'])->make(true);
        }
    }
    public function getAllKonsultan(Request $req)
    {
        if ($req->ajax()) {
            $data = User::with('konsultan.files')->where('level', 'konsultan')->get();
            return DataTables::of($data)
                ->addIndexColumn()->addColumn('Aksi', function ($data) {
                $btn = '<a href="#" class="btn btn-warning btn-sm mr-1" data-toggle="modal" data-target="#modalViewUser"
                    data-id="' . $data->id . '" id="viewUser">View</a>';
                    if ($data->is_active != 0) {
                        return $btn .= '<button href="#" class="btn btn-primary mr-1 btn-sm" disabled>Terverifikasi</button>';
                    }
                    $btn .= '<a href="#" class="btn btn-primary mr-1 btn-sm" id="verify" data-id="' . $data->id . '">Verifikasi</a>';
                    return $btn;
                })->rawColumns(['Aksi'])->make(true);
        }
    }
   
    public function show(User $user)
    {
        return response()->json($user);
    }

    public function verifyPro(Request $request)
    {
       
        
        return User::find($request->id)->update(['is_active'=>1]);

    }
}
