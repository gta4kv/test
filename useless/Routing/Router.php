<?php
/**
 * Created by PhpStorm.
 * User: dromazanov
 * Date: 27/06/16
 * Time: 21:14
 */

namespace Useless\Routing;


/**
 * Class Router
 * @package Useless\Routing
 */
class Router
{
    /**
     * @return bool|Route
     */
    public function matchCurrentRequest()
    {
        $requestMethod = app('request')->getMethod();
        $requestUrl = app('request')->getUri();

        if (($pos = strpos($requestUrl, '?')) !== false) {
            $requestUrl = substr($requestUrl, 0, $pos);
        }

        return $this->match($requestUrl, $requestMethod);
    }

    /**
     * @param $requestUrl
     * @param string $requestMethod
     * @return bool|Route
     */
    public function match($requestUrl, $requestMethod = 'GET')
    {
        foreach (route()->all() as $routes) {

            if (!in_array($requestMethod, (array)$routes->getMethods())) {
                continue;
            }

            $currentDir = dirname($_SERVER['SCRIPT_NAME']);

            if ($currentDir != '/') {
                $requestUrl = str_replace($currentDir, '', $requestUrl);
            }

            $route = rtrim($routes->getRegex(), '/');
            $pattern = "@^{$route}/?$@i";

            if (!preg_match($pattern, $requestUrl, $matches)) {
                continue;
            }

            array_shift($matches);

            $params = [];
            if (preg_match_all("/:([\w-%]+)/", $routes->getUrl(), $argumentKeys)) {
                $argumentKeys = $argumentKeys[1];

                if (count($argumentKeys) != count($matches)) {
                    continue;
                }

                foreach ($argumentKeys as $key => $name) {
                    if (isset($matches[$key])) {
                        $params[$name] = $matches[$key];
                    }
                }
            }
            $routes->setParameters($params);

            return $routes;
        }

        return false;
    }
}