<?php

namespace Useless\Validator;

use Useless\Validator\Contract\ValidationInterface;
use Useless\Validator\Validators\EmailValidator;
use Useless\Validator\Validators\LengthValidator;
use Useless\Validator\Validators\RequiredValidator;
use Exception;

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
        'length' => LengthValidator::class,
        'email' => EmailValidator::class
    ];

    /**
     * @var array
     */
    public $rules = [];

    /**
     * @var array
     */
    public $errors = [];

    public $fieldTranslations = [];


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

    public function setFieldTranslations(array $translations)
    {
        $this->fieldTranslations = $translations;

        return $this;
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
     * @return array
     */
    public function getRules()
    {
        return $this->rules;
    }

    /**
     * @return Validator
     */
    public static function factory()
    {
        return new self;
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
                $validatorParams = $validator[1];

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

        $this->errors[] = "The value '{$paramName}' {$error}";
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

}