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

    public function addModule($module, $alias)
    {
        $path = APP_ROOT . "/{$module}/Resource/views/";

        $this->engine->addPath($path, $alias);
    }

    public function addPath($path, $alias)
    {
        $this->engine->addPath($path, $alias);
    }

    public function addGlobal($var, $value)
    {
        $this->engine->addGlobal($var, $value);
    }

    public function render($file, array $parameters)
    {
        return $this->engine->get($file, $parameters);
    }
}