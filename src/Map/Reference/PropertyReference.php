<?php

namespace Cascade\Mapper\Map\Reference;

class PropertyReference implements ReferenceInterface
{
    /**
     * @var \ReflectionClass
     */
    private $class;

    /**
     * @var string
     */
    private $property;

    /**
     * @param string $class
     * @param string $property
     * @TODO: Remove class reference in favor of using ReflectionProperty directly in get/set methods.
     */
    public function __construct($class, $property)
    {
        if (!class_exists($class)) {
            // @TODO: Throw missing class exception.
        }

        $this->class = $reflectedClass = new \ReflectionClass($class);

        if ($reflectedClass->getName() !== 'stdClass') {
            if (!$reflectedClass->hasProperty($property)) {
                // @TODO: Throw missing property exception.
            }
        }

        $this->property = $property;
    }

    public function getValue($instance)
    {
        $class = $this->class;
        $property = $this->property;

        $className = $class->getName();

        if (!is_subclass_of($instance, $className)) {
            // @TODO: Throw invalid instance exception.
        }

        if ($className === 'stdClass') {
            return $instance->$property;
        }

        return $class->getProperty($property)->getValue($instance);
    }

    public function setValue($instance, $value)
    {
        $class = $this->class;
        $property = $this->property;

        $className = $class->getName();

        if (!is_subclass_of($instance, $className)) {
            // @TODO: Throw invalid instance exception.
        }

        if ($className === 'stdClass') {
            $instance->$property = $value;
        } else {
            $class->getProperty($property)->setValue($instance, $value);
        }

        return $instance;
    }
}
