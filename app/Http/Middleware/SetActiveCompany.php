<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetActiveCompany
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // If logged in
        if (auth()->check()) {
            // If no active company session
            if (! session()->has('active_company_id')) {
                // Get the first company the user belongs to
                $firstCompany = auth()->user()->companies()->first();

                if ($firstCompany) {
                    // Set their first business profile as default
                    session(['active_company_id' => $firstCompany->id]);
                } else {
                    // Force them to a setup screen if they don't belong to any company
                    // return redirect()->route('home');
                }
            }

            if (session()->has('active_company_id')) {
                setPermissionsTeamId(session('active_company_id'));
            }
        }

        return $next($request);
    }
}
