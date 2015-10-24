<?php
/**
 * Description of c <br/>
 * Configuracion del Sistema
 * @author epalomino
 */
class c
{
    public final static function get($v)
    {
        switch($v)
        {
            case 'templateSystem':
                $return='view/system/default/';
                break;
            case 'icono': 
                $return=self::get('templateSystem').'imagenes/ico.ico';
                break;
            case 'title':
                $return='Sistema de historia Clinica';
                break;
            case 'keyword':
                $return='Sistema de historia Clinica';
                break;
            case 'descripcion':
                $return='Sistema de historia Clinica';
                break;
            case 'autor':
                $return='Edison Palomino Ayala by.mysself@gmail.com';
                break;
            case 'load_logo':
                $return=self::get('templateSystem').'imagenes/logoload.png';
                break;
            case 'load_progress':
                $return=self::get('templateSystem').'imagenes/scs_progress_bar.gif';
                break;
            case 'fotoUsuarioPorDefecto':
                $return=self::get('templateSystem').'imagenes/user.png';
                break;
            case 'plantillaui':
                $return='resource/plugin/jquery/css/default/jquery-ui-1.10.3.custom.css';
                break;
            default:
                $return=null;
                f::message('No existe ['.$v.'] en la configuración');
                break;
        }
        return $return;
    }
    /**
     * getViewSystem($path, $echo=true, $once=true)
     * @param type $path
     * @param type $echo
     * @param type $once
     * @return type
     */
    public final static function getViewSystem($path, $echo=true, $once=true)
    {
        return f::getContents(self::get('templateSystem').$path,$echo,$once);
    }
}