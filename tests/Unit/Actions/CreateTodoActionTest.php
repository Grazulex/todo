<?php

declare(strict_types=1);

use App\Actions\Todo\CreateTodoAction;
use App\Events\TodoCreated;
use App\Models\User;

test('creates todo with valid attributes', function (): void {
    $user = User::factory()->create();
    $attributes = ['title' => 'Sample title', 'description' => 'Sample description'];
    $action = new CreateTodoAction();
    $todo = $action->handle($user, $attributes);
    $this->assertDatabaseHas('todos', ['id' => $todo->id, 'title' => 'Sample title', 'description' => 'Sample description']);
});

test('creates todo with null description', function (): void {
    $user = User::factory()->create();
    $attributes = ['title' => 'Sample title', 'description' => null];
    $action = new CreateTodoAction();
    $todo = $action->handle($user, $attributes);
    $this->assertDatabaseHas('todos', ['id' => $todo->id, 'title' => 'Sample title', 'description' => null]);
});

test('throws exception when title is missing', function (): void {
    $this->expectException(Throwable::class);
    $user = User::factory()->create();
    $attributes = ['description' => 'Sample description'];
    $action = new CreateTodoAction();
    $action->handle($user, $attributes);
});

test('throws exception when user is invalid', function (): void {
    $this->expectException(Throwable::class);
    $user = new User(); // Invalid user instance
    $attributes = ['title' => 'Sample title', 'description' => 'Sample description'];
    $action = new CreateTodoAction();
    $action->handle($user, $attributes);
});

test('broadcasts TodoCreated event', function (): void {
    Event::fake();
    $user = User::factory()->create();
    $attributes = ['title' => 'Sample title', 'description' => 'Sample description'];
    $action = new CreateTodoAction();
    $todo = $action->handle($user, $attributes);

    Event::assertDispatched(TodoCreated::class);
});
