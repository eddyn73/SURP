<?php
/**
 * Description of a <br/>
 * Retorna la auditoria
 *
 * @author epalomino
 */
class a
{
    /**
     * 
     * Retorna un array con los valor:<br/>
     * 
     * : user_agent<br/>
     * : navegador<br/>
     * : dispositivo<br/>
     * : sistemaoperativo<br/>
     * : modelo<br/>
     * : ip_remoto<br/>
     * : ip_local<br/>
     * : hostname_remoto<br/>
     * : hostname_local<br/>
     * : paginaAnterior<br/>
     * : paginaActual<br/>
     * : paginaAnteriorFront<br/>
     */
    public static function getAuditoria()
    {
        $user_agent=$_SERVER['HTTP_USER_AGENT'];

        $array=array();
        $array['user_agent']=$user_agent;
        $array['navegador']=self::getNavegador($user_agent);
        $array['dispositivo']=self::getDispositivo($user_agent);
        $array['sistemaoperativo']=self::getSistemaOperativo($user_agent);
        $array['modelo']=self::getModelo($user_agent);
        $array['ip_remoto']=$_SERVER['REMOTE_ADDR'];
        $array['ip_local']=$_SERVER['SERVER_ADDR'];
        $array['hostname_remoto']=gethostbyaddr($array['ip_remoto']);
        $array['hostname_local']=gethostbyaddr($array['ip_local']);
        $array['paginaAnterior']=@$_SERVER['HTTP_REFERER'];
        $array['paginaActual']=$_SERVER['SCRIPT_FILENAME'];
        $array['paginaAnteriorFront']=f::getSession('FrontController.HTTP_REFERER');

        return $array;
    }
    
    private static function getNavegador($user_agent)
    {
        if(stripos($user_agent,'MSIE 10')!==false)
        {
            $navegador='IE 10';
        }
        else if(stripos($user_agent,'MSIE 9')!==false)
        {
            $navegador='IE 9';
        }
        else if(stripos($user_agent,'MSIE 8')!==false)
        {
            $navegador='IE 8';
        }
        else if(stripos($user_agent,'MSIE 7')!==false)
        {
            $navegador='IE 7';
        }
        else if(stripos($user_agent,'MSIE 6')!==false)
        {
            $navegador='IE 6';
        }
        else if(stripos($user_agent,'MSIE 5')!==false)
        {
            $navegador='IE 5';
        }
        else if(stripos($user_agent,'MSIE')!==false)
        {
            $navegador='IE';
        }
        else if(stripos($user_agent,'chrome')!==false)
        {
            $navegador='Google Chrome';
        }
        else if(stripos($user_agent,'firefox')!==false)
        {
            $navegador='Mozilla Firefox';
        }
        else if(stripos($user_agent,'opera')!==false)
        {
            $navegador='Opera';
        }
        else if(stripos($user_agent,'safari')!==false)
        {
            $navegador='Safari';
        }
        else if(stripos($user_agent,'galeon')!==false)
        {
            $navegador='Galeon';
        }
        else if(stripos($user_agent,'konqueror')!==false)
        {
            $navegador='Konqueror';
        }
        else if(stripos($user_agent,'netscape')!==false)
        {
            $navegador='Netscape';
        }
        else
        {
            $navegador='Desconocido';
        }
        return $navegador;
    }
    
    private static function getDispositivo($user_agent)
    {
        if(stripos($user_agent,'mobile')!==false)
        {
            $dispositivo='Móvil';
        }
        else if(stripos($user_agent,'table')!==false)
        {
            $dispositivo='Tablet';
        }
        else
        {
            $dispositivo='Computadora';
        }
        return $dispositivo;
    }
    
    private static function getSistemaOperativo($user_agent)
    {
        #******************************************************************************************/
        #*                                      SISTEMA OPERATIVO                                 */
        #******************************************************************************************/
        if(stripos($user_agent,'windows')!==false)
        {
            $sistemaoperativo='Windows';
        }
        else if(stripos($user_agent,'android')!==false)
        {
            $sistemaoperativo='Android';
        }
        else if(stripos($user_agent,'iPad')!==false)
        {
            $sistemaoperativo='iPad';
        }
        else if(stripos($user_agent,'iPhone')!==false)
        {
            $sistemaoperativo='iPhone';
        }
        else if(stripos($user_agent,'iPod')!==false)
        {
            $sistemaoperativo='iPod';
        }
        else if(stripos($user_agent,'BlackBerry')!==false)
        {
            $sistemaoperativo='BlackBerry';
        }
        else if(stripos($user_agent,'linux')!==false)
        {
            $sistemaoperativo='Linux';
        }
        else if(stripos($user_agent,'mac')!==false)
        {
            $sistemaoperativo='Mac';
        }
        else 
        {
            $sistemaoperativo='Desconocido';
        }
        return $sistemaoperativo;
    }
    
