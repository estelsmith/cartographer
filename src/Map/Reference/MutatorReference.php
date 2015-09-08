<?php

namespace Cascade\Mapper\Map\Reference;

use Doctrine\Common\Inflector\Inflector;

class MutatorReference implements ReferenceInterface
{
    /**
     * @var string
     */
    private $getter;

    /**
     * @var string
     */
    private $setter;

    /**
     * @param string $field
     * @param null|string $getter
     * @param null|string $setter
     */
    public function __construct($field, $getter = null, $setter = null)
    {
        $this->getter = $getter ?: 'get' . Inflector::classify($field);
        $this->setter = $setter ?: 'set' . Inflector::classify($field);
    }

    public function getValue($instance)
    {
        $getter = $this->getter;
        $className = get_class($instance);

        return (new \ReflectionMethod($className, $getter))->invoke($instance);
    }

    public function setValue($instance, $value)
    {
        $setter = $this->setter;
        $className = get_class($instance);

        (new \ReflectionMethod($className, $setter))->invoke($instance, $value);

        return $instance;
    }
}
