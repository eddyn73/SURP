<?php
/**
 * Description of InterceptingFilter
 *
 * @author epalomino
 */
class InterceptingFilter
{
    public static final function parametrosPostUserPass()
    {
        $username=f::request('post', 'normal', 'username');
        $password=f::request('post', 'normal', 'password');
        $username='43699723';
        $password='qweqwe1';
        if(f::isEmpty(f::getSession('NENTI_CODIGO')) or !f::isEmpty($username))
        {
            $return=false;
            
            if(f::isEmpty(v::getError()))
            {
                v::valida($username, 'Usuario', 'required,minSize[8],maxSize[10]');
            }

            if(f::isEmpty(v::getError()))
            {
                v::valida($password, 'Clave', 'required,minSize[4],maxSize[10]');
            }

            if(f::isEmpty(v::getError()))
            {
                $row=DAO_DGENCA_USUARIO::validaUsuarioPassword($username, $password);
                if(f::isEmpty($row))
                {
                    v::setError('El Usuario o Clave es incorrecto');
                }
                else
                {
                    $entidad=$row[0]['NENTI_CODIGO'];
                    $nombre=$row[0]['CENTI_NOMBRECOMPLETO'];
                    $nombre=str_replace(',', ' ', $nombre);
                    $nombre=ucwords(strtolower($nombre));
                    $nombre=utf8_encode($nombre);
                }
            }

            if(f::isEmpty(v::getError()))
            {
                $return=true;
                f::setSession('NENTI_CODIGO', $entidad);
                f::setSession('CUSER_USERNAME', $username);
                s::set('CENTI_NOMBRECOMPLETO', $nombre);
            }
            else
            {
                $return=false;

                self::resetSessionSystem();

                if(s::get('typeResponse')=='json')
                {
                    v::validaErrorJSON();
                }
                else
                {
                    v::validaErrorUL(true);
                }
            }
        }
        else
        {
            $return=true;
        }
        return $return;
    }
    
    public static final function saveFolderHistory($folder)
    {
        $folder_history=f::getSession('FOLDER_HISTORY');
        if(f::isEmpty($folder_history))
        {
            $folder_history=$folder;
        }
        else
        {
            $folder_history.='='.$folder;
        }
        f::setSession('FOLDER_HISTORY', $folder_history);
    }
    
    public static final function validaFolderUnico($folder)
    {
        $return=true;
        $folder_history=f::getSession('FOLDER_HISTORY');
        foreach(explode('=', $folder_history) as $value)
        {
            if($value!=$folder)
            {
                $return=false;
            }
        }
        if(f::isEmpty($return))
        {
            v::setError('Modulo '.$folder.' fue alterado, reinicie la aplicación');
            self::resetSessionSystem();

            if(s::get('typeResponse')=='json')
            {
                v::validaErrorJSON();
            }
            else
            {
                v::validaErrorUL(true);
            }
        }
        return $return;
    }
    
    public static final function validaIP($echo=true)
    {
        $auditoria=a::getAuditoria();
        
        switch($auditoria['paginaAnterior'])
        {
            case f::getUrlApp():
                break;
            default:
                //v::setError('URL['.$auditoria['paginaAnterior'].'] restringida');
                break;
        }
        
        switch($auditoria['ip_remoto'])
        {
            case '127.0.0.1':
                break;
            default:
                v::setError('IP['.$auditoria['ip_remoto'].'] restringida');
                break;
        }
            
    
        if(f::isEmpty(v::getError()))
        {
            $return=true;
        }
        else
        {
            $return=false;
            
            if(!f::isEmpty($echo))
            {
                if(s::get('typeResponse')=='json')
                {
                    v::validaErrorJSON();
                }
                else
                {
                    v::validaErrorUL(true);
                }
            }
        }
        return $return;
    } 
    
    public static final function refreshMethodPost()
    {
        if(!f::isEmpty($_POST))
        {
            $post=null;
            foreach($_POST as $key=> $value)
            {
                if(f::isEmpty($post))
                {
                    $post=f::encode($key).'='.f::encode($value);
                }
                else
                {
                    $post.='&'.f::encode($key).'='.f::encode($value);
                }
                unset($_POST[$key]);
            }
            f::setSession('POST',$post);
            header("Location: ".f::getUrlApp());
            die();
        }
    }
    
    public static final function isRefreshMethodPost()
    {
        $post=f::getSession('POST');
        if(!f::isEmpty($post))
        {
            foreach(explode('&', $post) as $value)
            {
                $explode=explode('=', $value);
                if(count($explode)==2)
                {
                    $_POST[f::decode($explode[0])]=f::decode($explode[1]);
                }
            }
            f::setSession('POST',null);
        }
    }
    
    public static final function encodeMethodGet()
    {
        if(!f::isEmpty($_GET))
        {
            $get=null;
            foreach($_GET as $key=> $value)
            {
                if(f::isEmpty($get))
                {
                    $get=f::encode($key).'='.f::encode($value);
                }
                else
                {
                    $get.='&'.f::encode($key).'='.f::encode($value);
                }
                unset($_GET[$key]);
            }
            f::setSession('GET',$get);
        }
    }
    
    public static final function decodeMethodGet()
    {
        $get=f::getSession('GET');
        if(!f::isEmpty($get))
        {
            foreach(explode('&', $get) as $value)
            {
                $explode=explode('=', $value);
                if(count($explode)==2)
                {
                    $_GET[f::decode($explode[0])]=f::decode($explode[1]);
                }
            }
            f::setSession('GET',null);
        }
    }
    
    public static function resetSessionSystem()
    {
        f::setSession('NENTI_CODIGO', null);
        f::setSession('CUSER_USERNAME', null);
        f::setSession('FOLDER_HISTORY', null);
        
        f::setSession('$NCARR_CODIGO', null); 
        f::setSession('$NITEM_PADRE', null); 
        f::setSession('$NCONC_CODIGO', null); 
    }

    public static function validaSession()
    {
        $return=true;
        if(f::isEmpty(f::getSession('idUsuario')))
        {
            $return=false;
        }
        if(f::isEmpty($return))
        {
            v::setError('Su sesión caducó');
            if(s::get('typeResponse')=='json')
            {
                v::validaErrorJSON();
            }
            else
            {
                v::validaErrorUL(true);
            }
        }
        return $return;
    }
}