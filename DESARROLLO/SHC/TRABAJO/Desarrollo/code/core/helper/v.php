<?php
/**
 * Esta clase valida parametros <br/>
 * recibe mensajes de error <br/>
 * y genera JSON y HTML <b>UL</b>
 * 
 * @author epalomino
 */
class v
{
    private static $json=array();
    private static $error=array();

    /**
     * Si hay errores retorna un <br/>
     * <b>array</b> de errores, o <b>null</b> si <br/>
     * no hay errores
     * @return null|array
     */
    public static function getError()
    {
        $return=null;
        self::getErrorRecursivo(self::$error, $return);
        return $return;
    }

    private static function getErrorRecursivo($array, &$return)
    {
        foreach($array as $v)
        {
            if(is_array($v))
            {
                self::getErrorRecursivo($v, $return);
            }
            else if(!f::isEmpty($v))
            {
                $return[]=$v;
            }
        }
    }

    /**
     * Ingresa errores
     * @param type $value : Mensaje del Error
     */
    public static function setError($value)
    {
        self::$error[]=$value;
    }

    /**
     * Resetea los Errores
     */
    public static function clearError()
    {
        self::$error=array();
    }

    /**
     * Palabras reservadas de validación:<br/>
     * <b>required</b> => como minimo un digito<br/>
     * <b>minSize[10]</b> =>   como minimo 10 digitos<br/>
     * <b>maxSize[10]</b> =>   como maximo 10 digitos<br/>
     * <b>min[10]</b> =>   numero 10 como minimo<br/>
     * <b>max[10]</b> =>   numero 10 como minimo<br/>
     * <b>custom[ip-url-email-integer-number-onlyNumberSp-onlyLetterSp-onlyLetterNumber-date]</b>
     *  
     * @param type $fieldValue : Campo a validar
     * @param type $fieldName  : Nombre del Campo (Al retornar el error, especifica  a que campo)
     * @param type $valida     : String de validación 
     * @param type $injection  : indica si se aplica validacion de  SQL Injection, por defecto <b>true</b>
     */
    public static function valida(&$fieldValue, $fieldName, $valida, $injection=true)
    {
        self::setError(self::validaCampo($fieldValue, $fieldName, $valida, $injection));
    }
    
    /**
     * validaCampo(&$fieldValue,$fieldName='',$valida='',$injection=true)
     * @param array $fieldValue <p>campo a validar</p>
     * @param array $fieldName [optional]<p>Nombre de referencia del Campo</p>
     * @param string $valida<p>
     * 
     * <b>required</b> => como minimo un digito<br/>
     * <b>minSize[10]</b> =>   como minimo 10 digitos<br/>
     * <b>maxSize[10]</b> =>   como maximo 10 digitos<br/>
     * <b>min[10]</b> =>   numero 10 como minimo<br/>
     * <b>max[10]</b> =>   numero 10 como minimo<br/>
     * <b>custom[ip-url-email-integer-number-onlyNumberSp-onlyLetterSp-onlyLetterNumber-date]</b>
     * </p>
     * @param string $injection [optional]<p>valida injection por defecto <b>true</b></p>
     * @return array <p>Retorna un <b>arreglo</b> de errores, o retorna <b>false</b> en caso de estar correcto</p>
     */
    private static function validaCampo(&$fieldValue, $fieldName='', $valida='', $injection=true)
    {
        $fieldName='<strong>'.$fieldName.'</strong>';
        $return=false;
        $fieldValue=trim($fieldValue);
        $valida_array=explode(',', $valida);
        foreach($valida_array as $key=> $value)
        {
            $value_replace=str_replace('[', '_', $value);
            $value_replace=str_replace(']', '', $value_replace);
            $value_array=explode('_', $value_replace);
            if(count($value_array) == 2)
            {
                $value=trim($value_array[0]);
                $value_interno=trim($value_array[1]);
            }
            else
            {
                $value=trim($value);
                $value_interno='';
            }
            $return_temp=self::validaCampoExcepcion($fieldValue, $fieldName, $value, $value_interno);
            if(!empty($return_temp))
                $return[]=$return_temp;
        }
        if($injection == true)
        {
            $fieldValue=f::p($fieldValue);
        }
        return $return;
    }

