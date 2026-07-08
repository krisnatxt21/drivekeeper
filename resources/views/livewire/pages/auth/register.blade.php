<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
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
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="min-h-screen bg-surface-900 flex items-center justify-center p-4">
    <div class="w-full max-w-md">

        {{-- Logo --}}
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-white tracking-wider">
                <span class="text-primary">DRIVE</span>KEEPER
            </h1>
            <p class="text-gray-400 mt-2">Smart Vehicle Management System</p>
        </div>

        {{-- Card --}}
        <div class="bg-surface-800 rounded-2xl p-8 shadow-2xl border border-surface-700">

            <h2 class="text-xl font-bold text-white mb-6">Buat Akun Baru</h2>

            <form wire:submit="register" class="space-y-4">

                <div>
                    <label class="block text-sm text-gray-400 mb-1">Nama Lengkap</label>
                    <input wire:model="name" type="text" name="name"
                           required autofocus autocomplete="name"
                           class="w-full bg-surface-700 border border-surface-600 text-white rounded-lg px-4 py-2.5 focus:outline-none focus:border-primary transition-all"
                           placeholder="Nama kamu">
                    <x-input-error :messages="$errors->get('name')" class="mt-1 text-red-400 text-xs" />
                </div>

                <div>
                    <label class="block text-sm text-gray-400 mb-1">Email</label>
                    <input wire:model="email" type="email" name="email"
                           required autocomplete="username"
                           class="w-full bg-surface-700 border border-surface-600 text-white rounded-lg px-4 py-2.5 focus:outline-none focus:border-primary transition-all"
                           placeholder="email@example.com">
                    <x-input-error :messages="$errors->get('email')" class="mt-1 text-red-400 text-xs" />
                </div>

                <div>
                    <label class="block text-sm text-gray-400 mb-1">Password</label>
                    <input wire:model="password" type="password" name="password"
                           required autocomplete="new-password"
                           class="w-full bg-surface-700 border border-surface-600 text-white rounded-lg px-4 py-2.5 focus:outline-none focus:border-primary transition-all"
                           placeholder="Minimal 8 karakter">
                    <x-input-error :messages="$errors->get('password')" class="mt-1 text-red-400 text-xs" />
                </div>

                <div>
                    <label class="block text-sm text-gray-400 mb-1">Konfirmasi Password</label>
                    <input wire:model="password_confirmation" type="password" name="password_confirmation"
                           required autocomplete="new-password"
                           class="w-full bg-surface-700 border border-surface-600 text-white rounded-lg px-4 py-2.5 focus:outline-none focus:border-primary transition-all"
                           placeholder="Ulangi password">
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-red-400 text-xs" />
                </div>

                <button type="submit"
                        class="w-full bg-primary hover:bg-primary-dark text-white font-semibold py-2.5 rounded-lg transition-all mt-2">
                    Daftar Sekarang
                </button>

            </form>

            <p class="text-center text-gray-400 text-sm mt-6">
                Sudah punya akun?
                <a href="{{ route('login') }}" wire:navigate class="text-primary hover:underline">
                    Masuk di sini
                </a>
            </p>

        </div>

        <p class="text-center text-gray-600 text-xs mt-6">
            DriveKeeper &copy; {{ date('Y') }} • Developed by <span class="text-primary">KrishhV2</span>
        </p>

    </div>
</div>
