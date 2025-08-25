<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobCategory extends Model
{
    /** @use HasFactory<\Database\Factories\JobCategoryFactory> */
    use HasFactory;

    public function internships(): HasMany
    {
        return $this->hasMany(Internship::class);
    }
}
