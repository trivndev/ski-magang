<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Internship extends Model
{
    /** @use HasFactory<\Database\Factories\InternshipFactory> */
    use HasFactory;

    public function jobCategory(): BelongsTo
    {
        return $this->belongsTo(JobCategory::class);
    }
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class,'author_id');
    }
}
