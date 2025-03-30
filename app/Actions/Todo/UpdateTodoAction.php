<?php

declare(strict_types=1);

namespace App\Actions\Todo;

use App\Events\TodoCreated;
use App\Models\Todo;
use Illuminate\Support\Facades\DB;
use Throwable;

final class UpdateTodoAction
{
    /**
     * update a todo instance.
     *
     * @param  array{title: string, description: string|null}  $attributes
     *
     * @throws Throwable
     */
    public function handle(Todo $todo, array $attributes): Todo
    {
        return DB::transaction(function () use ($todo, $attributes): Todo {

            $todo->update([
                'title' => $attributes['title'],
                'description' => $attributes['description'],
            ]);

            $todo->refresh();

            // event(TodoCreated::class, $todo);

            return $todo;
        });
    }
}
