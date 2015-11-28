<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of DAO_Personal
 *
 * @author epalomino
 */
class DAO_Personal extends DAO
{
    private $db; 
    function __construct()
    {
        $this->db=parent::getDB();
    }
    
    public static function getCodPersonalByCodCIP($codCIP)
    {
        $db=parent::getDB();
         
        $db->setQuery("
            SELECT * 
            FROM e_personal 
            WHERE codCIP=<@codCIP>
        ");  
        $db->setQueryParametro('<@codCIP>', $codCIP);
        //f::message($db->getQuery());
        $db->executeQuery();
        $table=$db->getTable();
        if(f::isEmpty($table))
        {
            $return=false;
        }
        else
        {
            $return=$table[0]['codPersonal'];
        }
        return $return;
    }
}