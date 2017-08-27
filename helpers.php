<?php

use Useless\Application;


/**
 * @param null $class
 * @return object|\Useless\Container|Application
 */
function app($class = null)
{
    if ($class === null) {
        return Application::getInstance();
    }

    return Application::getInstance()->make($class);
}

/**
 * @return \Useless\View\View
 */
function view()
{
    return Application::getInstance()->make('view');
}

/**
 * @return \Useless\Http\Request
 */
function request()
{
    return Application::getInstance()->make('request');
}

/**
 * @return \Useless\Http\Response
 */
function response()
{
    return Application::getInstance()->make('response');
}

/**
 * @return \Useless\Routing\RouteCollection
 */
function route()
{
    return Application::getInstance()->make('route');
}

/**
 * @return \Useless\Config\Config
 */
function config()
{
    return Application::getInstance()->make('config');
}

/**
 * @return \Useless\Http\Session
 */
function session()
{
    return request()->getSession();
}