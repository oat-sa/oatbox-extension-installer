<?php

namespace oatbox\composer;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;

/**
 * Class ExtensionInstallerPlugin
 * @package oatbox\composer
 */
class ExtensionInstallerPlugin implements PluginInterface
{
    private $installer;

    public function activate(Composer $composer, IOInterface $io)
    {
        $this->installer = new ExtensionInstaller($io, $composer);

        $composer->getInstallationManager()->addInstaller($this->installer);
    }

    public function deactivate(Composer $composer, IOInterface $io)
    {
        $composer->getInstallationManager()->removeInstaller($this->installer);
    }

    public function uninstall(Composer $composer, IOInterface $io)
    {
    }
}
