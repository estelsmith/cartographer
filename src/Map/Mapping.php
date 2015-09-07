<?php

namespace Cascade\Mapper\Map;

use Cascade\Mapper\Map\Reference\ReferenceInterface;

class Mapping implements MappingInterface
{
    /**
     * @var ReferenceInterface
     */
    private $destinationReference;

    /**
     * @var ReferenceInterface
     */
    private $sourceReference;

    /**
     * @param ReferenceInterface $destinationReference
     * @param ReferenceInterface $sourceReference
     */
    public function __construct(ReferenceInterface $destinationReference, ReferenceInterface $sourceReference)
    {
        $this->destinationReference = $destinationReference;
        $this->sourceReference = $sourceReference;
    }

    public function map($destination, $source)
    {
        return $this->destinationReference->setValue($destination, $this->sourceReference->getValue($source));
    }
}
