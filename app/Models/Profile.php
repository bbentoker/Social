<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\{FollowCollection,ProfileCollection};


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
        return $this->hasMany(Post::class)->orderBy('created_at','desc');
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

    public function getFollowings(){
        return new FollowCollection($this->followings);
    }
    public function getFollowers(){
        return new FollowCollection($this->followers);
    }
    public function profileImage(){
        return asset('storage/'.$this->image);
    }
}
