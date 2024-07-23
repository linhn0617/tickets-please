<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginUserRequest;
use App\Http\Requests\ApiLoginRequest;
use App\Models\User;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use ApiResponses;

    public function login(LoginUserRequest $request){
        $request->validated($request->all());

        if(!Auth::attempt($request->only('email', 'password'))){
            return $this->error('Invalid credentials', 401);
        }

        $user = User::firstwhere('email', $request->email);

        return $this->ok(
            'Authenticated',
            [
                'token' => $user->createToken(
                    'API token for '. $user->email,
                    ['*'],
                    now()->addMonth())->plainTextToken
            ]
            );
    }

    public function logout(Request $request){
        //刪除該使用者所有的token
        //$request->user()->tokens()->delete();

        //刪除特定的token
        //$request->user()->tokens()->where('id', $tokenId)->delete();

        //刪除該使用者現在的token
        $request->user()->currentAccessToken()->delete();

        return $this->ok('');
    }

    
}
