<?php
/**
 * Proveedor de Base de Datos
 * 
 * @author epalomino
 */
abstract class DatabaseProvider
{
    /**
     *
     * @var type 
     */
    protected $conexionLink;                      //conexion
    protected $numeroQuerysTransaccionales;       //Numero de Querys Transaccionales
    protected $numeroQuerysNoTransaccionales;     //Numero de Querys no Transaccionales
    protected $numeroQuerys;                      //Numero de Querys
    protected $queryHitorial=array();             //query array historial
    protected $query;                             //query
    protected $nombreColumna=array();             //Nombre de las Columnas
    protected $numeroColumnas;                    //Numero de Columnas
    protected $filas;                             //filas afectadas
    protected $rowData=array();                   //parametros de la fila 
    protected $resourceSet;                       //resource set
    protected $executeMensaje;                    //Mensaje al Ejecutar un query
    protected $executeMensajeCodigo;              //Codigo del Mensaje al Ejecutar un query
    protected $executeMensajeDescripcion;         //Descripcion del Mensaje al Ejecutar un query
    protected $executeMensajeHistorial=array();   //Historial del Mensaje al Ejecutar un query
    protected $identity;                          //ID identity

    abstract public function setQuery($v, $incremental=false);

    abstract public function setQueryParametro($k, $v, $tipo='string');

    abstract public function getQuery();

    abstract public function executeQuery($transaccional=false, $saveHistorial=false);

    abstract public function getExecuteMensaje();

    abstract public function getExecuteMensajeCodigo();

    abstract public function getExecuteMensajeDescripcion();

    abstract public function getIdentity();

    abstract public function getFilas();

    abstract public function getNumeroColumnas();

    abstract public function getNombreColumna();

    abstract public function getDataResourceSet($fila, $columna);

    abstract public function nextRowData($tipo='ASSOC');

    abstract public function getRowData();

    abstract public function getRowDataParametro($v);

    abstract public function setRowDataParametro($k, $v);

    abstract public function free_result();
    
    abstract public function getTable($utf8=false);
}