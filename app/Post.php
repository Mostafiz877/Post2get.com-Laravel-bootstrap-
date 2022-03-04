<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'category_id', 'content', 'post_amount','status'

    ];


    public function customer_comments()
    {
        return $this->hasMany('App\Comment');
    }
}
