<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\FileKonsultan;
use App\Models\FileKontraktor;
use App\Models\Konsultan;
use App\Models\Kontraktor;
use App\Models\Owner;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            if ($user->is_active == 1) {
                $success = array();
                if ($user->level == "admin") {
                    $success = [

                        'user' => User::with('admin')->where('id', $user->id)->first(),
                    ];
                } else if ($user->level == "konsultan") {
                    $success = [

                        'user' => User::with('konsultan')->where('id', $user->id)->first(),
                    ];
                } else if ($user->level == "kontraktor") {
                    $success = [

                        'user' => User::with('kontraktor')->where('id', $user->id)->first(),
                    ];
                } else {
                    $success = [
                        'user' => User::with('owner')->where('id', $user->id)->first(),
                    ];
                }
                $success['token'] = $user->createToken('MyApp')->plainTextToken;
                return $this->sendResponse($success, 'User login successfully.');
            } else {
                return $this->sendError('Account not active.', ['error' => 'Akun belum aktif']);
            }
        } else {
            return $this->sendError('Unauthorized.', ['error' => 'Unauthorized']);
        }
    }
    public function daftar(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|min:3',
                'email' => 'required|email|unique:users,email',
                'username' => 'required|min:3|unique:users,username',
                'password' => 'required|min:8',
            ],
            [
                'email.email' => "Email tidak valid",
                'email.unique' => "Email sudah digunakan",
                'username.unique' => "Username sudah digunakan",
            ]
        );

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $input = [
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'avatar' => 'default.png',
            'level' => 'owner',
            'is_active' => $request->isActive
        ];
        $user = User::create($input);
        $owner = Owner::create(['userId' => $user->id]);
        // $data = Owner::with('user')->find($owner->id);
        return $this->sendResponse($user, 'User register successfully');
    }
    public function daftarKonsultan(Request $request)
    {
        $path = 'img/persyaratan/konsultan/';
        $file = $request->file('file');

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|min:3',
                'email' => 'required|email|unique:users,email',
                'username' => 'required|min:3|unique:users,username',
                'password' => 'required|min:8',
                'file' => 'required|mimes:pdf,jpg,jpeg,png'
            ],
            [
                'email.email' => "Email tidak valid",
                'email.unique' => "Email sudah digunakan",
                'username.unique' => "Username sudah digunakan",
                'file.required' => "File tidak boleh kosong",
            ]
        );

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $input = [
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'avatar' => 'default.png',
            'level' => 'konsultan',
            'is_active' => $request->isActive
        ];
        $file->storeAs($path, $file->hashName(), 'files');
        $user = User::create($input);
        $konsultan = Konsultan::create(['userId' => $user->id, 'slug' => Str::slug($input['name'])]);
        FileKonsultan::create(['konsultanId' => $konsultan->id, 'file' => $file->hashName()]);

        // Mengirim notifikasi ke admin
        $admin = User::where('level', 'admin')->first();
          
        $SERVER_API_KEY = 'AAAAODXY9xI:APA91bEJBxQ3kKubZRAQTIoCk_2aYGXE-xNUI571Oka9fIKCBwi-J0p4r__syz4_cpJuVTEDzbCSUJ0YdI_hN66KVjk8MmyqgpwBllRTOnhAGe60DgL08q4D0cdyGCGsumJOacD_crt0';
        // $SERVER_API_KEY = 'AAAAe3lvlps:APA91bEg_-VVYnHn12FPjiuyLzvjAaqCiZZHilXP3XImA99x8oEYJU5MEmndXwi3wcoooBlJml3uwXnTucZ0a0w2jvwI2NCLinqjmF7CxyAd8p6cxXOG4Ebjjw_lQdA8hO1PNJQU5fiY';
  
        $firebase = [
            "to" => $admin->fireBaseToken,
            // "registration_ids" => $user->fireBaseToken,
            "notification" => [
                "title" => "Architect App",
                "body" => "$request->name mendaftar sebagai konsultan. Mohon segera verifikasi!",  
            ]
        ];
        $dataString = json_encode($firebase);
    
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];
    
        $ch = curl_init();
      
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
               
        // curl_exec($ch);
        $response = curl_exec($ch);
        // $data = Konsultan::with('user', 'files')->find($konsultan->id);
        return $this->sendResponse($user, 'User register successfully');
    }
    public function daftarKontraktor(Request $request)
    {
        $path = 'img/persyaratan/kontraktor/';
        $file = $request->file('file');
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|min:3',
                'email' => 'required|email|unique:users,email',
                'username' => 'required|min:3|unique:users,username',
                'password' => 'required|min:8',
                'file.required' => "File tidak boleh kosong",
            ],
            [
                'email.email' => "Email tidak valid",
                'email.unique' => "Email sudah digunakan",
                'username.unique' => "Username sudah digunakan",
            ]
        );

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $input = [
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'avatar' => 'default.png',
            'level' => 'kontraktor',
            'is_active' => $request->isActive
        ];
        $file->storeAs($path, $file->hashName(), 'files');
        $user = User::create($input);
        $kontraktor = Kontraktor::create(['userId' => $user->id]);
        FileKontraktor::create(['kontraktorId' => $kontraktor->id, 'file' => $file->hashName()]);
        // $data = Kontraktor::with('user', 'files')->find($kontraktor->id);
        return $this->sendResponse($user, 'User register successfully');
    }
    public function logout(Request $request)
    {
        $user = User::firstWhere('id', Auth::user()->id)->update(['fireBaseToken' => '-']);
        $request->user()->tokens()->delete();
        return $this->sendResponse($user, 'You have been logged out');
    }

    public function setFirebase(Request $request) 
    {
        $data = User::firstWhere('id', Auth::user()->id)->update(['fireBaseToken' => $request->firebaseToken]);
        return $this->sendResponse($data, 'Berhasil mengirimkan firebase token');
    }
}
