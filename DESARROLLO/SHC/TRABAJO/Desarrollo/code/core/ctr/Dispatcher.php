<?php
/**
 * Description of Dispatcher
 *
 * @author epalomino
 */
class Dispatcher
{

    public static final function dispatch($folder, $include, $echo=true)
    {
        InterceptingFilter::saveFolderHistory($folder);
        InterceptingFilter::decodeMethodGet();
        InterceptingFilter::isRefreshMethodPost();

        switch($folder)
        {
            case 'misevacuaciones':
            case 'listaevacuacion':
            case 'aprobarevacuacion':
            case 'realizarevacuacion':
            case 'archivamiento':
            case 'modulo':
                self::redirect($folder, $include, $echo);
                break;
            case 'login':
            case 'masterPage':
                if(InterceptingFilter::validaIP())
                {
                    c::getViewSystem('modulos/'.$folder.'/'.$include.'.php', $echo);
                }
                break;
            default:
                f::message('No está configurado el modulo: ['.$folder.'] en la clase '.__CLASS__);
                break;
        }
    }

    private static final function redirect($folder, $include, $echo)
    {
        if(InterceptingFilter::validaIP())
        {
            if(InterceptingFilter::validaSession())
            {
                c::getViewSystem('modulos/'.$folder.'/'.$include.'.php', $echo);
            }
        }
    }

    public static final function redirectSystem()
    {
        f::setSession('FrontController.HTTP_REFERER', @$_SERVER['HTTP_REFERER']);
        InterceptingFilter::resetSessionSystem();
        InterceptingFilter::encodeMethodGet();
        InterceptingFilter::refreshMethodPost();
        if(InterceptingFilter::validaIP())
        {
            c::getViewSystem('index.php');
        }
    }
}