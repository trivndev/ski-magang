<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Internship extends Model
{
    /** @use HasFactory<\Database\Factories\InternshipFactory> */
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'job_title',
        'company',
        'company_logo',
        'location',
        'job_description',
        'requirements',
        'benefits',
        'contact_email',
        'contact_phone',
        'contact_name',
        'end_date',
        'author_id',
        'vocational_major_id',
        'status_id',
    ];

    public function likes(): HasMany
    {
        return $this->hasMany(LikedPost::class);
    }

    public function bookmarks(): HasMany
    {
        return $this->hasMany(BookmarkedPost::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function vocationalMajor(): BelongsTo
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

    protected static function booted(): void
    {
        static::deleting(function (self $model) {
            if (method_exists($model, 'isForceDeleting') && !$model->isForceDeleting()) {
                $deletedId = InternshipsPostStatus::query()
                    ->whereRaw('LOWER(status) = ?', ['deleted'])
                    ->value('id');
                if ($deletedId) {
                    $model->status_id = $deletedId;
                }
            }
        });
    }
}
