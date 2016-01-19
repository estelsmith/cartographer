<?php

namespace Cascade\Mapper\Mapping;

use Cascade\Mapper\Field\Reference\ReferenceInterface;
use Cascade\Mapper\Value\Resolver\ValueResolverInterface;

class ResolverMapping implements MappingInterface
{
    /**
     * @var ReferenceInterface
     */
    private $destinationReference;

    /**
     * @var ValueResolverInterface
     */
    private $valueResolver;

    /**
     * @param ReferenceInterface $destinationReference
     * @param ValueResolverInterface $valueResolver
     */
    public function __construct(ReferenceInterface $destinationReference, ValueResolverInterface $valueResolver)
    {
        $this->destinationReference = $destinationReference;
        $this->valueResolver = $valueResolver;
    }

    public function map($destination, $source)
    {
        return $this->destinationReference->setValue(
            $destination,
            $this->valueResolver->resolve($source, $destination)
        );
    }
}
