<?php

namespace App\Helpers\Routes;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class RouteHelper
{
public static function includeRouteFile(string $folder ): void
{

    //iterate through the v1 folder recursively
    $dirIterator = new RecursiveDirectoryIterator($folder);
    /**  @var RecursiveDirectoryIterator | RecursiveIteratorIterator $it   */
    $it = new RecursiveIteratorIterator($dirIterator);

    while($it->valid()){

        if(!$it->isDot()
            && $it->isFile()
            && $it->isReadable()
            && $it->current()->getExtension()==='php' ){

            require $it->key();
        }
        $it->next();
    }
}
}
