<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Support\Str;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function registration()
    {
        return view('auth.registration');
    }

    public function login()
    {
        return view('auth.login');
    }

    public function login_post(Request $request)
    {
        // dd($request->all());
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password], true))
        {
            if(Auth::User()->is_role == '2')
            {
                echo "Admin"; die();
                // return redirect()->intended('admin/dashboard');
            } 
            elseif(Auth::User()->is_role == '1')
            {
                echo "Guru"; die();
                // return redirect()->intended('guru/dashboard');
            }
            elseif(Auth::User()->is_role == '0') 
            {
                echo "Siswa"; die();
                // return redirect()->intended('siswa/dashboard');
            }
            else
            {
                return redirect('login')->with('error', 'Email tidak tersedia');
            }
        } else
        {
            return redirect()->back()->with('error', 'tolong masukan data yang benar');

        }
    }

    public function forgot()
    {
        return view(('auth.forgot'));
    }

    public function registration_post(Request $request)
    {
        $user = request()->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|min:6',
            'confirm_password' => 'required_with:password|same:password|min:6',
            'is_role' => 'required'
        ]);

        $user           = new User;
        $user->name     = trim($request->name);
        $user->email    = trim($request->email);
        $user->password = Hash::make($request->password);
        $user->is_role  = trim($request->is_role); 
        $user->remember_token = Str::random(50);
        $user->save();

        return redirect('login')->with('success', 'Berhasil mendaftar');
    }
}
