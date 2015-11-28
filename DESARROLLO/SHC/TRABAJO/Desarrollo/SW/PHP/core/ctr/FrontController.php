<?php
/**
 * El FrontController <br/>
 * direcciona las peticiones
 * 
 * @author epalomino
 */
class FrontController
{
    private static $instance;

    public static function getInstance()
    {
        if(f::isEmpty(self::$instance))
        {
            $class=__CLASS__;
            self::$instance=new $class;
        }
        return self::$instance;
    }
    
    public static function loadTemplateSystem()
    {
        Dispatcher::redirectSystem();
    }
    
    public function decodeParametrosBase64()
    { 
        $base64=f::request('post', 'normal', 'l'.f::encode('Base64ParametrosPublicos', false));
        if(!f::isEmpty($base64))
        {
            $base64=base64_decode($base64);
            $array=explode('&', $base64);
            //v::setError(f::message($array,null,false));
            foreach($array as $v)
            {
                $llave=null;
                $valor=null;
                $parametros=explode('=', $v);
                if($parametros >= 2)
                {
                    for($i=0; $i < count($parametros); $i++)
                    {
                        if($i == 0)
                        {
                            $llave=urldecode($parametros[$i]);
                        }
                        else
                        {
                            $valor.=urldecode($parametros[$i]);
                        }
                        if(!f::isEmpty($llave))
                        {
                            $_POST[$llave]=$valor;
                        }
                    }
                }
                else
                {
                    f::message('Error en los parámetros Públicos : '.f::message($parametros, '', false));
                }
            }
            unset($_POST['l'.f::encode('Base64ParametrosPublicos', false)]);
            $this->validaKeyPublico();
        }
    }
    private function validaKeyPublico()
    {
        $keyPublico=f::request('post', 'normal', 'l'.f::encode('Base64KeyPublico', false));
        
        if(!f::isEmpty($keyPublico))
        {
            if(f::llaveMaestra($keyPublico) === false)
            {
                foreach($_SESSION as $k=> $v)
                {
                    unset($_SESSION[$k]);
                }
                $message='Caducó la credencial de la aplicación, cargue otra vez esta página';
                if(f::request('post', 'decode', f::id('typeResponse'))=='json')
                {
                    v::setFalseJSON();
                    v::setJSON('tag', 'body, form');
                    v::setJSON('refrescar', true);
                    v::setJSON('descripcion', $message);
                    v::printJSON();
                }
                else
                {
                    v::clearError();
                    v::setError($message);
                    v::printUL();
                }
                die();
            }
        }
    }
    
    public function loadTemplateSystemLayout()
    {
        $folder=f::request('post', 'normal', 'm');
        $include=f::request('post', 'decode', f::id('i'));
        $function=f::request('post', 'decode', f::id('function'));
        $typeResponse=f::request('post', 'decode', f::id('typeResponse'));
        
        if(f::isEmpty($folder))
        {
            $folder=f::request('post', 'decode', f::id('m'));
        }
        
        if(f::isEmpty($typeResponse))
        {
            $typeResponse='html';
        }
        
        s::set('typeResponse', $typeResponse);
        
        Dispatcher::dispatch($folder,$include);
         
        if(!f::isEmpty($function))
        {
            if(function_exists($function))
            {
                call_user_func($function);
            }
            else
            {
                //f::message('No existe la funcion <strong>'.$function.'()</strong>');
            }
        }
    }
}