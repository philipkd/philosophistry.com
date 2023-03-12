<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit7090973900dc5f92c62bf3a2deae2ba3
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'ScssPhp\\ScssPhp\\' => 16,
        ),
        'M' => 
        array (
            'Michelf\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'ScssPhp\\ScssPhp\\' => 
        array (
            0 => __DIR__ . '/..' . '/scssphp/scssphp/src',
        ),
        'Michelf\\' => 
        array (
            0 => __DIR__ . '/..' . '/michelf/php-markdown/Michelf',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit7090973900dc5f92c62bf3a2deae2ba3::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit7090973900dc5f92c62bf3a2deae2ba3::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit7090973900dc5f92c62bf3a2deae2ba3::$classMap;

        }, null, ClassLoader::class);
    }
}
