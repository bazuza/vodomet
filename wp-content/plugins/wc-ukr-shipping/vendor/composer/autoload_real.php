<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderIniteb20e37ed7c6f2aa53921973f8cc68d1
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(array('ComposerAutoloaderIniteb20e37ed7c6f2aa53921973f8cc68d1', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderIniteb20e37ed7c6f2aa53921973f8cc68d1', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticIniteb20e37ed7c6f2aa53921973f8cc68d1::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
