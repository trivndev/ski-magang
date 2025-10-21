<?php

namespace App\Traits;

use App\Models\Internship;

trait HandlesInternshipsInteractions
{
    public function likeInteraction($internshipOrId)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $internship = $internshipOrId instanceof Internship
            ? $internshipOrId
            : Internship::find($internshipOrId);

        if (!$internship) {
            session()->flash('error', 'Post not found or has been deleted.');
            return false;
        }

        $existing = $internship->likes()->where('user_id', auth()->id())->first();
        if ($existing) {
            $existing->delete();
        } else {
            $internship->likes()->firstOrCreate(['user_id' => auth()->id()]);
        }

        return true;
    }

    public function bookmarkInteraction($internshipOrId)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $internship = $internshipOrId instanceof Internship
            ? $internshipOrId
            : Internship::find($internshipOrId);

        if (!$internship) {
            session()->flash('error', 'Post not found or has been deleted.');
            return false;
        }

        $existing = $internship->bookmarks()->where('user_id', auth()->id())->first();
        if ($existing) {
            $existing->delete();
        } else {
            $internship->bookmarks()->firstOrCreate(['user_id' => auth()->id()]);
        }

        return true;
    }
}
