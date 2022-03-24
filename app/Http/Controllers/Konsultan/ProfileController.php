<?php

namespace App\Http\Controllers\Konsultan;

use App\Http\Controllers\Controller;
use App\Models\Konsultan;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function show(User $user)
    {
   
        return User::with('konsultan')->where('id', $user->id)->first();
    
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {

        return view('konsultan.profile', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string',
            'username' => 'required|unique:users,username,' . Auth::user()->id,
            'email' => 'required|string|email',
            'telepon' => ['max:13|min:12|nullable', Rule::unique('konsultans')->ignore(Auth::user()->id, 'userId')],
            'website' => ['nullable',Rule::unique('konsultans')->ignore(Auth::user()->id, 'userId')],
            'instagram' => ['nullable',Rule::unique('konsultans')->ignore(Auth::user()->id, 'userId')],
            'about' => 'nullable|string|min:100',
        ]);
        $fields = [
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
        ];
        $input =[
            'telepon'=>$request->telepon,
            'website'=>$request->website,
            'instagram'=>$request->instagram,
            'about'=>$request->about,
        ];
        User::firstWhere('id', $user->id)->update($fields);
        Konsultan::firstWhere('userId',$user->id)->update($input);
        return 1;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, User $user)
    {
        User::destroy($user->id);
        $request->session()->flush();
        Auth::logout();
        return redirect()->intended(route('login'));
    }

    public function gantiAva(Request $request, User $user)
    {
        $img = $request->file('avatar');
        $filename = $img->hashName();
        $path = 'img/avatar/';
        $request->validate([
            'avatar' => 'required|mimes:jpg,jpeg,png'
        ]);
        if ($img) {
            $img->storeAs($path, $filename, 'files');
            if ($user->avatar != "default.png") {
                Storage::disk('files')->delete($path . '/' . $user->avatar);
            }
        }

        return User::firstWhere('id', $user->id)->update(['avatar' => $filename]);
    }

    public function confirmPass(Request $request, User $user)
    {


        if (password_verify($request->oldpass, $user->password)) {

            return response()->json(['status' => true]);
        }
        return response()->json(['status' => false]);
    }

    public function updatePass(Request $request, User $user)
    {
        $pass = Hash::make($request->newpass_confirmation);
        $request->validate([
            'newpass' => 'required|min:8|confirmed',
            'newpass_confirmation' => 'required|min:8'
        ]);
        return User::firstWhere('id', $user->id)->update(['password' => $pass]);
    }
}
