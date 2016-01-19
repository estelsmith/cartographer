<?php

namespace tests\Value\Resolver;

use Cascade\Mapper\Value\Resolver\CallableValueResolver;

class CallableResolverTest extends \PHPUnit_Framework_TestCase
{
    public function testResolveWillCallCallback()
    {
        $called = false;

        $instance = new CallableValueResolver(function () use (&$called) {
            $called = true;
        });

        $instance->resolve([], []);

        $this->assertTrue($called);
    }

    public function testResolvePassesSource()
    {
        $expectedSource = [
            'test' => 'test123'
        ];
        $actualSource = null;

        $instance = new CallableValueResolver(function ($source) use (&$actualSource) {
            $actualSource = $source;
        });

        $instance->resolve($expectedSource, []);

        $this->assertSame($expectedSource, $actualSource);
    }

    public function testResolvePassesDestination()
    {
        $expectedDestination = [];
        $actualDestination = null;

        $instance = new CallableValueResolver(function ($source, $destination) use (&$actualDestination) {
            $actualDestination = $destination;
        });

        $instance->resolve([], $expectedDestination);

        $this->assertSame($expectedDestination, $actualDestination);
    }

    public function testResolveWillReturnCallbackReturn()
    {
        $expectedResult = 'returned!';
        $actualResult = null;

        $instance = new CallableValueResolver(function () use ($expectedResult) {
            return $expectedResult;
        });

        $actualResult = $instance->resolve([], []);

        $this->assertSame($expectedResult, $actualResult);
    }
}
