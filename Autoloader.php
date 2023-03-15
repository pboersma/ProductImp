<?php
class productimp_Autoloader
{
    // /**
    //  * Registers productimp_Autoloader as an SPL autoloader.
    //  *
    //  * @param boolean $prepend
    //  */
    // public static function register($prepend = false)
    // {
    //     if (version_compare(phpversion(), '5.3.0', '>=')) {
    //         spl_autoload_register(array(new self, 'autoload'), true, $prepend);
    //     } else {
    //         spl_autoload_register(array(new self, 'autoload'));
    //     }
    // }

    /**
     * Handles autoloading of productimp classes.
     *
     * @param string $class
     */
    public static function autoload($class)
    {
        // replace namespace separators with directory separators in the relative 
        // class name, append with .php
        $class_path = str_replace('\\', '/', $class);
    
        $file =  __DIR__ . '/src/' . $class_path . '.php';

        // if the file exists, require it
        if (file_exists($file)) {
            require $file;
        }
    }
}
