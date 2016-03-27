<?php
namespace JWTPOC\Infrastructure\Services;


use Symfony\Component\Filesystem\Filesystem;

class Settings
{
    protected $fs;

    protected $path;

    /**
     * Use the filesystem to load settings.
     *
     * @param Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem, $path)
    {
        $this->fs = $filesystem;
        $this->path = $path;
    }

    public function findByName($name)
    {
        $settingsFile = $this->path;

        if (file_exists($settingsFile)) {
            $data = json_decode(file_get_contents($settingsFile));
            foreach ($data as $item) {
                if ($item->name == $name) {
                    return $item;
                }
            }
        }
    }
}