<?php
/**
 * Created by PhpStorm.
 * User: dromazanov
 * Date: 26/06/16
 * Time: 16:28
 */

namespace Useless\View\Engine;

use Exception;

/**
 * Class VanillaTemplateEngine
 * @package Useless\View\Engine
 */
class TwigTemplateEngine implements EngineInterface
{

    /**
     * @var \Twig_Loader_Filesystem
     */
    protected $loader;

    /**
     * @var \Twig_Environment
     */
    protected $twig;

    /**
     * TwigTemplateEngine constructor.
     */
    public function __construct()
    {
        $this->loader = new \Twig_Loader_Filesystem();

        $this->twig = new \Twig_Environment($this->loader, [
            'cache' => false
        ]);
    }

    /**
     * @param $path
     * @param array $variables
     * @return mixed
     */
    public function get($path, array $variables = [])
    {
        return $this->twig->render($path, $variables);
    }

    /**
     * @param $name
     * @param $var
     */
    public function addGlobal($name, $var)
    {
        $this->twig->addGlobal($name, $var);
    }

    /**
     * @param $dir
     * @param $alias
     * @throws \Twig_Error_Loader
     */
    public function addPath($dir, $alias)
    {
        $this->loader->addPath($dir, $alias);
    }
}