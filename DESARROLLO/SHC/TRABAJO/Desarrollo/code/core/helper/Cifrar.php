<?php
/**
 * Description of Cripto
 *
 * @author epalomino
 */
class Cifrar
{
    private static $cifradoActivo=true;
    #**********************************************************************************************/
    private static $charSet=null;
    private static $charSetNumerico='1234567890';
    private static $charSetMayuscula='ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    private static $charSetMinuscula='abcdefghijklmnopqrstuvwxyz';
    private static $charSetSize=null;
    private static $charSetArray=null;
    #**********************************************************************************************/
    private static $randomActivo=false;
    private static $randomCifrado='nK![W%WYV/XRjg@V5!.E';
    private static $randomNumero=8;
    private static $randomRango=5;
    private static $randomNumeroAux=null;
    private static $randomRangoAux=null;
    private static $randomCifradoAux=null;

    #**********************************************************************************************/
    #*                       Cifrado Criptográfico - Sustitucion                                  */
    #**********************************************************************************************/

    private static final function matrizProcesa($texto)
    {
        $array_text=str_split($texto);
        $length=count($array_text);

        $matriz_length=0;
        for($index=0; $index < $length; $index++)
        {
            if($index * $index >= $length)
            {
                $matriz_length=$index;
                break;
            }
        }
        $matriz=null;
        $k=0;
        for($i=0; $i < $matriz_length; $i++)
        {
            for($j=0; $j < $matriz_length; $j++)
            {
                if($k < $length)
                {
                    $inside['estado']=true;
                    $inside['value']=$array_text[$k];
                }
                else
                {
                    $inside['estado']=false;
                    $inside['value']=null;
                }
                $matriz[$i][$j]=$inside;
                $k++;
            }
        }
        return array(
            'matriz'=>$matriz
            , 'matriz_length'=>$matriz_length
            , 'length'=>$length
            , 'array_text'=>$array_text
        );
    }

    public static final function sustitucionEncode($texto)
    {
        if(!f::isEmpty(self::$cifradoActivo))
        {
            if(!is_array($texto) and !is_object($texto))
            {
                $return=self::matrizProcesa($texto);
                $matriz=$return['matriz'];
                $matriz_length=$return['matriz_length'];
                $length=$return['length'];
                $array_text=$return['array_text'];

                if($length >= 3)
                {
                    $k=0;
                    for($i=0; $i < $matriz_length; $i++)
                    {
                        for($j=0; $j < $matriz_length; $j++)
                        {
                            if($k < $length)
                            {
                                $inside['estado']=true;
                                $inside['value']=$array_text[$k];
                            }
                            else
                            {
                                $inside['estado']=false;
                                $inside['value']=null;
                            }
                            $matriz[$i][$j]=$inside;
                            $k++;
                        }
                    }

                    $encode=null;
                    for($j=0; $j < $matriz_length; $j++)
                    {
                        if($j % 2 != 0)//impares
                        {
                            for($i=0; $i < $matriz_length; $i++)
                            {
                                $inside=$matriz[$i][$j];
                                if(!f::isEmpty($inside['estado']))
                                {
                                    $encode.= $inside['value'];
                                }
                            }
                        }
                    }
                    for($j=0; $j < $matriz_length; $j++)
                    {
                        if($j % 2 == 0)//pares
                        {
                            for($i=0; $i < $matriz_length; $i++)
                            {
                                $inside=$matriz[$i][$j];
                                if(!f::isEmpty($inside['estado']))
                                {
                                    $encode.= $inside['value'];
                                }
                            }
                        }
                    }
                }
                else
                {
                    $encode=$texto;
                }
            }
            else
            {
                $encode=$texto;
            }
        }
        else
        {
            $encode=$texto;
        }
        return $encode;
    }

