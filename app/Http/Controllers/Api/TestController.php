<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function create()
    {
        return view('images.create');
    }

    public function store(Request $request)
    {
        $path = $request->file('image')->store('images', 's3');

        Storage::disk('s3')->setVisibility($path, 'private');

        $image = Image::create([
            'filename' => basename($path),
            'url' => Storage::disk('s3')->url($path)
        ]);

        return $image;
    }

    public function show(Image $image)
    {
        return $image->url;
    }
}
