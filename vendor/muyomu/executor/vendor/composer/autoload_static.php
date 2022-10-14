<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit6f458cf6d0953782887f098b0bda9528
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'Muyomu\\Executor\\' => 16,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Muyomu\\Executor\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit6f458cf6d0953782887f098b0bda9528::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit6f458cf6d0953782887f098b0bda9528::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit6f458cf6d0953782887f098b0bda9528::$classMap;

        }, null, ClassLoader::class);
    }
}
