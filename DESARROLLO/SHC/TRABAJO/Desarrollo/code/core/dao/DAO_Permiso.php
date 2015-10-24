<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of DAO_Permiso
 *
 * @author epalomino
 */
class DAO_Permiso extends DAO
{
    private $db;

    function __construct()
    {
        $this->db=parent::getDB();
    }

    public static function lista()
    {
        $db=parent::getDB();
        $db->setQuery("
            SELECT
                  e.codPermiso
                , e.estado
                , e.descripcion
                , e.fechaSolicitud
                , e.motivo
                , e.direccion
                , e.numeroDias
                , e.fechaInicio
                , e.fechaFin
                , e.codPersonal 
                , p.nombres
                , p.apellidoPat
                , p.apellidoMat
                , p.dni
                , p.edad
                , p.tipoSangre
                , p.grado
                , p.codCIP
            FROM e_permiso AS e
            INNER JOIN e_personal AS p
            ON
            (
                e.codPersonal=p.codPersonal
            ) 
        ");
        //f::message($db->getQuery());
        $db->executeQuery();
        return $db->getTable();
    }

    public static function getForm($codPermiso)
    {
        $db=parent::getDB();
        $db->setQuery("
            SELECT
                  e.codPermiso
                , e.estado
                , e.descripcion
                , e.fechaSolicitud
                , e.motivo
                , e.direccion
                , e.numeroDias
                , e.fechaInicio
                , e.fechaFin
                , e.codPersonal 
                , p.nombres
                , p.apellidoPat
                , p.apellidoMat
                , p.dni
                , p.edad
                , p.tipoSangre
                , p.grado
                , p.codCIP
            FROM e_permiso AS e
            INNER JOIN e_personal AS p
            ON
            (
                    e.codPersonal=p.codPersonal
                AND e.codPermiso=<@codPermiso>
            )
        ");
        $db->setQueryParametro('<@codPermiso>', $codPermiso);
        //f::message($db->getQuery());
        $db->executeQuery();
        return $db->getTable();
    }

    public static function nuevo(BE_Permiso $oBE_Permiso)
    {
        $db=parent::getDB();
        $db->setQuery("
            INSERT INTO e_permiso
            (
                   
                  estado
                , descripcion
                , fechaSolicitud
                , motivo
                , direccion
                , numeroDias
                , fechaInicio
                , fechaFin
                , codPersonal
            )
            VALUES
            ( 
                  1
                , <@descripcion>
                , NOW()
                , <@motivo>
                , <@direccion>
                , <@numeroDias>
                , <@fechaInicio>
                , <@fechaFin>
                , <@codPersonal>
            )
        ");
        $db->setQueryParametro('<@descripcion>', $oBE_Permiso->getDescripcion()); 
        $db->setQueryParametro('<@motivo>', $oBE_Permiso->getMotivo());
        $db->setQueryParametro('<@direccion>', $oBE_Permiso->getDireccion());
        $db->setQueryParametro('<@numeroDias>', $oBE_Permiso->getNumeroDias());
        $db->setQueryParametro('<@fechaInicio>', $oBE_Permiso->getFechaInicio());
        $db->setQueryParametro('<@fechaFin>', $oBE_Permiso->getFechaFin());
        $db->setQueryParametro('<@codPersonal>', $oBE_Permiso->getCodPersonal());
        //f::message($db->getQuery());
        $db->executeQuery(true);
        return $db->getIdentity();
    }

    public static function editar(BE_Permiso $oBE_Permiso)
    {
        $db=parent::getDB();
        $db->setQuery("
            UPDATE e_permiso
            SET   
                  descripcion=<@descripcion>
                , motivo=<@motivo>
                , direccion=<@direccion>
                , numeroDias=<@numeroDias>
                , fechaInicio=<@fechaInicio>
                , fechaFin=<@fechaFin>
                , codPersonal=<@codPersonal>
                 
            WHERE 
                codPermiso=<@codPermiso>
        ");
        $db->setQueryParametro('<@codPermiso>', $oBE_Permiso->getCodPermiso());
        $db->setQueryParametro('<@descripcion>', $oBE_Permiso->getDescripcion()); 
        $db->setQueryParametro('<@motivo>', $oBE_Permiso->getMotivo());
        $db->setQueryParametro('<@direccion>', $oBE_Permiso->getDireccion());
        $db->setQueryParametro('<@numeroDias>', $oBE_Permiso->getNumeroDias());
        $db->setQueryParametro('<@fechaInicio>', $oBE_Permiso->getFechaInicio());
        $db->setQueryParametro('<@fechaFin>', $oBE_Permiso->getFechaFin());
        $db->setQueryParametro('<@codPersonal>', $oBE_Permiso->getCodPersonal());
        //f::message($db->getQuery());
        $db->executeQuery(true);
        return $db->getFilas();
    }

    public static function eliminar(BE_Permiso $oBE_Permiso)
    {
        $db=parent::getDB();
        $db->setQuery("
            DELETE FROM e_permiso
            WHERE codPermiso=<@codPermiso>
        ");
        $db->setQueryParametro('<@codPermiso>', $oBE_Permiso->getCodPermiso());
        //f::message($db->getQuery());
        $db->executeQuery(true);
        return $db->getFilas();
    }
}