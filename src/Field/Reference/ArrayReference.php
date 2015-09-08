<?php

namespace Cascade\Mapper\Field\Reference;

class ArrayReference implements ReferenceInterface
{
    /**
     * @var string
     */
    private $field;

    /**
     * @param string $field
     */
    public function __construct($field)
    {
        $this->field = $field;
    }

    public function getValue($instance)
    {
        $field = $this->field;

        if (array_key_exists($field, $instance)) {
            return $instance[$field];
        }

        return null;
    }

    public function setValue($instance, $value)
    {
        $instance[$this->field] = $value;

        return $instance;
    }
}
