<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitce01450caa094108bfd947aa69a52fc9
{
    public static $files = array (
        'c964ee0ededf28c96ebd9db5099ef910' => __DIR__ . '/..' . '/guzzlehttp/promises/src/functions_include.php',
        'a0edc8309cc5e1d60e3047b5df6b7052' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/functions_include.php',
        '0e6d7bf4a5811bfa5cf40c5ccd6fae6a' => __DIR__ . '/..' . '/symfony/polyfill-mbstring/bootstrap.php',
        '37a3dc5111fe8f707ab4c132ef1dbc62' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/functions_include.php',
        'de85a44be454aa97188dad52ed888bed' => __DIR__ . '/..' . '/panique/laravel-sass/sass-compiler.php',
        'c65d09b6820da036953a371c8c73a9b1' => __DIR__ . '/..' . '/facebook/graph-sdk/src/Facebook/polyfills.php',
    );

    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Symfony\\Polyfill\\Mbstring\\' => 26,
            'Symfony\\Component\\Translation\\' => 30,
        ),
        'P' => 
        array (
            'Psr\\Http\\Message\\' => 17,
        ),
        'K' => 
        array (
            'KeriganSolutions\\FacebookFeed\\' => 30,
        ),
        'I' => 
        array (
            'Includes\\Modules\\' => 17,
        ),
        'G' => 
        array (
            'GuzzleHttp\\Psr7\\' => 16,
            'GuzzleHttp\\Promise\\' => 19,
            'GuzzleHttp\\' => 11,
        ),
        'F' => 
        array (
            'Facebook\\' => 9,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Symfony\\Polyfill\\Mbstring\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-mbstring',
        ),
        'Symfony\\Component\\Translation\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/translation',
        ),
        'Psr\\Http\\Message\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/http-message/src',
        ),
        'KeriganSolutions\\FacebookFeed\\' => 
        array (
            0 => __DIR__ . '/..' . '/kerigansolutions/fb-autoblog-wp/src',
        ),
        'Includes\\Modules\\' => 
        array (
            0 => __DIR__ . '/../..' . '/inc/modules',
        ),
        'GuzzleHttp\\Psr7\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/psr7/src',
        ),
        'GuzzleHttp\\Promise\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/promises/src',
        ),
        'GuzzleHttp\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/guzzle/src',
        ),
        'Facebook\\' => 
        array (
            0 => __DIR__ . '/..' . '/facebook/graph-sdk/src/Facebook',
        ),
    );

    public static $fallbackDirsPsr4 = array (
        0 => __DIR__ . '/..' . '/nesbot/carbon/src',
    );

    public static $classMap = array (
        'scss_formatter' => __DIR__ . '/..' . '/leafo/scssphp/scss.inc.php',
        'scss_formatter_compressed' => __DIR__ . '/..' . '/leafo/scssphp/scss.inc.php',
        'scss_formatter_crunched' => __DIR__ . '/..' . '/leafo/scssphp/scss.inc.php',
        'scss_formatter_nested' => __DIR__ . '/..' . '/leafo/scssphp/scss.inc.php',
        'scss_parser' => __DIR__ . '/..' . '/leafo/scssphp/scss.inc.php',
        'scss_server' => __DIR__ . '/..' . '/leafo/scssphp/scss.inc.php',
        'scssc' => __DIR__ . '/..' . '/leafo/scssphp/scss.inc.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitce01450caa094108bfd947aa69a52fc9::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitce01450caa094108bfd947aa69a52fc9::$prefixDirsPsr4;
            $loader->fallbackDirsPsr4 = ComposerStaticInitce01450caa094108bfd947aa69a52fc9::$fallbackDirsPsr4;
            $loader->classMap = ComposerStaticInitce01450caa094108bfd947aa69a52fc9::$classMap;

        }, null, ClassLoader::class);
    }
}
