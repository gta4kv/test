<?php
/**
 * Created by PhpStorm.
 * User: dromazanov
 * Date: 26/06/16
 * Time: 16:33
 */

namespace Useless\View;

use Useless\View\Engine\EngineInterface;

/**
 * Class View
 * @package Useless\View
 */
class View
{
    /**
     * @var EngineInterface
     */
    protected $engine;

    /**
     * View constructor.
     * @param EngineInterface $engine
     */
    public function __construct(EngineInterface $engine)
    {
        $this->engine = $engine;
    }

    /**
     * @param $module
     * @param $alias
     */
    public function addModule($module, $alias)
    {
        $path = APP_ROOT . "/{$module}/Resource/views/";

        $this->engine->addPath($path, $alias);
    }

    /**
     * @param $path
     * @param $alias
     */
    public function addPath($path, $alias)
    {
        $this->engine->addPath($path, $alias);
    }

    /**
     * @param $var
     * @param $value
     */
    public function addGlobal($var, $value)
    {
        $this->engine->addGlobal($var, $value);
    }

    /**
     * @param $file
     * @param array $parameters
     * @return string
     */
    public function render($file, $parameters = [])
    {
        return $this->engine->get($file, $parameters);
    }
}