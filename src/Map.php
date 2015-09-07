<?php

namespace Cascade\Mapper;

use Cascade\Mapper\Map\MappingInterface;

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

    private function addMapping(MappingInterface $mapping)
    {
        $this->mappings[] = $mapping;
    }
}
