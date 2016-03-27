<?php
namespace JWTPOCSystemTests\Application\Http\Kernel;

use GuzzleHttp\Client;

class APITest extends \PHPUnit_Framework_TestCase
{
    const PERSISTENCE_PATH = ROOT_PATH . 'storage/persistence/';
    const KEYS_PATH = ROOT_PATH . 'storage/keys/';

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
        $contents = $this->getSuccessfulResponseContents($baseUrl . '/clients');
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
        $contents = $this->getSuccessfulResponseContents($baseUrl . '/settings');
        static::assertTrue(is_array($contents), print_r($contents, true));
    }

    // @todo move Settings endpoint checks to SettingsAPITest

    /**
     * Settings listing will include structures having name as non-empty string.
     *
     * @param string $baseUrl
     * @dataProvider dataProviderAPIUrls
     */
    public function testSettingsListingWillIncludeStructuresHavingNameAsNonEmptyString($baseUrl)
    {
        $contents = $this->getSuccessfulResponseContents($baseUrl . '/settings');

        if (empty($contents)) {
            static::markTestSkipped('No settings entries found, can\'t check this.');
        }

        foreach ($contents as $entry) {
            static::assertObjectHasAttribute('name', $entry);
            static::assertInternalType('string', $entry->name);
            static::assertNotEmpty($entry->name);
        }
    }

    /**
     * Settings listing will include structures having description as non-empty string.
     *
     * @param string $baseUrl
     * @dataProvider dataProviderAPIUrls
     */
    public function testSettingsListingWillIncludeStructuresHavingDescriptionAsNonEmptyString($baseUrl)
    {
        $contents = $this->getSuccessfulResponseContents($baseUrl . '/settings');

        if (empty($contents)) {
            static::markTestSkipped('No settings entries found, can\'t check this.');
        }

        foreach ($contents as $entry) {
            static::assertObjectHasAttribute('description', $entry);
            static::assertInternalType('string', $entry->description);
            static::assertNotEmpty($entry->description);
        }
    }

    /**
     * Settings listing will include structures having value as non-empty string.
     *
     * @param string $baseUrl
     * @dataProvider dataProviderAPIUrls
     */
    public function testSettingsListingWillIncludeStructuresHavingValueAsNonEmptyString($baseUrl)
    {
        $contents = $this->getSuccessfulResponseContents($baseUrl . '/settings');

        if (empty($contents)) {
            static::markTestSkipped('No settings entries found, can\'t check this.');
        }

        foreach ($contents as $entry) {
            static::assertObjectHasAttribute('value', $entry);
            static::assertInternalType('string', $entry->value);
            static::assertNotEmpty($entry->value);
        }
    }

    /**
     * Settings listing will include details found in the settings persistence that are marked with the public flag.
     */
    public function testSettingsListingWillIncludeDetailsFoundInTheSettingsPersistenceThatAreMarkedWithThePublicFlag()
    {
        $contents = $this->getSuccessfulResponseContents(ACTUAL_API_URL . '/settings');

        if (empty($contents)) {
            static::markTestSkipped('No settings entries found, can\'t check this.');
        }
        
        $loadedSettings = json_decode(file_get_contents(self::PERSISTENCE_PATH . 'settings.json'));

        foreach ($contents as $entry) {
            $foundSetting = null;

            foreach ($loadedSettings as $setting) {
                if ($setting->name == $entry->name) {
                    $foundSetting = $setting;
                    break;
                }
            }

            if (is_null($foundSetting)) {
                static::fail('The API returned an entry that was not matched in the stored entries.');
            }

            static::assertTrue($foundSetting->public);
            static::assertEquals($foundSetting->description, $entry->description);

            if ($foundSetting->type == 'string') {
                static::assertEquals($foundSetting->value, $entry->value);

            } else if ($foundSetting->type == 'pub') {
                $path = self::KEYS_PATH . $foundSetting->value;

                $keyContents = file_get_contents($path);
                $keyContents = str_replace([PHP_EOL, "\n", "\r\n"], '', $keyContents);
                $actual = str_replace([PHP_EOL, "\n", "\r\n"], '', $entry->value);

                static::assertEquals($keyContents, $actual);

            } else {
                static::fail(
                    'Unknown entry type. '
                    . ' Stored: ' . print_r($foundSetting, true)
                    . ' Received: ' . print_r($entry, true)
                );
            }
        }
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

    /**
     * @param $url
     * @return mixed
     */
    protected function getSuccessfulResponseContents($url)
    {
        $response = $this->client->get($url);
        $contents = json_decode($response->getBody()->getContents());
        return $contents;
    }
}