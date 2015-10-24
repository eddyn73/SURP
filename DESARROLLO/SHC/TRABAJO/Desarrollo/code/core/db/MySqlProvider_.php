<?php
/**
 * Proveedor de MySQL
 * 
 * @author epalomino
 */
class MySqlProvider_ extends DatabaseProvider implements DataBaseProviderInterface
{ 
    public function __construct($funcion=null)
    {
        $this->conectar($funcion);
    }

    public function __destruct()
    {
        $this->desconectar();
    }

    public function conectar($funcion)
    {
        if(f::isEmpty($funcion))
        {
            $funcion='por_defecto_mysql';
        }

        if(!isset($this->conexionLink))
        {
            $oConfig=new Config();
            $flag=false;
            if(is_array($funcion))
            {
                $flag=true;
                $oConfig->setHostname($funcion['hostname']);
                $oConfig->setUsername($funcion['username']);
                $oConfig->setPassword($funcion['password']);
                $oConfig->setDatabase($funcion['database']);
            }
            else
            {
                if(method_exists($oConfig, $funcion))
                {
                    $flag=true;
                    call_user_func(array($oConfig, $funcion));
                }
                else
                {
                    die(f::message('No se encontro la función <strong>'.$funcion.'()</strong>', null, false));
                }
            }

            if($flag)
            {
                $this->conexionLink=mysqli_connect($oConfig->getHostname()
                                , $oConfig->getUsername()
                                , $oConfig->getPassword()) or
                        die(f::message('(MySQL)Error de Conexión:[HOST][USER][PASS]'.@mysqli_error($this->conexionLink).'[#'.@mysqli_errno($this->conexionLink).']', '', false));
                @mysqli_select_db($this->conexionLink, $oConfig->getDatabase()) or die(f::message('(MySQL)Error de Base de Datos: '.@mysqli_error($this->conexionLink).'[#'.@mysqli_errno($this->conexionLink).']', null, false));
            }
        }
        else
        {
            die(f::message('(MySQL_i)Ya existe una conexión',null, false));
        }
    }

    public function desconectar()
    {
        if(isset($this->conexionLink))
        {
            @mysqli_close($this->conexionLink) or die(f::message('(MySQL_i)No se cerro la conexión', '', false));
        }
        else
        {
            die(m('(MySQL_i)No hay conexión', '', false));
        }
    }

    public function startTransaction()
    {
        mysqli_query($this->conexionLink, "START TRANSACTION;");
    }

    public function commit()
    {
        mysqli_query($this->conexionLink, "COMMIT;");
    }

    public function rollback()
    {
        mysqli_query($this->conexionLink, "ROLLBACK;");
    }

    public function setQuery($v, $incremental=false)
    {
        if($incremental)
        {
            $this->query.=$v;
        }
        else
        {
            $this->query=$v;
        }
    }

    public function setQueryParametro($k, $v,$tipo='string')
    {
        switch(strtolower($tipo))
        {
            case 'string':
                $v="'".$v."'";
                break;
            case 'int':
                $v=$v;
                break;
            case '%like':
                $v="'%".$v."'";
                break;
            case '%like%':
                $v="'%".$v."%'";
                break;
            case 'like%':
                $v="'".$v."%'";
                break;
            default:
                $v="'".$v."'";
                break;
        }
        $this->query=str_replace($k, $v, $this->query);
    }

    public function getQuery()
    {
        return $this->query;
    }

    public function executeQuery($transaccional=false, $saveHistorial=false)
    {
        if($saveHistorial)
            $this->queryHitorial[]=$this->query;
        $this->numeroQuerys++;
        if($transaccional)
        {
            $this->numeroQuerysTransaccionales++;
            mysqli_query($this->conexionLink, $this->query);
            $this->filas=mysqli_affected_rows($this->conexionLink);
            $this->identity=mysqli_insert_id($this->conexionLink);
        }
        else
        {
            $this->numeroQuerysNoTransaccionales++;
            $this->resourceSet=mysqli_query($this->conexionLink, $this->query);
            $this->filas=mysqli_num_rows($this->resourceSet);
            $this->nombreColumna=array();
            while($p=mysqli_fetch_field($this->resourceSet))
            {
                $this->nombreColumna[]=$p;
            }
            $this->numeroColumnas=mysqli_field_count($this->conexionLink);
        }

        $this->executeMensajeCodigo=mysqli_errno($this->conexionLink);
        $this->executeMensajeDescripcion=mysqli_error($this->conexionLink);
        if(isEmpty($this->executeMensajeCodigo))
            $this->executeMensaje=null;
        else
            $this->executeMensaje=$this->executeMensajeDescripcion.' [#'.$this->executeMensajeCodigo.']';
        if($saveHistorial)
            $this->executeMensajeHistorial[]=$this->executeMensaje;
    }

    public function getExecuteMensaje()
    {
        return $this->executeMensaje;
    }

    public function getExecuteMensajeCodigo()
    {
        return $this->executeMensajeCodigo;
    }

    public function getExecuteMensajeDescripcion()
    {
        return $this->executeMensajeDescripcion;
    }

    public function getIdentity()
    {
        return $this->identity;
    }

    public function getFilas()
    {
        return $this->filas;
    }

    public function getNumeroColumnas()
    {
        return $this->numeroColumnas;
    }

    public function getNombreColumna()
    {
        return $this->nombreColumna;
    }

    public function getDataResourceSet($fila, $columna)
    {
        $this->resourceSet->data_seek($fila);
        $this->rowData=$this->resourceSet->fetch_array();
        return $this->rowData[$columna];
    }

    public function nextRowData($tipo='ASSOC')
    {
        if($tipo == 'BOTH')
        {
            $tipo=MYSQLI_BOTH;
        }
        elseif($tipo == 'NUM')
        {
            $tipo=MYSQLI_NUM;
        }
        else
        {
            $tipo=MYSQLI_ASSOC;
        }

        $this->rowData=mysqli_fetch_array($this->resourceSet, $tipo);
        return $this->rowData;
    }

    public function getRowData()
    {
        return $this->rowData;
    }

    public function getRowDataParametro($v)
    {
        return $this->rowData[$v];
    }
    
    public function setRowDataParametro($k,$v)
    {
        return $this->rowData[$k]=$v;
    }

    public function free_result()
    {
        mysqli_free_result($this->resourceSet);
    }
    
    public function getTable($utf8=false)
    {
        $table=null;
        if($this->getFilas()>0)
        {
            $i=0;
            while($this->nextRowData())
            {
                foreach($this->getRowData() as $k=> $v)
                {
                    if($utf8=='encode')
                    {
                        $v=utf8_encode($v);
                    }
                    else if($utf8=='decode')
                    {
                        $v=utf8_decode($v);
                    }
                    $table[$i][$k]=$v;
                }
                $i++;
            }
        }
        $this->free_result();
        return $table;
    }
}
?>