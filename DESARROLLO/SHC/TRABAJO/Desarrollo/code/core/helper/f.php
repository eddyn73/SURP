<?php
f::start();
/**
 * <p>
 * La clase <b>f</b> consta de una libreria <br/>
 * de funciones estaticas; La función <b>f::start();</b> <br/>
 * inica los parametros de configuración <br/>
 * y se debe ejecutar primero
 * </p>
 * 
 * @author epalomino
 */
class f
{
    #**********************************************************************************************/
    #*                                 Varaibles de Configuración                                 */
    #**********************************************************************************************/
    private static $comprimir=true;
    private static $encriptar=true;
    private static $error_reporting=true;
    private static $plantillaui=null;
    private static $sessionEncriptada=true;
    private static $sessionPersonalizado=true;
    private static $sessionPath='resource/session/';
    private static $sessionName='QWERT';
    private static $session=null;
    private static $url=null;
    private static $patchApp=null;
    private static $semilla=null;
    private static $credencial=null;
    private static $prefijo='l';
    private static $callFunctionJS=null;
    private static $activeEncodeDecodeUTF8=true;

    public static function start()
    {
        self::import('core/helper/Cifrar.php');
        date_default_timezone_set('America/Bogota');
        setlocale(LC_ALL, "es_ES@euro", "es_ES", "esp");

        if(self::isEmpty(self::$error_reporting))
        {
            error_reporting(0);
        }
        else
        {
            error_reporting(E_ALL);
            ini_set('display_errors', '1');
        }
        self::getCredencial();
    }

    public static function getPlantillaUI()
    {
        if(self::isEmpty(self::$plantillaui))
        {
            if(self::isEmpty(self::getSession('plantillaui')))
            {
                self::setSession('plantillaui', c::get('plantillaui'));
            }
            self::$plantillaui=self::getSession('plantillaui');
        }
        return self::$plantillaui;
    }

    public static function setPlantillaUI($value)
    {
        self::setSession('plantillaui', $value);
    }

    public static function getVarEncriptar()
    {
        return self::$encriptar;
    }

    public static function getVarPrefijo()
    {
        return self::$prefijo;
    }

    public static function id($texto)
    {
        $prefijo=self::getVarPrefijo();
        if(!self::isEmpty(self::$encriptar))
        {
            $return=$prefijo.Cifrar::md5($texto.f::getSemilla());
        }
        else
        {
            $return=$prefijo.$texto;
        }
        return $return;
    }

    public static function encode($texto, $random=true)
    {
        if(!self::isEmpty(self::$encriptar))
        {
            $return=Cifrar::base64Encode($texto, $random);
            $return=Cifrar::desplazamientoEncode($return);
            $return=Cifrar::sustitucionEncode($return);
        }
        else
        {
            $return=$texto;
        }
        return $return;
    }

    public static function decode($texto, $random=true)
    {
        if(!self::isEmpty(self::$encriptar))
        {
            $return=Cifrar::sustitucionDecode($texto);
            $return=Cifrar::desplazamientoDecode($return);
            $return=Cifrar::base64Decode($return, $random);
        }
        else
        {
            $return=$texto;
        }
        return $return;
    }

    /**
     * Usa la función <b>empty()</b> de php 
     * @param type $value : valor a verificar
     * @return boolean
     */
    public static function isEmpty($value)
    {
        if(empty($value))
        {
            $return=true;
        }
        else
        {
            $return=false;
        }
        return $return;
    }

    /**
     * Retorna la ruta de la aplicación
     * @return string
     */
    public static function getPatchApp()
    {
        if(self::isEmpty(self::$patchApp))
        {
            self::$patchApp=dirname(dirname(dirname(__FILE__)));
        }
        return self::$patchApp;
    }

