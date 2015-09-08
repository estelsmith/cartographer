<?php

namespace Cascade\Mapper\Map;

use Cascade\Mapper\Field\Reference\ArrayReference;
use Cascade\Mapper\Field\Reference\MutatorReference;
use Cascade\Mapper\Field\Reference\PropertyReference;
use Cascade\Mapper\Field\Reference\ReferenceInterface;
use Cascade\Mapper\Mapping\Mapping;
use Cascade\Mapper\Mapping\MappingInterface;

class Map implements MapInterface
{
    const REF_ARRAY = 'ref_array';
    const REF_CLASS_PROPERTIES = 'ref_class_properties';
    const REF_CLASS_MUTATORS = 'ref_class_mutators';

    /**
     * @var string
     */
    private $from = self::REF_ARRAY;

    /**
     * @var MappingInterface[]
     */
    private $mappings = [];

    /**
     * @var string
     */
    private $to = self::REF_ARRAY;

    public function getMappings()
    {
        return $this->mappings;
    }

    /**
     * @param string $from
     * @return $this
     */
    public function from($from)
    {
        if ($this->isValidRefType($from)) {
            $this->from = $from;
            return $this;
        }

        // @TODO: Throw Invalid From exception.
        return $this;
    }

    /**
     * @param string $to
     * @return $this
     */
    public function to($to)
    {
        if ($this->isValidRefType($to)) {
            $this->to = $to;
            return $this;
        }

        // @TODO: Throw Invalid To exception.
        return $this;
    }

    /**
     * @param string $fromField
     * @param string $toField
     * @return $this
     */
    public function add($fromField, $toField)
    {
        $destinationReference = $this->referenceField($this->to, $toField);
        $sourceReference = $this->referenceField($this->from, $fromField);

        $this->mappings[] = new Mapping($destinationReference, $sourceReference);

        return $this;
    }

    /**
     * @param MappingInterface $mapping
     * @return $this
     */
    public function addMapping(MappingInterface $mapping)
    {
        $this->mappings[] = $mapping;
        return $this;
    }

    /**
     * @param string $refType
     * @return bool
     */
    private function isValidRefType($refType)
    {
        $validRefTypes = [self::REF_ARRAY, self::REF_CLASS_PROPERTIES, self::REF_CLASS_MUTATORS];

        if (in_array($refType, $validRefTypes, true)) {
            return true;
        }

        return false;
    }

    /**
     * @param string $refType
     * @param string $field
     * @return ReferenceInterface
     */
    private function referenceField($refType, $field)
    {
        switch ($refType) {
            case self::REF_CLASS_PROPERTIES:
                return new PropertyReference($field);
                break;
            case self::REF_CLASS_MUTATORS:
                return new MutatorReference($field);
                break;
            default:
                return new ArrayReference($field);
                break;
        }
    }
}