    public static function sustitucionDecode($texto)
    {
        if(!f::isEmpty(self::$cifradoActivo))
        {
            if(!is_array($texto) and !is_object($texto))
            {
                $return=self::matrizProcesa($texto);
                $matriz=$return['matriz'];
                $matriz_length=$return['matriz_length'];
                $length=$return['length'];
                $array_text=$return['array_text'];

                if($length >= 3)
                {
                    $k=0;
                    for($j=0; $j < $matriz_length; $j++)
                    {
                        if($j % 2 != 0)//impares
                        {
                            for($i=0; $i < $matriz_length; $i++)
                            {
                                $inside=$matriz[$i][$j];
                                if(!f::isEmpty($inside['estado']))
                                {
                                    $inside['value']=$array_text[$k];
                                    $matriz[$i][$j]=$inside;
                                    $k++;
                                }
                            }
                        }
                    }

                    for($j=0; $j < $matriz_length; $j++)
                    {
                        if($j % 2 == 0)//pares
                        {
                            for($i=0; $i < $matriz_length; $i++)
                            {
                                $inside=$matriz[$i][$j];
                                if(!f::isEmpty($inside['estado']))
                                {
                                    $inside['value']=$array_text[$k];
                                    $matriz[$i][$j]=$inside;
                                    $k++;
                                }
                            }
                        }
                    }
                    $decode=null;
                    for($i=0; $i < $matriz_length; $i++)
                    {
                        for($j=0; $j < $matriz_length; $j++)
                        {
                            $inside=$matriz[$i][$j];
                            if(!f::isEmpty($inside['estado']))
                            {
                                $decode.=$inside['value'];
                            }
                        }
                    }
                }
                else
                {
                    $decode=$texto;
                }
            }
            else
            {
                $decode=$texto;
            }
        }
        else
        {
            $decode=$texto;
        }

        return $decode;
    }
    #**********************************************************************************************/
    #**********************************************************************************************/
    #*                       Cifrado Criptográfico - Desplazamiento                               */
    #**********************************************************************************************/

    private static function desplazarTexto($texto, $desplaza)
    {
        //$texto=strval($texto);
        $return=null;
        for($i=0; $i < strlen($texto); $i++)
        {
            $return .= self::desplazarDigito($texto{$i}, $desplaza);
        }
        return $return;
    }

    public static function desplazamientoEncode($texto, $desplaza=null)
    {
        if(!f::isEmpty(self::$cifradoActivo))
        { 
            if(!is_array($texto) and !is_object($texto))
            {
                $desplaza=self::desplacamientoValida($texto, $desplaza);
                $return=self::desplazarTexto($texto, $desplaza);
            }
            else
            {
                $return=$texto;
            }
        }
        else
        {
            $return=$texto;
        } 
        return $return;
    }

    public static function desplazamientoDecode($texto, $desplaza=null)
    {
        if(!f::isEmpty(self::$cifradoActivo))
        {
            if(!is_array($texto) and !is_object($texto))
            {
                $desplaza=self::desplacamientoValida($texto, $desplaza);
                $return=self::desplazarTexto($texto, (($desplaza) * (-1)));
            }
            else
            {
                $return=$texto;
            }
        }
        else
        {
            $return=$texto;
        } 
        return $return;
    }

    private static function desplacamientoValida($texto, $desplaza=null)
    {
        $default=10;
        if(f::isEmpty($desplaza))
        {
            $n=strlen($texto);
            if($n==0)
            {
                $n=1;
            }
            if(self::getCharSetSize() > $n)
            {
                $desplaza=self::getCharSetSize() % $n;
            }
            else
            {
                $desplaza=$n % self::getCharSetSize();
            }
            if(f::isEmpty($desplaza))
            {
                $desplaza=$default;
            }
        }

        if($desplaza >= self::getCharSetSize() or $desplaza < ((-1) * (self::getCharSetSize())))
        {
            $desplaza=$default;
        }
        return $desplaza;
    }