    /**
     * Retorna la URL de la aplicación
     * @return type
     */
    public static function getUrlApp()
    {
        if(self::isEmpty(self::$url))
        {
            $appPath=str_replace(DIRECTORY_SEPARATOR, '/', self::getPatchApp());
            $array_appPatch=explode('/', $appPath);
            $array_urlPatch=explode('/', $_SERVER['SCRIPT_NAME']);

            $array_urlPatch_temp=null;
            foreach($array_urlPatch as $key=> $value)
            {
                if(self::isEmpty(trim($value)))
                {
                    unset($array_urlPatch[$key]);
                }
                else
                {
                    $array_urlPatch_temp[]=$value;
                }
            }
            $array_urlPatch=$array_urlPatch_temp;
            unset($array_urlPatch_temp);
            $patchURL=null;
            for($i=0; $i < count($array_urlPatch); $i++)
            {
                for($j=(count($array_appPatch) - 1); $j >= 0; $j--)
                {
                    if(trim($array_urlPatch[$i]) != trim($array_appPatch[$j]))
                    {
                        $j=-1;
                    }
                    else
                    {
                        $aux=0;
                        $flag2=true;
                        $tope=($i - count($array_appPatch) + 1);
                        if($tope < 0)
                            $tope=0;
                        for($k=$i; $k >= $tope; $k--)
                        {
                            if(trim($array_urlPatch[$k]) != trim($array_appPatch[count($array_appPatch) - 1 - $aux]))
                            {
                                $flag2=false;
                            }
                            else
                            {
                                if(!self::isEmpty($flag2))
                                {
                                    $patchURL[count($array_appPatch) - 1 - $aux]=$array_urlPatch[$k];
                                }
                            }
                            $aux++;
                        }
                        if(!self::isEmpty($flag2))
                        {
                            $j=-1;
                        }
                    }
                }
            }
            $stringURL=null;
            if(!self::isEmpty($patchURL))
            {
                $patchURL=array_reverse($patchURL);
                $stringURL=implode('/', $patchURL);
                $stringURL='/'.$stringURL.'/';
            }
            self::$url='http://'.$_SERVER['HTTP_HOST'].$stringURL.'/';
        }
        return self::$url;
    }

    public static function sessionStart()
    {
        if(self::isEmpty(self::$session))
        {
            if(!self::isEmpty(self::$sessionPersonalizado))
            {
                self::$sessionPath=str_replace('/', DIRECTORY_SEPARATOR, self::$sessionPath);
                self::$sessionPath=str_replace('\\', DIRECTORY_SEPARATOR, self::$sessionPath);
                
                $session_name=basename(self::getPatchApp()).self::$sessionName;
                $session_name=str_replace('.', 'A', $session_name);
                $session_name=str_replace('_', 'B', $session_name);
                $session_name=str_replace('-', 'C', $session_name);
                
                session_name($session_name);
            }
            
            if(self::isEmpty(@session_start()))
            {
                session_destroy();
                self::sessionStart();
            }
            else
            {
                self::$session=true;
            }
        }
    }

    public static final function getSemilla()
    {
        if(self::isEmpty(self::$semilla))
        {
            $ruta=self::getPatchApp();
            $carpeta=basename($ruta);
            $semilla=$carpeta.'.'.count(explode(DIRECTORY_SEPARATOR, $ruta));
            self::$semilla=$semilla;
        }
        return self::$semilla;
    }

    public static function message($contenido, $clase=null, $echo=true)
    {
        if(self::isEmpty(trim($clase)))
        {
            $clase='ui-state-highlight';
        }

        if(is_object($contenido) or is_array($contenido))
        {
            $return=print_r($contenido, true);
        }
        else
        {
            $return=$contenido;
        }

        $return='
            <div class="'.$clase.' ui-corner-all" style="padding:5px;margin:2px 0px;">
                <pre style="padding:0px;margin:0px;">'.$return.'</pre>
            </div>
        ';

        if($echo)
        {
            echo $return;
        }
        else
        {
            return $return;
        }
    }

    /**
     * Retorna el contenido ejecutado del archivo<br/>
     * Se debe indicar la ruta del archivo tomando<br/>
     * como base la ruta de la aplicación<br/>
     * <br/><br/>
     * getContents<b>(</b>$path<b>,</b> $echo=true<b>,</b> $once=true<b>)</b>
     * @param type $path    :ruta del archivo
     * @param type $echo    :<b>true</b> por defecto
     * @param type $once    :<b>true</b> por defecto
     * @return string
     */
    public static function getContents($path, $echo=true, $once=true)
    {

        $path=str_replace('/', DIRECTORY_SEPARATOR, $path);
        $path=str_replace('\\', DIRECTORY_SEPARATOR, $path);
        $ruta=self::getPatchApp().DIRECTORY_SEPARATOR.$path;

        if(file_exists($ruta))
        {
            ob_start();
            if($once)
            {
                require_once($ruta);
            }
            else
            {
                require($ruta);
            }
            $return=ob_get_contents();
            ob_end_clean();

            if(f::isEmpty($echo))
            {
                return $return;
            }
            else
            {
                echo $return;
            }
        }
        else
        {
            self::message('no existe la ruta getContents['.$path.'] en la clase['.__CLASS__.']');
        }
    }

