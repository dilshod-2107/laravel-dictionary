<?php


namespace App\Jobs;
use Parser;
use File;

class DictionaryFile
{
    
    protected static $file;


   
    public static function getXml($file)
    {
        if (static::$file===null) {
            ini_set("memory_limit","-1");
            static::$file = new static();
            static::$file = Parser::xml(File::get($file));
        }
        
        return static::$file;
    }

    
    protected function __construct()
    {
    }

    
    private function __clone()
    {
    }

   
    private function __wakeup()
    {
    }
}
