<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\{ProfileResource,ProfileCollection};

class HomeController extends Controller
{
    
    public function home(){
        $user = request()->user();
        return new ProfileResource($user->profile);
    }
}
