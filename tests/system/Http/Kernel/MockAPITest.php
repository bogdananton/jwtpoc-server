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
     *
     * @param string $baseUrl
     * @dataProvider dataProviderAPIUrls
     */
    public function testWhenAccessingTheRootPathThenReturnTheIntrospectionLinks($baseUrl)
    {
        $expected = (object) [
            'clients_link' => $baseUrl . '/clients',
            'settings_link' => $baseUrl . '/settings',
        ];

        $response = $this->client->get($baseUrl);
        $contents = json_decode($response->getBody()->getContents());

        static::assertEquals($expected, $contents);
    }

    /**
     * When accessing the clients listing then get an array.
     *
     * @param string $baseUrl
     * @dataProvider dataProviderAPIUrls
     */
    public function testWhenAccessingTheClientsListingThenGetAnArray($baseUrl)
    {
        $response = $this->client->get($baseUrl . '/clients');
        $contents = json_decode($response->getBody()->getContents());

        static::assertTrue(is_array($contents));
    }

    /**
     * When accessing the settings listing then get an array.
     *
     * @param string $baseUrl
     * @dataProvider dataProviderAPIUrls
     */
    public function testWhenAccessingTheSettingsListingThenGetAnArray($baseUrl)
    {
        $response = $this->client->get($baseUrl . '/settings');
        $contents = json_decode($response->getBody()->getContents());

        static::assertTrue(is_array($contents), print_r($contents, true));
    }

    /**
     * Using this to ensure that both URLs behave the same.
     *
     * @return array
     */
    public function dataProviderAPIUrls()
    {
        return [
            [
                MOCK_API_URL,
            ],
            [
                ACTUAL_API_URL,
            ]
        ];
    }
}