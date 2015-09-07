<?php

namespace Cascade\Mapper;

use Cascade\Mapper\Context\ContextInterface;
use Cascade\Mapper\Map\MappingInterface;

class Mapper implements MapperInterface
{
    public function map($destination, $source, ContextInterface $context)
    {
        return $this->visitMap($context->getMap(), $destination, $source);
    }

    private function visitMap(MapInterface $map, $destination, $source)
    {
        $mappings = $map->getMappings();

        $newDestination = $destination;

        foreach ($mappings as $mapping) {
            $newDestination = $this->visitMapping($mapping, $destination, $source);
        }

        return $newDestination;
    }

    private function visitMapping(MappingInterface $mapping, $destination, $source)
    {
        return $mapping->map($destination, $source);
    }
}
