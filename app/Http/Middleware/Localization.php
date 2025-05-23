<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\HttpFoundation\Response;

final class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function handle(Request $request, Closure $next): Response
    {
        // if user is logged in, get the locale from the user settings
        if (auth()->check()) {
            /** @var string $locale */
            $locale = auth()->user()->locale ?? config('app.locale');
            app()->setLocale($locale);

            return $next($request);
        }

        /** @var string $locale */
        $locale = session()->get('locale', config('app.locale'));
        app()->setLocale($locale);

        return $next($request);
    }
}
