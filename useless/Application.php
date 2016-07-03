<?php

namespace Useless;

use Useless\Config\Config;
use Useless\Http\Request;
use Useless\Http\Response;
use Useless\Http\Session;
use Useless\Routing\Router;
use Useless\Routing\RoutingServiceProvider;
use Useless\Support\ServiceProvider;
use Useless\View\View;

/**
 * Class Application
 * @package Useless
 */
class Application extends Container
{
    /**
     * @var
     */
    public $basePath;

    /**
     * @var array
     */
    public $serviceProviders = [];

    /**
     * Application constructor.
     * @param string $basePath
     */
    public function __construct($basePath = '')
    {
        if ($basePath) {
            $this->setBasePath($basePath);
        }

        $this->registerDefaultBindings();
        $this->registerDefaultAliases();
        $this->registerDefaultProviders();
    }

    /**
     *
     */
    public function registerDefaultBindings()
    {
        static::setInstance($this);

        $this->instance('app', $this);
        $this->instance(Application::class, $this);
    }

    /**
     *
     */
    public function registerDefaultProviders()
    {
        $this->register(new RoutingServiceProvider($this));
    }

    /**
     *
     */
    public function registerDefaultAliases()
    {
        $aliases = [
            'view' => View::class,
            'config' => Config::class,
            'router' => Router::class,
            'session' => Session::class,
            'request' => Request::class,
            'response' => Response::class
        ];

        foreach ($aliases as $alias => $concrete) {
            $this->alias($alias, $concrete);
        }
    }

    /**
     * @param $provider
     * @return bool|mixed
     */
    public function register($provider)
    {
        if ($registered = $this->getProvider($provider)) {
            return $registered;
        }

        if (is_string($provider)) {
            $provider = $this->resolveProviderClass($provider);
        }

        $provider->register();

        return $provider;
    }

    /**
     * @param $provider
     * @return bool
     */
    public function getProvider($provider)
    {
        $name = is_string($provider) ? $provider : get_class($provider);

        foreach ($this->serviceProviders as $serviceProvider) {
            if ($name instanceof $serviceProvider) {
                return $provider;
            }
        }

        return false;
    }

    /**
     * @param $provider
     * @return mixed
     */
    public function resolveProviderClass($provider)
    {
        return new $provider($this);
    }

    /**
     * @param string $basePath
     * @return $this
     */
    public function setBasePath($basePath)
    {
        $this->basePath = $basePath;

        return $this;
    }
}