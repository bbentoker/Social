<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\{Profile};
use App\Http\Resources\ProfileResource;


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
        $this->authorize('update',$profile);

        //update operation

        
    }
    
    public function destroy($id)
    {
        
    }
    
}
