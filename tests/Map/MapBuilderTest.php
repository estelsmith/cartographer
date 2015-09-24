<?php

namespace tests\Map;

use Cascade\Mapper\Field\Reference\ArrayReference;
use Cascade\Mapper\Field\Reference\MutatorReference;
use Cascade\Mapper\Field\Reference\PropertyReference;
use Cascade\Mapper\Map\Exception\InvalidReferenceTypeException;
use Cascade\Mapper\Map\MapBuilder;
use Cascade\Mapper\Mapping\EmbeddedMapping;
use Cascade\Mapper\Mapping\Mapping;
use Cascade\Mapper\Mapping\ResolverMapping;
use Cascade\Mapper\Value\Resolver\ValueResolverInterface;

class MapBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testFromWithInvalidReferenceTypeWillThrowAnException()
    {
        $expectedException = InvalidReferenceTypeException::class;
        $actualException = null;

        $referenceType = 'invalid';

        $instance = new MapBuilder();

        try {
            $instance->from($referenceType);
        } catch (\Exception $e) {
            $actualException = get_class($e);
        }

        $this->assertSame($expectedException, $actualException);
    }

    public function testFromWithValidReferenceWillNotThrowAnException()
    {
        $expectedReferences = [
            MapBuilder::REF_ARRAY,
            MapBuilder::REF_CLASS_PROPERTIES,
            MapBuilder::REF_CLASS_MUTATORS
        ];

        $expectedException = null;
        $actualException = null;

        $instance = new MapBuilder();

        try {
            foreach ($expectedReferences as $reference) {
                $instance->from($reference);
            }
        } catch (\Exception $e) {
            $actualException = get_class($e);
        }

        $this->assertSame($expectedException, $actualException);
    }

    public function testToWithInvalidReferenceTypeWillThrowAnException()
    {
        $expectedException = InvalidReferenceTypeException::class;
        $actualException = null;

        $referenceType = 'invalid';

        $instance = new MapBuilder();

        try {
            $instance->to($referenceType);
        } catch (\Exception $e) {
            $actualException = get_class($e);
        }

        $this->assertSame($expectedException, $actualException);
    }

    public function testToWithValidReferenceWillNotThrowAnException()
    {
        $expectedReferences = [
            MapBuilder::REF_ARRAY,
            MapBuilder::REF_CLASS_PROPERTIES,
            MapBuilder::REF_CLASS_MUTATORS
        ];

        $expectedException = null;
        $actualException = null;

        $instance = new MapBuilder();

        try {
            foreach ($expectedReferences as $reference) {
                $instance->to($reference);
            }
        } catch (\Exception $e) {
            $actualException = get_class($e);
        }

        $this->assertSame($expectedException, $actualException);
    }

    public function testCanAddPlainMappings()
    {
        $toField = 'toField';
        $fromField = 'fromField';

        $expectedMappings = [
            new Mapping(new MutatorReference($toField), new ArrayReference($fromField)),
            new Mapping(new MutatorReference($toField), new PropertyReference($fromField))
        ];
        $actualMappings = null;

        $instance = (new MapBuilder())
            ->from(MapBuilder::REF_ARRAY)
            ->to(MapBuilder::REF_CLASS_MUTATORS)
            ->add($toField, $fromField)
            ->from(MapBuilder::REF_CLASS_PROPERTIES)
            ->add($toField, $fromField)
        ;

        $actualMappings = $instance->getMap()->getMappings();

        $this->assertEquals($expectedMappings, $actualMappings);
    }

    public function testCanAddEmbeddedMappings()
    {
        $toField = 'toField';
        $fromField = 'fromField';

        $expectedMappings = [
            new EmbeddedMapping(new MutatorReference($fromField), (new MapBuilder())
                ->from(MapBuilder::REF_CLASS_PROPERTIES)
                ->to(MapBuilder::REF_CLASS_MUTATORS)
                ->add($toField, $fromField)
                ->getMap()
            ),
            new EmbeddedMapping(new MutatorReference($fromField), (new MapBuilder())
                ->from(MapBuilder::REF_ARRAY)
                ->to(MapBuilder::REF_ARRAY)
                ->add($toField, $fromField)
                ->getMap()
            )
        ];
        $actualMappings = null;

        $instance = (new MapBuilder())
            ->from(MapBuilder::REF_CLASS_MUTATORS)
            ->to(MapBuilder::REF_CLASS_MUTATORS)
            ->addEmbedded($fromField, (new MapBuilder())
                ->from(MapBuilder::REF_CLASS_PROPERTIES)
                ->to(MapBuilder::REF_CLASS_MUTATORS)
                ->add($toField, $fromField)
                ->getMap()
            )
            ->addEmbedded($fromField, (new MapBuilder())
                ->from(MapBuilder::REF_ARRAY)
                ->to(MapBuilder::REF_ARRAY)
                ->add($toField, $fromField)
                ->getMap()
            )
        ;

        $actualMappings = $instance->getMap()->getMappings();

        $this->assertEquals($expectedMappings, $actualMappings);
    }

    public function testCanAddResolverMappings()
    {
        $toField = 'toField';

        $resolver = $this
            ->getMockBuilder(ValueResolverInterface::class)
            ->setMethods(['resolve'])
            ->getMock()
        ;

        $expectedMappings = [
            new ResolverMapping(new MutatorReference($toField), $resolver)
        ];
        $actualMappings = null;

        $instance = (new MapBuilder())
            ->from(MapBuilder::REF_ARRAY)
            ->to(MapBuilder::REF_CLASS_MUTATORS)
            ->addResolver($toField, $resolver)
        ;

        $actualMappings = $instance->getMap()->getMappings();

        $this->assertEquals($expectedMappings, $actualMappings);
    }

    public function testCanAddMixedMappings()
    {
        $resolver = $this
            ->getMockBuilder(ValueResolverInterface::class)
            ->setMethods(['resolve'])
            ->getMock()
        ;

        $expectedMappings = [
            new Mapping(new MutatorReference('id'), new ArrayReference('id')),
            new EmbeddedMapping(new ArrayReference('attributes'), (new MapBuilder())
                ->from(MapBuilder::REF_ARRAY)
                ->to(MapBuilder::REF_CLASS_MUTATORS)
                ->add('name', 'name')
                ->getMap()
            ),
            new ResolverMapping(new MutatorReference('full_name'), $resolver),
            new Mapping(new MutatorReference('another_test'), new ArrayReference('another_test'))
        ];
        $actualMappings = null;

        $instance = (new MapBuilder())
            ->from(MapBuilder::REF_ARRAY)
            ->to(MapBuilder::REF_CLASS_MUTATORS)
            ->add('id', 'id')
            ->addEmbedded('attributes', (new MapBuilder())
                ->from(MapBuilder::REF_ARRAY)
                ->to(MapBuilder::REF_CLASS_MUTATORS)
                ->add('name', 'name')
                ->getMap()
            )
            ->addResolver('full_name', $resolver)
            ->addMapping(new Mapping(new MutatorReference('another_test'), new ArrayReference('another_test')))
        ;

        $actualMappings = $instance->getMap()->getMappings();

        $this->assertEquals($expectedMappings, $actualMappings);
    }
}
