<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class Admincontroller extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }
    public function userPage()
    {
        return view('admin.userpage');
    }
    public function proPage()
    {
        return view('admin.propage');
    }
    public function adminPage()
    {
        return view('admin.adminpage');
    }
    public function desainPage()
    {
        
        return view('admin.design');
    }


 
   
    public function show(User $user)
    {
        return response()->json($user);
    }



    public function getTimeLogging()
    {

        $from = Carbon::createFromFormat('Y-m-d H:i:s', Auth::user()->last_login);
        $to = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now());

        $diff = $to->diffInMinutes($from);

        return response()->json(['time' => $diff]);
    }
    public function verifyProp()
    {
        return view('admin.verifyprop');
    }

    public function verifyPayment()
    {
        return view('admin.verify-payment');
    }
}