    private static function validaCampoExcepcion($fieldValue, $fieldName, $value, $value_interno)
    {
        $return=false;
        #***********************************************************/
        #                        REQUERIDO                         */
        #***********************************************************/
        if($value == 'required')
        {
            if(strlen($fieldValue) == 0)
            {
                $return='El campo '.$fieldName.' está requerido';
            }
        }
        #***********************************************************/
        #                    MINIMO CARACTERES                    */
        #***********************************************************/
        else if($value == 'minSize')
        {
            if(strlen($fieldValue) > 0)
            {
                if(is_numeric($value_interno))
                    $value_interno=intval($value_interno);
                if(is_int($value_interno))
                {
                    if(strlen($fieldValue) < $value_interno)
                    {
                        $return='El campo '.$fieldName.' debe tener <strong>'.$value_interno.'</strong> dígitos como mínimo';
                    }
                }
                else
                {
                    $return='<strong>Error Interno:</strong> Entero no valido en <strong>minSize['.$value_interno.']</strong> en el campo ['.$fieldName.'] ';
                }
            }
        }
        /*         * ********************************************************** */
        /*                  MAXIMO CARACTERES                        */
        /*         * ********************************************************** */
        else if($value == 'maxSize')
        {
            if(strlen($fieldValue) > 0)
            {
                if(is_numeric($value_interno))
                    $value_interno=intval($value_interno);
                if(is_int($value_interno))
                {
                    if(strlen($fieldValue) > $value_interno)
                    {
                        $return='El campo '.$fieldName.' debe tener <strong>'.$value_interno.'</strong> dígitos como máximo';
                    }
                }
                else
                {
                    $return='<strong>Error Interno:</strong> Entero no valido en <strong>maxSize['.$value_interno.']</strong> en el campo ['.$fieldName.'] ';
                }
            }
        }
        /*         * ********************************************************** */
        /*                      NUMERO MINIMO                        */
        /*         * ********************************************************** */
        else if($value == 'min')
        {
            if(strlen($fieldValue) > 0)
            {
                if(is_numeric($value_interno))
                    $value_interno=floatval($value_interno);
                if(is_float($value_interno))
                {
                    if(is_numeric($fieldValue))
                    {
                        if($fieldValue < $value_interno)
                        {
                            $return='El campo '.$fieldName.' debe ser mayor o igual a  <strong>'.$value_interno.'</strong>';
                        }
                    }
                    else
                    {
                        $return='<strong>Alerta:</strong> Número no válido en el campo ['.$fieldName.'] ';
                    }
                }
                else
                {
                    $return='<strong>Error Interno:</strong> Entero no valido en <strong>maxSize['.$value_interno.']</strong> en el campo ['.$fieldName.'] ';
                }
            }
        }
        /*         * ********************************************************** */
        /*                      NUMERO MAXIMO                        */
        /*         * ********************************************************** */
        else if($value == 'max')
        {
            if(strlen($fieldValue) > 0)
            {

                if(is_numeric($value_interno))
                    $value_interno=floatval($value_interno);
                if(is_float($value_interno))
                {
                    if(is_numeric($fieldValue))
                    {
                        if($fieldValue > $value_interno)
                        {
                            $return='El campo '.$fieldName.' debe ser menor o igual a  <strong>'.$value_interno.'</strong>';
                        }
                    }
                    else
                    {
                        $return='<strong>Alerta:</strong> Número no válido en el campo ['.$fieldName.'] ';
                    }
                }
                else
                {
                    $return='<strong>Error Interno:</strong> Entero no valido en <strong>maxSize['.$value_interno.']</strong> en el campo ['.$fieldName.'] ';
                }
            }
        }
        /*         * *********************************************************************************** */
        /* CUSTOM [ip-url-email-integer-number-onlyNumberSp-onlyLetterSp-onlyLetterNumber-date] */
        /*         * *********************************************************************************** */
        else if($value == 'custom')
        {
            if(strlen($fieldValue) > 0)
            {
                if($value_interno == 'ip')
                {
                    $regex='/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\z/';
                    if(!preg_match($regex, $fieldValue))
                    {
                        $return='El campo '.$fieldName.' debe tener el formato [<strong>000.000.000.000</strong>]';
                    }
                }
                else if($value_interno == 'url')
                {
                    $regex="/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i";
                    if(!preg_match($regex, $fieldValue))
                    {
                        $return='El campo '.$fieldName.' no tiene formato de URL [<strong>http://</strong>][<strong>ftp://</strong>][<strong>www.</strong>]';
                    }
                }
                else if($value_interno == 'email')
                {
                    $regex="/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,6}$/";
                    if(!preg_match($regex, $fieldValue))
                    {
                        $return='El campo '.$fieldName.' no tiene formato de E-mail [correo@dominio.com]';
                    }
                }
                else if($value_interno == 'integer')
                {
                    $regex='/^[\-\+]?\d+$/';
                    if(!preg_match($regex, $fieldValue))
                    {
                        $return='El campo '.$fieldName.' no es un entero válido';
                    }
                }
                else if($value_interno == 'number')
                {
                    $regex='/^[\-\+]?(([0-9]+)([\.,]([0-9]+))?|([\.,]([0-9]+))?)$/';
                    if(!preg_match($regex, $fieldValue))
                    {
                        $return='El campo '.$fieldName.' no es un número válido';
                    }
                }
                else if($value_interno == 'date')
                {
                    $regex='~^(((0[1-9]|[12]\d|3[01])\/(0[13578]|1[02])\/((19|[2-9]\d)\d{2}))|((0[1-9]|[12]\d|30)\/(0[13456789]|1[012])\/((19|[2-9]\d)\d{2}))|((0[1-9]|1\d|2[0-8])\/02\/((19|[2-9]\d)\d{2}))|(29\/02\/((1[6-9]|[2-9]\d)(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00))))$~';
                    if(!preg_match($regex, $fieldValue))
                    {
                        $return='El campo '.$fieldName.' no es una fecha válida [<strong>dd/mm/aaaa</strong>]';
                    }
                }
                else if($value_interno == 'onlyNumberSp')
                {
                    $regex='/^[0-9\ ]+$/';
                    if(!preg_match($regex, $fieldValue))
                    {
                        $return='El campo '.$fieldName.' debe ser solo numérico';
                    }
                }
                else if($value_interno == 'onlyLetterSp')
                {
                    $regex='/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\ \']+$/';
                    if(!preg_match($regex, $fieldValue))
                    {
                        $return='El campo '.$fieldName.' debe ser solo letras';
                    }
                }
                else if($value_interno == 'onlyLetterNumber')
                {
                    $regex='/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ]+$/';
                    if(!preg_match($regex, $fieldValue))
                    {
                        $return='El campo '.$fieldName.' solo letras y números';
                    }
                }
                else
                {
                    $return='<strong>Error Interno:</strong> No Existe la Excepción <strong>custom['.$value_interno.']</strong> en el campo ['.$fieldName.'] ';
                }
            }
        }
        else
        {
            $return='<strong>Error Interno:</strong> No Existe la Excepción <strong>'.$value.'['.$value_interno.']</strong> en el campo ['.$fieldName.'] ';
        }
        return $return;
    }
    
