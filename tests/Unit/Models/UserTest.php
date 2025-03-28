<?php

declare(strict_types=1);

use App\Models\Todo;
use App\Models\User;

test('to array', function (): void {
    $user = User::factory()->create()->refresh();

    expect(array_keys($user->toArray()))
        ->toBe([
            'id',
            'name',
            'email',
            'email_verified_at',
            'created_at',
            'updated_at',
        ]);
});

test('user can have many todos', function (): void {
    $user = User::factory()->create();

    Todo::factory()
        ->count(3)
        ->for($user)
        ->create();

    expect($user->Todos)->toHaveCount(3)
        ->and($user->Todos->first())->toBeInstanceOf(Todo::class);
});
