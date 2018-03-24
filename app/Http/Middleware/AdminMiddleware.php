<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		// If the user is not an admin, we do not let them access the restircted pages.
		if(Auth::user()->is_admin !== 1) {
			return redirect('home');
		} 

		return $next($request);
	}
}
