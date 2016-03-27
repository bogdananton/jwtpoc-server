<?php
namespace JWTPOC\Resources\Settings\Persistence\Gateways;

use JWTPOC\Resources\Settings\Persistence\GatewayInterface;
use Symfony\Component\Filesystem\Filesystem;

class JSONFile implements GatewayInterface
{
    /** @var Filesystem  */
    protected $fs;

    /** @var string  */
    protected $path;

    /**
     * Use the filesystem to load settings.
     *
     * @param string $path
     * @param Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem, $path)
    {
        $this->fs = $filesystem;
        $this->path = $path;
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