    private static function desplazarDigito($digito, $n)
    {
        $return=null;
        foreach(self::getCharSetArray() as $key=> $value)
        {
            if($digito === $value)
            {
                $k=$key + $n;
                if($k < 0)
                {
                    $k += self::getCharSetSize();
                }
                else if($k >= self::getCharSetSize())
                {
                    $k -= self::getCharSetSize();
                }
                $return=self::$charSetArray[$k];
                break;
            }
        }
        if($return === null)
        {
            $return=$digito;
        }
        return $return;
    }

    private static function getCharSetSize()
    {
        if(f::isEmpty(self::$charSetSize))
        {
            self::$charSetSize=strlen(self::getCharSet());
        }
        return self::$charSetSize;
    }

    private static function getCharSetArray()
    {
        if(f::isEmpty(self::$charSetArray))
        {
            self::$charSetArray=str_split(self::getCharSet());
        }

        return self::$charSetArray;
    }
    #**********************************************************************************************/

    public static final function getCharSet()
    {
        if(f::isEmpty(self::$charSet))
        {
            $charSet=self::$charSetMayuscula;
            $charSet.=self::$charSetNumerico;
            $charSet.=self::$charSetMinuscula;
            self::$charSet=self::sustitucionEncode($charSet);
        }
        return self::$charSet;
    }

    /**
     * Valores de $charSet:<br/>
     * $charSet : stringUp <br/>
     * $charSet : int <br/>
     * $charSet : stringLow <br/>
     * $charSet : string <br/>
     * $charSet : stringUpInt <br/>
     * $charSet : strinLowpInt <br/>
     * random($limite,$charSet=null) 
     * @param type $limite
     * @param type $charSet
     * @return type
     */
    public static function random($limite, $charSet=null)
    {
        switch($charSet)
        {
            case 'stringUp'://String Mayuscula
                $muestra=self::$charSetMayuscula;
                break;
            case 'int'://Numerico
                $muestra=self::$charSetNumerico;
                break;
            case 'stringLow'://String Minuscula
                $muestra=self::$charSetMinuscula;
                break;
            case 'string'://String
                $muestra=self::$charSetMayuscula;
                $muestra.=self::$charSetMinuscula;
                break;
            case 'stringUpInt'://String Mayuscula con Numeros
                $muestra=self::$charSetMayuscula;
                $muestra.=self::$charSetNumerico;
                break;
            case 'strinLowpInt'://String Minuscula con Numeros
                $muestra=self::$charSetMinuscula;
                $muestra.=self::$charSetNumerico;
                break;
            default:
                $muestra=self::getCharSet();
                break;
        }
        $array_random=array();
        for($i=0; $i < $limite; $i++)
        {
            $array_random[]=$muestra{rand(0, strlen($muestra) - 1)};
        }
        return implode('', $array_random);
    }
    #**********************************************************************************************/
    #*                       Cifrado Criptográfico - Base64                                       */
    #**********************************************************************************************/

    public static function getRandomNumero()
    {
        if(f::isEmpty(self::$randomActivo))
        {
            $return=self::$randomNumero;
        }
        else
        {
            if(f::isEmpty(self::$randomNumeroAux))
            {
                f::sessionStart();
                $randomNumero=f::getSemilla().'.'.'random-numero';
                
                if(!f::isEmpty(f::getVarSessionEncriptada()))
                {
                    $prefijo=f::getVarPrefijo();
                    if(!f::isEmpty(f::getVarEncriptar()))
                    {
                        $randomNumero=$prefijo.self::md5($randomNumero);
                    }
                    else
                    {
                        $randomNumero=$prefijo.$randomNumero;
                    }
                }
                
                if(!isset($_SESSION[$randomNumero]))
                {
                    $random=rand(8, 12);
                    
                    $_SESSION[$randomNumero]=$random;
                }
                self::$randomNumeroAux=$_SESSION[$randomNumero];
                
            
            }
            $return=self::$randomNumeroAux;
        }
        return $return;
    }

