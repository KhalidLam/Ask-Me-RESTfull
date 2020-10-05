<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ["question_id", "body"];
    protected $with = ['user'];

    // Relationship methods
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function question()
    {
        return $this->belongsTo('App\Question');
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }
}
