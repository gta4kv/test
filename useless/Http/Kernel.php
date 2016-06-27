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
     * @var Application
     */
    public $app;
    /**
     * @var Router
     */
    public $router;

    /**
     * Kernel constructor.
     * @param Application $app
     * @param Router $router
     */
    public function __construct(Application $app, Router $router)
    {
        $this->app = $app;
        $this->router = $router;
    }

    public function handle()
    {
        $route = $this->router->matchCurrentRequest();

        if (!$route instanceof Route) {
            throw new NotFoundHttpException;
        }

        /** @var $pipe Pipeline */
        $pipe = $this->app->make(Pipeline::class);

        return $pipe->send($this->app['request'])
            ->through($route->getMiddleware())
            ->then(function ($request) use ($route) {
                $content = $this->createAction($route);

                return $this->app['response']->setContent($content);
            });
    }

    public function createAction(Route $route)
    {
        $callable = [$this->app->make($route->getController()), $route->getAction()];

        return call_user_func_array($callable, $route->getParameters());
    }
}