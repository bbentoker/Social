<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\Models\{Post};
use App\Http\Resources\{PostResource,PostCollection,CommentResource,CommentCollection};
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $user = request()->user();
        return new PostCollection($user->profile->posts);
    }

    public function show(Post $post)
    {
        return new PostResource($post);
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

        return new PostResource($post);
    }


    public function update(Request $request,Post $post)
    {
        $this->authorize('update',$post);
        
        request()->validate([
            'caption' => 'max:255',
        ]);

        $post->update([
            'caption' => request()->caption ?? $post->caption
        ]);

        return new PostResource($post);
    }

    public function destroy($id)
    {
        
    }
    
    public function comment(Post $post){

        request()->validate([
            'comment' => 'required|max:255',
        ]);

        $comment = $post->comments()->create([
            'comment' => request()->comment,
            'profile_id' => request()->user()->profile->id
        ]);

        return new CommentResource($comment);
    }
}
