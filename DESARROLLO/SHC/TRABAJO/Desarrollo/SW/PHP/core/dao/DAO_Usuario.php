<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of DAO_Usuario
 *
 * @author epalomino
 */
class DAO_Usuario extends DAO
{
    private $db;
    
    function __construct()
    {
        $this->db=new DataBase();
    }
    
    public final function login(BE_Usuario $oBE_Usuario)
    {
        $this->db->setQuery("
            SELECT
                  idUsuario
                , usuario
                , clave
                , nombre
                , apellido
                , imagen
                , email
                , plantillaui
                , orden
                , idPerfil
            FROM _usuario
            WHERE usuario=<@usuario>
            AND clave=<@clave>;
        "); 
        $this->db->setQueryParametro('<@usuario>', $oBE_Usuario->getUsuario()); 
        $this->db->setQueryParametro('<@clave>', $oBE_Usuario->getClave()); 
        //f::message($this->db->getQuery());
        $this->db->executeQuery();
        $table=$this->db->getTable();
        
        foreach($table as $row)
        {
            $oBE_Usuario->setIdUsuario($row['idUsuario']);
            $oBE_Usuario->setUsuario($row['usuario']);
            $oBE_Usuario->setClave($row['clave']);
            $oBE_Usuario->setNombre($row['nombre']);
            $oBE_Usuario->setApellido($row['apellido']);
            $oBE_Usuario->setImagen($row['imagen']);
            $oBE_Usuario->setEmail($row['email']);
            $oBE_Usuario->setPlantillaui($row['plantillaui']);
            $oBE_Usuario->setOrden($row['orden']);
            $oBE_Usuario->setIdPerfil($row['idPerfil']);
        } 
    }
}