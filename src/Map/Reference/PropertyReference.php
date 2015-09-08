<?php

namespace Cascade\Mapper\Map\Reference;

class PropertyReference implements ReferenceInterface
{
    /**
     * @var string
     */
    private $property;

    /**
     * @param string $property
     */
    public function __construct($property)
    {
        $this->property = $property;
    }

    public function getValue($instance)
    {
        $property = $this->property;
        $className = get_class($instance);

        if ($className === 'stdClass') {
            return $instance->$property;
        }

        return (new \ReflectionProperty($className, $property))->getValue($instance);
    }

    public function setValue($instance, $value)
    {
        $property = $this->property;
        $className = get_class($instance);

        if ($className === 'stdClass') {
            $instance->$property = $value;
        } else {
            (new \ReflectionProperty($className, $property))->setValue($instance, $value);
        }

        return $instance;
    }
}
