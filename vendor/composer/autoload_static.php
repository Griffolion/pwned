<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit0f1e762240486a5a6cf63ccf1093f0a5
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Pwned\\' => 6,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Pwned\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit0f1e762240486a5a6cf63ccf1093f0a5::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit0f1e762240486a5a6cf63ccf1093f0a5::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}