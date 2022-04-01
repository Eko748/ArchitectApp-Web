<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\FileKonsultan;
use App\Models\Konsultan;
use App\Models\Owner;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }
    public function chooseAccount()
    {
        return view('auth.choose');
    }
    public function registerKosultan()
    {
        return view('auth.register-konsultan');
    }
    public function registerKontraktor()
    {
        return view('auth.register-kontaktor');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|min:3|unique:users,username',
            'password' => 'required|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'avatar' => 'default.png',
            'level' => 'owner',
            'is_active' => 0,
        ]);
        Owner::create(['userId' => $user->id]);
        event(new Registered($user));


        return redirect(route('login'));
    }
    public function storeKonsultan(Request $request)
    {
        $path = 'persyaratan/konsultan/';
        $file = $request->file('file');

        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|min:3|unique:users,username',
            'password' => 'required|min:8',
            'file' => 'required',
            'file.*' => 'mimes:pdf,jpg,jpeg,png'
        ]);
        $input = [
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'avatar' => 'default.png',
            'level' => 'konsultan',
            'is_active' => 0,
        ];
        $user = User::create($input);
        $kons = new Konsultan([
            'userId' => $user->id,
            'slug' => Str::slug($request->name)
        ]);
        $konsultan = $user->konsultan()->save($kons);
        foreach ($file as $item) {
            $item->storeAs($path, $item->hashName(), 'files');
            $files = new FileKonsultan(['konsultanId' => $konsultan->id, 'file' => $item->hashName()]);
            $konsultan->files()->save($files);
        }
        return redirect(route('login'));
    }
    public function storeKontraktor(Request $request)
    {
        $path = 'persyaratan/kontraktor/';
        $file = $request->file('file');

        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|min:3|unique:users,username',
            'password' => 'required|min:8',
            'file' => 'required|mimes:pdf,jpg,jpeg,png'
        ]);
        $input = [
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'avatar' => 'default.png',
            'level' => 'kontraktor',
            'is_active' => 0,
        ];
        $file->storeAs($path, $file->hashName(), 'files');
        $user = User::create($input);
        return redirect(route('login'));
    }
}
