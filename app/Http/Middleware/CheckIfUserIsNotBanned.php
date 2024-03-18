<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckIfUserIsNotBanned
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // check if user is logged in
        if (Auth::guard('api')->check()) {
            // get logged in user instance
            $user = auth()->user();

            // check if user is not banned
            if ($user->is_banned) {
                // logout user
                $user->token()->revoke();
                $user->token()->delete();

                // return response
                return prepareUnsuccessfulResponse(
                    trans('messages.auth.unsuccessful.your_account_is_banned'),
                    403
                );
            }
        }

        return $next($request);
    }
}