    private static function getModelo($user_agent)
    {
        #******************************************************************************************/
        #*                                     MODELO DISPOSITIVO                                 */
        #******************************************************************************************/
        if(stripos($user_agent,'GT-I9300')!==false)
        {
            $modelo='Galaxy S III - [GT-I9300]';
        }
        else if(stripos($user_agent,'HTC One')!==false)
        {
            $modelo='HTC One';
        }
        else if(stripos($user_agent,'HTC')!==false)
        {
            $modelo='HTC';
        }
        else if(stripos($user_agent,'GT-S7500')!==false)
        {
            $modelo='Galaxy Ace Plus - [GT-S7500]';
        }
        else if(stripos($user_agent,'GT-S5839')!==false)
        {
            $modelo='Galaxy Ace VE - [GT-S5839]';
        }
        else if(stripos($user_agent,'GT-P5110')!==false)
        {
            $modelo='Galaxy Tab 2 10.1 - [GT-P5110]';
        }
        else if(stripos($user_agent,'LT26')!==false)
        {
            $modelo='Sony Xperia S - [LT26]';
        }
        else if(stripos($user_agent,'TM420M')!==false)
        {
            $modelo='Airis [TM420M]';
        }
        else if(stripos($user_agent,'SM-N900')!==false)
        {
            $modelo='Galaxy Note 3 - [SM-N900]';
        }
        else if(stripos($user_agent,'GT-I9500')!==false)
        {
            $modelo='Galaxy S4 - [GT-I9500]';
        }
        else if(stripos($user_agent,'GT-N8010')!==false)
        {
            $modelo='Galaxy Note 10.1 - [GT-N8010]';
        }
        else if(stripos($user_agent,'MOT-XT389')!==false)
        {
            $modelo='Motorola Motoluxe - [MOT-XT389]';
        }
        else if(stripos($user_agent,'A2107')!==false)
        {
            $modelo='Tablet Lenovo A2107';
        }
        else if(stripos($user_agent,'LG-P768')!==false)
        {
            $modelo='LG OPTIMUS L9 - [LG-P768]';
        }
        else if(stripos($user_agent,'MD-0697')!==false)
        {
            $modelo='Prolink - [MD-0697]';
        }
        else if(stripos($user_agent,'PAD705')!==false)
        {
            $modelo='Tablet PAD705';
        }
        else if(stripos($user_agent,'GT-I8190L')!==false)
        {
            $modelo='Galaxy S III mini - [GT-I8190L]';
        }
        else if(stripos($user_agent,'GT-N7100')!==false)
        {
            $modelo='Galaxy Note II - [GT-N7100]';
        }
        else if(stripos($user_agent,'GT-P3113')!==false)
        {
            $modelo='Samsung Galaxy Tab 2 - [GT-P3113]';
        }
        else if(stripos($user_agent,'SGPT12')!==false)
        {
            $modelo='Tablet Sony - [SGPT12]';
        }
        else if(stripos($user_agent,'LG-E450')!==false)
        {
            $modelo='LG Optimus L5 II - [LG-E450]';
        }
        else if(stripos($user_agent,'LG-E976')!==false)
        {
            $modelo='LG Optimus G - [LG-E976]';
        }
        else if(stripos($user_agent,'LT22')!==false)
        {
            $modelo='Sony Xperia P - [LT22]';
        } 
        else if(stripos($user_agent,'SGH-T999L')!==false)
        {
            $modelo='T-Mobile Cell Phones (Galaxy S3)- [SGH-T999L]';
        }
        else if(stripos($user_agent,'XT914')!==false)
        {
            $modelo='Motorola Razr D1 - [XT914]';
        }
        else if(stripos($user_agent,'SCH-R970C')!==false)
        {
            $modelo='T-Mobile Cell Phones (Galaxy S4)- [SGH-R970C]';
        }
        else if(stripos($user_agent,'GT-S5570')!==false)
        {
            $modelo='Galaxy Mini - [GT-S5570]';
        }
        else if(stripos($user_agent,'U8820')!==false)
        {
            $modelo='Huawei Titán - [U8820]';
        }
        else if(stripos($user_agent,'A1_07')!==false)
        {
            $modelo='IdeaPad (Copia de Lenovo) - [A1_07]';
        }
        else if(stripos($user_agent,'GT-I9100')!==false)
        {
            $modelo='Galaxy S II';
        }
        else if(stripos($user_agent,'GT-S5830')!==false)
        {
            $modelo='Galaxy Ace';
        }
        else if(stripos($user_agent,'A810')!==false)
        {
            $modelo='HTC ChaCha - [A810]';
        }
        else if(stripos($user_agent,'GT-S5360')!==false)
        {
            $modelo='Galaxy Y - [GT-S5360]';
        }
        else if(stripos($user_agent,'LG-E400')!==false)
        {
            $modelo='LG Optimus L3 - [LG-E400]';
        }
        else if(stripos($user_agent,'GT-S5300')!==false)
        {
            $modelo='Galaxy Pocket - [GT-S5300]';
        }
        else if(stripos($user_agent,'XT626')!==false)
        {
            $modelo='Motorola IronRock - [XT626]';
        }
        else if(stripos($user_agent,'XT615')!==false)
        {
            $modelo='Motorola MotoSmart Plus - [XT615]';
        }
        else if(stripos($user_agent,'LG-E612')!==false)
        {
            $modelo='LG Optimus L5 - [LG-E612]';
        }
        else if(stripos($user_agent,'GT-P3100')!==false)
        {
            $modelo='GALAXY Tab 2 (7.0) - [GT-P3100]';
        }
        else 
        {
            $modelo='Desconocido';
        }
        return $modelo;
    }
}