<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\{Auth,Hash,Storage};
use App\Http\Resources\{ProfileResource,ProfileCollection,UserResource};
use App\Models\{User,Profile};
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class ProfileController extends Controller
{
    
    
    public function index()
    {   
        $user = Auth::user();
        
        $profile = new ProfileResource($user->profile);

        $link = route('profiles.edit',$user->profile->id);
        
        return Inertia::render('Profile/Index',[
            'Profile' => $profile, 
            'Link' => $link
        ]);
    }

    
    
    public function create()
    {
        
    }

    
    
    public function store(Request $request)
    {
        //
    }

    
    
    public function show(Profile $profile)
    {   
        $followLink = route('profiles.follow',$profile->id);
        $unfollowLink = route('profiles.unfollow',$profile->id);

        return Inertia::render('Profile/Show',[
            'Profile' => new ProfileResource($profile),
            'FollowLink' => $followLink,
            'UnfollowLink' => $unfollowLink
        ]);
    }

    
    
    public function edit(Profile $profile)
    {   
        $auth = Auth::user();
         
        if($auth->id !== $profile->user_id){
            return redirect()->route('profiles.show',$profile->id);
        }
        
        $profile = new ProfileResource($auth->profile);

        $updateUrl = route('profiles.update',$auth->profile->id);

        return Inertia::render('Profile/Edit',[
            'Profile' => $profile, 
            'User' => new UserResource($auth),
            'UpdateUrl' => $updateUrl
        ]);
    }

    
    
    public function update(Request $request, Profile $profile)
    {   

        $this->authorize('update',$profile);

        request()->validate([
            'username' =>  Rule::unique('profiles')->ignore($profile),
            'title' => 'max:50|nullable',
            'description' => 'max:255|nullable',
            'url' => 'url|nullable',
            'email' => 'email|max:255',
            'password' => 'min:8|confirmed|nullable',
            'image' => 'mimes:jpeg,jpg,png|max:10000|nullable'
        ]);
        
        if(request('image')){     
            
            $path = request('image')->store('uploads','s3');
            
            $img = Image::make(request('image'));
            $img->resize(320, 300);   
            
            $img = $img->stream();
            
            Storage::disk('s3')->put($path,$img->__toString());
            
            Storage::disk('s3')->setVisibility($path, 'public');
            
            $url = Storage::disk('s3')->url($path);
        }

        $user = Auth::user();

        $user->profile()->update([
            'username' => $request->username ?? $profile->username,
            'title' => $request->title ?? $profile->title,
            'description' => $request->description ?? $profile->description,
            'url' => $request->url ?? $profile->url,
            'image' => $url ?? $profile->image,
        ]);

        $user->update([
            'email' => $request->email ?? $user->email,
            'password' => Hash::make($request->password) ?? $user->password,
        ]);
        
        return redirect()->route('profiles.index');
    }

    
    
    public function destroy($id)
    {
        //
    }

    public function follow(Profile $profile){
        dd("follow");
        $user = Auth::user();

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
        dd("unfollow");
        $user = Auth::user();

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
