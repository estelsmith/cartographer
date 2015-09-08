<?php

namespace Cascade\Mapper\Field\Reference;

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
        $this->getter = $getter ?: 'get' . $this->classify($field);
        $this->setter = $setter ?: 'set' . $this->classify($field);
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

    private function classify($word)
    {
        return str_replace(' ', '', ucwords(strtr($word, '_-', '  ')));
    }
}
