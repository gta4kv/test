<?php
/**
 * Created by PhpStorm.
 * User: dromazanov
 * Date: 27/06/16
 * Time: 23:21
 */

namespace Useless\Http\Middlewares;


use Useless\Http\Request;
use Useless\Http\Response;

class Auth
{
    public function handle(Request $request, $next)
    {
        if (!$request->getSession()->get('user'))
        {
            (new Response())->redirect('/login');
        }

        return $next($request);
    }
}