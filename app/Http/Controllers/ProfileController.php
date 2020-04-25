<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProfileUpdateRequest;
use App\User;
use App\Profile;
use Exception;
use Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
// use Illuminate\Support\Facades\File;

class ProfileController extends Controller
{
    public function update(ProfileUpdateRequest $request) 
    {
        try {
            $user = auth()->setRequest($request)->user();
            $result = $user->profile()->updateOrCreate(['user_id' => $user->id], [
                'first_name' => $request['first_name'],
                'middle_name' => $request['middle_name'],
                'last_name' => $request['last_name'],
                'classification' => $request['classification'],
                'occupation' => $request['occupation'],
                'memo' => $request['memo'],
            ]);
            if($result) {
                $result = $user->profileExtension()->updateOrCreate(['user_id' => $user->id], [
                    'dob' => $request['dob'],
                    'address' => $request['address'],
                    'nationality' => $request['nationality'],
                    'religion' => $request['religion']
                ]);
                if($result) {
                    return response()->json([
                        'message'=> 'Profile Updated'
                    ], 200);
                }
            } else {
                throw new HttpResponseException(response()->json([
                    'errors'=> [
                        'message' => 'Profile Update failed'
                    ]
                ], JsonResponse::HTTP_BAD_REQUEST));
            }
        } catch (Exception $e) {
            throw new HttpResponseException(response()->json([
                'errors'=> [
                    'message' => 'Request error : Failed to update profile, please try again.'
                ]
            ], JsonResponse::HTTP_BAD_REQUEST));
        } 
    }

    public function imageUpdate(Request $request) 
    {
        try {
            $user = auth()->setRequest($request)->user();
            $profile = Profile::where(['user_id' => $user->id ])->firstOrFail();

            $validator = Validator::make($request->all(), [
                'image' => [ 'required', 'image', 'max:1000'],
            ]);
            
            if ($validator->fails()) {
                $msg = $validator->errors();
                throw new HttpResponseException(response()->json([
                    'errors'=> $msg
                ], JsonResponse::HTTP_BAD_REQUEST));
            } else {
                // Remove current profile & thumbnail
                if(isset($profile->image)) {
                    if (Storage::delete('public/'.$profile->image)) {
                        if(!Storage::delete('public/profiles/thumbnails/'.$user->id.'-thumb.png')) {
                            throw new HttpResponseException(response()->json([
                                'errors'=> [
                                    'message' => 'failed to remove profile thumbnail'
                                ]
                            ], JsonResponse::HTTP_BAD_REQUEST));
                        }
                    } else {
                        throw new HttpResponseException(response()->json([
                            'errors'=> [
                                'message' => 'failed to remove profile image'
                            ]
                        ], JsonResponse::HTTP_BAD_REQUEST));
                    }
                }
                // Save profile image
                $imagePath = $request->image->storeAs('profiles', $user->id.'-img.'.$request->image->guessExtension(), 'public');
                $image = Image::make(storage_path("app/public/{$imagePath}"))->fit(400,400);
                $image->save();
                // Create thumbnail image.
                $thumbPath = $request->image->storeAs('profiles/thumbnails', $user->id.'-thumb.png', 'public');
                $imageThumb = Image::make(storage_path("app/public/{$thumbPath}"))->encode('png', 65)->fit(50,50);
                $imageThumb->save();
                // Update Query
                $profile->updateOrCreate(['user_id' => $user->id], [
                    'image' => $imagePath,
                ]);
                // Response
                return response()->json([
                    'message'=> 'Profile image updated'
                ], 200);
            }
        } catch (Exception $e) {
            throw new HttpResponseException(response()->json([
                'errors'=> [
                    'message' => 'Request error : Failed to update profile image, please try again.'
                ]
            ], JsonResponse::HTTP_BAD_REQUEST));
        } 
    }
}
