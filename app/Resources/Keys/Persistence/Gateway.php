<?php
namespace JWTPOC\Resources\Keys\Persistence;

use JWTPOC\Resources\Keys\Persistence\Factory;
use Symfony\Component\Filesystem\Filesystem;

class Gateway implements \JWTPOC\Contracts\Keys\Gateway
{
    /** @var Filesystem  */
    protected $fs;

    /** @var string  */
    protected $path;

    /** @var string  */
    protected $factory;

    /**
     * @param Filesystem $filesystem
     * @param string $path  Folder path.
     * @param Factory $factory
     */
    public function __construct(Filesystem $filesystem, $path, Factory $factory)
    {
        $this->fs = $filesystem;
        $this->path = $path;
        $this->factory = $factory;
    }

    public function getContents($filename)
    {
        $response = '';
        $path = $this->path . $filename;

        if ($this->fs->exists($path)) {
            $response = file_get_contents($path);
        }

        return $response;
    }
}
