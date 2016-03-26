<?php
namespace tests\system\Http\Kernel;

use GuzzleHttp\Client;

class MockAPITest extends \PHPUnit_Framework_TestCase
{
    protected $client;

    public function setUp()
    {
        $this->client = new Client();
    }

    /**
     * When accessing the root path then return the introspection links.
     */
    public function testWhenAccessingTheRootPathThenReturnTheIntrospectionLinks()
    {
        $expected = (object) [
            'clients_link' => MOCK_API_URL . '/clients',
            'settings_link' => MOCK_API_URL . '/settings',
        ];

        $response = $this->client->get(MOCK_API_URL);
        $contents = json_decode($response->getBody()->getContents());

        static::assertEquals($expected, $contents);
    }
}