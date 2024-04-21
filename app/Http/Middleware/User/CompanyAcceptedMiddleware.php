<?php

namespace App\Http\Middleware\User;

use Closure;
use Illuminate\Http\Request;

class CompanyAcceptedMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = getAuthUser('web');

        if($user->type == 'company' && !$user->is_accepted && !$request->is('dashboard'))
        {
            return back()->with('error' ,__('account_not_accepted'));
        }
        return $next($request);
    }
}
