<?php

namespace Cascade\Mapper\Map;

use Cascade\Mapper\Mapping\MappingInterface;

interface MapInterface
{
    /**
     * @return MappingInterface[]
     */
    public function getMappings();
}