    /**
     * Ingresa el parametro y valor al arreglo de json
     * @param type $key     : Parametro
     * @param type $value   : Valor
     */
    public static function setJSON($key, $value)
    {
        self::$json[$key]=$value;
    }

    /**
     * Obtiene el valor del Parametro
     * @param type $key : Parametro
     * @return value
     */
    public static function getJSON($key)
    {
        return self::$json[$key];
    }

    /**
     * Resetea el JSON
     */
    public static function clearJSON()
    {
        self::$json=array();
    }

    /**
     * hace un <b>echo</b> en formato JSON
     */
    public static function printJSON()
    {
        if(!f::isEmpty(self::$json))
        {
            echo json_encode(self::$json);
        }
    }

    /**
     * Setea los paramtros basicos <br/>
     * del JSON con mensaje Correcto<br/>
     * <br/>
     * <b>accion</b>:true<br/>
     * <b>refrescar</b>:false<br/>
     * <b>estilo</b>:ui-state-highlight<br/>
     * <b>icono</b>:ui-icon-info<br/>
     * <b>segundos</b>:7<br/>
     * <b>tag</b>:body<br/>
     * <b>ubicacion</b>:up<br/>
     * <b>respuesta</b>:Correcto<br/>
     * <b>descripcion</b>:null<br/>
     * <b>data</b>:null<br/>
     * <b>cerrar</b>:true<br/>
     */
    public static function setTrueJSON()
    {
        self::clearJSON();
        self::setJSON('accion', true);
        self::setJSON('refrescar', false);
        self::setJSON('estilo', 'ui-state-highlight');
        self::setJSON('icono', 'ui-icon-info');
        self::setJSON('segundos', '7');
        self::setJSON('tag', 'body');
        self::setJSON('ubicacion', 'up');
        self::setJSON('respuesta', 'Mensaje:');
        self::setJSON('descripcion', null);
        self::setJSON('data', null);
        self::setJSON('cerrar', true);
    }

