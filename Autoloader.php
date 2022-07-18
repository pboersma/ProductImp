<?php
class productimp_Autoloader
{
    /**
     * Registers productimp_Autoloader as an SPL autoloader.
     *
     * @param boolean $prepend
     */
    public static function register($prepend = false)
    {
        if (version_compare(phpversion(), '5.3.0', '>=')) {
            spl_autoload_register(array(new self, 'autoload'), true, $prepend);
        } else {
            spl_autoload_register(array(new self, 'autoload'));
        }
    }

    /**
     * Handles autoloading of productimp classes.
     *
     * @param string $class
     */
    public static function autoload($class)
    {
        if (0 !== strpos($class, 'productimp')) {
            return;
        }
        
        $file = dirname(__FILE__) . '/' . str_replace(array('_', "\0"), array('/', ''), $class) . '.php';

        var_dump($file);
        if (is_file($file)) {
            require_once $file;
        }
    }
}
