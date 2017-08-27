<?php
/**
 * Created by PhpStorm.
 * User: dromazanov
 * Date: 27/08/2017
 * Time: 19:42
 */

namespace Useless\Validator\Validators;


use Useless\Validator\AbstractValidator;
use Useless\Validator\Contract\ValidationInterface;

class InValidator extends AbstractValidator implements ValidationInterface
{
    /**
     * @param $value
     * @return bool|string
     */
    public function validate($value)
    {
        $possibleValues = $this->getParam('values');

        if (!is_array($possibleValues)) {
            throw new \InvalidArgumentException('[Values] parameter should be array');
        }

        $isObject = $this->getParam('isObject');
        $found = false;

        if ($isObject && $function = $this->getParam('function')) {
            foreach ($possibleValues as $object) {
                $found = ($value == $object->$function());

                if ($found) break;
            }
        }


        if (($isObject && !$found) || (!$isObject && !in_array($value, $possibleValues))) {
            return ' has incorrect value';
        }

        return true;
    }
}