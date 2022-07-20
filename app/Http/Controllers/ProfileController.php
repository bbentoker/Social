<?php

namespace App\Http\Controllers;

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
        //validations
        $this->authorize('update',$profile);
        
        //url regex 
        $regex = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';
        
        request()->validate([
            'username' => 'max:50|unique:profiles',
            'title' => 'max:255',
            'description' => 'max:255',
            'url' => 'regex:'.$regex,
            'image' => 'mimes:jpeg,jpg,png,gif|max:10000'
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
    
}
