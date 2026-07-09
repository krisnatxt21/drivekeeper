<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
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

            <h2 class="text-xl font-bold text-white mb-6">Masuk ke Akun</h2>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form wire:submit="login" class="space-y-4">

                <div>
                    <label class="block text-sm text-gray-400 mb-1">Email</label>
                    <input wire:model="form.email" type="email" name="email"
                           required autofocus autocomplete="username"
                           class="w-full bg-surface-700 border border-surface-600 text-white rounded-lg px-4 py-2.5 focus:outline-none focus:border-primary transition-all"
                           placeholder="email@example.com">
                    <x-input-error :messages="$errors->get('form.email')" class="mt-1 text-red-400 text-xs" />
                </div>

                <div>
                    <label class="block text-sm text-gray-400 mb-1">Password</label>
                    <input wire:model="form.password" type="password" name="password"
                           required autocomplete="current-password"
                           class="w-full bg-surface-700 border border-surface-600 text-white rounded-lg px-4 py-2.5 focus:outline-none focus:border-primary transition-all"
                           placeholder="••••••••">
                    <x-input-error :messages="$errors->get('form.password')" class="mt-1 text-red-400 text-xs" />
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 text-sm text-gray-400 cursor-pointer">
                        <input wire:model="form.remember" type="checkbox"
                               class="rounded border-surface-600 bg-surface-700 text-primary">
                        Ingat saya
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" wire:navigate
                           class="text-sm text-primary hover:text-primary-light transition-all">
                            Lupa password?
                        </a>
                    @endif
                </div>

                <button type="submit"
                        class="w-full bg-primary hover:bg-primary-dark text-white font-semibold py-2.5 rounded-lg transition-all mt-2">
                    Masuk
                </button>

            </form>

            <p class="text-center text-gray-400 text-sm mt-6">
                Belum punya akun?
                <a href="{{ route('register') }}" wire:navigate class="text-primary hover:underline">
                    Daftar sekarang
                </a>
            </p>

        </div>

        <p class="text-center text-gray-600 text-xs mt-6">
            DriveKeeper &copy; {{ date('Y') }} • Developed by <span class="text-primary">KrishhV2</span>
        </p>

    </div>
</div>
