<?php

namespace tests\Field\Reference;

use Cascade\Mapper\Field\Reference\PropertyReference;

class PropertyReferenceStub
{
    public $testValue;
}

class PropertyReferenceTest extends \PHPUnit_Framework_TestCase
{
    public function testGetValueOnStdClassReturnsAppropriateValue()
    {
        $field = 'test';

        $expectedResult = 'test value';
        $actualResult = null;

        $target = new \stdClass();
        $target->test = $expectedResult;

        $instance = new PropertyReference($field);
        $actualResult = $instance->getValue($target);

        $this->assertSame($expectedResult, $actualResult);
    }

    public function testGetValueReturnsAppropriateValue()
    {
        $field = 'testValue';

        $expectedResult = 'test value';
        $actualResult = null;

        $target = new PropertyReferenceStub();
        $target->testValue = $expectedResult;

        $instance = new PropertyReference($field);
        $actualResult = $instance->getValue($target);

        $this->assertSame($expectedResult, $actualResult);
    }

    public function testSetValueOnStdClassUpdatesInstance()
    {
        $field = 'test';

        $expectedResult = 'test value';
        $actualResult = null;

        $target = new \stdClass();
        $target->test = null;

        $instance = new PropertyReference($field);
        $resultTarget = $instance->setValue($target, $expectedResult);
        $actualResult = $target->$field;

        $this->assertSame($resultTarget, $target);
        $this->assertSame($expectedResult, $actualResult);
    }

    public function testSetValueUpdatesInstance()
    {
        $field = 'testValue';

        $expectedResult = 'test value';
        $actualResult = null;

        $target = new PropertyReferenceStub();

        $instance = new PropertyReference($field);
        $resultTarget = $instance->setValue($target, $expectedResult);
        $actualResult = $target->$field;

        $this->assertSame($resultTarget, $target);
        $this->assertSame($expectedResult, $actualResult);
    }
}
