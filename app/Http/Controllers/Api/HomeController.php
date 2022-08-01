<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\{ProfileResource,ProfileCollection,PostResource,PostCollection};

class HomeController extends Controller
{
    
    public function home(){

        $profile = request()->user()->profile;
        
        $followings = $profile->followings;
        $data = array();

        foreach($followings as $followed){
            array_push($data,$followed->posts->first());
        }

        $lastPosts = array('posts' => new  PostCollection($data));

        return $lastPosts;
    }
}
