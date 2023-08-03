<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;


class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $this->validate($request,[
            'email' => 'required',
            'password' => 'required',
        ]);
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            try {
                if (!$token = JWTAuth::attempt($credentials))
                    return response()->json([
                        'error' => 'Credenciales invalidas'
                    ], 400);

            } catch (JWTException $e) {
                return response()->json([
                    'error' => 'Token no creado'
                ], 500);
            }

            $userData = Auth::user();
            $name = $userData->userData['name'];
            $email= $userData->userData['email'];


            return view('auth.dashboard', compact('name','email','token'));

        }

        return response()->json([
            'error' => 'Credenciales invalidas'
        ], 400);


    }

    public function logout(Request $request)
    {
        $validator = Validator::make($request->only('token'), [
            'token' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }

        try {

            JWTAuth::invalidate($request->token);
            return response()->json([
                'success' => true,
                'message' => 'Usuario desconectado'
            ]);

        } catch (JWTException $exception) {


            return response()->json([
                'success' => false,
                'message' => 'Error'
            ], 500);
        }
    }

    public function showLoginForm()
    {
        if (auth()->check()) {

            $userData = Auth::user();
            $name = $userData->userData['name'];
            $email= $userData->userData['email'];

            return view('auth.dashboard', compact('name','email','token'));
        }

        return view('auth.login');
    }

}