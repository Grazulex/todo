<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;

test('email verification screen can be rendered', function (): void {
    $user = User::factory()->unverified()->create();

    $response = $this->actingAs($user)->get('/verify-email');

    $response->assertStatus(200);
});

test('email can be verified', function (): void {
    $user = User::factory()->unverified()->create();

    Event::fake();

    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        ['id' => $user->id, 'hash' => sha1($user->email)]
    );

    $response = $this->actingAs($user)->get($verificationUrl);

    Event::assertDispatched(Verified::class);
    expect($user->fresh()->hasVerifiedEmail())->toBeTrue();
    $response->assertRedirect(route('dashboard', absolute: false).'?verified=1');
});

test('email is not verified with invalid hash', function (): void {
    $user = User::factory()->unverified()->create();

    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        ['id' => $user->id, 'hash' => sha1('wrong-email')]
    );

    $this->actingAs($user)->get($verificationUrl);

    expect($user->fresh()->hasVerifiedEmail())->toBeFalse();
});

test('redirects to dashboard if email is already verified', function (): void {
    $user = User::factory()->create(['email_verified_at' => now()]);
    $this->actingAs($user);

    $response = $this->post(route('verification.send'));

    $response->assertRedirect(route('dashboard'));
});

test('sends verification email if email is not verified', function (): void {
    $user = User::factory()->create(['email_verified_at' => null]);
    $this->actingAs($user);

    Notification::fake();

    $response = $this->post(route('verification.send'));

    Notification::assertSentTo($user, VerifyEmail::class);
    $response->assertRedirect();
    $response->assertSessionHas('status', 'verification-link-sent');
});

test('redirects back if user is not authenticated', function (): void {
    $response = $this->post(route('verification.send'));

    $response->assertRedirect(route('login'));
});

test('redirects to dashboard if user has verified email', function (): void {
    $user = User::factory()->create(['email_verified_at' => now()]);
    $this->actingAs($user);

    $response = $this->get(route('verification.notice'));

    $response->assertRedirect(route('dashboard'));
});

test('shows verification prompt if user has not verified email', function (): void {
    $user = User::factory()->create(['email_verified_at' => null]);
    $this->actingAs($user);

    $response = $this->get(route('verification.notice'));

    $response->assertViewIs('auth.verify-email');
});

test('redirects to login if user is not authenticated', function (): void {
    $response = $this->get(route('verification.notice'));

    $response->assertRedirect(route('login'));
});
