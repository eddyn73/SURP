<?php
/**
 * Description of BL_Login
 *
 * @author epalomino
 */
class BL_Login extends BL
{
    private $oBE_Usuario;
    private $oDAO_Usuario;

    function __construct()
    {
        $this->oBE_Usuario=new BE_Usuario();
        $this->oDAO_Usuario=new DAO_Usuario();
    }

    public final function login()
    {
        //$this->resetearIntentoActual();
        if(f::isEmpty(v::getError()))
        {
            $this->validaCredencial();
        }
        if(f::isEmpty(v::getError()))
        {
            $this->validaIntento();
        }
        if(f::isEmpty(v::getError()))
        {
            $this->validaCaptcha();
        }
        if(f::isEmpty(v::getError()))
        {
            $usuario=f::request('post', 'normal', f::id('usuario'));
            v::valida($usuario, 'Usuario', 'required,maxSize[15]');
        }
        if(f::isEmpty(v::getError()))
        {
            $clave=f::request('post', 'normal', f::id('clave'));
            v::valida($clave, 'Clave', 'required,maxSize[15]');
        }
        //v::setError('sape!');
        if(!f::isEmpty(v::getError()))
        {
            $this->aumentaIntento();
            v::validaErrorJSON('.classMessageLogin', 'up');
        }
        else
        {
            $this->oBE_Usuario->setUsuario($usuario);
            $this->oBE_Usuario->setClave($clave);

            $this->oDAO_Usuario->login($this->oBE_Usuario);

            if(!f::isEmpty($this->oBE_Usuario->getIdUsuario()))
            {
                $this->resetearIntentoActual();
                
                f::setSession('idUsuario', $this->oBE_Usuario->getIdUsuario());
                f::setSession('nombre', $this->oBE_Usuario->getNombre().' '.$this->oBE_Usuario->getApellido());

                v::setTrueJSON();
                v::setJSON('tag', 'body');
                v::setJSON('ubicacion', 'up');

                v::setJSON('descripcion', c::getViewSystem('modulos/masterPage/index.php', false));
            }
            else
            {
                v::setFalseJSON();
                v::setJSON('tag', '.classMessageLogin');
                v::setJSON('ubicacion', 'up');
                v::setError('Usuario o Clave incorrecto');
                $this->aumentaIntento();
                v::setJSON('descripcion', v::validaErrorUL());
            }
            v::printJSON();
        }
    }

    public function logoff()
    {
        f::setSession('idUsuario', null);
        f::setSession('nombre', null);

        v::setTrueJSON();
        v::setJSON('tag', 'body');
        v::setJSON('ubicacion', 'up');
        v::setJSON('descripcion', c::getViewSystem('modulos/login/index.php', false));
        v::printJSON();
    }
}