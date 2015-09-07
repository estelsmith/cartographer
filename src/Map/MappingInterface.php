<?php

namespace Cascade\Mapper\Map;

interface MappingInterface
{
    /**
     * @param mixed $destination
     * @param mixed $source
     * @return mixed
     */
    public function map($destination, $source);
}
