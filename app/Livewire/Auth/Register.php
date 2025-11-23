<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Spatie\Permission\Models\Role as SpatieRole;

#[Layout('components.layouts.auth.html'), Title('Register | SKI MAGANG')]
class Register extends Component
{
    public string $name = '';

    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $emailInput = strtolower(trim($this->email));
        if ($emailInput !== '') {
            $banned = User::query()
                ->where('email', $emailInput)
                ->whereNotNull('banned_at')
                ->exists();

            if ($banned) {
                $this->addError('email', 'An account with this email has been blocked by the administrator.');
                return;
            }
        }

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required', 'string', 'lowercase', 'email', 'max:255',
                Rule::unique(User::class, 'email'),
            ],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $user = User::create($validated);

        event(new Registered($user));

        if (SpatieRole::where('name', 'user')->exists() && !$user->hasRole('user')) {
            $user->assignRole('user');
        }

        Auth::login($user);

        $this->redirect(route('home', absolute: false), navigate: true);
    }
}
