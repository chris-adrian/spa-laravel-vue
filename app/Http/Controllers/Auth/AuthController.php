<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\TokenRequest;
use App\Http\Requests\UserCreateRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Profile;
use Illuminate\Support\Facades\DB;
use Exception;

class AuthController extends Controller
{

    public function user(Request $request)
    {   
        try {
            $user = $request->user();
            $user->profile()->value('middle_name') ? $query = ['first_name', 'middle_name', 'last_name']: $query = ['first_name','last_name'];
            $fname = $user->profile()->get($query);
            
            return response()->json([
                // 'username' => $user->username,
                // 'email' => $user->email,
                'fullname' => $fname[0],
                'id' => $user->id,
                'role' => $user->role,
            ]);
        } catch (Exception $e) {
            throw new HttpResponseException(response()->json(null, JsonResponse::HTTP_UNAUTHORIZED));
        }         
    }

    public function create(UserCreateRequest $request)
    {
        $request = $request->validated();
    
        if(!$request['middle_name']) {
            if(Profile::where([
                ['first_name', $request['first_name']],
                ['last_name', $request['last_name']]
            ])->exists()) {
                throw new HttpResponseException(response()->json([
                    'errors'=> [
                        'message' => "Combination of FIRST and LAST names already exist, Please provide a middle name as well.",
                        'middle_name' => 'Provide a middle name'
                    ]
                ], JsonResponse::HTTP_CONFLICT));
            } else {
                return $this->createUser($request);
            }
        } else {
            if(Profile::where([
                ['first_name', $request['first_name']],
                ['middle_name', $request['middle_name']],
                ['last_name', $request['last_name']]
            ])->exists()) {
                throw new HttpResponseException(response()->json([
                    'errors'=> [
                        'message' => 'The full name already exists. (More actions needed)',
                        'full_name' => 'Full name is taken',
                        'redirect' =>'/'.$request['first_name'].'.'.$request['middle_name'].'.'.$request['last_name']
                    ]
                ], JsonResponse::HTTP_CONFLICT));
            } else {
                return $this->createUser($request);
            }
        }  
    }

    public function signin(TokenRequest $request) 
    {
        if (!$token = auth()->attempt(request()->only('username','password'))) {
            throw new HttpResponseException(response()->json([
                'errors'=> [
                    'message'=>'Incorrect Credentials'
                ]
            ], JsonResponse::HTTP_UNAUTHORIZED));
        }

        return response()->json(compact('token'));
    }

    public function signout() 
    {
        auth()->logout();
    }

    private function createUser($request) {
        try {
            $user = User::create([
                'username' => $request['username'],
                'password' => Hash::make($request['password']),
                'email' => $request['email']
            ]);
    
            $user->profile()->create([
                'first_name' => $request['first_name'],
                !$request['middle_name'] ?: 'middle_name' => $request['middle_name'],
                'last_name' => $request['last_name'],
            ]);
        } catch (Exception $e) {
            throw new HttpResponseException(response()->json([
                'errors'=> [
                    'message'=>'Registration failed'
                ]
            ], JsonResponse::HTTP_BAD_REQUEST));
        }
        return true;
    }
}
