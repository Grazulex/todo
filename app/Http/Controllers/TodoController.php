<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Todo\CreateTodoAction;
use App\Actions\Todo\DestroyTodoAction;
use App\Actions\Todo\UpdateTodoAction;
use App\Http\Requests\Todo\StoreTodoRequest;
use App\Models\Todo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Throwable;

final class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('todos.index', [
            'todos' => Todo::query()
                ->where('user_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('todos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @throws Throwable
     */
    public function store(StoreTodoRequest $request, CreateTodoAction $action): RedirectResponse
    {
        $action->handle(Auth::user(), $request->validated());

        return redirect()->route('todos.index');

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Todo $todo): View
    {

        return view('todos.edit', ['todo' => $todo]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @throws Throwable
     */
    public function update(StoreTodoRequest $request, UpdateTodoAction $action, Todo $todo): RedirectResponse
    {
        $request->validated();
        $action->handle($todo, $request->only('title', 'description'));

        return redirect()->route('todos.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DestroyTodoAction $action, Todo $todo): RedirectResponse
    {
        $action->handle($todo);

        return redirect()->route('todos.index');
    }
}
