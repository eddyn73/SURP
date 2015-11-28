<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of DAO_Unidad
 *
 * @author epalomino
 */
class DAO_Unidad extends DAO
{
    private $db;

    function __construct()
    {
        $this->db=parent::getDB();
    }

    public static function listaUnidades($sql)
    {
        $db=new DataBase();
        $db->setQuery(" 
            SELECT
                  codUnidad
                , nombre
            FROM e_unidad
            WHERE {$sql}
                AND estado=2
        ");
        //f::message($db->getQuery());
        $db->executeQuery();
        return $db->getTable('encode');
    }
}