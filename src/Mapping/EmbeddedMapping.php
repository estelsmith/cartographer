<?php

namespace Cascade\Mapper\Mapping;

use Cascade\Mapper\Field\Reference\ReferenceInterface;
use Cascade\Mapper\Map\MapInterface;

class EmbeddedMapping implements MappingInterface
{
    /**
     * @var ReferenceInterface
     */
    private $sourceReference;

    /**
     * @var MapInterface
     */
    private $map;

    /**
     * @param ReferenceInterface $sourceReference
     * @param MapInterface $map
     */
    public function __construct(ReferenceInterface $sourceReference, MapInterface $map)
    {
        $this->sourceReference = $sourceReference;
        $this->map = $map;
    }

    public function map($destination, $source)
    {
        $sourceReference = $this->sourceReference;
        $mappings = $this->map->getMappings();

        $embeddedValues = $sourceReference->getValue($source);

        $newDestination = $destination;
        foreach ($mappings as $mapping) {
            $newDestination = $mapping->map($newDestination, $embeddedValues);
        }

        return $newDestination;
    }
}