    public static final function getVarSessionEncriptada()
    {
        return self::$sessionEncriptada;
    }

    public static function setSession($k, $v)
    {
        self::sessionStart();
        $k=self::getSemilla().'.'.$k;

        if(!self::isEmpty(self::$sessionEncriptada))
        {
            $k=self::id($k);
            $v=self::encode($v);
        }
        $_SESSION[$k]=$v;
    }

    public static function getSession($k)
    {
        self::sessionStart();
        $k=self::getSemilla().'.'.$k;

        if(!self::isEmpty(self::$sessionEncriptada))
        {
            $k=self::id($k);
        }

        if(!isset($_SESSION[$k]))
        {
            $return=null;
        }
        else
        {
            $return=$_SESSION[$k];

            if(!self::isEmpty(self::$sessionEncriptada))
            {
                $return=self::decode($return);
            }
        }
        return $return;
    }

    public static function getCredencial()
    {
        if(self::isEmpty(self::$credencial))
        {
            if(self::isEmpty(self::getSession('credencial')))
            {
                self::setSession('credencial', self::id(uniqid(self::getSemilla(), true)));
            }
            self::$credencial=self::getSession('credencial');
        }
        return self::$credencial;
    }

    public static function import($path)
    {
        $path=str_replace('/', DIRECTORY_SEPARATOR, $path);
        $path=str_replace('\\', DIRECTORY_SEPARATOR, $path);

        $pathImport=self::getPatchApp().DIRECTORY_SEPARATOR.$path;
        if(file_exists($pathImport))
        {
            require_once($pathImport);
        }
        else
        {
            self::message('No se importó la ruta['.$pathImport.']');
        }
    }

    public static function importAllClass()
    {
        self::import('core/library/JavaScriptPacker.php');
        self::import('core/db/DataBaseProviderInterface.php');
        self::import('core/db/DatabaseProvider.php');
        self::import('core/mail/PHPMailer.php');
        self::import('core/be/BE.php');
        self::import('core/bl/BL.php');
        self::import('core/dao/DAO.php');
        $MVC_ruta=self::getPatchApp().DIRECTORY_SEPARATOR.'core'.DIRECTORY_SEPARATOR;
        $MVC_ruta_directorio=opendir($MVC_ruta);
        while($MVC_ruta_archivo=readdir($MVC_ruta_directorio))
        {
            if(is_dir($MVC_ruta.$MVC_ruta_archivo) and (
                    $MVC_ruta_archivo == 'be' or $MVC_ruta_archivo == 'bl' or $MVC_ruta_archivo == 'ctr' or $MVC_ruta_archivo == 'dao' or $MVC_ruta_archivo == 'helper' or $MVC_ruta_archivo == 'db'
                    ))
            {
                $MVC_ruta_sub_directorio=opendir($MVC_ruta.$MVC_ruta_archivo.DIRECTORY_SEPARATOR);
                while($MVC_ruta_sub_archivo=readdir($MVC_ruta_sub_directorio))
                {
                    if(is_file($MVC_ruta.$MVC_ruta_archivo.DIRECTORY_SEPARATOR.$MVC_ruta_sub_archivo))
                    {
                        self::import('core/'.$MVC_ruta_archivo.'/'.$MVC_ruta_sub_archivo);
                    }
                }
                closedir($MVC_ruta_sub_directorio);
            }
        }
        closedir($MVC_ruta_directorio);
    }

    public static function validaServidor($valida=true)
    {
        //$valida=false;
        if(!self::isEmpty($valida))
        {
            if(!isset($_SERVER['HTTP_REFERER']))
            {
                $_SERVER['HTTP_REFERER']=null;
            }
            if(strpos($_SERVER['HTTP_REFERER'], $_SERVER["SERVER_NAME"]) == '')
            {
                self::import('core/bl/BL.php');
                self::import('core/library/JavaScriptPacker.php');
                self::import('core/helper/c.php');
                die(c::getViewSystem('modulos/error/_validaServidor.detalle.php', false));
            }
        }
    }

