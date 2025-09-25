<?php

use App\Livewire\Internships\BookmarkedPost;
use App\Livewire\Internships\Create;
use App\Livewire\Internships\LikedPost;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use App\Livewire\Internships\Index;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::middleware(['auth', 'verified'])
    ->prefix('internships')
    ->name('internships.')
    ->group(function () {
        Route::get('/', Index::class)->name('index');
        Route::get('/create', Create::class)->name('create');
        Route::get('/liked', LikedPost::class)->name('liked');
        Route::get('/bookmarked', BookmarkedPost::class)->name('bookmarked');
    });

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

require __DIR__ . '/auth.php';
