<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['tagname'];
    protected $appends = ['posts_count'];

    public function questions()
    {
        return $this->belongsToMany('App\Question');
    }

    //
    public function getPostsCountAttribute(){
        return $this->questions()->count();
    }
}
