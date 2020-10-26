<?php

namespace oatbox\composer;

use Composer\Package\PackageInterface;
use Composer\Installer\LibraryInstaller;

/**
 * Class ExtensionInstaller
 * @package oatbox\composer
 */
class ExtensionInstaller extends LibraryInstaller
{
    const EXTENSION_NAME_KEY = 'tao-extension-name';

    public function getInstallPath(PackageInterface $package)
    {
        $extra = $package->getExtra();

        if ($extra !== null && isset($extra[self::EXTENSION_NAME_KEY])) {
            $baseDir = '';
            try {
                $reader = function ($object, $property) {
                    return \Closure::bind(
                        function & () use ($property) {
                            return $this->$property;
                        },
                        $object,
                        $object
                    )->__invoke();
                };
                $config = $reader($this->downloadManager->getDownloader('path'), 'config');
                $baseDir = $reader($config, 'baseDir');
                $baseDir = realpath($baseDir) . DIRECTORY_SEPARATOR;
            } catch (\InvalidArgumentException $e) {
            }
            return $baseDir . $extra[self::EXTENSION_NAME_KEY];
        }

        throw new \InvalidArgumentException('Could not find extension name in manifest');
    }

    /**
     * Required for BC, for composer version issued before 15.11.2015
     *
     * @param PackageInterface $package
     *
     * @return string
     */
    public function getPackageBasePath(PackageInterface $package)
    {
        return $this->getInstallPath($package);
    }

    public function supports($packageType)
    {
        return $packageType === 'tao-extension';
    }

}
