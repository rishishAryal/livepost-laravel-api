<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    public function getTitleUpperCaseAttribute(){
        return strtoupper($this->title);
    }
    public function setTitleAttribute($value){
        $this->attributes['title']= strtolower($value);
    }
    protected $casts = [
      'body'=>'array'
    ];

    public function comments(){
        return $this->hasMany(Comment::class,'post_id',);
    }
    public function users(){
        return $this->belongsToMany(User::class,'post_user','post_id','user_id');
    }

}
