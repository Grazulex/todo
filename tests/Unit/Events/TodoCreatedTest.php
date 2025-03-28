<?php

declare(strict_types=1);

use App\Events\TodoCreated;
use App\Models\Todo;
use Illuminate\Broadcasting\PrivateChannel;

test('broadcasts on correct channel', function (): void {
    $todo = Todo::factory()->create();
    $event = new TodoCreated($todo);
    $this->assertContains(new PrivateChannel('channel-name'), $event->broadcastOn());
})->skip();

test('event contains correct todo instance', function (): void {
    $todo = Todo::factory()->create();
    $event = new TodoCreated($todo);
    $this->assertSame($todo, $event->todo);
});
