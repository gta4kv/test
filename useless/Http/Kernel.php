<?php
/**
 * Created by PhpStorm.
 * User: dromazanov
 * Date: 26/06/16
 * Time: 12:53
 */

namespace Useless\Http;

use Useless\Application;
use Useless\Pipeline;
use Useless\Routing\Route;
use Useless\Routing\Router;
use Useless\Http\Exceptions\NotFoundHttpException;

/**
 * Class Kernel
 * @package Useless\Http
 */
class Kernel
{
    /**
     * @return Response
     */
    public function handle()
    {
        $route = app('router')->matchCurrentRequest();

        if (!$route instanceof Route) {
            throw new NotFoundHttpException;
        }

        /** @var $pipe Pipeline */
        $pipe = app(Pipeline::class);

        return $pipe->send(request())
            ->through($route->getMiddleware() ? $route->getMiddleware() : [])
            ->then(function (Request $request) use ($route) {
                $content = $this->createAction($route);

                $request->terminate();

                return response()->setContent($content);
            });
    }

    public function createAction(Route $route)
    {
        $callable = [app($route->getController()), $route->getAction()];

        return call_user_func_array($callable, $route->getParameters());
    }
}