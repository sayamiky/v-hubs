<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

Route::get('terms-condition', function () {
    return view('info.terms-condition');
})->name('terms.condition');

Route::get('privacy-policy', function () {
    return view('info.privacy-policy');
})->name('privacy.policy');

Route::get('registration-id', function () {
    return view('info.registration-id');
})->name('registration.id');

require __DIR__.'/auth.php';
