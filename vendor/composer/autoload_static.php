<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitdb07a0e5a44b34ffeaea70c20303ddd0
{
    public static $prefixLengthsPsr4 = array (
        'L' => 
        array (
            'LINE\\' => 5,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'LINE\\' => 
        array (
            0 => __DIR__ . '/..' . '/linecorp/line-bot-sdk/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitdb07a0e5a44b34ffeaea70c20303ddd0::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitdb07a0e5a44b34ffeaea70c20303ddd0::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
