<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Admin
{
  public function handle($request, Closure $next, $guard = null)
  {
    /*if (Auth::guard($guard)->guest()) {
      if ($request->ajax()) {
        return response('Unauthorized.', 401);
      } else {
        return redirect()->guest('login');
      }
    } else if (!Auth::guard($guard)->user()->is_admin) {
      Auth::logout();
      return redirect()->to('/login')->withError('Permission Denied');
    }*/
    if(Auth::guard($guard)->user() == null)
    {
      Auth::logout();
      return redirect()->to('/login')->withError('Permission Denied');
    }

    if ((Auth::guard($guard)->user()->is_admin)
      &&(Auth::guard($guard)->user()->is_active))
    {
      return $next($request);
    }
    else {
      Auth::logout();
      return redirect()->to('/login')->withError('Permission Denied');
    }


  }
}
