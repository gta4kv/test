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
class VanillaTemplateEngine implements EngineInterface
{

    /**
     * @param $path
     * @param array $variables
     * @return string
     * @throws Exception
     */
    public function get($path, array $variables = [])
    {
        $obLevel = ob_get_level();
        ob_start();

        extract($variables, EXTR_SKIP);

        try {
            include $path;
        } catch (\Exception $e) {
            $this->handleViewException($e, $obLevel);
        }

        return ltrim(ob_get_clean());
    }

    /**
     * @param Exception $e
     * @param $obLevel
     * @throws Exception
     */
    protected function handleViewException(Exception $e, $obLevel)
    {
        while (ob_get_level() > $obLevel) {
            ob_end_clean();
        }

        throw $e;
    }
}