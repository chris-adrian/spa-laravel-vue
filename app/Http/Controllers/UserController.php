<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\User;
use App\Profile;
use App\ProfileExtension;
use App\Http\Requests\JustAVeryLongNamedRequestTest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Validator;
use Exception;
use Illuminate\Validation\Rule;
// use App\Http\Middleware\JwtAuthMiddleware;

class UserController extends Controller
{
    public function getInfo(Request $request) 
    {
        try{
            $userRequest = auth()->setRequest($request)->user();
            // Validate Request
            $validator = Validator::make($request->all(), [
                'first_name' => 'required|string|max:255|',
                'middle_name' => 'nullable|string|max:255|',
                'last_name' => 'required|string|max:255|'
            ]);
            if ($validator->fails()) {
                $msg = $validator->errors();
                throw new HttpResponseException(response()->json([
                    'errors'=> $msg
                ], JsonResponse::HTTP_BAD_REQUEST));
            } else {
                $request = $validator->validated();
                $query = [
                    ['first_name', $request['first_name']],
                    ['last_name', $request['last_name']],
                ];
                if(isset($request['middle_name'])) {
                    array_push($query, ['middle_name', $request['middle_name']]);
                }
                // Get User Profile
                try {
                    $userContent = Profile::where($query)->firstOrFail();
                    if($userRequest) {
                        if($userRequest->id == $userContent->user_id) {
                            // User & Requested Profile matched
                            $userContentExt = ProfileExtension::where(['user_id' => $userContent->user_id])->first();
                            return response()->json([
                                'profile'=> $userContent,
                                'profileExtension'=> $userContentExt,
                                'authorization' => 2
                            ], 200);
                        } else {
                            // User & Requested Profile mismatched
                            return response()->json([
                                'profile'=> $userContent,
                                'authorization' => 1
                            ], 200);
                        }
                    } else {
                        // Unauthorized : Guest 
                        return response()->json([
                            'profile'=> $userContent,
                            'authorization' => 0
                        ], 200);
                    }
                } catch (Exception $e) {
                    throw new HttpResponseException(response()->json([
                        'errors'=> [
                            'message' => 'User not found'
                        ]
                    ], JsonResponse::HTTP_BAD_REQUEST));
                }
            }
        } catch (\Throwable $th) {
            throw new HttpResponseException(response()->json([
                'errors'=> [
                    'message' => 'Request error : Failed to fetch user profile information',
                ]
            ], JsonResponse::HTTP_BAD_REQUEST));
        }
    }

    public function account(Request $request) 
    {
        $user = $request->user();
        return response()->json([
            'username' => $user->username,
            'email' => $user->email
        ]);
    }

    public function update(Request $request)
    {
        // try{
            $user = auth()->user();
            $validator = Validator::make($request->all(), [
                'username' => 'nullable|string|min:4|max:100|'.Rule::unique('users')->ignore($user->id),
                'email' => 'nullable|string|email|max:255|'.Rule::unique('users')->ignore($user->id),
                'password' => 'required|string|min:4|max:12',
                'newPassword' => 'nullable|string|min:4|max:12'
            ]);
            
            if ($validator->fails()) {
                $msg = $validator->errors();
                throw new HttpResponseException(response()->json([
                    'errors'=> $msg
                ], JsonResponse::HTTP_BAD_REQUEST));
            } else {
                $request = $validator->validated();
                try {
                    $user->username = $request['username'];
                    $user->email = $request['email'];
                    if($request['newPassword']) {
                        $user->password = Hash::make($request['newPassword']);
                    }
                    $user->save();
                    return response()->json([
                        'message'=> 'Account updated'
                    ], 200);
                } catch (Exception $e) {
                    throw new HttpResponseException(response()->json([
                        'errors'=> [
                            'message' => $e
                        ]
                    ], JsonResponse::HTTP_BAD_REQUEST));
                }
            }  
        // } catch (\Throwable $th) {
        //     throw new HttpResponseException(response()->json([
        //         'errors'=> [
        //             'message' => 'Request error : Failed to update account, please try again',
        //         ]
        //     ], JsonResponse::HTTP_BAD_REQUEST));
        // }  
    }


}
