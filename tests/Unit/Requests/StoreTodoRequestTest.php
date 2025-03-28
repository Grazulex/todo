<?php

declare(strict_types=1);

use App\Http\Requests\Todo\StoreTodoRequest;
use App\Models\User;

test('authorizes the request', function (): void {
    $request = new StoreTodoRequest();
    $this->assertTrue($request->authorize());
});

test('validates title field', function (): void {
    $request = new StoreTodoRequest();
    $rules = $request->rules();
    $this->assertArrayHasKey('title', $rules);
    $this->assertContains('required', $rules['title']);
    $this->assertContains('string', $rules['title']);
    $this->assertContains('min:3', $rules['title']);
    $this->assertContains('max:50', $rules['title']);
});

test('validates description field', function (): void {
    $request = new StoreTodoRequest();
    $rules = $request->rules();
    $this->assertArrayHasKey('description', $rules);
    $this->assertContains('nullable', $rules['description']);
    $this->assertContains('string', $rules['description']);
    $this->assertContains('max:100', $rules['description']);
});

test('validates user_id field', function (): void {
    $request = new StoreTodoRequest();
    $rules = $request->rules();
    $this->assertArrayHasKey('user_id', $rules);
    $this->assertContains('required', $rules['user_id']);
    $this->assertContains('integer', $rules['user_id']);
    $this->assertContains('exists:users,id', $rules['user_id']);
});

test('fails validation when title is missing', function (): void {
    $request = StoreTodoRequest::create('/', 'POST', [
        'description' => 'Sample description',
        'user_id' => 1,
    ]);
    $validator = Validator::make($request->all(), $request->rules());
    $this->assertTrue($validator->fails());
    $this->assertArrayHasKey('title', $validator->errors()->messages());
});

test('passes validation with valid data', function (): void {
    $user = User::factory()->create();
    $request = StoreTodoRequest::create('/', 'POST', [
        'title' => 'Sample title',
        'description' => 'Sample description',
        'user_id' => $user->id,
    ]);
    $validator = Validator::make($request->all(), $request->rules());

    $this->assertFalse($validator->fails());
});
