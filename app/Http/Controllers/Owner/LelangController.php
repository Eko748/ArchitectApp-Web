<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\ImageOwner;
use App\Models\LelangImage;
use App\Models\LelangOwner;
use App\Models\Owner;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LelangController extends Controller
{
    public function rules()
    {
        return [
            'title' => 'required|min:3',
            'desc' => 'required',
            'from' => 'required',
            'to' => 'required',
            'designstyle' => 'required',
            'rab' => 'boolean',
            'desain' => 'boolean',
            'panjang' => 'required|numeric',
            'lebar' => 'required|numeric'

        ];
    }
    public function field(Request $request)
    {

        $data = [
            'ownerId' => $request->ownerId,
            'title' => $request->title,
            'description' => $request->description,
            'budgetFrom' => Str::of($request->from)->replace('.', ''),
            'budgetTo' => Str::of($request->to)->replace('.', ''),
            'RAB' => 0,
            'desain' => 0,
            'gayaDesain' => $request->designstyle,
            // 'kontraktor' => "0",
            // 'status' => 0,
            'panjang' => 8,
            'lebar' => 8,
            // 'luas' => $request->luas
        ];
        if ($request->has('rab')) {
            $data['RAB'] = $request->rab;
        }
        if ($request->has('desain')) {
            $data['desain'] = $request->desain;
        }

        return $data;
    }
    public function postLelang(Request $request)
    {
        // dd($request->luas);
        // $request->validate($this->rules());
        // $data = $this->field($request);
        $lelang = LelangOwner::create($request->all());
        if ($request->hasFile('image')) {
            $img = $request->file('image');
            $path = 'img/lelang/tkp/';
            $no = 1;
            foreach ($img as $key) {
                $filename = Str::slug($request->title) . '-' . Carbon::now()->toDateString() . '-' . $no++ . '.' . $key->getClientOriginalExtension();
                $key->storeAs($path, $filename, 'files');
                $image = new ImageOwner(['lelangOwnerId' => $lelang->id, 'image' => $filename]);
                $lelang->image()->save($image);
            }
            return redirect(route('owner.my.lelang'))->with('msg', 'Lelang sukses ditambahkan');
        }
        return redirect(route('owner.my.lelang'))->with('msg', 'Lelang sukses ditambahkan');
    }

    public function showMyLelang(LelangOwner $lelang)
    {
        $data = LelangOwner::where('id', $lelang->id)->with('owner.user', 'image')->with('proposal.konsultan.user')->withCount('proposal')->first();
        return $data;
    }
    public function AllMyLelang()
    {
        $owner = Owner::where('userId', Auth::user()->id)->first();
        $data = LelangOwner::with('owner.user', 'image')->withCount('proposal')->where('ownerId', $owner->id)->where('status', 0)->get();
        return $data;
    }
}
