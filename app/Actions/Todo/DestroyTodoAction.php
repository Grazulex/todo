<?php

declare(strict_types=1);

namespace App\Actions\Todo;

use App\Models\Todo;
use Illuminate\Support\Facades\DB;
use Throwable;

final class DestroyTodoAction
{
    /**
     * update a todo instance.
     *
     * @throws Throwable
     */
    public function handle(Todo $todo): bool
    {
        return DB::transaction(function () use ($todo): true {
            $todo->delete();
            return true;
        });
    }
}
