<?php

namespace tests\Map;

use Cascade\Mapper\Field\Reference\ArrayReference;
use Cascade\Mapper\Field\Reference\MutatorReference;
use Cascade\Mapper\Field\Reference\PropertyReference;
use Cascade\Mapper\Map\Exception\InvalidReferenceTypeException;
use Cascade\Mapper\Map\Map;
use Cascade\Mapper\Mapping\EmbeddedMapping;
use Cascade\Mapper\Mapping\Mapping;
use Cascade\Mapper\Mapping\ResolverMapping;
use Cascade\Mapper\Value\Resolver\ValueResolverInterface;

class ResolverStub implements ValueResolverInterface
{
    public function resolve($source)
    {
        return 'test';
    }
}

class MapTest extends \PHPUnit_Framework_TestCase
{
    public function testFromWithInvalidReferenceTypeWillThrowAnException()
    {
        $expectedException = InvalidReferenceTypeException::class;
        $actualException = null;

        $referenceType = 'invalid';

        $instance = new Map();

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
            Map::REF_ARRAY,
            Map::REF_CLASS_PROPERTIES,
            Map::REF_CLASS_MUTATORS
        ];

        $expectedException = null;
        $actualException = null;

        $instance = new Map();

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

        $instance = new Map();

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
            Map::REF_ARRAY,
            Map::REF_CLASS_PROPERTIES,
            Map::REF_CLASS_MUTATORS
        ];

        $expectedException = null;
        $actualException = null;

        $instance = new Map();

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

        $instance = (new Map())
            ->from(Map::REF_ARRAY)
            ->to(Map::REF_CLASS_MUTATORS)
            ->add($toField, $fromField)
            ->from(Map::REF_CLASS_PROPERTIES)
            ->add($toField, $fromField)
        ;

        $actualMappings = $instance->getMappings();

        $this->assertEquals($expectedMappings, $actualMappings);
    }

    public function testCanAddEmbeddedMappings()
    {
        $toField = 'toField';
        $fromField = 'fromField';

        $expectedMappings = [
            new EmbeddedMapping(new MutatorReference($fromField), (new Map())
                ->from(Map::REF_CLASS_PROPERTIES)
                ->to(Map::REF_CLASS_MUTATORS)
                ->add($toField, $fromField)
            ),
            new EmbeddedMapping(new MutatorReference($fromField), (new Map())
                ->from(Map::REF_ARRAY)
                ->to(Map::REF_ARRAY)
                ->add($toField, $fromField)
            )
        ];
        $actualMappings = null;

        $instance = (new Map())
            ->from(Map::REF_CLASS_MUTATORS)
            ->to(Map::REF_CLASS_MUTATORS)
            ->addEmbedded($fromField, (new Map())
                ->from(Map::REF_CLASS_PROPERTIES)
                ->to(Map::REF_CLASS_MUTATORS)
                ->add($toField, $fromField)
            )
            ->addEmbedded($fromField, (new Map())
                ->from(Map::REF_ARRAY)
                ->to(Map::REF_ARRAY)
                ->add($toField, $fromField))
        ;

        $actualMappings = $instance->getMappings();

        $this->assertEquals($expectedMappings, $actualMappings);
    }

    public function testCanAddResolverMappings()
    {
        $toField = 'toField';

        $expectedMappings = [
            new ResolverMapping(new MutatorReference($toField), new ResolverStub())
        ];
        $actualMappings = null;

        $instance = (new Map())
            ->from(Map::REF_ARRAY)
            ->to(Map::REF_CLASS_MUTATORS)
            ->addResolver($toField, new ResolverStub())
        ;

        $actualMappings = $instance->getMappings();

        $this->assertEquals($expectedMappings, $actualMappings);
    }

    public function testCanAddMixedMappings()
    {
        $expectedMappings = [
            new Mapping(new MutatorReference('id'), new ArrayReference('id')),
            new EmbeddedMapping(new ArrayReference('attributes'), (new Map())
                ->from(Map::REF_ARRAY)
                ->to(Map::REF_CLASS_MUTATORS)
                ->add('name', 'name')
            ),
            new ResolverMapping(new MutatorReference('full_name'), new ResolverStub()),
            new Mapping(new MutatorReference('another_test'), new ArrayReference('another_test'))
        ];
        $actualMappings = null;

        $instance = (new Map())
            ->from(Map::REF_ARRAY)
            ->to(Map::REF_CLASS_MUTATORS)
            ->add('id', 'id')
            ->addEmbedded('attributes', (new Map())
                ->from(Map::REF_ARRAY)
                ->to(Map::REF_CLASS_MUTATORS)
                ->add('name', 'name')
            )
            ->addResolver('full_name', new ResolverStub())
            ->addMapping(new Mapping(new MutatorReference('another_test'), new ArrayReference('another_test')))
        ;

        $actualMappings = $instance->getMappings();

        $this->assertEquals($expectedMappings, $actualMappings);
    }
}
