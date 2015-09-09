<?php

namespace tests\Field\Reference;

use Cascade\Mapper\Field\Reference\MutatorReference;

interface MutatorReferenceStub
{
    public function getTestValue();

    public function setTestValue();

    public function addTestValue();

    public function isTestValue();
}

class MutatorReferenceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $target;

    public function setUp()
    {
        $this->target = $this
            ->getMockBuilder(MutatorReferenceStub::class)
            ->setMethods(['getTestValue', 'setTestValue', 'addTestValue', 'isTestValue'])
            ->getMock()
        ;
    }

    public function testGetValueReturnsAppropriateValue()
    {
        $expectedGetter = 'getTestValue';
        $field = 'testValue';

        $expectedResult = 'test';
        $actualResult = null;

        $target = $this->target;
        $target
            ->expects($this->once())
            ->method($expectedGetter)
            ->willReturn($expectedResult)
        ;

        $instance = new MutatorReference($field);
        $actualResult = $instance->getValue($target);

        $this->assertSame($expectedResult, $actualResult);
    }

    public function testGetValueWithCustomGetterReturnsAppropriateValue()
    {
        $expectedGetter = 'isTestValue';
        $field = 'testValue';

        $expectedResult = 'test';
        $actualResult = null;

        $target = $this->target;
        $target
            ->expects($this->once())
            ->method($expectedGetter)
            ->willReturn($expectedResult)
        ;

        $instance = new MutatorReference($field, $expectedGetter);
        $actualResult = $instance->getValue($target);

        $this->assertSame($expectedResult, $actualResult);
    }

    public function testGetValueNormalizesFieldBeforeReturning()
    {
        $expectedGetter = 'getTestValue';
        $field = 'test_value';

        $expectedResult = 'test';
        $actualResult = null;

        $target = $this->target;
        $target
            ->expects($this->once())
            ->method($expectedGetter)
            ->willReturn($expectedResult)
        ;

        $instance = new MutatorReference($field);
        $actualResult = $instance->getValue($target);

        $this->assertSame($expectedResult, $actualResult);
    }

    public function testSetValueCallsAppropriateSetter()
    {
        $expectedSetter = 'setTestValue';
        $field = 'testValue';
        $value = 'test';

        $target = $this->target;

        $expectedResult = $target;
        $actualResult = null;

        $target
            ->expects($this->once())
            ->method($expectedSetter)
            ->willReturnSelf()
        ;

        $instance = new MutatorReference($field);
        $actualResult = $instance->setValue($target, $value);

        $this->assertSame($expectedResult, $actualResult);
    }

    public function testSetValueWithCustomSetterCallsAppropriateSetter()
    {
        $expectedSetter = 'addTestValue';
        $field = 'testValue';
        $value = 'test';

        $target = $this->target;

        $expectedResult = $target;
        $actualResult = null;

        $target
            ->expects($this->once())
            ->method($expectedSetter)
            ->willReturnSelf()
        ;

        $instance = new MutatorReference($field, null, $expectedSetter);
        $actualResult = $instance->setValue($target, $value);

        $this->assertSame($expectedResult, $actualResult);
    }

    public function testSetValueNormalizedFieldBeforeCallingSetter()
    {
        $expectedSetter = 'setTestValue';
        $field = 'test_value';
        $value = 'test';

        $target = $this->target;

        $expectedResult = $target;
        $actualResult = null;

        $target
            ->expects($this->once())
            ->method($expectedSetter)
            ->willReturnSelf()
        ;

        $instance = new MutatorReference($field);
        $actualResult = $instance->setValue($target, $value);

        $this->assertSame($expectedResult, $actualResult);
    }
}
