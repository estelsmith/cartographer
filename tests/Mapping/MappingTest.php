<?php

namespace tests\Mapping;

use Cascade\Mapper\Field\Reference\ReferenceInterface;
use Cascade\Mapper\Mapping\Mapping;

class MappingTest extends \PHPUnit_Framework_TestCase
{
    public function testCanMapValue()
    {
        $destination = [
            'test' => 'test destination'
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

        $destinationReference = $this
            ->getMockBuilder(ReferenceInterface::class)
            ->setMethods(['getValue', 'setValue'])
            ->getMock()
        ;

        $destinationReference
            ->expects($this->once())
            ->method('setValue')
            ->with($destination, $source['test'])
            ->willReturn($destination)
        ;

        $instance = new Mapping($destinationReference, $sourceReference);

        $expectedResult = $destination;
        $result = $instance->map($destination, $source);

        $this->assertSame($expectedResult, $result);
    }
}
