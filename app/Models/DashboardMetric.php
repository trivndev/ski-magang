<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DashboardMetric extends Model
{
    use HasFactory;

    protected $fillable = [
        'snapshot_at',
        'total_posts',
        'posts_this_month',
        'approved_count',
        'rejected_count',
        'pending_count',
        'active_users',
        'deleted_posts',
        'monthly_series',
        'monthly_user_series',
        'top_liked_posts',
    ];

    protected $casts = [
        'snapshot_at' => 'datetime',
        'monthly_series' => 'array',
        'monthly_user_series' => 'array',
        'top_liked_posts' => 'array',
    ];
}
