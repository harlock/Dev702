<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'title', 'content', 'user_id',
    ];

    public function getResponses(){
        return $this->hasMany(Response::class);
    }
}