    public static function paginado($hash, $total, $pagina, $filas)
    {
        $p['total_paginas']=ceil($total / $filas);
        $p['mostrarPaginas']=5;

        $p['inicio']=$pagina - floor($p['mostrarPaginas'] / 2);
        $p['fin']=$pagina + floor($p['mostrarPaginas'] / 2);

        if($p['inicio'] < 1)
        {
            $p['inicio']=1;
            $p['fin']=$p['inicio'] + $p['mostrarPaginas'];
        }
        if($p['fin'] > $p['total_paginas'])
        {
            $p['fin']=$p['total_paginas'];
            $p['inicio']=$p['fin'] - $p['mostrarPaginas'];
        }
        if($p['inicio'] < 1)
        {
            $p['inicio']=1;
        }
        $maximo_mostrar=$pagina * $filas;
        if($maximo_mostrar > $total)
            $maximo_mostrar=$total;
        echo '
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="left" valign="middle">
                <span class="classPaginadoFooter ui-corner-tr ui-corner-bl ui-corner-br ui-state-default ui-state-disabled" disabled="disabled">Del '.
        (($pagina - 1) * $filas + 1)." al ".$maximo_mostrar." de {$total}"
        .' Registros</span>
            </td>
            <td align="right" valign="middle">
        ';


        if($p['inicio'] == $pagina)
        {
            echo '<span class="classPaginadoFooter ui-corner-tl ui-corner-bl ui-state-default ui-state-disabled" disabled="disabled">Primero</span>';
        }
        else
        {
            echo '<span class="classPaginadoFooter ui-corner-tl ui-corner-bl ui-state-default" onclick="setHash(\''.$hash.'&filas=\'+$(\'#filas\').val()+\'&pagina=1\');">Primero</span>';
        }

        if($pagina == 1)
        {
            echo '<span class="classPaginadoFooter ui-state-default ui-state-disabled" disabled="disabled">Anterior</span>';
        }
        else
        {
            echo '<span class="classPaginadoFooter ui-state-default" onclick="setHash(\''.$hash.'&filas=\'+$(\'#filas\').val()+\'&pagina='.($pagina - 1).'\');">Anterior</span>';
        }

        if($p['inicio'] > 1)
        {
            echo '<span class="classPaginadoFooter ui-state-default ui-state-disabled" disabled="disabled">...</span>';
        }

        for($i=$p['inicio']; $i <= $p['fin']; $i++)
        {
            if($i == $pagina)
            {
                echo '<span class="classPaginadoFooter ui-state-default ui-state-disabled" disabled="disabled">'.$i.'</span>';
            }
            else
            {
                echo '<span class="classPaginadoFooter ui-state-default" onclick="setHash(\''.$hash.'&filas=\'+$(\'#filas\').val()+\'&pagina='.$i.'\');">'.$i.'</span>';
            }
        }

        if($p['fin'] < $p['total_paginas'])
        {
            echo '<span class="classPaginadoFooter ui-state-default ui-state-disabled" disabled="disabled">...</span>';
        }

        if($pagina == $p['total_paginas'])
        {
            echo '<span class="classPaginadoFooter ui-state-default ui-state-disabled" disabled="disabled">Siguiente</span>';
        }
        else
        {
            echo '<span class="classPaginadoFooter ui-state-default" onclick="setHash(\''.$hash.'&filas=\'+$(\'#filas\').val()+\'&pagina='.($pagina + 1).'\');">Siguiente</span>';
        }


        if($p['fin'] == $pagina)
        {
            echo '<span class="classPaginadoFooter ui-corner-tr ui-corner-br ui-state-default ui-state-disabled" disabled="disabled">Último</span>';
        }
        else
        {
            echo '<span class="classPaginadoFooter ui-corner-tr ui-corner-br ui-state-default"
             onclick="setHash(\''.$hash.'&filas=\'+$(\'#filas\').val()+\'&pagina='.$p['total_paginas'].'\');">Último</span>';
        }

        echo ' &nbsp;
			</td>
		  </tr>
		</table>
		';
    }

    /**
     * Retorna un md5 de las sesiones del App <br/>
     * Si recibe el parametro key público, lo compra <br/>
     * y retorna <b>true</b> si es igual al key privado o <br/>
     * <b>false</b> si son diferentes
     * @param string $key : Key Público a comprar
     * @return boolean|key
     */
    public static function llaveMaestra($key=null)
    {
        $key_master=Cifrar::getRandomCifrado().Cifrar::getRandomNumero().Cifrar::getRandomRango();
        $key_master=self::id($key_master);

        if(self::isEmpty($key))
        {
            $return=$key_master;
        }
        else if($key == $key_master)
        {
            $return=true;
        }
        else
        {
            $return=false;
        }
        return $return;
    }

