<?php

declare(strict_types=1);

namespace App\Actions\Todo;

use App\Events\TodoCreated;
use App\Models\Todo;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Throwable;

final class CreateTodoAction
{
    /**
     * Create a new todo instance.
     *
     * @param  array{title: string, description: string|null}  $attributes
     *
     * @throws Throwable
     */
    public function handle(User $user, array $attributes): Todo
    {
        return DB::transaction(function () use ($user, $attributes): Todo {
            $todo = $user->todos()->create([
                'title' => $attributes['title'],
                'description' => $attributes['description'],
            ]);

            event(TodoCreated::class, $todo);

            return $todo;
        });
    }
}
