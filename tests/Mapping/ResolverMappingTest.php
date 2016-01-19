<?php

namespace tests\Mapping;

use Cascade\Mapper\Field\Reference\ReferenceInterface;
use Cascade\Mapper\Mapping\ResolverMapping;
use Cascade\Mapper\Value\Resolver\ValueResolverInterface;

class ResolverMappingTest extends \PHPUnit_Framework_TestCase
{
    public function testCanMapValue()
    {
        $destination = [
            'test' => 'test destination'
        ];

        $source = [
            'test' => 'test source'
        ];

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

        $resolver = $this
            ->getMockBuilder(ValueResolverInterface::class)
            ->setMethods(['resolve'])
            ->getMock()
        ;

        $resolver
            ->expects($this->once())
            ->method('resolve')
            ->with($source, $destination)
            ->willReturn($source['test'])
        ;

        $instance = new ResolverMapping($destinationReference, $resolver);

        $expectedResult = $destination;
        $result = $instance->map($destination, $source);

        $this->assertSame($expectedResult, $result);
    }
}
