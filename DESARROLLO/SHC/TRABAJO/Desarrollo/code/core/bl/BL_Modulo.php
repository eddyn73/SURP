<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of BL_Modulo
 *
 * @author epalomino
 */
class BL_Modulo extends BL
{
    private $oDAO_Modulo;
    private $oDAO_Accion;

    function __construct()
    {
        $this->oDAO_Modulo=new DAO_Modulo();
        $this->oDAO_Accion=new DAO_Accion();
    }

    public function listaModulos()
    {
        return $this->oDAO_Modulo->listaModulos(f::getSession('idUsuario'));
    }
    
    public function listaModulosPaginado()
    {
        $pagina=$this->getPaginadoPagina('modulo');
        $filas=$this->getPaginadoFilas('modulo');
        return $this->oDAO_Modulo->listaModulosPaginado($pagina, $filas);
    }
    
    public function verModulo()
    {
        if(f::isEmpty(v::getError()))
        {
            $this->validaCredencial();
        }
        if(f::isEmpty(v::getError()))
        {
            $idModulo=f::request('post', 'decode', f::id('idModulo'));
            v::valida($idModulo, 'idModulo', 'required,maxSize[11],custom[integer]');
        }
        if(f::isEmpty(v::getError()))
        {
            $idUsuario=f::getSession('idUsuario');
            v::valida($idUsuario, 'idUsuario', 'required,maxSize[11],custom[integer]');
        }
        //v::setError('sape!');
        if(!f::isEmpty(v::getError()))
        {
            v::validaErrorJSON('#divMasterPageRightContent', 'up');
        }
        else
        {
            $modulo=array();
            $acciones=array();
            foreach($this->oDAO_Modulo->getModuloAcciones($idUsuario, $idModulo) as $i=> $row)
            {
                if(f::isEmpty($modulo))
                {
                    $modulo['idModulo']=$row['idModulo'];
                    $modulo['nombre']=$row['nombre'];
                    $modulo['carpeta']=$row['carpeta'];
                    $modulo['descripcion']=$row['descripcion'];
                    $modulo['imagen']=$row['imagen'];
                    $modulo['persistente']=$row['persistente'];
                    $modulo['estado']=$row['estado'];
                    $modulo['orden']=$row['orden'];
                }

                $acciones[$i]['idAccion']=$row['idAccion'];
                $acciones[$i]['nombre']=$row['nombre'];
                $acciones[$i]['descripcion']=$row['descripcion'];
                $acciones[$i]['mensaje']=$row['mensaje'];
                $acciones[$i]['orden']=$row['orden'];
            }

            if(!f::isEmpty($acciones))
            {
                $accion=$this->oDAO_Accion->listAcciones();

                foreach($accion as $i=> $row1)
                {
                    foreach($acciones as $j=> $row2)
                    {
                        if($row1['idAccion'] == $row2['idAccion'])
                        {
                            $accion[$i]['estado']=1;
                        }
                    }
                }
                if($accion[0]['estado'] == '1')// 1:read
                {
                    v::setTrueJSON();
                    v::setJSON('tag', '#divMasterPageRightContent');
                    v::setJSON('ubicacion', 'up');
                    v::setError('si');
                    v::setJSON('descripcion', v::validaErrorUL());
                    v::setJSON('data', c::getViewSystem('modulos/'.$modulo['carpeta'].'/index.php', false));
                }
                else
                {
                    v::setFalseJSON();
                    v::setJSON('tag', '#divMasterPageRightContent');
                    v::setJSON('ubicacion', 'up');
                    v::setError($accion[0]['mensaje']);
                    v::setJSON('descripcion', v::validaErrorUL());
                    v::setJSON('data', f::message($accion, null, false));
                }
            }
            else
            {
                v::setFalseJSON();
                v::setJSON('tag', '#divMasterPageRightContent');
                v::setJSON('ubicacion', 'up');
                v::setError('Acceso negado');
                v::setError('Consulte al administrador');
                v::setJSON('descripcion', v::validaErrorUL());
                v::setJSON('data', null);
            }
            v::printJSON();
        }
    }
}