    /**
     * Crea una imagen transparente
     * @param type $width   :1 por defecto
     * @param type $height  :1 por defecto
     * @param type $echo    :true por defecto
     * @return string
     */
    public static function pixel($width=1, $height=1, $echo=true)
    {
        $return='
            <div class="classPaddinMargin0 ui-helper-clearfix" style="width:'.$width.'px;height:'.$height.'px;">
                <img src="'.self::getUrlApp().c::get('templateSystem').'imagenes/pixel.png" width="'.$width.'" height="'.$height.'" border="0"/>
            </div>
        ';
        if(!self::isEmpty($echo))
        {
            echo $return;
        }
        else
        {
            return $return;
        }
    }

    public static function plantillasUI(&$plantillas, $ruta=null)
    {
        if(self::isEmpty($ruta))
        {
            $ruta=self::getPatchApp()
                    .DIRECTORY_SEPARATOR.'resource'
                    .DIRECTORY_SEPARATOR.'plugin'
                    .DIRECTORY_SEPARATOR.'jquery'
                    .DIRECTORY_SEPARATOR.'css'
                    .DIRECTORY_SEPARATOR;
        }
        if(is_dir($ruta))
        {
            if($aux=opendir($ruta))
            {
                while(($archivo=readdir($aux)) !== false)
                {
                    if($archivo != "." && $archivo != "..")
                    {
                        $ruta_completa=$ruta.$archivo;
                        if(is_dir($ruta_completa))
                        {
                            self::plantillasUI($plantillas, $ruta_completa.DIRECTORY_SEPARATOR);
                        }
                        else
                        {
                            if(strtolower(substr($archivo, -3, 3)) == 'css' and strtolower(substr($archivo, -7, 7)) != 'min.css')
                            {

                                $print=str_replace(self::getPatchApp().DIRECTORY_SEPARATOR, '', $ruta_completa);
                                $print=str_replace(DIRECTORY_SEPARATOR, '/', $print);
                                $print=str_replace('resource/plugin/', '', $print);
                                $plantillas['ruta'][]=$print;
                                $print_array=explode('/', $print);
                                $plantillas['carpeta'][]=$print_array[count($print_array) - 2];
                            }
                        }
                    }
                }
                closedir($aux);
            }
            else
            {
                self::message('No se pudo abrir la carpeta <strong>['.$ruta.']</strong>', 'ui-state-error');
            }
        }
        else
        {
            self::message('No es una ruta válida <strong>['.$ruta.']</strong>', 'ui-state-error');
        }
    }

    public static function convertirObjetoAunArreglo($objeto)
    {
        $return=array();
        if(is_array($objeto))
            $keys=array_keys($objeto);
        else if(is_object($objeto))
            $keys=array_keys(get_object_vars($objeto));
        else
            return $objeto;

        foreach($keys as $key)
        {
            $value=$objeto->$key;
            if(is_array($objeto))
                $return[$key]=self::convertirObjetoAunArreglo($objeto[$key]);
            else
                $return[$key]=self::convertirObjetoAunArreglo($objeto->$key);
        }
        return $return;
    }

    public static function validaArchivo($file, $peso, $extension)
    {
        $return=false;
        $peso=str_replace(',', '.', $peso);
        if(!isset($_FILES[$file]))
            $error[]='Debe seleccionar un archivo';
        else
        {
            if(!is_numeric($peso))
            {
                $value_length=strlen($peso);
                $qty=substr($peso, 0, $value_length - 1);
                $unit=strtolower(substr($peso, $value_length - 1));
                switch($unit)
                {
                    case 'k':
                        $qty *= 1024;
                        break;
                    case 'm':
                        $qty *= 1048576;
                        break;
                    case 'g':
                        $qty *= 1073741824;
                        break;
                }
                $peso=$qty;
            }
            if($_FILES[$file]['size'] > $peso)
                $return[]='Peso Actual['.self::formatoBytes($_FILES[$file]['size']).'], peso Máximo['.self::formatoBytes($peso).']';

            $extension_array=explode(',', strtolower(trim($extension)));
            $flag=false;
            if(count($extension_array) > 0)
                if(!empty($extension_array[0]))
                    foreach($extension_array as $k=> $v)
                    {
                        $v=trim($v);
                        if($v == 'jpg')
                            $v='jpeg';
                        if(strpos(strtolower($_FILES[$file]['type']), $v))
                            $flag=true;
                    }
            if(!$flag)
                $return[]='Formato['.$_FILES[$file]['type'].'] incorrecto, Solo se permite '.$extension;
        }
        return $return;
    }

