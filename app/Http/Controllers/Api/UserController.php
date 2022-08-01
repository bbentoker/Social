<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use App\Models\{User};
use App\Http\Resources\{UserResource,UserCollection};

class UserController extends Controller
{
    
    public function index()
    {
        //add pagination to this method
        $users = User::all();
        return new UserCollection($users);
    }
    
    
    
    public function show(User $user)
    {
        return new UserResource($user);
    }
    
    
    
    
    public function update(Request $request, User $user)
    {
        
        $this->authorize('update',$user);

        //update operation

        request()->validate([
            'name' => 'max:255',
            'email' => 'email|unique:users|max:255',
            'password' => 'min:8|max:255',
            'password_confirmation' => 'same:password',//çokomelli
        ]);

        $user = $request->user();
        
        $user->update([
            'name' => $request->name ?? $user->name,
            'email' => $request->email ?? $user->email,
            'password' => Hash::make($request->password) ?? $user->password,
            'photo' => $path ?? $user->photo,
        ]);

        return new UserResource($user);
    }
    
    //configure later
    public function destroy(User $user)
    {
        
    } 
   
}
