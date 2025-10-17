<?php

use App\Livewire\AdminDashboard\Index as AdminIndex;
use App\Livewire\Internships\BookmarkedPost;
use App\Livewire\Internships\Create;
use App\Livewire\Internships\LikedPost;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use App\Livewire\Internships\Index as InternshipsIndex;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::prefix('internships')
    ->name('internships.')
    ->group(function () {
        Route::get('/', InternshipsIndex::class)->name('index');
        Route::middleware(['auth', 'verified'])->group(function () {
            Route::get('/create', Create::class)->name('create');
            Route::get('/liked', LikedPost::class)->name('liked');
            Route::get('/bookmarked', BookmarkedPost::class)->name('bookmarked');
        });
    });

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware(['auth', 'verified', 'role:admin|supervisor'])->group(function () {
        Route::get('/', AdminIndex::class)->name('dashboard');
    });

    Route::middleware(['auth', 'verified', 'role:supervisor'])->group(function () {
        Route::get('/supervisor', function () {
            return response('Supervisor only page');
        })->name('supervisor');
    });
});

Route::get('dashboard', function () {
    return view('dashboard');
})->name('dashboard');


require __DIR__ . '/auth.php';
