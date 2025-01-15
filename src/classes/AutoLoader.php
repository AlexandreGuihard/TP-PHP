<?php
class AutoLoader {
    static function register() {
        spl_autoload_register(array(__CLASS__, 'autoLoad'));
    }

    static function autoLoad($className) {
        $className = str_replace('\\', '/', $className);
        $file = __DIR__.'/../classes/'.$className.'.php';
        
        if (file_exists($file)) {
            require_once $file;
        } else {
            echo "Fichier introuvable : " . $file . "<br>";
        }
    }
    
}
?>
