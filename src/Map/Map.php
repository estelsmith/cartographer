<?php

namespace Cascade\Mapper\Map;

use Cascade\Mapper\Field\Reference\ArrayReference;
use Cascade\Mapper\Field\Reference\MutatorReference;
use Cascade\Mapper\Field\Reference\PropertyReference;
use Cascade\Mapper\Field\Reference\ReferenceInterface;
use Cascade\Mapper\Map\Exception\InvalidReferenceTypeException;
use Cascade\Mapper\Mapping\EmbeddedMapping;
use Cascade\Mapper\Mapping\Mapping;
use Cascade\Mapper\Mapping\MappingInterface;
use Cascade\Mapper\Mapping\ResolverMapping;
use Cascade\Mapper\Value\Resolver\ValueResolverInterface;

class Map implements MapInterface
{
    const REF_ARRAY = 'REF_ARRAY';
    const REF_CLASS_PROPERTIES = 'REF_CLASS_PROPERTIES';
    const REF_CLASS_MUTATORS = 'REF_CLASS_MUTATORS';

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
     * @throws InvalidReferenceTypeException
     */
    public function from($from)
    {
        return $this->setReference('from', $from);
    }

    /**
     * @param string $to
     * @return $this
     * @throws InvalidReferenceTypeException
     */
    public function to($to)
    {
        return $this->setReference('to', $to);
    }

    /**
     * @param string $toField
     * @param string $fromField
     * @return $this
     */
    public function add($toField, $fromField)
    {
        $destinationReference = $this->resolveToRef($toField);
        $sourceReference = $this->resolveFromRef($fromField);

        $this->addMapping(new Mapping($destinationReference, $sourceReference));

        return $this;
    }

    public function addEmbedded($fromField, MapInterface $map)
    {
        $this->addMapping(new EmbeddedMapping($this->resolveFromRef($fromField), $map));
        return $this;
    }

    public function addResolver($toField, ValueResolverInterface $resolver)
    {
        $this->addMapping(new ResolverMapping($this->resolveToRef($toField), $resolver));
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
     * @param string $field
     * @return ReferenceInterface
     */
    protected function resolveFromRef($field)
    {
        return $this->referenceField($this->from, $field);
    }

    /**
     * @param string $field
     * @return ReferenceInterface
     */
    protected function resolveToRef($field)
    {
        return $this->referenceField($this->to, $field);
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
            case self::REF_CLASS_MUTATORS:
                return new MutatorReference($field);
            default:
                return new ArrayReference($field);
        }
    }

    /**
     * @param string $target
     * @param string $reference
     * @return $this
     * @throws InvalidReferenceTypeException
     */
    private function setReference($target, $reference)
    {
        if ($this->isValidRefType($reference)) {
            $this->{$target} = $reference;
            return $this;
        }

        throw new InvalidReferenceTypeException(sprintf(
            'Reference type "%s" is not valid',
            $reference
        ));
    }
}
