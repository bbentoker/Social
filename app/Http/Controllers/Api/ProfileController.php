<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use App\Models\{Profile};
use App\Http\Resources\{ProfileResource,ProfileCollection};


class ProfileController extends Controller
{
    
    public function index()
    {
        $user = request()->user();
        return new ProfileResource($user->profile);
    }
    
    public function show(Profile $profile)
    {
        return new ProfileResource($profile);
    }
    
    public function update(Request $request, Profile $profile)
    {
        //url regex,not working properly
        $regex = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';
        
        //validations
        $this->authorize('update',$profile);
        
        request()->validate([
            'username' => 'max:50|unique:profiles',
            'title' => 'max:255',
            'description' => 'max:255',
            'url' => 'regex:'.$regex,
            'image' => 'mimes:jpeg,jpg,png|max:10000'
        ]);
        
        //update operation
        
        if(request('image')){
            
            $path = request()->file('image')->store('uploads','public');

            $image = Image::make($request->file('image')->getRealPath());
            
            $image->save('.png');            
        }

        $user = $request->user();
        
        $user->profile()->update([
            'username' => $request->username ?? $profile->username,
            'title' => $request->title ?? $profile->title,
            'description' => $request->description ?? $profile->description,
            'url' => $request->url ?? $profile->url,
            'image' => $path ?? $profile->image,
        ]);

        return new ProfileResource($user->profile);

    }
    
    public function destroy($id)
    {
        
    }
    
    public function follow(Profile $profile){
        $user = request()->user();

        if($user->profile->id == $profile->id){
            return response()->json([
                'message' => 'You can not follow your own profile.'
            ], 417);
        }

        if($user->profile->isFollowing($profile)){
            return response()->json([
                'message' => 'You are already following this profile.'
            ], 417);
        }

        $user->profile->followings()->attach($profile);
        return response()->json([
            'message' => 'You are currently following this profile.'
        ], 200);
    }
    public function unfollow(Profile $profile){
        $user = request()->user();

        if($user->profile->id == $profile->id){
            return response()->json([
                'message' => 'You can not unfollow your own profile.'
            ], 417);
        }

        if(!$user->profile->isFollowing($profile)){
            return response()->json([
                'message' => 'You are already not following this profile.'
            ], 417);
        }

        $user->profile->followings()->detach($profile);
        
        return response()->json([
            'message' => 'You are currently not following this profile.'
        ], 200);
    }
}
