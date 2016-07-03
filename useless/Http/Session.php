<?php
/**
 * Created by PhpStorm.
 * User: dromazanov
 * Date: 03/07/16
 * Time: 20:29
 */

namespace Useless\Http;

/**
 * Class Session
 * @package Useless\Http
 */
class Session
{
    /**
     * @var bool
     */
    public $started = false;

    /**
     * Session constructor.
     */
    public function __construct()
    {
        $this->start();
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function start()
    {
        if ($this->started) {
            return true;
        }

        if (session_status() == PHP_SESSION_ACTIVE) {
            return true;
        }

        if (!session_start()) {
            throw new \Exception('Cannot start session, check your configuration');
        }

        $this->started = true;

        return true;
    }

    /**
     * @return bool
     */
    public function close()
    {
        if (session_status() == PHP_SESSION_ACTIVE) {
            session_write_close();
        }

        return true;
    }

    /**
     * @param $name
     * @param null $defaultValue
     * @return null
     */
    public function get($name = null, $defaultValue = null)
    {
        if (!$name) {
            return $_SESSION;
        }

        if (isset($_SESSION[$name])) {
            return $_SESSION[$name];
        }

        return $defaultValue;
    }

    /**
     * @param $name
     * @param $value
     * @return $this
     */
    public function set($name, $value)
    {
        $_SESSION[$name] = $value;

        return $this;
    }
}