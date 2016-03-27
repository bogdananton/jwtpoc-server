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

use JWTPOC\Resources\Settings\Persistence\Factory;
use JWTPOC\Resources\Settings\Persistence\Gateways\JSONFile;
use JWTPOC\Resources\Settings\Persistence\Models\Item;
use Symfony\Component\Filesystem\Filesystem;

class AllTest extends \PHPUnit_Framework_TestCase
{
    /** @var  Filesystem|\Mockery\MockInterface */
    protected $filesystem;

    /** @var  JSONFile|\Mockery\MockInterface */
    protected $gateway;

    /** @var  Factory|\Mockery\MockInterface */
    protected $factory;

    /** @var  string */
    protected $path;

    static public $systemMock;

    public function setUp()
    {
        $this->path = '/path/to/persistence/settings.json';
        $this->filesystem = \Mockery::mock(Filesystem::class);
        $this->factory = \Mockery::mock(Factory::class)->makePartial();

        $args = [
            $this->filesystem,
            $this->path,
            $this->factory,
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
                'name' => 'name-1',
                'description' => 'description-1',
                'value' => 'value-1',
                'type' => 'type-1',
                'public' => true,
                'admin' => true,
                'writable' => true,
            ],
            (object)[
                'name' => 'name-2',
                'description' => 'description-2',
                'value' => 'value-2',
                'type' => 'type-2',
                'public' => true,
                'admin' => true,
                'writable' => true,
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

        $expected = [];
        foreach ($contents as $content) {
            $expected[] = new Item(
                $content->name,
                $content->description,
                $content->value,
                $content->type,
                $content->public,
                $content->admin,
                $content->writable
            );
        }

        static::assertEquals($expected, $response);
    }
}