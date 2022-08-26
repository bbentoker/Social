<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\{Auth,Hash,Storage};
use App\Http\Resources\{ProfileResource,ProfileCollection,UserResource};
use App\Models\{User,Profile};
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class PostController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        $storeLink = route('posts.store');

        return Inertia::render('Post/Create',[
            'StoreLink' => $storeLink
        ]);
    }

   
    public function store(Request $request)
    {
        request()->validate([
            'caption' => 'required|max:255',
            'image' => 'required|mimes:jpeg,jpg,png|max:10000'
        ]);

        $path = request('image')->store('uploads','s3');
            
        $img = Image::make(request('image'));
        $img->resize(320, 240);   
        
        $img = $img->stream();
        
        Storage::disk('s3')->put($path,$img->__toString());
        
        Storage::disk('s3')->setVisibility($path, 'public');

        $url = Storage::disk('s3')->url($path);

        $profile = request()->user()->profile;

        $post = $profile->posts()->create([
            'caption' => request()->caption,
            'image' => $url
        ]);

        return redirect()->route('profiles.index');
    }

    
    public function show($id)
    {
        return $id;
    }

    
    public function edit($id)
    {
        //
    }

    
    public function update(Request $request, $id)
    {
        //
    }

    
    public function destroy($id)
    {
        //
    }
}
