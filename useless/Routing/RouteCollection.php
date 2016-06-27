<?php
/**
 * Created by PhpStorm.
 * User: dromazanov
 * Date: 27/06/16
 * Time: 21:14
 */

namespace Useless\Routing;

use SplObjectStorage;

class RouteCollection extends SplObjectStorage
{
    public function add(Route $route)
    {
        parent::attach($route, null);
    }

    /**
     * @return Route[]
     */
    public function all()
    {
        $routes = [];

        foreach ($this as $route)
        {
            $routes[] = $route;
        }

        return $routes;
    }
}