    public static function subirArchivo($file, $ruta, $prefijo='file', &$archivo=NULL, &$nameFile=NULL)
    {
        $return=false;
        $nameFile=$_FILES[$file]['name'];
        $formato=explode('.', $nameFile);
        $t=microtime(true);
        $micro=sprintf("%06d", ($t - floor($t)) * 1000000);
        $archivo=$prefijo.'_'.date('YmdHis').self::getSession('idUsuario').$micro.'.'.$formato[count($formato) - 1];
        $archivo=$ruta.$archivo;
        if(file_exists($archivo))
            $return[]="El archivo[".$archivo."] ya existe, ¡Ingrésalo con otro nombre!";
        else
        {
            if(!@move_uploaded_file($_FILES[$file]['tmp_name'], $archivo))
                $return[]="No se pudo subir el archivo[".$archivo."] vuelva a intentarlo!";
        }
        return $return;
    }

    public static function ajustartamanio($wmaximo, $hmaximo, &$wactual=NULL, &$hactual=NULL)
    {
        $wm=$wmaximo;
        $hm=$hmaximo;

        $wa=$wactual;
        $ha=$hactual;

        $auxwa=$wa;
        $auxha=$ha;

        if($wa >= $wm)
        {
            $auxwa=$wm;
            $auxha=($ha * $wm / $wa);
            $wa=$auxwa;
            $ha=$auxha;
        }
        if($ha >= $hm)
        {
            $auxwa=($wa * $hm / $ha);
            $auxha=$hm;
            $wa=$auxwa;
            $ha=$auxha;
        }
        $wactual=$wa;
        $hactual=$ha;
    }

    public static function redimencionartamanio($file, $wm, $hm, &$wa=NULL, &$ha=NULL, &$format=NULL)
    {
        ini_set('memory_limit', '256M');
        list($wa, $ha)=getimagesize($file);
        $formato=explode('.', $file);
        $format=strtolower($formato[count($formato) - 1]);

        if((filesize($file) > '680') and ($format == 'gif' or $format == 'jpg' or $format == 'png'))
        {//verifico el tamanio y el peso en kb
            self::ajustartamanio($wm, $hm, $wa, $ha);

            if($format == 'gif')
                $imagen=imagecreatefromgif($file);
            else if($format == 'jpg')
                $imagen=imagecreatefromjpeg($file);
            else if($format == 'png')
                $imagen=imagecreatefrompng($file);

            unlink($file); // BORRAMOS el archivo original

            $width=imagesx($imagen);
            $height=imagesy($imagen);
            if(function_exists("imagecreatetruecolor"))
                $calidad=imagecreatetruecolor($wa, $ha);
            else
                $calidad=imagecreate($wa, $ha);
            imagecopyresized($calidad, $imagen, 0, 0, 0, 0, $wa, $ha, $width, $height);

            sleep(1); // si pesa mas de 1450MB que espera 1 segundo para que la imagen se termine de crear

            if($format == 'gif')
                $imagen=@imagegif($calidad, $file, 100);
            else if($format == 'jpg')
                $imagen=@imagejpeg($calidad, $file, 100);
            else if($format == 'png')
                $imagen=@imagepng($calidad, $file, 100);

            @imagedestroy($imagen);
        }
        return true;
    }

