<?php

declare(strict_types=1);

use App\Enums\StatusEnum;
use App\Models\Todo;
use App\Models\User;

test('to array', function (): void {
    $todo = Todo::factory()->create()->refresh();

    expect(array_keys($todo->toArray()))
        ->toBe([
            'id',
            'title',
            'description',
            'status',
            'user_id',
            'created_at',
            'updated_at',
        ]);
});

test('todo belongs to a user', function (): void {
    $todo = Todo::factory()->create();

    expect($todo->user)->toBeInstanceOf(User::class);
});

test('check that status is an enum', function (): void {
    $todo = Todo::factory()->create();

    expect($todo->status)->toBeInstanceOf(StatusEnum::class);
});
