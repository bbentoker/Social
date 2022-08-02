<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class TestController extends Controller
{
    public function create()
    {
        return view('images.create');
    }

    public function store(Request $request)
    {
        $path = $request->file('image')->store('images', 's3');

        Storage::disk('s3')->setVisibility($path, 'public');

        return Storage::disk('s3')->url($path);
    }

    public function show(Image $image)
    {
        return $image->url;
    }
}
