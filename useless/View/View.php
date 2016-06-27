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

    public function render($file, array $parameters)
    {
        $segments = explode('::', $file);

        if (count($segments) < 2) {
            throw  new \Exception("Trying to render unknown file [{$file}]");
        }

        $module = ucfirst($segments[0]);

        $file = APP_ROOT . "/{$module}/Resource/views/{$segments[1]}.php";


        return $this->engine->get($file, $parameters);
    }
}