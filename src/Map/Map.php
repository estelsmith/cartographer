<?php

namespace Cascade\Mapper\Map;

use Cascade\Mapper\Mapping\MappingInterface;

class Map implements MapInterface
{
    /**
     * @var MappingInterface[]
     */
    private $mappings = [];

    /**
     * @param MappingInterface[] $mappings
     */
    public function __construct($mappings)
    {
        foreach ($mappings as $mapping) {
            $this->addMapping($mapping);
        }
    }

    public function getMappings()
    {
        return $this->mappings;
    }

    /**
     * @param MappingInterface $mapping
     */
    private function addMapping(MappingInterface $mapping)
    {
        $this->mappings[] = $mapping;
    }
}
