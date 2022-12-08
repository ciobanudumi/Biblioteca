<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit4125537b93b7312cfee9d6ea64152ca5
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/public',
        ),
    );

    public static $classMap = array (
        'App\\Book' => __DIR__ . '/../..' . '/public/Book.php',
        'App\\BookManager' => __DIR__ . '/../..' . '/public/BookManager.php',
        'App\\DbConnection' => __DIR__ . '/../..' . '/public/DbConnection.php',
        'App\\Filter' => __DIR__ . '/../..' . '/public/Filter.php',
        'App\\SQLBuilder' => __DIR__ . '/../..' . '/public/SQLBuilder.php',
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit4125537b93b7312cfee9d6ea64152ca5::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit4125537b93b7312cfee9d6ea64152ca5::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit4125537b93b7312cfee9d6ea64152ca5::$classMap;

        }, null, ClassLoader::class);
    }
}