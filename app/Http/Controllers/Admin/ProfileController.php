<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{

    public function show(User $user)
    {
        return User::with('admin')->where('id', $user->id)->first();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('admin.profile', compact('user'));
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
        ]);
        $fields = [
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
        ];
        return User::firstWhere('id', $user->id)->update($fields);
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
