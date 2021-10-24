<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Validator;
use JWTAuth;
use JWTFactory;
use Carbon\Carbon;
use Tymon\JWTAuth\Claims\Issuer;
use Tymon\JWTAuth\Claims\IssuedAt;
use Tymon\JWTAuth\Claims\Expiration;
use Tymon\JWTAuth\Claims\NotBefore;
use Tymon\JWTAuth\Claims\JwtId;
use Tymon\JWTAuth\Claims\Subject;

class AuthController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    } 

    public function login(Request $request){
        $credentials = $request->only('email', 'password');
        // dd($credentials);
        $token = null;
        try {
           if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['invalid_email_or_password'], 422);
           }
        } catch (JWTAuthException $e) {
            return response()->json(['failed_to_create_token'], 500);
        }
        return response()->json([
            'token' => $token,
            'status' => 200
        ]);
    }

    public function getUserInfo(Request $request)
    {
        $user = JWTAuth::toUser($request->token);
        return response()->json(['result' => $user, 'status' => 200]);
    }

    public function getTokenFromOtherAttributes()
    {
        $data = [
            'email' => 'yen@gmail.com',
            'name' => 'Yen',
        ];

        $customClaims = JWTFactory::customClaims($data);
        $payload = JWTFactory::make($data);
        $token = JWTAuth::encode($payload);

        // echo $token;
        return response()->json([
            'data' => $token->get(),
            'status' => 200
        ]);

    }

}
