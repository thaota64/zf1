<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitfcf3bd96f0d054fd78b01f7b2865c623
{
    public static $files = array (
        '0e6d7bf4a5811bfa5cf40c5ccd6fae6a' => __DIR__ . '/..' . '/symfony/polyfill-mbstring/bootstrap.php',
    );

    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Symfony\\Polyfill\\Mbstring\\' => 26,
            'Symfony\\Component\\Yaml\\' => 23,
            'Symfony\\Component\\Filesystem\\' => 29,
            'Symfony\\Component\\Console\\' => 26,
            'Symfony\\Component\\Config\\' => 25,
        ),
        'P' => 
        array (
            'Phinx\\' => 6,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Symfony\\Polyfill\\Mbstring\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-mbstring',
        ),
        'Symfony\\Component\\Yaml\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/yaml',
        ),
        'Symfony\\Component\\Filesystem\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/filesystem',
        ),
        'Symfony\\Component\\Console\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/console',
        ),
        'Symfony\\Component\\Config\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/config',
        ),
        'Phinx\\' => 
        array (
            0 => __DIR__ . '/..' . '/robmorgan/phinx/src/Phinx',
        ),
    );

    public static $prefixesPsr0 = array (
        'Z' => 
        array (
            'Zend_' => 
            array (
                0 => __DIR__ . '/..' . '/zendframework/zendframework1/library',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitfcf3bd96f0d054fd78b01f7b2865c623::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitfcf3bd96f0d054fd78b01f7b2865c623::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInitfcf3bd96f0d054fd78b01f7b2865c623::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}