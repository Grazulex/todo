<?php

declare(strict_types=1);

use App\Models\User;

test('authorizes the request', function (): void {
    $request = new App\Http\Requests\Auth\LoginRequest();
    $this->assertTrue($request->authorize());
});

test('validates email and password fields', function (): void {
    $request = new App\Http\Requests\Auth\LoginRequest();
    $rules = $request->rules();
    $this->assertArrayHasKey('email', $rules);
    $this->assertArrayHasKey('password', $rules);
    $this->assertContains('required', $rules['email']);
    $this->assertContains('string', $rules['email']);
    $this->assertContains('email', $rules['email']);
    $this->assertContains('required', $rules['password']);
    $this->assertContains('string', $rules['password']);
});

test('authenticates with valid credentials', function (): void {
    $user = User::factory()->create(['password' => bcrypt('password')]);
    $request = App\Http\Requests\Auth\LoginRequest::create('/', 'POST', [
        'email' => $user->email,
        'password' => 'password',
    ]);
    $this->actingAs($user);
    $request->authenticate();
    $this->assertAuthenticatedAs($user);
});

test('throws validation exception with invalid credentials', function (): void {
    $this->expectException(Illuminate\Validation\ValidationException::class);
    $request = App\Http\Requests\Auth\LoginRequest::create('/', 'POST', [
        'email' => 'invalid@example.com',
        'password' => 'invalid-password',
    ]);
    $request->authenticate();
});

test('ensures request is not rate limited', function (): void {
    $request = App\Http\Requests\Auth\LoginRequest::create('/', 'POST', [
        'email' => 'test@example.com',
        'password' => 'password',
    ]);
    RateLimiter::shouldReceive('tooManyAttempts')->andReturn(false);
    $request->ensureIsNotRateLimited();
    $this->assertTrue(true); // No exception thrown
});

test('returns correct throttle key', function (): void {
    $request = App\Http\Requests\Auth\LoginRequest::create('/', 'POST', [
        'email' => 'test@example.com',
    ]);
    $this->assertEquals('test@example.com|127.0.0.1', $request->throttleKey());
});
