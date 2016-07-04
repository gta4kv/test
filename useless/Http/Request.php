<?php
/**
 * Created by PhpStorm.
 * User: dromazanov
 * Date: 26/06/16
 * Time: 12:53
 */

namespace Useless\Http;

use Useless\Application;


/**
 * Class Request
 * @package Useless\Http
 */
class Request
{
    /**
     * @var null
     */
    private $csrfToken = null;

    /**
     * @var Session
     */
    protected $session;

    public function __construct(Application $app)
    {
        $this->session = $app['session'];
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        if (isset($_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE'])) {
            return strtoupper($_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE']);
        }

        if (isset($_SERVER['REQUEST_METHOD'])) {
            return strtoupper($_SERVER['REQUEST_METHOD']);
        }

        return 'GET';
    }


    /**
     *
     */
    public function terminate()
    {
//        $this->getSession()->close();
    }

    /**
     * @return Session
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * @param null $name
     * @param null $defaultValue
     * @return array|string|null
     */
    public function post($name = null, $defaultValue = null)
    {
        if ($name === null) {
            return $_POST;
        }

        if (isset($_POST[$name])) {
            return $_POST[$name];
        } else if ($defaultValue) {
            return $defaultValue;
        }

        return null;
    }

    public function get($name = null, $defaultValue = null)
    {
        if ($name === null) {
            return $_GET;
        }

        if (isset($_GET[$name])) {
            return $_GET[$name];
        } else if ($defaultValue) {
            return $defaultValue;
        }

        return null;
    }

    /**
     * Проверяет если это POST запрос
     * @return bool
     */
    public function getIsPost()
    {
        return $this->getMethod() == 'POST';
    }

    /**
     * Проверяет если это GET запрос
     *
     * @return bool
     */
    public function getIsGet()
    {
        return $this->getMethod() == 'GET';
    }

    /**
     * Проверяет если это Ajax запрос
     *
     * @return bool
     */
    public function getIsAjax()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }

    /**
     * @return mixed
     */
    public function getUri()
    {
        return $_SERVER['REQUEST_URI'];
    }
}