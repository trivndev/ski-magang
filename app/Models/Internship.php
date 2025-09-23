<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Internship extends Model
{
    /** @use HasFactory<\Database\Factories\InternshipFactory> */
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'job_title',
        'company',
        'location',
        'job_description',
        'requirements',
        'benefits',
        'contact_email',
        'contact_phone',
        'contact_name',
        'end_date',
        'author_id',
        'job_category_id',
        'vocational_major_id',
        'status_id',
    ];

    protected $with = ['jobCategory', 'author','vocationalMajor', 'status'];

    protected $casts = [
      "end_date" => "datetime",
    ];

    public function likes(): HasMany
    {
        return $this->hasMany(LikedPost::class);
    }

    public function bookmarks(): HasMany
    {
        return $this->hasMany(BookmarkedPost::class);
    }

    public function jobCategory(): BelongsTo
    {
        return $this->belongsTo(JobCategory::class);
    }

    public function VocationalMajor(): BelongsTo
    {
        return $this->belongsTo(VocationalMajor::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(InternshipsPostStatus::class, 'status_id');
    }
}
