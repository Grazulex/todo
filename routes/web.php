<?php

declare(strict_types=1);

use App\Livewire\Home;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class)->name('home');

Route::middleware('auth')->group(function (): void {
    Route::redirect('settings', 'settings/profile');
    Route::get('settings/profile', App\Livewire\Settings\Profile::class)->name('settings.profile');
    Route::get('settings/password', App\Livewire\Settings\Password::class)->name('settings.password');
    Route::get('settings/appearance', App\Livewire\Settings\Appearance::class)->name('settings.appearance');
    Route::get('settings/locale', App\Livewire\Settings\Locale::class)->name('settings.locale');

});

require __DIR__.'/auth.php';
