<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Konsultan;
use App\Models\User;
use App\Models\Owner;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function updateProfile(Request $request, User $user)
    {
        // $validator = Validator::make($request->all(), [
        //     'name' => 'required',
        //     'telepon' => 'required',
        //     'alamat' => 'required',
        // ]);
            
        // if ($validator->fails()) {
        //     return $this->sendError('Validation Error.', $validator->errors());
        // }
        // $input = [
        //     'telepon' => $request->telepon,
        //     'alamat' => $request->alamat,
        // ];
        if ($request->name != null) {
            $data = User::firstWhere('id', $user->id)->update(['name' => $request->name]);
        }
        if ($request->telepon != null) {
            $data = Owner::firstWhere('userId', $user->id)->update(['telepon' => $request->telepon]);
        }
        if ( $request->alamat != null) {
            $data = Owner::firstWhere('userId', $user->id)->update(['alamat' => $request->alamat]);
        }
        if ($data) {
            return $this->sendResponse($data, 'Berhasil mengubah profil');
        }
        return $this->sendError('', ['error' => 'Gagal mengubah profil'], 400);
    }
    public function updateProfileConsultant(Request $request, User $user)
    {
        if ($request->name != null) {
            $data = User::firstWhere('id', $user->id)->update(['name' => $request->name]);
        }
        if ($request->telepon != null) {
            $data = Konsultan::firstWhere('userId', $user->id)->update(['telepon' => $request->telepon]);
        }
        if ( $request->alamat != null) {
            $data = Konsultan::firstWhere('userId', $user->id)->update(['alamat' => $request->alamat]);
        }
        if ($request->website != null) {
            $data = Konsultan::firstWhere('userId', $user->id)->update(['website' => $request->website]);
        }
        if ( $request->instagram != null) {
            $data = Konsultan::firstWhere('userId', $user->id)->update(['instagram' => $request->instagram]);
        }
        if ( $request->about != null) {
            $data = Konsultan::firstWhere('userId', $user->id)->update(['about' => $request->about]);
        }
        if ($data) {
            return $this->sendResponse($data, 'Berhasil mengubah profil');
        }
        return $this->sendError('', ['error' => 'Gagal mengubah profil'], 400);
    }
    public function updatePass(Request $request, User $user)
    {
        $pass = Hash::make($request->newpass_confirmation);
        $validator = Validator::make($request->all(), [
            'newpass' => 'required|min:8|confirmed',
            'newpass_confirmation' => 'required|min:8'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
      
           $data= User::firstWhere('id', $user->id)->update(['password' => $pass]);
           
           return $this->sendResponse($data, 'Berhasil mengubah password anda');
        }
        
        public function gantiAva(Request $request,User $user)
        {
            $ava=$request->file('image');
            $path = 'img/avatar/';
        $validator = Validator::make($request->all(), [
            'image' => 'required|mimes:jpg,jpeg,png'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
      
            if ( $ava->storeAs($path, $ava->getClientOriginalName(),'files')) {
               $data = User::firstWhere('id', $user->id)->update(['avatar' => $ava->getClientOriginalName()]);
            return $this->sendResponse($data, 'Berhasil mengubah avatar');
        }
        return $this->sendError('Failed', 'Gagal mengubah avatar');

        
    }
}
