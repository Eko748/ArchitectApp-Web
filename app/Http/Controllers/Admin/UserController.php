<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function getAllUser(Request $req)
    {
        if ($req->ajax()) {
            $data = User::with('owner')->where('level', 'owner')->get();
            
            return DataTables::of($data)
                ->addIndexColumn()->addColumn('Aksi', function ($data) {
                    $btn = '<a href="#" class="btn btn-warning btn-sm mr-1" data-toggle="modal" data-target="#modalViewUser"
                    data-id="' . $data->id . '" id="viewUser">View</a>';
                    return $btn;
                })->rawColumns(['Aksi'])->make(true);
        }
    }

    public function show(User $user)
    {
        return $user;
    }
}
