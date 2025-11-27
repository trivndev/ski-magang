<?php

namespace App\Http;

use App\Http\Middleware\IsBanned;
use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel{
    protected $middlewareGroups = [
        'web' => [
            IsBanned::class
        ]
    ];
}
