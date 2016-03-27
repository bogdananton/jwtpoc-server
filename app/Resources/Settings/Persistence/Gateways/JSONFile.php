<?php
namespace JWTPOC\Resources\Settings\Persistence\Gateways;

use JWTPOC\Contracts\Settings\Gateway;
use JWTPOC\Resources\Settings\Persistence\Factory;
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

    public function all()
    {
        $settingsFile = $this->path;
        $data = [];

        if ($this->fs->exists($settingsFile)) {
            $contents = file_get_contents($settingsFile);
            $data = json_decode($contents);

            // @todo ensure that the proper structure is returned in the resulting array
            // ...

        } else {
            // @todo log this
        }

        return !empty($data) && is_array($data) ? $data : [];
    }
}