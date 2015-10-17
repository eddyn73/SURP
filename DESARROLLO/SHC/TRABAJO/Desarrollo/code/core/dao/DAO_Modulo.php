<?php
/**
 * Description of DAO_Modulo
 *
 * @author epalomino
 */
class DAO_Modulo extends DAO
{
    private $db;

    function __construct()
    {
        $this->db=new DataBase();
    }

    public function listaModulos($idUsuario)
    {
        $this->db->setQuery("
            SELECT
                m.idModulo
              , m.nombre
              , m.carpeta
              , m.descripcion
              , m.imagen
              , m.persistente
              , m.estado
              , m.orden
            FROM _moduloperfil AS mp
            INNER JOIN _usuario AS u
            ON
            (
                u.idPerfil=mp.idPerfil
                AND u.idUsuario=<@idUsuario>
            )
            INNER JOIN _modulo AS m
            ON
            (
                m.idModulo=mp.idModulo
                AND m.estado=1
            )
            ORDER BY m.orden ASC
        ");
        $this->db->setQueryParametro('<@idUsuario>', $idUsuario);
        //f::message($this->db->getQuery());
        $this->db->executeQuery();
        return $this->db->getTable();
    }

    public function getModuloAcciones($idUsuario, $idModulo)
    {
        $this->db->setQuery("
            SELECT
                m.idModulo
              , m.nombre
              , m.carpeta
              , m.descripcion
              , m.imagen
              , m.persistente
              , m.estado
              , m.orden
              , a.idAccion
              , a.nombre
              , a.descripcion
              , a.mensaje
              , a.orden
            FROM _moduloperfil AS mp
            INNER JOIN _usuario AS u
            ON
            (
                    u.idPerfil=mp.idPerfil
                AND u.idUsuario=<@idUsuario>
                AND mp.idModulo=<@idModulo>
            )
            INNER JOIN _modulo AS m
            ON
            (
                    m.idModulo=mp.idModulo
                AND m.estado=1
                AND m.idModulo=<@idModulo>
            )
            INNER JOIN _accionmoduloperfil AS amp
            ON
            (
                mp.idModuloPerfil=amp.idModuloPerfil
            )
            INNER  JOIN _accion AS a
            ON
            (
                a.idAccion=amp.idAccion
            )
            ORDER BY
                m.orden ASC
              , a.orden ASC
        ");
        $this->db->setQueryParametro('<@idUsuario>', $idUsuario);
        $this->db->setQueryParametro('<@idModulo>', $idModulo);
        //f::message($this->db->getQuery());
        $this->db->executeQuery();
        return $this->db->getTable();
    }

    public function listaModulosPaginado($pagina, $filas)
    {
        $this->db->setQuery("
            SELECT
                  idModulo
                , nombre
                , carpeta
                , descripcion
                , imagen
                , persistente
                , estado
                , orden
            FROM _modulo
            ORDER BY orden ASC
            LIMIT <@pagina>, <@filas>
        ");
        $pagina=($pagina-1)*$filas;
        $this->db->setQueryParametro('<@pagina>', $pagina, 'int');
        $this->db->setQueryParametro('<@filas>', $filas, 'int');
        //f::message($this->db->getQuery());
        $this->db->executeQuery();
        return $this->db->getTable();
    }
}