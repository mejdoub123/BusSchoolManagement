<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;
    use HasUser;
    protected $guarded = [];
    public function school()
    {
        return $this->hasOne(School::class);
    }
}
