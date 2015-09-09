<?php

namespace tests\Field\Reference;

use Cascade\Mapper\Field\Reference\ArrayReference;

class ArrayReferenceTest extends \PHPUnit_Framework_TestCase
{
    public function testGetValueOnNonExistentFieldReturnsNull()
    {
        $data = [
            'test1' => 'test one',
            'test' => 'test',
            'test2' => 'test two'
        ];
        $field = 'non-existent';

        $instance = new ArrayReference($field);

        $expectedResult = null;
        $actualResult = $instance->getValue($data);

        $this->assertSame($expectedResult, $actualResult);
    }

    public function testGetValueReturnsAppropriateValue()
    {
        $data = [
            'test1' => 'test one',
            'test' => 'test',
            'test2' => 'test two'
        ];
        $field = 'test';

        $instance = new ArrayReference($field);

        $expectedResult = $data[$field];
        $actualResult = $instance->getValue($data);

        $this->assertSame($expectedResult, $actualResult);
    }

    public function testSetValueReturnsUpdatedInstance()
    {
        $data = [
            'test1' => 'test one',
            'test' => 'test',
            'test2' => 'test two'
        ];
        $field = 'test';
        $value = 'actual test';

        $instance = new ArrayReference($field);

        $expectedResult = $data;
        $expectedResult[$field] = $value;
        $actualResult = $instance->setValue($data, $value);

        $this->assertSame($expectedResult, $actualResult);
    }
}
