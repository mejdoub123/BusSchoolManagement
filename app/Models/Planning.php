<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planning extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function busschool()
    {
        return $this->belongsTo(BusSchool::class);
    }
}
