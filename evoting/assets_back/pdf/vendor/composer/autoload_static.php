<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit219bfd58c83b553b4df16db963b14a3a
{
    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInit219bfd58c83b553b4df16db963b14a3a::$classMap;

        }, null, ClassLoader::class);
    }
}