    public static function getRandomRango()
    {
        if(f::isEmpty(self::$randomActivo))
        {
            $return=self::$randomRango;
        }
        else
        {
            if(f::isEmpty(self::$randomRangoAux))
            {
                f::sessionStart();
                $randomRango=f::getSemilla().'.'.'random-rango';
                
                if(!f::isEmpty(f::getVarSessionEncriptada()))
                {
                    $prefijo=f::getVarPrefijo();
                    if(!f::isEmpty(f::getVarEncriptar()))
                    {
                        $randomRango=$prefijo.self::md5($randomRango);
                    }
                    else
                    {
                        $randomRango=$prefijo.$randomRango;
                    }
                }
                
                if(!isset($_SESSION[$randomRango]))
                {
                    $random=rand(5, 7);
            
                    $_SESSION[$randomRango]=$random;
                }
                self::$randomRangoAux=$_SESSION[$randomRango];
            
            }
            $return=self::$randomRangoAux;
        }
        return $return;
    }

    public static function getRandomCifrado()
    {
        $return=null;
        if(f::isEmpty(self::$randomActivo))
        {
            $return=self::$randomCifrado;
        }
        else
        {
            if(f::isEmpty(self::$randomCifradoAux))
            {
                f::sessionStart();
                $randomCifrado=f::getSemilla().'.'.'random-cifrado';
                
                if(!f::isEmpty(f::getVarSessionEncriptada()))
                {
                    $prefijo=f::getVarPrefijo();
                    if(!f::isEmpty(f::getVarEncriptar()))
                    {
                        $randomCifrado=$prefijo.md5($randomCifrado.rand(0, 10));
                    }
                    else
                    {
                        $randomCifrado=$prefijo.$randomCifrado;
                    }
                }
                
                if(!isset($_SESSION[$randomCifrado]))
                {
                    $random=uniqid(self::$randomCifrado, true);
                    $_SESSION[$randomCifrado]=$random;
                }
                self::$randomCifradoAux=$_SESSION[$randomCifrado];
            }
            $return=self::$randomCifradoAux;
        }
        return $return;
    }

    public static function base64Encode($field, $random=true)
    {
        if(!f::isEmpty(self::$cifradoActivo))
        {
            if(!f::isEmpty($random))
            {
                $r1=self::random(self::getRandomNumero() + self::getRandomRango());
                $r2=self::random(self::getRandomNumero() - self::getRandomRango());
                $r3=self::random(self::getRandomNumero());
                $r4=self::random(self::getRandomRango());
                $data=base64_encode($r1.$field.$r2);
                $data=$r3.$data.$r4;
            }
            else
            {
                $data=base64_encode($field);
            }
            $data=str_replace(array('+', '/', '='), array('-', '_', 'i1lo0'), $data);
        }
        else
        { 
            $data=$field;
        }
        return $data;
    }

    public static function base64Decode($field, $random=true)
    {
        if(!f::isEmpty(self::$cifradoActivo))
        {
            if(!f::isEmpty($random))
            {
                $field=substr($field, self::getRandomNumero(), (self::getRandomRango() * (-1)));
            }

            $data=str_replace(array('-', '_', 'i1lo0'), array('+', '/', '='), $field);
            $mod4=strlen($data) % 4;
            if($mod4)
            {
                $data .= substr('====', $mod4);
            }
            $data=base64_decode($data);
            if(!f::isEmpty($random))
            {
                $data=substr($data, self::getRandomNumero() + self::getRandomRango(), (self::getRandomNumero() - self::getRandomRango()) * (-1));
            }
        }
        else
        {
            $data=$field;
        }
        
        return $data;
    }

    /**
     * Retorna un <b>MD5</b><br/><br/>
     * md5($texto)
     * @param type $texto :parametro a cifrar
     * @return string
     */
    public static function md5($texto)
    {
        if(!f::isEmpty(self::$cifradoActivo))
        {
            $return=self::base64Encode($texto, false).self::getRandomCifrado();
            $return=self::sustitucionEncode($return);
            $return=self::desplazamientoEncode($return);
            $return=md5($return);
        }
        else
        {
            $return=$texto;
        } 
        return $return;
    }
}