    /**
     * Obtiene los Parametros de entrada HTTP
     * @param type $request     :get|post|request
     * @param type $mode        :decode|decode.false|encode|encode.false|normal
     * @param type $var_value   :parametro HTTP
     * @return type
     */
    public static function request($request, $mode, $var_value)
    {
        $return=null;
        $icono='<span class="ui-icon ui-icon-alert" style="float:left"></span> Error Interno: ';
        $class='ui-state-error';
        if($request == 'post')
        {

            if(isset($_POST[$var_value]))
            {
                if($mode == 'decode')
                {
                    $return=self::decode($_POST[$var_value]);
                }
                else if($mode == 'decode.false')
                {
                    $return=self::decode($_POST[$var_value], false);
                }
                else if($mode == 'encode')
                {
                    $return=self::encode($_POST[$var_value]);
                }
                else if($mode == 'encode.false')
                {
                    $return=self::encode($_POST[$var_value], false);
                }
                else if($mode == 'normal')
                {
                    $return=$_POST[$var_value];
                }
                else
                {
                    self::message($icono."El tipo <strong>request[mode:{$mode}]</strong> no existe", $class);
                }
            }
        }
        else if($request == 'get')
        {
            if(isset($_GET[$var_value]))
            {
                if($mode == 'decode')
                {
                    $return=self::decode($_GET[$var_value]);
                }
                else if($mode == 'decode.false')
                {
                    $return=self::decode($_GET[$var_value], false);
                }
                else if($mode == 'encode')
                {
                    $return=self::encode($_GET[$var_value]);
                }
                else if($mode == 'encode.false')
                {
                    $return=self::encode($_GET[$var_value], false);
                }
                else if($mode == 'normal')
                {
                    $return=$_GET[$var_value];
                }
                else
                {
                    self::message($icono."El tipo <strong>request[mode:{$mode}]</strong> no existe", $class);
                }
            }
        }
        else
        {
            self::message($icono."El tipo <strong>request[request:{$request}]</strong> no existe", $class);
        }
        return $return;
    }

    public static function p($parametro)
    {
        //return trim(mysql_real_escape_string(stripslashes($parametro)));
        return self::mssql_real_escape_string($parametro);
        //return mysql_real_escape_string(stripslashes(nl2br($parametro)));
    }

    private static function mssql_real_escape_string($s)
    {
        $s=stripslashes($s);
        $s=str_replace("'", "''", $s);
        return $s;
    }

    function carpetaInfo($path)
    {
        $totalsize=0;
        $totalcount=0;
        $dircount=0;
        if($handle=opendir($path))
        {
            while(false !== ($file=readdir($handle)))
            {
                $nextpath=$path.'/'.$file;
                if($file != '.' && $file != '..' && !is_link($nextpath))
                {
                    if(is_dir($nextpath))
                    {
                        $dircount++;
                        $result=carpetaInfo($nextpath);
                        $totalsize += $result['peso'];
                        $totalcount += $result['archivos'];
                        $dircount += $result['capertas'];
                    }
                    elseif(is_file($nextpath))
                    {
                        $totalsize += filesize($nextpath);
                        $totalcount++;
                    }
                }
            }
        }
        closedir($handle);
        $total['peso']=$totalsize;
        $total['archivos']=$totalcount;
        $total['carpetas']=$dircount;
        return $total;
    }

    public static function formatoBytes($a_bytes)
    {
        if($a_bytes < 1024)
        {
            return $a_bytes.' B';
        }
        elseif($a_bytes < 1048576)
        {
            return round($a_bytes / 1024, 0).' KB';
        }
        elseif($a_bytes < 1073741824)
        {
            return round($a_bytes / 1048576, 2).' MB';
        }
        elseif($a_bytes < 1099511627776)
        {
            return round($a_bytes / 1073741824, 2).' GB';
        }
        elseif($a_bytes < 1125899906842624)
        {
            return round($a_bytes / 1099511627776, 2).' TB';
        }
        elseif($a_bytes < 1152921504606846976)
        {
            return round($a_bytes / 1125899906842624, 2).' PB';
        }
        elseif($a_bytes < 1180591620717411303424)
        {
            return round($a_bytes / 1152921504606846976, 2).' EB';
        }
        elseif($a_bytes < 1208925819614629174706176)
        {
            return round($a_bytes / 1180591620717411303424, 2).' ZB';
        }
        else
        {
            return round($a_bytes / 1208925819614629174706176, 2).' YB';
        }
    }

    public static function comprimirHTML($buffer)
    {  
        $buffer=str_replace('callFunction', 'v'.f::callFunctionJS(), $buffer);
        self::encriptarBuffer($buffer, 'html_f__','f','md5');
        self::encriptarBuffer($buffer, 'html_v__','v','md5');
        self::encriptarBuffer($buffer, 'html_p__',null,'md5');
        self::encriptarBuffer($buffer, 'html_e__',null,'encode');
        
        $return=null;
        if(!self::isEmpty(self::$comprimir))
        {
            $busca=array('/\>[^\S ]+/s', '/[^\S ]+\</s', '/(\s)+/s');
            $reemplaza=array('>', '<', '\\1');
            $return=preg_replace($busca, $reemplaza, $buffer);
        }
        else
        {
            $return=$buffer;
        }
        return $return;
    }

    public static function htmlStart()
    {
        ob_start('f::comprimirHTML');
    }

    public static function htmlStop()
    {
        ob_end_flush();
    }

