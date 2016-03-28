<?php
namespace JWTPOCUnitTests\Resources\Settings\Presentation\Models\Collection;


use JWTPOC\Resources\Settings\Presentation\Models\Collection;
use JWTPOC\Resources\Settings\Presentation\Models\Item;

class ConstructTest extends \PHPUnit_Framework_TestCase
{
    /**
     * When calling toArray will return an array of the input values.
     */
    public function testWhenCallingToArrayWillReturnAnArrayOfTheInputValues()
    {
        $domainItem0 = new Item('name-0', 'description-0', 'value-0', true);
        $domainItem1 = new Item('name-1', 'description-1', 'value-1', true);

        $collection = new Collection([
            $domainItem0,
            $domainItem1,
        ]);

        $contents = $collection->toArray();
        static::assertEquals(2, $contents->count());

        $expected0 = [
            'name' => 'name-0',
            'description' => 'description-0',
            'value' => 'value-0',
        ];

        $expected1 = [
            'name' => 'name-1',
            'description' => 'description-1',
            'value' => 'value-1',
        ];

        static::assertEquals($expected0, $contents->get(0));
        static::assertEquals($expected1, $contents->get(1));
    }
}
