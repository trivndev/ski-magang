<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.auth.html')]
class ForgotPassword extends Component
{
    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        $email = Str::lower(trim($this->email));

        $exists = User::query()
            ->where('email', $email)
            ->exists();

        if (!$exists) {
            $this->ensureForgotIsNotRateLimited();

            RateLimiter::hit($this->forgotThrottleKey());

            throw ValidationException::withMessages([
                'email' => __("We can't find a user with that email address."),
            ]);
        }

        Password::sendResetLink(['email' => $email]);

        RateLimiter::clear($this->forgotThrottleKey());

        session()->flash('status', __('A reset link will be sent if the account exists.'));
    }

    protected function ensureForgotIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->forgotThrottleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->forgotThrottleKey());

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => (int) ceil($seconds / 60),
            ]),
        ]);
    }

    protected function forgotThrottleKey(): string
    {
        return 'forgot-password:' . Str::transliterate(Str::lower($this->email) . '|' . request()->ip());
    }
}
