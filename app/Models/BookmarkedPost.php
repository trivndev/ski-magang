<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookmarkedPost extends Model
{
    /** @use HasFactory<\Database\Factories\BookmarkedPostFactory> */
    use HasFactory;

    public function internship()
    {
        return $this->belongsTo(Internship::class);

    }

    public function user()
    {
        return $this->belongsTo(User::class);

    }
}
