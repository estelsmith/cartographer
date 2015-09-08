<?php

namespace Cascade\Mapper\Mapping;

interface MappingInterface
{
    /**
     * @param mixed $destination
     * @param mixed $source
     * @return mixed
     */
    public function map($destination, $source);
}
