<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VocationalMajor extends Model
{
    /** @use HasFactory<\Database\Factories\VocationalMajorFactory> */
    use HasFactory;

    public $timestamps = false;

    public function internships():HasMany
    {
        return $this->hasMany(Internship::class);
    }
}
