<?php

namespace App\Models;

trait HasComments
{

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
