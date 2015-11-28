<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of DAO_Accion
 *
 * @author epalomino
 */
class DAO_Accion extends DAO
{
    private $db;
    private static $accion=null;
    function __construct()
    {
        $this->db=new DataBase();
    }
    
    public function listAcciones()
    {
        if(f::isEmpty(self::$accion))
        {
            $this->db->setQuery("
                SELECT
                    idAccion
                  , nombre
                  , descripcion
                  , mensaje
                  , orden
                  , 0 as estado
                FROM _accion
                ORDER BY orden ASC
            ");  
            //f::message($this->db->getQuery());
            $this->db->executeQuery();
            self::$accion=$this->db->getTable();
        }
        return self::$accion;
    }
}