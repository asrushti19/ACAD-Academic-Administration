<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit8793538e7df7245f17994e920fa243d6
{
    public static $prefixLengthsPsr4 = array (
        'I' => 
        array (
            'Inc\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Inc\\' => 
        array (
            0 => __DIR__ . '/../..' . '/inc',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit8793538e7df7245f17994e920fa243d6::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit8793538e7df7245f17994e920fa243d6::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
