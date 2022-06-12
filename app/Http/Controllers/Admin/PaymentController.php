<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KonstruksiOwner;
use App\Models\Order;
use App\Models\OrderKontraktor;
use App\Models\PaymentKonsultan;
use App\Models\ProjectOwner;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PaymentController extends Controller
{
    public function getAllPayment(Request $req)
    {
        if ($req->ajax()) {
            $data = PaymentKonsultan::with('kontrak.proposal.lelang.owner.user','kontrak.projectOwner.project.konsultan.user')->where('status', 0)->get();

            return DataTables::of($data)
                ->addIndexColumn()->addColumn('Aksi', function ($data) {
                    $btn = '<a href="#" class="btn btn-warning btn-sm mr-1" id="verify" data-id="'.$data->id.'">Verifikasi</a>';
                    return $btn;
                })->addColumn('bukti',function ($data)
                {
                    $bukti = "<div class='chocolat-parent'> <a target='_blank' href='".asset('img/payment/konsultan/'.$data->buktiBayar)."' class='chocolat-image' title='".$data->buktiBayar."'>
                        <div data-crop-image='285'>
                          <img alt='image' src='".asset('img/payment/konsultan/'.$data->buktiBayar)."' class='img-fluid' width='100'>
                        </div>
                      </a>
                    </div>";
                    return $bukti;
                })->addColumn('tanggal', function ($data) {
                    return Carbon::parse($data->created_at)->isoFormat('dddd, D MMMM YYYY');
            })->addColumn('jumlah', function ($data) {
                return "Rp".number_format(($data->kontrak->proposal->tawaranHargaDesain + $data->kontrak->proposal->tawaranHargaRab),00,',','.');
            })->rawColumns(['Aksi','bukti','tanggal','jumlah'])->make(true);
        }
    }

    public function getAllOrder(Request $req, Order $order)
    {
        if ($req->ajax()) {
            $data = Order::with('owner.user','kontrak.projectOwner.project.konsultan.user')->where('status', "Belum Bayar")->get();
            // $order = ProjectOwner::where('status', "Sudah Bayar")->first();
            return DataTables::of($data)
                ->addIndexColumn()->addColumn('Aksi', function ($data) {
                $btn = '<a href="#" class="btn btn-warning btn-sm mr-1" data-toggle="modal" data-target="#modalViewUser"
                    data-id="' . $data->id . '" id="viewUser">View</a>';
                    if ($data->is_active != 0) {
                        return $btn .= '<button href="#" class="btn btn-primary mr-1 btn-sm" disabled>Terverifikasi</button>';
                    }
                    $btn .= '<a href="#" class="btn btn-primary mr-1 btn-sm" id="verify" data-id="' . $data->id . '">Verifikasi</a>';
                    return $btn;
                // })->addColumn('status', function ($projectOwner) {
                //     // $status = $order->status
                //     // $order = ProjectOwner::where('id',$projectOwner->id)->where('status', "Sudah Bayar")->first();
                //     // $status = $order->status;
                //     return $order;
                })->addColumn('tanggal', function ($data) {
                    return Carbon::parse($data->created_at)->isoFormat('dddd, D MMMM YYYY');
                })->addColumn('jumlah', function ($data) {
                    return "Rp".number_format(($data->gross_amount),00,',','.');
                })->rawColumns(['Aksi','tanggal','jumlah'])->make(true);
        }
    }

    public function getAllArchievedOrder(Request $req, Order $order)
    {
        if ($req->ajax()) {
            $data = Order::with('owner.user','kontrak.projectOwner.project.konsultan.user')->where('status', "Sudah Bayar")->get();
            // $order = ProjectOwner::where('status', "Sudah Bayar")->first();
            return DataTables::of($data)
                ->addIndexColumn()->addColumn('Aksi', function ($data) {
                $btn = '<a href="#" class="btn btn-warning btn-sm mr-1" data-toggle="modal" data-target="#modalViewUser"
                    data-id="' . $data->id . '" id="viewUser">View</a>';
                    if ($data->is_active != 0) {
                        return $btn .= '<button href="#" class="btn btn-primary mr-1 btn-sm" disabled>Terverifikasi</button>';
                    }
                    $btn .= '<a href="#" class="btn btn-primary mr-1 btn-sm" id="verify" data-id="' . $data->id . '">Verifikasi</a>';
                    return $btn;
                // })->addColumn('status', function ($projectOwner) {
                //     // $status = $order->status
                //     // $order = ProjectOwner::where('id',$projectOwner->id)->where('status', "Sudah Bayar")->first();
                //     // $status = $order->status;
                //     return $order;
                })->addColumn('tanggal', function ($data) {
                    return Carbon::parse($data->created_at)->isoFormat('dddd, D MMMM YYYY');
                })->addColumn('jumlah', function ($data) {
                    return "Rp".number_format(($data->gross_amount),00,',','.');
                })->rawColumns(['Aksi','tanggal','jumlah'])->make(true);
        }
    }

    public function getAllTransaksi(Request $req)
    {
        if ($req->ajax()) {
            $data = OrderKontraktor::with('owner.user','kontrak.konstruksiOwner.cabang.kontraktor.user')->where('status', "Belum Bayar")->get();

            return DataTables::of($data)
                ->addIndexColumn()->addColumn('Aksi', function ($data) {
                $btn = '<a href="#" class="btn btn-warning btn-sm mr-1" data-toggle="modal" data-target="#modalViewUser"
                    data-id="' . $data->id . '" id="viewUser">View</a>';
                    if ($data->is_active != 0) {
                        return $btn .= '<button href="#" class="btn btn-primary mr-1 btn-sm" disabled>Terverifikasi</button>';
                    }
                    $btn .= '<a href="#" class="btn btn-primary mr-1 btn-sm" id="verify" data-id="' . $data->id . '">Verifikasi</a>';
                    return $btn;
                })->addColumn('tanggal', function ($data) {
                    return Carbon::parse($data->created_at)->isoFormat('dddd, D MMMM YYYY');
                })->addColumn('jumlah', function ($data) {
                    return "Rp".number_format(($data->gross_amount),00,',','.');
                })->rawColumns(['Aksi','tanggal','jumlah'])->make(true);
        }
    }

    public function getAllArchievedTransaksi(Request $req)
    {
        if ($req->ajax()) {
            $data = OrderKontraktor::with('owner.user','kontrak.konstruksiOwner.cabang.kontraktor.user')->where('status', "Sudah Bayar")->get();

            return DataTables::of($data)
                ->addIndexColumn()->addColumn('Aksi', function ($data) {
                $btn = '<a href="#" class="btn btn-warning btn-sm mr-1" data-toggle="modal" data-target="#modalViewUser"
                    data-id="' . $data->id . '" id="viewUser">View</a>';
                    if ($data->is_active != 0) {
                        return $btn .= '<button href="#" class="btn btn-primary mr-1 btn-sm" disabled>Terverifikasi</button>';
                    }
                    $btn .= '<a href="#" class="btn btn-primary mr-1 btn-sm" id="verify" data-id="' . $data->id . '">Verifikasi</a>';
                    return $btn;
                })->addColumn('tanggal', function ($data) {
                    return Carbon::parse($data->created_at)->isoFormat('dddd, D MMMM YYYY');
                })->addColumn('jumlah', function ($data) {
                    return "Rp".number_format(($data->gross_amount),00,',','.');
                })->rawColumns(['Aksi','tanggal','jumlah'])->make(true);
        }
    }

    public function verifyPayment(Request $request)
    {
        return PaymentKonsultan::find($request->id)->update(['status' => 1]);
    }
    
    public function verifyOrder(Request $request)
    {
        return Order::find($request->id)->update(['status' => "Sudah Bayar"]);
    }

    public function unverifyOrder(Request $request)
    {
        return Order::find($request->id)->update(['status' => "Belum Bayar"]);
    }

    public function verifyTransaksi(Request $request)
    {
        return OrderKontraktor::find($request->id)->update(['status' => "Sudah Bayar"]);
    }

    public function unverifyTransaksi(Request $request)
    {
        return OrderKontraktor::find($request->id)->update(['status' => "Belum Bayar"]);
    }
}