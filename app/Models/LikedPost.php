<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LikedPost extends Model
{
    /** @use HasFactory<\Database\Factories\LikedPostFactory> */
    use HasFactory;

    public $timestamps = false;

    public function internship()
    {
        return $this->belongsTo(Internship::class);

    }

    public function user()
    {
        return $this->belongsTo(User::class);

    }
}
