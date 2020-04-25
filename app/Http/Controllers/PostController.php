<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserPostRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Intervention\Image\Facades\Image;
use App\Post;
use Illuminate\Support\Facades\Storage;
use Validator;

class PostController extends Controller
{
    public function create(UserPostRequest $request) 
    {
        try {
            $user = auth()->setRequest($request)->user();
            if ($request->has('image')) {
                $imagePath = request('image')->store('post', 'public');
                // $image = Image::make(public_path("storage/{$imagePath}"))->fit(1200,800);
                $image = Image::make(storage_path("app/public/{$imagePath}"))->resize(1200, 800, function ($constraint) {
                    $constraint->aspectRatio();
                });
                
                $image->save();
            }

            $result = $user->posts()->create([
                'title' => $request['title'],
                'image' => $request->has('image') ? $imagePath :'',
    		    'description' => $request->has('description') ? $request['description'] :'',
            ]);
        
            return response()->json([
                'message'=> 'Post Successful'
            ], 200);
        } catch (\Throwable $th) {
            throw new HttpResponseException(response()->json([
                'errors'=> [
                    'message' => 'Request error : Posting failed, please try again.',
                ]
            ], JsonResponse::HTTP_BAD_REQUEST));
        }
    }

    public function update(UserPostRequest $request)
    {
        try {
            $user = auth()->setRequest($request)->user();
            $postQuery = [
                ['user_id', $user->id],
                ['id', $request['id']],
            ];
            $post = Post::where($postQuery)->firstOrFail();
            $updateQuery = [
                'title' => $request['title'],
                'description' => $request['description'],
            ];
            //Image Update
            if ($request->has('image')) {
                // Remove old image
                if($post->image) {
                    if (!Storage::delete('public/'.$post->image)) {
                        throw new HttpResponseException(response()->json([
                            'errors'=> 'Error in removing current image'
                        ], JsonResponse::HTTP_BAD_REQUEST));
                    }
                } 
                // Store new image
                $imagePath = request('image')->store('post', 'public');
                // $image = Image::make(public_path("storage/{$imagePath}"))->fit(1200,800);
                $image = Image::make(storage_path("app/public/{$imagePath}"))->resize(1200, 800, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $image->save();
                //Include Image Update
                $updateQuery['image'] = $imagePath;
                //Return Image Path
                $response['image'] = $imagePath;
            }
            // Update Query
            $result = $post->update($updateQuery);
            // Response
            $response['message'] = 'Post update successful';
            return response()->json($response, 200);
        } catch (\Throwable $th) {
            throw new HttpResponseException(response()->json([
                'errors'=> [
                    'message' => 'Request error : Post update failed, please try again.',
                ]
            ], JsonResponse::HTTP_BAD_REQUEST));
        }
    }

    public function delete(Request $request) 
    {
        try {
            $user = auth()->setRequest($request)->user();
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer',
            ]);        
            // Validate Request
            if ($validator->fails()) {
                $msg = $validator->errors();
                throw new HttpResponseException(response()->json([
                    'errors'=> $msg
                ], JsonResponse::HTTP_BAD_REQUEST));
            } else {
                $request = $validator->validated();
                // Get Post
                $postQuery = [
                    ['user_id', $user->id],
                    ['id', $request['id']],
                ];
                $post = Post::where($postQuery)->firstOrFail();
                // Delete Post
                if($post->delete()) {
                    if($post->image) {
                        if (Storage::delete('public/'.$post->image)) {
                            return response()->json([
                                'message'=> 'Post Deleted'
                            ], 200);
                        } else {
                            throw new HttpResponseException(response()->json([
                                'errors'=> [
                                    'message' => 'Request error : Failed to remove post image',
                                ]
                            ], JsonResponse::HTTP_BAD_REQUEST));
                        }
                    } else {
                        return response()->json([
                            'message'=> 'Post Deleted'
                        ], 200);
                    }
                }
            }
        } catch (\Throwable $th) {
            throw new HttpResponseException(response()->json([
                'errors'=> [
                    'message' => 'Request error : Failed to delete post, please try again.',
                ]
            ], JsonResponse::HTTP_BAD_REQUEST));
        }
    }

    public function list(Request $request) 
    {
        try {
            $user = auth()->setRequest($request)->user();
            if($request->all) {
                $result = Post::select('profiles.user_id', 'profiles.image AS p_image', 'profiles.first_name', 'profiles.middle_name', 'profiles.last_name', 'posts.id', 'posts.title', 'posts.description', 'posts.image')
                ->join('profiles', 'profiles.user_id', '=', 'posts.user_id')
                ->orderBy('posts.created_at', 'desc')
                ->paginate(5);
            } else {
                // $result = Post::where(['user_id' => $user->id ]);
                // $result = $user->posts()->orderBy('created_at', 'desc')->paginate(5);
                $result = Post::select('profiles.user_id', 'profiles.image AS p_image', 'profiles.first_name', 'profiles.middle_name', 'profiles.last_name', 'posts.id', 'posts.title', 'posts.description', 'posts.image')
                ->join('profiles', 'profiles.user_id', '=', 'posts.user_id')
                ->where('posts.user_id', $user->id)
                ->orderBy('posts.created_at', 'desc')
                ->paginate(5);
            }
            return response()->json($result, 200);
        } catch (\Throwable $th) {
            throw new HttpResponseException(response()->json([
                'errors'=> [
                    'message' => 'Request error : Failed to fetch list of posts',
                ]
            ], JsonResponse::HTTP_BAD_REQUEST));
        }
    }
}
