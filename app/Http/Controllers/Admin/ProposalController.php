<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TenderKonsultan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class ProposalController extends Controller
{
    public function putVerifyProp(TenderKonsultan $proposal)
    {
        $data = TenderKonsultan::where('id', $proposal->id)->update(['status' => 2]);
        return $data;
    }
    public function showTenderWin(TenderKonsultan $proposal)
    {
        return TenderKonsultan::with('konsultan.user', 'konsultan.projects.images', 'lelang.owner.user')->where('id', $proposal->id)->first();
    }

    public function showAllTenderWin(Request $request)
    {
        if ($request->ajax()) {
            $data = TenderKonsultan::where('status', 1)->with('konsultan.user', 'konsultan.projects.images', 'lelang.owner.user')->get();

            return DataTables::of($data)
                ->addIndexColumn()->addColumn('tanggal', function ($data) {
                $createdAt = Carbon::parse($data->updated_at);
                return $createdAt->format('d M Y');
                })->addColumn('Aksi', function ($data) {
                    $btn = '<a href="#" class="btn btn-warning btn-sm mr-1" data-toggle="modal" data-target="#modalViewUser"
                    data-id="' . $data->id . '" id="viewUser">View</a>';
                    return $btn;
                })->rawColumns(['Aksi'])->make(true);
        }
    }
}
