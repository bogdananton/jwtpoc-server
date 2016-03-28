<?php
namespace JWTPOCUnitTests\Resources\Settings\Presentation\Models\Item;


use JWTPOC\Resources\Settings\Presentation\Models\Item;

class ConstructTest extends \PHPUnit_Framework_TestCase
{
    /**
     * When calling toArray will return an array of the input values.
     */
    public function testWhenCallingToArrayWillReturnAnArrayOfTheInputValues()
    {
        $domainItem = new Item('name-1', 'description-1', 'value-1', true);

        $contents = $domainItem->toArray();
        static::assertEquals('name-1', $contents['name']);
        static::assertEquals('description-1', $contents['description']);
        static::assertEquals('value-1', $contents['value']);
    }

    /**
     * When calling toString will return an array of the input values.
     */
    public function testWhenCallingToStringWillReturnAnArrayOfTheInputValues()
    {
        $domainItem = new Item('name-1', 'description-1', 'value-1', true);

        $expected = '{' . PHP_EOL .
        '    "name": "name-1",' . PHP_EOL .
        '    "description": "description-1",' . PHP_EOL .
        '    "value": "value-1"' . PHP_EOL .
        '}';

        static::assertEquals($expected, $domainItem->__toString());
    }
}