<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit882da86a99190a5d9dbc4ef53e3acec7
{
    public static $prefixLengthsPsr4 = array (
        'a' => 
        array (
            'app\\' => 4,
        ),
        'P' => 
        array (
            'Psr\\Log\\' => 8,
            'PAMI\\' => 5,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'app\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/Psr/Log',
        ),
        'PAMI\\' => 
        array (
            0 => __DIR__ . '/..' . '/marcelog/pami/src/PAMI',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit882da86a99190a5d9dbc4ef53e3acec7::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit882da86a99190a5d9dbc4ef53e3acec7::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
