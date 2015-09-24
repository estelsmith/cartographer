<?php

namespace Cascade\Mapper\Map;

use Cascade\Mapper\Map\Exception\InvalidReferenceTypeException;
use Cascade\Mapper\Mapping\MappingInterface;
use Cascade\Mapper\Value\Resolver\ValueResolverInterface;

interface MapBuilderInterface
{
    const REF_ARRAY = 'REF_ARRAY';
    const REF_CLASS_PROPERTIES = 'REF_CLASS_PROPERTIES';
    const REF_CLASS_MUTATORS = 'REF_CLASS_MUTATORS';

    /**
     * @param string $from
     * @return $this
     * @throws InvalidReferenceTypeException
     */
    public function from($from);

    /**
     * @param string $to
     * @return $this
     * @throws InvalidReferenceTypeException
     */
    public function to($to);

    /**
     * @param string $toField
     * @param string $fromField
     * @return $this
     */
    public function add($toField, $fromField);

    /**
     * @param MappingInterface $mapping
     * @return $this
     */
    public function addMapping(MappingInterface $mapping);

    /**
     * @param $fromField
     * @param MapInterface $map
     * @return $this
     */
    public function addEmbedded($fromField, MapInterface $map);

    /**
     * @param $toField
     * @param ValueResolverInterface $resolver
     * @return $this
     */
    public function addResolver($toField, ValueResolverInterface $resolver);

    /**
     * @return MapInterface
     */
    public function getMap();
}
