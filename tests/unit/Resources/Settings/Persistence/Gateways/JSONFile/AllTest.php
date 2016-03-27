<?php
namespace JWTPOC\Resources\Settings\Persistence\Gateways;

use JWTPOCUnitTests\Resources\Persistence\Gateways\JSONFile\AllTest;

function file_get_contents($file)
{
    $mock = AllTest::$systemMock;
    $contents = $mock->file_get_contents($file);

    return $contents;
}

namespace JWTPOCUnitTests\Resources\Persistence\Gateways\JSONFile;

use JWTPOC\Resources\Settings\Persistence\Gateways\JSONFile;
use Symfony\Component\Filesystem\Filesystem;

class AllTest extends \PHPUnit_Framework_TestCase
{
    /** @var  Filesystem|\Mockery\MockInterface */
    protected $filesystem;

    /** @var  JSONFile|\Mockery\MockInterface */
    protected $gateway;

    /** @var  string */
    protected $path;

    static public $systemMock;

    public function setUp()
    {
        $this->path = '/path/to/persistence/settings.json';
        $this->filesystem = \Mockery::mock(Filesystem::class);

        $args = [
            $this->filesystem,
            $this->path,
        ];

        $this->gateway = \Mockery::mock(JSONFile::class, $args)->makePartial();
    }

    public function tearDown()
    {
        \Mockery::close();
    }

    /**
     * When then file is not found then return empty array.
     */
    public function testWhenThenFileIsNotFoundThenReturnEmptyArray()
    {
        $this->filesystem
            ->shouldReceive('exists')
            ->once()
            ->with($this->path)
            ->andReturn(false);

        $response = $this->gateway->all();
        static::assertSame([], $response);
    }

    /**
     * When the file is found then return the json decoded contents.
     */
    public function testWhenTheFileIsFoundThenReturnTheJsonDecodedContents()
    {
        $contents = [
            (object)[
                'name' => 'n1',
                'description' => 'd1',
                'value' => 'v1',
            ],
            (object)[
                'name' => 'n2',
                'description' => 'd2',
                'value' => 'v2',
            ],
        ];

        $fileContentsJsonEncoded = json_encode($contents);

        $this->filesystem
            ->shouldReceive('exists')
            ->once()
            ->with($this->path)
            ->andReturn(true);

        $mock = \Mockery::mock('fake');
        $mock->shouldReceive('file_get_contents')
            ->once()
            ->with($this->path)
            ->andReturn($fileContentsJsonEncoded);

        self::$systemMock = $mock;

        $response = $this->gateway->all();
        static::assertEquals($contents, $response);
    }
}