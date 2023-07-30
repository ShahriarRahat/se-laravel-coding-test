<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function register()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
           'name' => 'required|max:50',
           'email' => 'required|email:rfc,dns|unique:users',
           'password' => 'required|min:6|confirmed',
           'account_type' => 'required',
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                Toastr::error($error);
            }
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'account_type' => $request->account_type,
            ]);

            DB::commit();

            auth()->login($user);
            Toastr::success('Registered Successfully');
            return redirect()->route('home');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            Toastr::error('Sorry! Something went wrong');
            return redirect()->back();
        }

    }

    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
           'email' => 'required|email',
           'password' => 'required',
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                Toastr::error($error);
            }
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        try {
            if (auth()->attempt($request->only('email', 'password'))) {
                return redirect()->route('home');
            }else{
                Toastr::error('Invalid Credentials');
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            //throw $th;
            Toastr::error('Authentication Error');
            return redirect()->back();
        }

    }

    public function logout()
    {
        try {
            auth()->logout();
            Toastr::success('Logged Out Successfully');
            return redirect()->route('home');
        } catch (\Throwable $th) {
            //throw $th;
            Toastr::error('Authentication Error');
            return redirect()->back();
        }
    }
}
