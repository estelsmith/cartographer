<?php

namespace Cascade\Mapper\Map\Reference;

use Doctrine\Common\Inflector\Inflector;

class MutatorReference implements ReferenceInterface
{
    /**
     * @var \ReflectionClass
     */
    private $class;

    /**
     * @var \ReflectionMethod
     */
    private $getter;

    /**
     * @var \ReflectionMethod
     */
    private $setter;

    /**
     * @param string $class
     * @param string $field
     * @param null|string $getterMethod
     * @param null|string $setterMethod
     * @TODO: Remove class reference in favor of using ReflectionMethod directly in get/set methods.
     */
    public function __construct($class, $field, $getterMethod = null, $setterMethod = null)
    {
        $this->class = $reflectedClass = new \ReflectionClass($class);

        $getter = $getterMethod ?: 'get' . Inflector::classify($field);
        $setter = $setterMethod ?: 'set' . Inflector::classify($field);

        $this->getter = $reflectedClass->getMethod($getter);
        $this->setter = $reflectedClass->getMethod($setter);
    }

    public function getValue($instance)
    {
        $class = $this->class;
        $getter = $this->getter;

        $className = $class->getName();

        if (!is_subclass_of($instance, $className)) {
            // @TODO: Throw invalid instance exception.
        }

        return $getter->invoke($instance);
    }

    public function setValue($instance, $value)
    {
        $class = $this->class;
        $setter = $this->setter;

        $className = $class->getName();

        if (!is_subclass_of($instance, $className)) {
            // @TODO: Throw invalid instance exception.
        }

        $setter->invoke($instance, $value);

        return $instance;
    }
}
