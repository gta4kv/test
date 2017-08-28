<?php

namespace Useless\Validator;

use Exception;
use Useless\Validator\Contract\ValidationInterface;
use Useless\Validator\Validators\ClosureValidator;
use Useless\Validator\Validators\DateValidator;
use Useless\Validator\Validators\EmailValidator;
use Useless\Validator\Validators\NumericValidator;
use Useless\Validator\Validators\InValidator;
use Useless\Validator\Validators\LengthValidator;
use Useless\Validator\Validators\RequiredValidator;

/**
 * Basic Usage
 *
 * $validation = $validator->setRules([
 *  ['barcode', [
 *      ['required', []],
 *      ['length', ['max' => 13, 'min' => 13]]
 *  ]],
 *  ['full_name', [
 *      ['required', []]
 *  ]]
 * ])
 * ->setFieldTranslations(['barcode' => 'Номер пропуска', 'full_name' => 'ФИО'])
 * ->validate($request->post());
 *
 * Class Validator
 * @package Validator
 */
class Validator
{
    /**
     * @var array
     */
    public static $validators = [
        'required' => RequiredValidator::class,
        'closure'  => ClosureValidator::class,
        'numeric'  => NumericValidator::class,
        'length'   => LengthValidator::class,
        'email'    => EmailValidator::class,
        'date'     => DateValidator::class,
        'in'       => InValidator::class
    ];

    /**
     * @var array
     */
    public $rules = [];

    /**
     * @var array
     */
    public $errors = [];

    /**
     * @var array
     */
    public $fieldTranslations = [];

    /**
     * @return Validator
     */
    public static function factory()
    {
        return new self;
    }

    /**
     * @param array $translations
     * @return $this
     */
    public function setFieldTranslations(array $translations)
    {
        $this->fieldTranslations = $translations;

        return $this;
    }

    /**
     * @param array $data
     * @return bool
     * @throws Exception
     */
    public function validate(array $data)
    {
        foreach ($this->getRules() as $rule) {
            $dataName = $rule[0];
            $validators = $rule[1];

            foreach ($validators as $validator) {
                $validatorName = $validator[0];
                $validatorParams = isset($validator[1]) ? $validator[1] : [];

                $validator = $this->createValidator($validatorName, $validatorParams);

                $validator = $validator->validate($this->getData($data, $dataName));

                if (!is_bool($validator)) {
                    $this->setError($dataName, $validator);
                }
            }
        }

        if (count($this->getErrors()) > 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * @return array
     */
    public function getRules()
    {
        return $this->rules;
    }

    /**
     * @param array $rules
     * @return $this
     */
    public function setRules(array $rules)
    {
        $this->rules = $rules;

        return $this;
    }

    /**
     * @param $name
     * @param array $params
     * @return ValidationInterface
     * @throws Exception
     */
    public function createValidator($name, array $params)
    {
        $validator = $this->getValidator($name);

        $reflection = new \ReflectionClass($validator);

        if (!$reflection->implementsInterface(ValidationInterface::class)) {
            throw new Exception("Validator {$name} must implement ValidationInterface");
        }

        $instance = $reflection->newInstanceWithoutConstructor();

        $method = $reflection->getMethod('setParams');

        $method->invoke($instance, $params);

        return $instance;
    }

    /**
     * @param $name
     * @return mixed
     * @throws Exception
     */
    public function getValidator($name)
    {
        if (!isset(self::$validators[$name])) {
            throw new Exception('Trying to get unknown validator: ' . $name);
        }

        return self::$validators[$name];
    }

    /**
     * @param $data
     * @param $paramName
     * @return string
     */
    public function getData($data, $paramName)
    {
        if (!isset($data[$paramName]) || $data[$paramName] == '') {
            return '';
        }

        return $data[$paramName];
    }

    /**
     * @param $paramName
     * @param $error
     */
    public function setError($paramName, $error)
    {
        $paramName = $this->getFieldTranslation($paramName);

        $this->errors[] = "{$paramName} {$error}";
    }

    /**
     * @param string $field
     * @return string
     */
    public function getFieldTranslation($field)
    {
        if (!isset($this->fieldTranslations[$field])) {
            return $field;
        }

        return $this->fieldTranslations[$field];
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @return $this
     */
    public function resetErrors()
    {
        $this->errors = [];

        return $this;
    }

}