<?php
/**
 * Created by PhpStorm.
 * User: dromazanov
 * Date: 26/06/16
 * Time: 10:12
 */

namespace Useless;

use Closure;
use Exception;
use ArrayAccess;
use ReflectionClass;
use ReflectionParameter;

/**
 * Class Container
 * @package Useless
 */
class Container implements ArrayAccess
{
    /**
     * @var array
     */
    public $instances = [];

    /**
     * @var array
     */
    public $bindings = [];
    /**
     * @var
     */
    public static $instance;

    /**
     * @var
     */
    protected $aliases;

    /**
     * @param Container $container
     */
    public static function setInstance(Container $container)
    {
        static::$instance = $container;
    }

    /**
     * @return mixed
     */
    public static function getInstance()
    {
        return static::$instance;
    }

    /**
     * @param $class
     * @param $instance
     */
    public function instance($class, $instance)
    {
        $this->instances[$class] = $instance;
    }

    /**
     * @param $abstract
     * @return mixed
     */
    public function getAlias($abstract)
    {
        if (!isset($this->aliases[$abstract])) {
            return $abstract;
        }

        return $this->aliases[$abstract];
    }

    /**
     * @param $abstract
     * @param $concrete
     */
    public function alias($abstract, $concrete)
    {
        $this->aliases[$abstract] = $concrete;
    }

    /**
     * @param $abstract
     * @param null $concrete
     */
    public function bind($abstract, $concrete = null)
    {
        $abstract = $this->getAlias($abstract);

        if (is_null($concrete)) {
            $concrete = $abstract;
        }

        $this->bindings[$abstract] = compact('concrete');
    }

    /**
     * @param Closure $closure
     * @return Closure
     */
    public function share(Closure $closure)
    {
        return function ($container) use ($closure) {
            static $object;

            if (is_null($object)) {
                $object = $closure($container);
            }

            return $object;
        };
    }

    /**
     * @param $class
     * @return mixed|object
     * @throws Exception
     */
    public function make($class)
    {
        $class = $this->getAlias($class);

        if (isset($this->instances[$class])) {
            return $this->instances[$class];
        }

        $class = $this->getConcrete($class);

        return $this->build($class);
    }


    /**
     * @param $abstract
     * @return string
     */
    public function getConcrete($abstract)
    {
        if (! isset($this->bindings[$abstract])) {
            if ($this->missingLeadingSlash($abstract) &&
                isset($this->bindings['\\'.$abstract])) {
                $abstract = '\\'.$abstract;
            }

            return $abstract;
        }

        return $this->bindings[$abstract]['concrete'];
    }

    /**
     * @param $class
     * @return bool
     */
    protected function missingLeadingSlash($class)
    {
        return is_string($class) && strpos($class, '\\') !== 0;
    }

    /**
     * @param array $parameters
     * @return array
     * @throws Exception
     */
    public function getDependencies(array $parameters)
    {
        $dependencies = [];

        foreach ($parameters as $parameter) {
            $dependencies[] = $this->resolveClass($parameter);
        }

        return $dependencies;
    }

    /**
     * @param ReflectionParameter $parameter
     * @return mixed|object
     * @throws Exception
     */
    protected function resolveClass(ReflectionParameter $parameter)
    {
        try {
            return $this->make($parameter->getClass()->name);
        } catch (Exception $e) {

            throw $e;
        }
    }

    /**
     * @param $class
     * @param array $params
     * @return object
     * @throws Exception
     */
    protected function build($class, array $params = [])
    {
        if ($class instanceof Closure) {
            return $class($this, $params);
        }

        $reflector = new ReflectionClass($class);

        if (!$reflector->isInstantiable()) {
            throw new Exception("Trying to instantiate [$class] which is not instantiable");
        }

        $constructor = $reflector->getConstructor();

        if (is_null($constructor)) {
            return new $class;
        }

        $dependencies = $constructor->getParameters();

        $instances = $this->getDependencies($dependencies);

        return $reflector->newInstanceArgs($instances);
    }

    /**
     * Whether a offset exists
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     * An offset to check for.
     * </p>
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     * @since 5.0.0
     */
    public function offsetExists($offset)
    {
        return isset($this->bindings[$offset]);
    }

    /**
     * Offset to retrieve
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     * @return mixed Can return all value types.
     * @since 5.0.0
     */
    public function offsetGet($offset)
    {
        return $this->make($offset);
    }

    /**
     * Offset to set
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param mixed $value <p>
     * The value to set.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetSet($offset, $value)
    {
        $this->bind($offset, $value);
    }

    /**
     * Offset to unset
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetUnset($offset)
    {
        unset($this->bindings[$offset], $this->instances[$offset]);
    }
}