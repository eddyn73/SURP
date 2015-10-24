<?php
/**
 * Proveedor de SQL Server
 * 
 * @author epalomino
 */
class MsSqlProvider extends DatabaseProvider implements DataBaseProviderInterface
{
    function __construct($funcion=null)
    {
        $this->conectar($funcion);
    }

    function __destruct()
    {
        $this->desconectar();
    }

    public function conectar($funcion)
    { 
        if(f::isEmpty($funcion))
        {
            $funcion='por_defecto_mssql';
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
                $this->conexionLink=mssql_connect($oConfig->getHostname()
                                , $oConfig->getUsername()
                                , $oConfig->getPassword()) or
                        die(f::message('(MsSQL)Error de Conexión:[HOST][USER][PASS]'.@mssql_get_last_message(), '', false));
                @mssql_select_db($oConfig->getDatabase(),$this->conexionLink) or die(f::message('(MsSQL)Error de Base de Datos: '.@mssql_get_last_message(), null, false));
            }
        }
        else
        {
            die(f::message('(MsSQL)Ya existe una conexión', null, false));
        }
    }

    public function desconectar()
    { 
        if(isset($this->conexionLink))
        {
            @mssql_close($this->conexionLink) or die(f::message('(MsSQL)No se cerro la conexión', '', false));
        }
        else
        {
            die(f::message('(MsSQL)No hay conexión', '', false));
        }
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
    /**
     * Los tipos pueden ser :<br>
     * string<br>
     * int<br>
     * %like<br>
     * %like%<br>
     * like%<br>
     * setQueryParametro($k, $v,$tipo='string')
     * @param type $k       :parametro
     * @param type $v       :valor
     * @param type $tipo    :tipo de parametro
     */
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
        {
            $this->queryHitorial[]=$this->query;
        }
        $this->numeroQuerys++;
        if($transaccional)
        {
            $this->numeroQuerysTransaccionales++;
            mssql_query($this->query,$this->conexionLink);
            $this->filas=mssql_rows_affected($this->conexionLink);
            $this->identity=$this->getMssqlIdentity();
        }
        else
        {
            $this->numeroQuerysNoTransaccionales++;
            $this->resourceSet=mssql_query($this->query, $this->conexionLink) or f::message(mssql_get_last_message(),'ui-state-error');
            $this->filas=mssql_num_rows($this->resourceSet);
            $this->nombreColumna=array();
            while($p=mssql_fetch_field($this->resourceSet))
            {
                $this->nombreColumna[]=$p;
            }
            $this->numeroColumnas=count($this->nombreColumna);
        }

        $this->executeMensajeCodigo=mssql_get_last_message();
        $this->executeMensajeDescripcion=$this->executeMensajeCodigo;
        $this->executeMensaje=$this->executeMensajeCodigo;
        if($saveHistorial)
        {
            $this->executeMensajeHistorial[]=$this->executeMensaje;
        }
    }
    
    private function getMssqlIdentity()
    {
        $id=0;
        return $id;
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

        $this->rowData=mssql_fetch_array($this->resourceSet, $tipo);
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
        mssql_free_result($this->resourceSet);
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