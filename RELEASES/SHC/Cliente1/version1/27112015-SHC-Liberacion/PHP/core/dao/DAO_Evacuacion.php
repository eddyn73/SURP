<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of DAO_Evacuacion
 *
 * @author epalomino
 */
class DAO_Evacuacion extends DAO
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
                  e.codEvacuacion
                , e.fecha
                , e.estado
                , e.lugarDestino
                , e.lugarOrigen
                , e.fechaInicio
                , e.fechaFin
                , e.motivo
                , e.observaciones
                , e.codPersonal
                , p.nombres
                , p.apellidoPat
                , p.apellidoMat
                , p.dni
                , p.edad
                , p.tipoSangre
                , p.grado
                , p.codCIP
            FROM e_evacuacion AS e
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

    public static function getForm($codEvacuacion)
    {
        $db=parent::getDB();
        $db->setQuery("
            SELECT
                  e.codEvacuacion
                , e.fecha
                , e.estado
                , e.fechaInicio
                , e.fechaFin
                , e.motivo
                , e.observaciones
                , e.codPersonal
                , e.codTipoEvacuacion
                , e.codMedioEvacuacion
                , e.codPersonalAcompaniante
                , p.dni
                , p.edad
                , p.tipoSangre
                , p.codCIP
                , p.grado
                , p.nombres
                , p.apellidoPat
                , p.apellidoMat
                , pa.nombres AS nombresAcompaniante
                , pa.apellidoPat AS apellidoPatAcompaniante
                , pa.apellidoMat AS apellidoMatAcompaniante
                , te.nombre AS motivo
                , me.nombre AS medioEvacuacion
                , u.nombre AS lugarOrigen
                , ud.nombre AS lugarDestino
            FROM e_evacuacion AS e
            INNER JOIN e_personal AS p
            ON
            (
            e.codPersonal=p.codPersonal
            )
            INNER JOIN e_personal AS pa
            ON
            (
            e.codPersonalAcompaniante=pa.codPersonal
            )
            INNER JOIN e_tipoevacuacion AS te
            ON
            (
            e.codTipoEvacuacion=te.codTipoEvacuacion
            )
            INNER JOIN e_medioevacuacion AS me
            ON
            (
            e.codMedioEvacuacion=me.codMedioEvacuacion
            )
            INNER JOIN e_unidad AS u
            ON
            (
            p.codUnidad=u.codUnidad
            )
            INNER JOIN e_unidad AS ud
            ON
            (
            e.lugarDestino=ud.codUnidad
            )
            WHERE e.codEvacuacion=<@codEvacuacion>
            ORDER BY e.codEvacuacion ASC 
        ");
        $db->setQueryParametro('<@codEvacuacion>', $codEvacuacion);
        //f::message($db->getQuery());
        $db->executeQuery();
        return $db->getTable();
    }

    public static function nuevo(BE_Evacuacion $oBE_Evacuacion)
    {
        $db=parent::getDB();
        $db->setQuery("
            INSERT INTO e_evacuacion
            (
                  fecha
                , estado
                , lugarDestino 
                , fechaInicio
                , fechaFin 
                , observaciones
                , codPersonal
                , codTipoEvacuacion
                , codMedioEvacuacion
                , codPersonalAcompaniante
            )
            VALUES
            (
                  NOW()
                , <@estado> 
                , <@lugarDestino> 
                , <@fechaInicio>
                , <@fechaFin> 
                , <@observaciones>
                , <@codPersonal>
                , <@codTipoEvacuacion>
                , <@codMedioEvacuacion>
                , <@codPersonalAcompaniante>
            )
        ");
        $db->setQueryParametro('<@lugarDestino>', $oBE_Evacuacion->getLugarDestino());
        $db->setQueryParametro('<@fechaInicio>', $oBE_Evacuacion->getFechaInicio());
        $db->setQueryParametro('<@fechaFin>', $oBE_Evacuacion->getFechaFin());
        $db->setQueryParametro('<@observaciones>', $oBE_Evacuacion->getObservaciones());
        $db->setQueryParametro('<@codPersonal>', $oBE_Evacuacion->getCodPersonal());

        $db->setQueryParametro('<@codTipoEvacuacion>', $oBE_Evacuacion->getCodTipoEvacuacion());
        $db->setQueryParametro('<@codMedioEvacuacion>', $oBE_Evacuacion->getCodMedioEvacuacion());
        $db->setQueryParametro('<@codPersonalAcompaniante>', $oBE_Evacuacion->getCodPersonalAcompaniante());
        $db->setQueryParametro('<@estado>', $oBE_Evacuacion->getEstado());

        //f::message($db->getQuery());
        $db->executeQuery(true);
        return $db->getIdentity();
    }

    public static function editar(BE_Evacuacion $oBE_Evacuacion)
    {
        $db=parent::getDB();
        $db->setQuery("
            UPDATE e_evacuacion
            SET   
                  lugarDestino=<@lugarDestino>
                , lugarOrigen=<@lugarOrigen>
                , fechaInicio=<@fechaInicio>
                , fechaFin=<@fechaFin>
                , motivo=<@motivo>
                , observaciones=<@observaciones>
                , codPersonal=<@codPersonal>
            WHERE 
                codEvacuacion=<@codEvacuacion>
        ");
        $db->setQueryParametro('<@codEvacuacion>', $oBE_Evacuacion->getCodEvacuacion());
        $db->setQueryParametro('<@lugarDestino>', $oBE_Evacuacion->getLugarDestino());
        $db->setQueryParametro('<@lugarOrigen>', $oBE_Evacuacion->getLugarOrigen());
        $db->setQueryParametro('<@fechaInicio>', $oBE_Evacuacion->getFechaInicio());
        $db->setQueryParametro('<@fechaFin>', $oBE_Evacuacion->getFechaFin());
        $db->setQueryParametro('<@motivo>', $oBE_Evacuacion->getMotivo());
        $db->setQueryParametro('<@observaciones>', $oBE_Evacuacion->getObservaciones());
        $db->setQueryParametro('<@codPersonal>', $oBE_Evacuacion->getCodPersonal());
        //f::message($db->getQuery());
        $db->executeQuery(true);
        return $db->getFilas();
    }

    public static function eliminar($codEvacuacion)
    {
        $db=parent::getDB();
        $db->setQuery("
            DELETE FROM e_evacuacion
            WHERE codEvacuacion=<@codEvacuacion>
        ");
        $db->setQueryParametro('<@codEvacuacion>',$codEvacuacion);
        //f::message($db->getQuery());
        $db->executeQuery(true);
        return $db->getFilas();
    }

    public static function listaPersonal($sql)
    {
        $db=new DataBase();
        $db->setQuery(" 
            SELECT
                p.codPersonal
              , p.nombres
              , p.apellidoPat
              , p.apellidoMat
              , p.dni
              , p.edad
              , p.tipoSangre
              , p.grado
              , p.codCIP
              , p.codUnidad
              , u.nombre AS lugarOrigen
            FROM e_personal AS p
            INNER JOIN e_unidad AS u
            ON
            (
                p.codUnidad=u.codUnidad
                {$sql}
            )
        ");
        //f::message($db->getQuery());
        $db->executeQuery();
        return $db->getTable('encode');
    }

    public static function listaMotivos()
    {
        $db=new DataBase();
        $db->setQuery(" 
            SELECT
                  codTipoEvacuacion
                , nombre
                , descripcion
            FROM e_tipoevacuacion
            ORDER BY nombre ASC
        ");
        //f::message($db->getQuery());
        $db->executeQuery();
        return $db->getTable();
    }

    public static function listaMedioEvacuacion()
    {
        $db=new DataBase();
        $db->setQuery(" 
            SELECT
                  codMedioEvacuacion
                , nombre
                , descripcion
            FROM e_medioevacuacion
            ORDER BY nombre ASC
        ");
        //f::message($db->getQuery());
        $db->executeQuery();
        return $db->getTable();
    }

    public static function listaEvcuaciones()
    {
        $db=parent::getDB();
        $db->setQuery("
            SELECT
                  e.codEvacuacion
                , e.fecha
                , e.estado
                , e.fechaInicio
                , e.fechaFin
                , e.motivo
                , e.observaciones
                , e.codPersonal
                , e.codTipoEvacuacion
                , e.codMedioEvacuacion
                , e.codPersonalAcompaniante
                , p.codCIP
                , p.grado
                , p.nombres
                , p.apellidoPat
                , p.apellidoMat
                , pa.nombres AS nombresAcompaniante
                , pa.apellidoPat AS apellidoPatAcompaniante
                , pa.apellidoMat AS apellidoMatAcompaniante
                , te.nombre AS motivo
                , me.nombre AS medioEvacuacion
                , u.nombre AS lugarOrigen
                , ud.nombre AS lugarDestino
            FROM e_evacuacion AS e
            INNER JOIN e_personal AS p
            ON
            (
            e.codPersonal=p.codPersonal
            )
            INNER JOIN e_personal AS pa
            ON
            (
            e.codPersonalAcompaniante=pa.codPersonal
            )
            INNER JOIN e_tipoevacuacion AS te
            ON
            (
            e.codTipoEvacuacion=te.codTipoEvacuacion
            )
            INNER JOIN e_medioevacuacion AS me
            ON
            (
            e.codMedioEvacuacion=me.codMedioEvacuacion
            )
            INNER JOIN e_unidad AS u
            ON
            (
            p.codUnidad=u.codUnidad
            )
            INNER JOIN e_unidad AS ud
            ON
            (
            e.lugarDestino=ud.codUnidad
            )
            WHERE e.estado=1
            ORDER BY e.codEvacuacion ASC
            ;
        ");
        //f::message($db->getQuery());
        $db->executeQuery();
        return $db->getTable();
    }

    public static function estadoEvacucacion($codEvacuacion, $estado)
    {
        $db=parent::getDB();
        $db->setQuery("
            UPDATE e_evacuacion
            SET estado=<@estado>
            WHERE codEvacuacion=<@codEvacuacion>
        ");
        $db->setQueryParametro('<@estado>', $estado);
        $db->setQueryParametro('<@codEvacuacion>', $codEvacuacion);
        //f::message($db->getQuery());
        $db->executeQuery(true);
        return $db->getFilas();
    }

    public static function listaMisEvcuaciones($codPersonal)
    {
        $db=parent::getDB();
        $db->setQuery("
            SELECT
                  e.codEvacuacion
                , e.fecha
                , e.estado
                , e.fechaInicio
                , e.fechaFin
                , e.motivo
                , e.observaciones
                , e.codPersonal
                , e.codTipoEvacuacion
                , e.codMedioEvacuacion
                , e.codPersonalAcompaniante
                , p.codCIP
                , p.grado
                , p.nombres
                , p.apellidoPat
                , p.apellidoMat
                , pa.nombres AS nombresAcompaniante
                , pa.apellidoPat AS apellidoPatAcompaniante
                , pa.apellidoMat AS apellidoMatAcompaniante
                , te.nombre AS motivo
                , me.nombre AS medioEvacuacion
                , u.nombre AS lugarOrigen
                , ud.nombre AS lugarDestino
            FROM e_evacuacion AS e
            INNER JOIN e_personal AS p
            ON
            (
            e.codPersonal=p.codPersonal
            )
            INNER JOIN e_personal AS pa
            ON
            (
            e.codPersonalAcompaniante=pa.codPersonal
            )
            INNER JOIN e_tipoevacuacion AS te
            ON
            (
            e.codTipoEvacuacion=te.codTipoEvacuacion
            )
            INNER JOIN e_medioevacuacion AS me
            ON
            (
            e.codMedioEvacuacion=me.codMedioEvacuacion
            )
            INNER JOIN e_unidad AS u
            ON
            (
            p.codUnidad=u.codUnidad
            )
            INNER JOIN e_unidad AS ud
            ON
            (
            e.lugarDestino=ud.codUnidad
            )
            WHERE p.codPersonal=<@codPersonal>
            ORDER BY e.codEvacuacion ASC
            ;
        ");
        $db->setQueryParametro('<@codPersonal>', $codPersonal);
        //f::message($db->getQuery());
        $db->executeQuery();
        return $db->getTable();
    }
}