    private static function encriptarBuffer(&$buffer, $buscar, $prefijo=null,$modo='md5')
    {
        $arreglo=array();
        foreach(explode($buscar, $buffer) as $index=> $string)
        {
            if($index > 0)
            {
                $stringTemp=null;
                $flagTemp=true;

                foreach(str_split($string) as $key=> $letra)
                {
                    if($flagTemp == true)
                    {
                        $letraTemporal=strtoupper($letra);
                        switch($letraTemporal)
                        {
                            case 'A':
                            case 'B':
                            case 'C':
                            case 'D':
                            case 'E':
                            case 'F':
                            case 'G':
                            case 'H':
                            case 'I':
                            case 'J':
                            case 'K':
                            case 'L':
                            case 'M':
                            case 'N':
                            case 'Ñ':
                            case 'O':
                            case 'P':
                            case 'Q':
                            case 'R':
                            case 'S':
                            case 'T':
                            case 'U':
                            case 'V':
                            case 'W':
                            case 'X':
                            case 'Y':
                            case 'Z':
                            case '1':
                            case '2':
                            case '3':
                            case '4':
                            case '5':
                            case '6':
                            case '7':
                            case '8':
                            case '9':
                            case '0':
                            case '_':    
                                $stringTemp.=$letra;
                                break;
                            default:
                                $flagTemp=false;
                                break;
                        }
                    }
                }
                $arreglo[]=$buscar.$stringTemp;
            }
        }
        usort($arreglo,'f::usortAux');
        foreach($arreglo as $value)
        {
            $valueTemp=str_replace($buscar,'',$value);
            $cript=null;
            switch($modo)
            {
                case 'encode':
                    $cript=f::encode($valueTemp);
                    break;
                default:
                    $cript=f::id($valueTemp);
                    break;
            }
            $buffer=str_replace($value, $prefijo.$cript, $buffer);
        }
    }

    public static function usortAux($a, $b)
    {
        return strlen($b) - strlen($a);
    }

    public static function comprimirJS($buffer)
    {
        $return=null;
        $buffer=str_replace('callFunction', 'v'.f::callFunctionJS(), $buffer);
        self::encriptarBuffer($buffer, 'f__','f','md5');
        self::encriptarBuffer($buffer, 'v__','v','md5');
        self::encriptarBuffer($buffer, 'p__',null,'md5');
        self::encriptarBuffer($buffer, 'e__',null,'encode');
        
        if(!self::isEmpty(self::$comprimir))
        {
            $packer=new JavaScriptPacker($buffer, 62, true, true);
            $return=$packer->pack();
        }
        else
        {
            $return=$buffer;
        }
        return $return;
    }

    public static function comprimirJS_($buffer)
    {
        $return=null;
        if(!self::isEmpty(self::$comprimir))
        {
            $packer=new JavaScriptPacker($buffer, 62, true, true);
            $return=$packer->pack();
        }
        else
        {
            $return=$buffer;
        }
        return $return;
    }

    public static function jsStart()
    {
        ob_start('f::comprimirJS');
    }

    public static function jsStop()
    {
        ob_end_flush();
    }

    public static function eviarMail($fromName, $correo, $asunto, $mensaje)
    {
        $mail=new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPAuth=true;

        $mail->Port=465;
        $mail->Host="smtp.correo.com";
        $mail->Username="correo@correo.com";
        $mail->Password="clave";

        $mail->From='correo@correo.com';
        $mail->FromName=$fromName;
        $mail->AddAddress($correo);

        $mail->WordWrap=50; // set word wrap
        //$mail->AddAttachment("/var/tmp/file.tar.gz"); // attachment
        //$mail->AddAttachment("/tmp/image.jpg", "new.jpg"); // attachment
        $mail->IsHTML(true); // send as HTML
        $mail->Subject=$asunto;
        $mail->Body=$mensaje; //HTML Body
        $mail->AltBody=strip_tags($mail->Body); // Este es el contenido alternativo sin html
        $mail->Send();
    }
    
    public static function callFunctionJS()
    {
        if(self::isEmpty(self::$callFunctionJS))
        { 
            $semilla=str_replace(array('.','-'), array('_','_'), self::getSemilla());
            self::$callFunctionJS=f::id($semilla);
        }
        return self::$callFunctionJS;
    }

    public static function getActiveEncodeDecodeUTF8()
    {
        return self::$activeEncodeDecodeUTF8;
    }
}