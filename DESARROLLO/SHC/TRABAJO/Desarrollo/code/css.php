<?php
require('./core/helper/f.php');
//f::validaServidor();
f::import('core/bl/BL.php');
f::import('core/helper/c.php');
$src=f::request('get', 'decode', f::id('src'));
if(!f::isEmpty($src))
{ 
    $src=str_replace('/', DIRECTORY_SEPARATOR, $src);
    $src=str_replace('\\', DIRECTORY_SEPARATOR, $src);
    
    $ruta=f::getPatchApp().DIRECTORY_SEPARATOR.$src;
    if(file_exists($ruta))
    {
        $p['carpeta']=dirname($ruta);
        $p['carpeta']=str_replace(DIRECTORY_SEPARATOR, '/', $p['carpeta']);
        $p['carpeta'].='/';
        
        $p['data']=f::getContents($src,false);
        back($p['carpeta'], $p['data']);
 
        if(strpos($p['carpeta'], c::get('templateSystem').'css'))
        //if($p['carpeta'] == c::get('templateSystem').'css')
        {
            $p['carpeta']=str_replace('css/', '', $p['carpeta']);
        }
        $p['carpeta']=str_replace(str_replace(DIRECTORY_SEPARATOR,'/', f::getPatchApp()).'/','', $p['carpeta']);
        $p['carpeta']=f::getUrlApp().$p['carpeta'];
        //f::message($p['carpeta']);
        //f::message(f::getPatchApp());
        $p['data']=str_replace("url('", "url('{$p['carpeta']}", $p['data']);
        $p['data']=str_replace("url(\"", "url(\"{$p['carpeta']}", $p['data']);
        $p['data']=str_replace("url(i", "url({$p['carpeta']}i", $p['data']);
        
        header("Content-type: text/css");
        echo $p['data'];
    }
} 

function back(&$carpeta, &$data)
{
    if(strpos($data, '../'))
    {
        $data=str_replace("../", "", $data);
        $carpeta=dirname($carpeta).'/';
        back($carpeta, $data);
    }
}




