<?php

namespace tests;

use Cascade\Mapper\Context\ContextInterface;
use Cascade\Mapper\Map\MapInterface;
use Cascade\Mapper\Mapper;
use Cascade\Mapper\Mapping\MappingInterface;

class MapperTest extends \PHPUnit_Framework_TestCase
{
    public function testCanMapValues()
    {
        $destination = [
            'test' => 'test destination'
        ];

        $firstDestination = [
            'test' => 'first destination'
        ];

        $secondDestination = [
            'test' => 'second destination'
        ];

        $source = [
            'test' => 'test source'
        ];

        $context = $this
            ->getMockBuilder(ContextInterface::class)
            ->setMethods(['getMap'])
            ->getMock()
        ;

        $context
            ->expects($this->once())
            ->method('getMap')
            ->willReturnCallback(function () use ($destination, $firstDestination, $secondDestination, $source) {
                $map = $this
                    ->getMockBuilder(MapInterface::class)
                    ->setMethods(['getMappings'])
                    ->getMock()
                ;

                $map
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
                            ->with($destination, $source)
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
                            ->with($firstDestination, $source)
                            ->willReturn($secondDestination)
                        ;

                        $mappings[] = $mapping;

                        return $mappings;
                    })
                ;

                return $map;
            })
        ;

        $instance = new Mapper();

        $expectedResult = $secondDestination;
        $result = $instance->map($destination, $source, $context);

        $this->assertSame($expectedResult, $result);
    }
}
