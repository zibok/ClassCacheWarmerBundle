<?php

namespace Zibok\Bundle\ClassCacheWarmerBundle\CacheWarmer;

use Symfony\Component\HttpKernel\CacheWarmer\CacheWarmerInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\ClassLoader\ClassCollectionLoader;

class ClassesCacheWarmer implements CacheWarmerInterface
{
    /**
     * The kernel to use for warmup
     * @var KernelInterface
     */
    private $kernel;

    private $name;

    private $extension;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
        $this->name = 'classes';
        $this->extension = '.php';
    }

    public function warmUp($cacheDir)
    {
        if (is_file($cacheDir.'/classes.map')) {
            ClassCollectionLoader::load(
                include($cacheDir.'/classes.map'),
                $cacheDir,
                $this->name,
                $this->kernel->isDebug(),
                false,
                $this->extension
            );
        }
    }

    public function isOptional()
    {
        return false;
    }
}
