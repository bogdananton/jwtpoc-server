<?php
namespace tests\system\Http\Kernel;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class RoutesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * When accessing a route that will not be found then return page not found with 404 status code.
     */
    public function testWhenAccessingARouteThatWillNotBeFoundThenReturnPageNotFoundWith404StatusCode()
    {
        $client = new Client();

        try {
            $client->get(BASE_URL . '/not-found-for-sure');
            static::fail('Expected an exception to have been thrown.');

        } catch (ClientException $e) {
            $contents = json_decode($e->getResponse()->getBody()->getContents());
            static::assertEquals('Page not found.', $contents->message);

        } catch (\Exception $e) {
            static::fail($e->getMessage());
        }
    }

    /**
     * When accessing a test route then return expected sample.
     */
    public function testWhenAccessingATestRouteThenReturnExpectedSample()
    {
        $client = new Client();
        $expected = ['success' => true];

        $response = $client->get(BASE_URL . '/test-url');
        $contents = json_decode($response->getBody()->getContents(), true);

        static::assertEquals($expected, $contents);
    }
}