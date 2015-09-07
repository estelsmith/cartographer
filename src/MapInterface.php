<?php

namespace Cascade\Mapper;

use Cascade\Mapper\Map\MappingInterface;

interface MapInterface
{
    /**
     * @return MappingInterface[]
     */
    public function getMappings();
}
