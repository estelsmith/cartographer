<?php

namespace tests\Map;

use Cascade\Mapper\Map\Map;
use Cascade\Mapper\Mapping\MappingInterface;

class MapTest extends \PHPUnit_Framework_TestCase
{
    public function testCanGetMappings()
    {
        $expectedMappings = [
            $this->getMockBuilder(MappingInterface::class)->setMethods(['map'])->getMock(),
            $this->getMockBuilder(MappingInterface::class)->setMethods(['map'])->getMock(),
            $this->getMockBuilder(MappingInterface::class)->setMethods(['map'])->getMock()
        ];

        $instance = new Map($expectedMappings);

        $expectedResult = $expectedMappings;
        $result = $instance->getMappings();

        $this->assertSame($expectedResult, $result);
    }
}
