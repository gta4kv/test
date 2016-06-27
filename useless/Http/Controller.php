<?php
/**
 * Created by PhpStorm.
 * User: dromazanov
 * Date: 26/06/16
 * Time: 17:41
 */

namespace Useless\Http;

use Useless\Application;

/**
 * Class Controller
 * @package Useless\Http
 */
abstract class Controller
{
    /**
     * @var Application
     */
    protected $app;

    protected $request;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $this->app = Application::getInstance();
        $this->request = $this->app['request'];
    }
}