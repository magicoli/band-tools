<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitefba4890212e3000482f5e3d08b43d06
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'MBCPT\\' => 6,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'MBCPT\\' => 
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
            $loader->prefixLengthsPsr4 = ComposerStaticInitefba4890212e3000482f5e3d08b43d06::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitefba4890212e3000482f5e3d08b43d06::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitefba4890212e3000482f5e3d08b43d06::$classMap;

        }, null, ClassLoader::class);
    }
}
