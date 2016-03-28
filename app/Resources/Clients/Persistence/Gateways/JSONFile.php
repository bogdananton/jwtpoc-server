<?php
namespace JWTPOC\Resources\Clients\Persistence\Gateways;

use JWTPOC\Contracts\Clients\Gateway;
use JWTPOC\Resources\Clients\Persistence\Factory;
use JWTPOC\Resources\Clients\Persistence\Models\Item;
use Symfony\Component\Filesystem\Filesystem;

class JSONFile implements Gateway
{
    /** @var Filesystem  */
    protected $fs;

    /** @var string  */
    protected $path;

    /** @var Factory  */
    protected $factory;

    /**
     * Use the filesystem to load clients.
     *
     * @param Filesystem $filesystem
     * @param string $path  JSON file path.
     * @param Factory $factory
     */
    public function __construct(Filesystem $filesystem, $path, Factory $factory)
    {
        $this->fs = $filesystem;
        $this->path = $path;
        $this->factory = $factory;
    }

    /**
     * @return Item[]
     */
    public function all()
    {
        $response = [];

        if ($this->fs->exists($this->path)) {
            $contents = file_get_contents($this->path);
            $data = json_decode($contents);

            if (is_array($data)) {
                foreach ($data as $entry) {
                    $response[] = $this->factory->buildItem(
                        $entry->name,
                        $entry->description,
                        $entry->callbackUrl
                    );
                }
            }

        } else {
            // @todo log this
        }

        return $response;
    }
}