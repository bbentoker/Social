<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'title' => $this->title,
            'description' => $this->description,
            'url' => $this->url,
            'image' => $this->image,
            'following_count' => $this->followings->count(),
            'follower_count' => $this->followers->count(),
            'followings' => new FollowCollection($this->followings),
            'followers' => new FollowCollection($this->followers),
            'posts' => new PostCollection($this->posts) 
        ];
    }
}
