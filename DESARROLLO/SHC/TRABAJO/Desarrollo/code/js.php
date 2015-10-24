<?php
require('./core/helper/f.php');
f::validaServidor();
f::import('core/bl/BL.php');
f::import('core/library/JavaScriptPacker.php');
f::import('core/helper/c.php');
$src=f::request('get', 'decode', f::id('src'));
if(!f::isEmpty($src))
{
    if(file_exists(f::getPatchApp().DIRECTORY_SEPARATOR.$src))
    {
        header("Content-type: application/x-javascript");
        f::getContents($src);
    }
}