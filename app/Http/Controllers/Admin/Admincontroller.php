<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Admin;
use App\Models\Owner;
use App\Models\Kontraktor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Konsultan;

class Admincontroller extends Controller
{
    public function index()
    {
        // $data = [
        //     "jumlah_data_admin" => Admin::count(),
        //     "jumlah_data_konsultan" => Konsultan::count(),
        //     "jumlah_data_owner" => Owner::count(),
        //     "jumlah_data_kontraktor" => Kontraktor::count(),

        // ];
        // return view('admin.dashboard', $data);
    }
    public function userPage()
    {
        $data = [
            "userpage" => User::where("level", "owner")->get()
        ];
        return view('admin.userpage', $data);
    }
    public function proPage()
    {
        $data = [
            "propage" => User::where("level", "konsultan")->get()
        ];
        return view('admin.propage', $data);
    }
    public function adminPage()
    {
        $data = [
            "adminpage" => User::where("level", "kontraktor")->get()
        ];
        return view('admin.adminpage', $data);
    }
    public function desainPage()
    {

        return view('admin.design');
    }

    public function deletekonsul($id)
    {
        // $data =
        User::where("id", $id)->delete();
        return redirect('/konsultan')->with('success', "<script>alert('Post deleted successfully')</script>");
    }

    public function deleteowner($id)
    {
        // $data =
        User::where("id", $id)->delete();
        return redirect('/owner')->with('success', "<script>alert('Post deleted successfully')</script>");
    }

    public function deletekontraktor($id)
    {
        // $data =
        User::where("id", $id)->delete();
        return redirect('/kontraktor')->with('success', "<script>alert('Post deleted successfully')</script>");
    }

// eko

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
    public function verifyOrder()
    {
        return view('admin.verify-order');
    }
    public function getArchievedOrder()
    {
        return view('admin.archieved-order');
    }

    public function getVerifyTransaksi()
    {
        return view('admin.verify-transaksi');
    }
    public function getArchievedTransaksi()
    {
        return view('admin.archieved-transaksi');
    }
}
