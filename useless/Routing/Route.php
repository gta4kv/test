<?php

/**
 * Created by PhpStorm.
 * User: dromazanov
 * Date: 27/06/16
 * Time: 21:19
 */

namespace Useless\Routing;
use InvalidArgumentException;
use Useless\Http\Middlewares\Auth;

/**
 * Class Route
 * @package Useless\Routing
 */
class Route
{

    /**
     * @var
     */
    private $url;

    /**
     * Don't need more methods now...
     *
     * @var array
     */
    private $methods = ['GET', 'POST'];

    /**
     * @var mixed|null
     */
    private $uses;
    /**
     * @var mixed|null
     */
    private $name;
    /**
     * @var array
     */
    private $filters = [];
    /**
     * @var array
     */
    private $parameters = [];



    public function __construct($resource, $methods, $uses)
    {
        $this->url = $resource;

        $this->methods = (array) $methods;
        $this->uses = $uses;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param $url
     */
    public function setUrl($url)
    {
        $url = (string)$url;

        if (substr($url, -1) !== '/') {
            $url .= '/';
        }
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getUses()
    {
        return $this->uses;
    }

    /**
     * @return array
     */
    private function getParts()
    {
        $parts = explode('@', $this->getUses());

        if (count($parts) != 2) {
            throw new InvalidArgumentException("[{$this->getUses()}] is not valid route argument");
        }

        return $parts;
    }

    /**
     * @return string
     */
    public function getController()
    {
        return $this->getParts()[0];
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->getParts()[1];
    }

        /**
         * @return array
         */
    public function getMethods()
    {
        return $this->methods;
    }

    /**
     * @param array $methods
     */
    public function setMethods(array $methods)
    {
        $this->methods = $methods;
    }

    /**
     * @return mixed|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $name
     */
    public function setName($name)
    {
        $this->name = (string)$name;
    }

    /**
     * @param array $filters
     */
    public function setFilters(array $filters)
    {
        $this->filters = $filters;
    }

    /**
     * @return mixed
     */
    public function getRegex()
    {
        return preg_replace_callback('/(:\w+)/', [&$this, 'substituteFilter'], $this->url);
    }

    /**
     * @param $matches
     * @return mixed|string
     */
    private function substituteFilter($matches)
    {
        if (isset($matches[1], $this->filters[$matches[1]])) {
            return $this->filters[$matches[1]];
        }
        return '([\w-%]+)';
    }

    public function getMiddleware()
    {
        return Auth::class;
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @param array $parameters
     */
    public function setParameters(array $parameters)
    {
        $this->parameters = $parameters;
    }
}