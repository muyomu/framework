<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitb8210cc27746014efcea8625037bf54c
{
    public static $prefixLengthsPsr4 = array (
        'm' => 
        array (
            'muyomu\\router\\' => 14,
            'muyomu\\http\\' => 12,
            'muyomu\\filter\\' => 14,
            'muyomu\\database\\' => 16,
            'muyomu\\config\\' => 14,
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
        'muyomu\\filter\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
        'muyomu\\database\\' => 
        array (
            0 => __DIR__ . '/..' . '/muyomu/database/src',
        ),
        'muyomu\\config\\' => 
        array (
            0 => __DIR__ . '/..' . '/muyomu/config/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitb8210cc27746014efcea8625037bf54c::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitb8210cc27746014efcea8625037bf54c::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitb8210cc27746014efcea8625037bf54c::$classMap;

        }, null, ClassLoader::class);
    }
}
