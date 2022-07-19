<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    public static function boot(){
        parent::boot();
       
    }
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function posts(){
        return $this->hasMany(Post::class);
    }

    public function followings(){
        return $this->belongsToMany(Profile::class,'follow_table','following_id','followed_id');
    }

    public function followers(){
        return $this->belongsToMany(Profile::class,'follow_table','followed_id','following_id');
    }
    public function isFollowing($id){
        return $this->followings->contains($id);
    }
}
