<?php

namespace App\Models;

trait HasUser
{
    public function user()
    {
        return $this->morphOne(User::class, 'profile');
    }
}