    /**
     * Setea los paramtros basicos <br/>
     * del JSON con mensaje Incorrecto<br/>
     * <br/>
     * <b>accion</b>:false<br/>
     * <b>refrescar</b>:false<br/>
     * <b>estilo</b>:ui-state-error<br/>
     * <b>icono</b>:ui-icon-alert<br/>
     * <b>segundos</b>:7<br/>
     * <b>tag</b>:body<br/>
     * <b>ubicacion</b>:up<br/>
     * <b>respuesta</b>:Error<br/>
     * <b>descripcion</b>:null<br/>
     * <b>data</b>:null<br/>
     * <b>cerrar</b>:true<br/>
     */
    public static function setFalseJSON()
    {
        self::clearJSON();
        self::setJSON('accion', false);
        self::setJSON('refrescar', false);
        self::setJSON('estilo', 'ui-state-error');
        self::setJSON('icono', 'ui-icon-alert');
        self::setJSON('segundos', '7');
        self::setJSON('tag', 'body');
        self::setJSON('ubicacion', 'up');
        self::setJSON('respuesta', 'Mensaje:');
        self::setJSON('descripcion', null);
        self::setJSON('data', null);
        self::setJSON('cerrar', true);
    }

    /**
     * Retorna false si no hay error, en caso <br/>
     * contrario retorna true y llama a <b>printJSON()</b>
     * @param type $tag         :   <b>body</b> por defecto
     * @param type $ubicacion   :   <b>up</b> por defecto
     * @return boolean          
     */
    public static function validaErrorJSON($tag='body', $ubicacion='up',$cerrar=true)
    {
        $return=false;
        if(!f::isEmpty(self::getError()))
        {
            self::setFalseJSON();
            self::setJSON('segundos', (7 * count(self::getError())));
            self::setJSON('tag', $tag);
            self::setJSON('ubicacion', $ubicacion);
            self::setJSON('descripcion', self::validaErrorUL());
            self::setJSON('cerrar', $cerrar);
            self::printJSON();
            $return=true;
        }
        return $return;
    }

    /**
     * <b>validaErrorUL</b>($echo=false)<br/>
     * Retorna false si no hay error, en caso <br/>
     * contrario retorna los errores en formato HTML <b>UL</b>
     * @param type $echo :   <b>false</b> por defecto
     * @return string|boolean
     */
    public static function validaErrorUL($echo=false)
    {
        $return=false;
        if(!f::isEmpty(self::getError()))
        {
            $return='
            <ul style="padding:0px 0px 0px 14px;margin:5px;">
                <li style="padding:1px;">'.implode('</li><li style="padding:1px;">', self::getError()).'</li>
            </ul>
            ';
        }

        if(!f::isEmpty($echo))
        {
            if(f::isEmpty($return))
            {
                return $return;
            }
            else
            {
                echo $return;
                return true;
            }
        }
        else
        {
            return $return;
        }
    }
    
    public static function printUL()
    {
        self::validaErrorUL(true);
    }

}