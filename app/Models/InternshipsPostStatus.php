<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InternshipsPostStatus extends Model
{
    /** @use HasFactory<\Database\Factories\InternshipsPostStatusFactory> */
    use HasFactory;

    protected $table = 'internships_post_statuses';
    public $timestamps = false;

    protected $fillable = ['status','status_color'];

    public function internships(): HasMany
    {
        return $this->hasMany(Internship::class, 'status_id');
    }
}
