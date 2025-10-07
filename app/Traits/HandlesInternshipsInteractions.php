<?php

namespace App\Traits;

use App\Models\Internship;
use Illuminate\Support\Facades\Auth;

trait HandlesInternshipsInteractions
{
    public function likeInteraction(Internship $internship)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $existing = $internship->likes()
            ->where('user_id', auth()->id())
            ->first();

        if ($existing) {
            $existing->delete();
        } else {
            $internship->likes()->firstOrCreate([
                'user_id' => auth()->id(),
            ]);
        }
    }

    public function bookmarkInteraction(Internship $internship)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $existing = $internship->bookmarks()
            ->where('user_id', auth()->id())
            ->first();

        if ($existing) {
            $existing->delete();
        } else {
            $internship->bookmarks()->firstOrCreate([
                'user_id' => auth()->id(),
            ]);
        }
    }
}
