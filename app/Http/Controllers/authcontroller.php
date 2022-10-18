<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\StoreusertableRequest;
use App\Http\Requests\UpdateusertableRequest;
//use Illuminate\Foundation\Auth\User;

use function Psr\Log\error;

class authcontroller extends Controller
{


    public function createaccount(Request $request)
    {
        $createaccount = validator::make($request->all(),[
            'name'         => ['required','string','max:255'] ,
            'email'        => ['required','string','email','max:255'] ,
            'password'     => ['required','string','min:8'] ,
            'facebook_url' => ['text'],
            'phone'        => ['required','string','max:255'] ,

        ]);
        $request['password']=Hash::make($request['password']);
        $user = User::query()->create([
            'name'          => $request->name,
            'email'         => $request->email,
            'password'      => $request->password,
            'facebook_url'  => $request->facebook_url,
            'phone'         => $request->phone,
        ]);

        //  make token from user
        $tokenResult = $user->createToken('Personal Access Token');
        $token_user = $user->createToken('personal access Token');
        $data["user"]        = $user;
        $data["token_type"]  = 'Bearer';
        $data["access_token"]= $token_user->accessToken;

        return response()->json($data, Response::HTTP_OK);
    }

    public function login(Request $request){
        $email    = $request['email'];
        $password = $request['password'];
            if(!Auth::attempt(['email' => $email, 'password' => $password])){
                throw new AuthenticationException();
            }
            $user = $request->user();

            // make token to user login
            $token_user = $user->createToken('personal access Token');
            $data["user"]        = $user;
            $data["token_type"]  = 'Bearer';
            $data["access_token"]= $token_user->accessToken;

            return response()->json($data, Response::HTTP_OK);
    }


    public function logout(Request $request) {
        $request->user()->token()->delete();
        return response()->json([
            'message'=>'logout done successfully'
        ]);
    }

}


