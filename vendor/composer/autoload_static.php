<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit285847b743627f36d86dd5241b8b5228
{
    public static $prefixLengthsPsr4 = array (
        'm' => 
        array (
            'muyomu\\router\\' => 14,
            'muyomu\\http\\' => 12,
            'muyomu\\framework\\' => 17,
            'muyomu\\executor\\' => 16,
            'muyomu\\dpara\\' => 13,
            'muyomu\\database\\' => 16,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'muyomu\\router\\' => 
        array (
            0 => __DIR__ . '/..' . '/muyomu/router/src',
        ),
        'muyomu\\http\\' => 
        array (
            0 => __DIR__ . '/..' . '/muyomu/http/src',
        ),
        'muyomu\\framework\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
        'muyomu\\executor\\' => 
        array (
            0 => __DIR__ . '/..' . '/muyomu/executor/src',
        ),
        'muyomu\\dpara\\' => 
        array (
            0 => __DIR__ . '/..' . '/muyomu/dpara/src',
        ),
        'muyomu\\database\\' => 
        array (
            0 => __DIR__ . '/..' . '/muyomu/database/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit285847b743627f36d86dd5241b8b5228::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit285847b743627f36d86dd5241b8b5228::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit285847b743627f36d86dd5241b8b5228::$classMap;

        }, null, ClassLoader::class);
    }
}
