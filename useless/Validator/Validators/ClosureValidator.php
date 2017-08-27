<?php
/**
 * Created by PhpStorm.
 * User: dromazanov
 * Date: 26/06/16
 * Time: 09:40
 */

namespace Useless\Validator\Validators;

use Closure;
use Useless\Validator\AbstractValidator;
use Useless\Validator\Contract\ValidationInterface;

/**
 * Class RequiredValidator
 * @package Validator\Validators
 */
class ClosureValidator extends AbstractValidator implements ValidationInterface
{

    /**
     * @param $value
     * @return bool|string
     */
    public function validate($value)
    {
        if (! $this->getParam('function') instanceof Closure) {
            throw new \InvalidArgumentException('Function must be a closure');
        }

        /** @var Closure $closure */
        $closure = $this->getParam('function');

        // assuming that you closure returns string or true as all other validators
        return $closure($value);
    }


}