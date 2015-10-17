<?php
/**
 * Description of DataBase
 * 
 * @author epalomino
 */
class DataBase extends DatabaseProvider
{
    private static $time=0;
    private static $history=array();
    private static $instance=array();
    private $db;
    /**
     * Crea una instancia única por objeto del Proveedor
     * <br/><br/>
     * DataBaseFactory<b>(</b>$instance='db'<b>,
     * </b> $provider='MsSqlProvider'<b>,</b> $funcion=null<b>)</b>
     * @param type $instance : <b>db</b> por defecto
     * @param type $provider : <b>MsSqlProvider</b> por defecto
     * @param type $funcion  : <b>null</b> por defecto
     */
    public function __construct($instance='db', $provider='MySqlProvider', $funcion=null)
    {
        if(!class_exists($provider))
        {
            die(f::message('El proveedor ['.$provider.'] no existe', null, false));
        }

        if(!isset(self::$instance[$instance]))
        {
            if(class_exists($provider))
            {
                self::$instance[$instance]=new $provider($funcion);
            }
            else
            {
                die(f::message('No existe el Proveedor['.$provider.']', null, false));
            }
        }
        $this->db=self::$instance[$instance];
    } 
    
    function __destruct()
    {
        //f::message(self::$time);
        //f::message(self::$history);
    }
    public function setQuery($v, $incremental=false)
    {
        $this->db->setQuery($v, $incremental);
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
    public function setQueryParametro($k, $v, $tipo='string')
    {
        $this->db->setQueryParametro($k, $v, $tipo);
    }

    public function getQuery()
    {
       return $this->db->getQuery();
    }

    public function executeQuery($transaccional=false, $saveHistorial=false)
    {
        //$inicio=microtime(true);
        $this->db->executeQuery($transaccional, $saveHistorial);
        //$fin=microtime(true);
        //$time=number_format((($fin)-($inicio)),5, ',', ' ');
        //$aray['time']=$time.' ['.$fin.'-'.$inicio.']';
        //$aray['query']=$this->getQuery();
        //self::$history[]=$aray;
        //self::$time+=$time;
    }

    public function getExecuteMensaje()
    {
        return $this->db->getExecuteMensaje();
    }

    public function getExecuteMensajeCodigo()
    {
        return $this->db->getExecuteMensajeCodigo();
    }

    public function getExecuteMensajeDescripcion()
    {
        return $this->db->getExecuteMensajeDescripcion();
    }

    public function getIdentity()
    {
        return $this->db->getIdentity();
    }

    public function getFilas()
    {
        return $this->db->getFilas();
    }

    public function getNumeroColumnas()
    {
        return $this->db->getNumeroColumnas();
    }

    public function getNombreColumna()
    {
        return $this->db->getNombreColumna();
    }

    public function getDataResourceSet($fila, $columna)
    {
        return $this->db->getDataResourceSet($fila, $columna);
    }
    
    /**
     * nextRowData($tipo='ASSOC')
     * @param type $tipo
     * @return type
     */
    public function nextRowData($tipo='ASSOC')
    {
        return $this->db->nextRowData($tipo);
    }

    public function getRowData()
    {
        return $this->db->getRowData();
    }

    public function getRowDataParametro($v)
    {
        return $this->db->getRowDataParametro($v);
    }

    public function setRowDataParametro($k, $v)
    {
        return $this->db->setRowDataParametro($k, $v);
    }

    public function free_result()
    {
        $this->db->free_result();
    }
    
    /**
     * Retorna un array bidimencional <br/>
     * en forma de tabla
     * <br/>
     * <br/>
     * getDataGridView<b>(</b>$db<b>,</b>$utf8=false<b>)</b>
     * @param type $db      : objeto <b>DataBase();</b>
     * @param type $utf8    : por defecto <b>false</b>, puede <br/> 
     *                      tener <b>encode</b> o <b>decode</b>
     * @return type $array
     */
    public function getTable($utf8=false)
    {
        return  $this->db->getTable($utf8);
    }
}