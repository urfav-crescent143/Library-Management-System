<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()) {
            return redirect()->route('login');
        } //checks whether someone is logged in.

        if (! $request->user()->is_admin) {
            abort(403, 'Access denied. Admins only.');
        } //checks whether the logged-in user is an admin.

        return $next($request); //lets an authorized request continue.
    }
}