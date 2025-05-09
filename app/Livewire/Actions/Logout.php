<?php

declare(strict_types=1);

namespace App\Livewire\Actions;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Features\SupportRedirects\Redirector;

final class Logout
{
    /**
     * Log the current user out of the application.
     */
    /** @phpstan-ignore-next-line  */
    public function __invoke(): Redirector|RedirectResponse
    {
        Auth::guard('web')->logout();

        Session::invalidate();
        Session::regenerateToken();

        return redirect('/');
    }
}
