<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit8d47684a6e6bd4b2d5d8d05b8a0990f9
{
    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInit8d47684a6e6bd4b2d5d8d05b8a0990f9::$classMap;

        }, null, ClassLoader::class);
    }
}