<?php

namespace App\Livewire\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('components.layouts.auth.html'), Title('Login | SKI MAGANG')]
class Login extends Component
{
    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->ensureIsNotRateLimited();

        if (!Auth::validate(['email' => $this->email, 'password' => $this->password])) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());

        $user = \App\Models\User::where('email', $this->email)->first();
        if ($user && !is_null($user->banned_at)) {
            throw ValidationException::withMessages([
                'email' => 'Your account has been banned. Please contact support.',
            ]);
        }

        if ($user && ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail) && !$user->hasVerifiedEmail()) {
            $this->redirect(route('verification.notice', absolute: false), navigate: true);
            return;
        }

        Auth::login($user, $this->remember);
        Session::regenerate();
        $default = $this->resolveHomeFor($user);
        $this->redirectIntended(default: $default, navigate: true);
    }

    protected function resolveHomeFor($user): string
    {
        if (!$user) {
            return route('home', absolute: false);
        }

        if ($user->hasRole(['admin', 'supervisor'])) {
            return route('admin.dashboard', absolute: false);
        }

        return route('home', absolute: false);
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email) . '|' . request()->ip());
    }
}
