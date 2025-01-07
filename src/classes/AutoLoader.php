<?php
class AutoLoader{
    static function register(){
        spl_autoload_register(array(__CLASS__, 'autoLoad'));
    }

    static function autoLoad($fctn){
        $path = str_replace('\\', '/', $fctn).'.php';
        require 'classes/'.$path;
    }
}
?>