<?php
namespace JWTPOC\Resources\Settings\Persistence\Gateways;

use JWTPOC\Contracts\Settings\Gateway;
use JWTPOC\Resources\Settings\Persistence\Factory;
use JWTPOC\Resources\Settings\Persistence\Models\Item;
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
     * Use the filesystem to load settings.
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
        $settingsFile = $this->path;
        $response = [];

        if ($this->fs->exists($settingsFile)) {
            $contents = file_get_contents($settingsFile);
            $data = json_decode($contents);

            if (is_array($data)) {
                foreach ($data as $entry) {
                    $response[] = $this->factory->buildItem(
                        $entry->name,
                        $entry->description,
                        $entry->value,
                        $entry->type,
                        $entry->public,
                        $entry->admin,
                        $entry->writable
                    );
                }
            }

            // @todo ensure that the proper structure is returned in the resulting array
            // ...

        } else {
            // @todo log this
        }

        return $response;
    }
}