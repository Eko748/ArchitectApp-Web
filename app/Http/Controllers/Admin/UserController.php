<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Admin;
use App\Models\Owner;
use App\Models\Kontraktor;
use App\Models\Konsultan;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function lastLogin()
    {
        $data = [
            "jumlah_data_order" => Order::count(),
            "jumlah_data_konsultan" => Konsultan::count(),
            "jumlah_data_owner" => Owner::count(),
            "jumlah_data_kontraktor" => Kontraktor::count(),
        ];
        $users = User::select("*")
                        ->whereNotNull('last_seen')
                        ->orderBy('last_seen', 'DESC')
                        ->paginate(10);
        
        return view('admin.dashboard', compact('users'), $data);
    }

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
