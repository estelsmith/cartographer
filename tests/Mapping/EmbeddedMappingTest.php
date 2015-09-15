<?php

namespace tests\Mapping;

use Cascade\Mapper\Field\Reference\ReferenceInterface;
use Cascade\Mapper\Map\MapInterface;
use Cascade\Mapper\Mapping\EmbeddedMapping;
use Cascade\Mapper\Mapping\MappingInterface;

class EmbeddedMappingTest extends \PHPUnit_Framework_TestCase
{
    public function testCanMapValue()
    {
        $destination = [
            'test' => 'test destination'
        ];

        $firstDestination = [
            'test' => '1st destination'
        ];

        $secondDestination = [
            'test' => '2nd destination'
        ];

        $source = [
            'test' => 'test source'
        ];

        $sourceReference = $this
            ->getMockBuilder(ReferenceInterface::class)
            ->setMethods(['getValue', 'setValue'])
            ->getMock()
        ;

        $sourceReference
            ->expects($this->once())
            ->method('getValue')
            ->willReturn($source['test'])
        ;

        $embeddedMap = $this
            ->getMockBuilder(MapInterface::class)
            ->setMethods(['getMappings'])
            ->getMock()
        ;

        $embeddedMap
            ->expects($this->once())
            ->method('getMappings')
            ->willReturnCallback(function () use ($destination, $firstDestination, $secondDestination, $source) {
                $mappings = [];

                $mapping = $this
                    ->getMockBuilder(MappingInterface::class)
                    ->setMethods(['map'])
                    ->getMock()
                ;

                $mapping
                    ->expects($this->once())
                    ->method('map')
                    ->with($destination, $source['test'])
                    ->willReturn($firstDestination)
                ;

                $mappings[] = $mapping;

                $mapping = $this
                    ->getMockBuilder(MappingInterface::class)
                    ->setMethods(['map'])
                    ->getMock()
                ;

                $mapping
                    ->expects($this->once())
                    ->method('map')
                    ->with($firstDestination, $source['test'])
                    ->willReturn($secondDestination)
                ;

                $mappings[] = $mapping;

                return $mappings;
            })
        ;

        $instance = new EmbeddedMapping($sourceReference, $embeddedMap);

        $expectedResult = $secondDestination;
        $result = $instance->map($destination, $source);

        $this->assertSame($expectedResult, $result);
    }
}
