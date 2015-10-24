<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of BL_Permiso
 *
 * @author epalomino
 */
class BL_Permiso extends BL
{

    function __construct()
    {
        
    }

    public function lista()
    {
        return DAO_Permiso::lista();
    }

    public function getForm()
    {
        if(f::isEmpty(v::getError()))
        {
            $codPermiso=f::request('post', 'decode', f::id('codPermiso'));
            v::valida($codPermiso, 'codPermiso', 'required,maxSize[11]');
        }
        if(!f::isEmpty(v::getError()))
        {
            $codPermiso=0;
            v::clearError();
        }

        $table=DAO_Permiso::getForm($codPermiso);

        if(f::isEmpty($table))
        {
            $table[0]['codPermiso']=null;
            $table[0]['estado']=null;
            $table[0]['descripcion']=null;
            $table[0]['fechaSolicitud']=null;
            $table[0]['motivo']=null;
            $table[0]['direccion']=null;
            $table[0]['numeroDias']=null;
            $table[0]['fechaInicio']=null;
            $table[0]['fechaFin']=null;
            $table[0]['codPersonal']=null;
            $table[0]['nombres']=null;
            $table[0]['apellidoPat']=null;
            $table[0]['apellidoMat']=null;
            $table[0]['dni']=null;
            $table[0]['edad']=null;
            $table[0]['tipoSangre']=null;
            $table[0]['grado']=null;
            $table[0]['codCIP']=null;
        }
        return $table;
    }

    public function nuevo()
    {
        if(f::isEmpty(v::getError()))
        {
            $this->validaCredencial();
        }
        if(f::isEmpty(v::getError()))
        {
            $codCIP=f::request('post', 'normal', f::id('codCIP'));
            v::valida($codCIP, 'Código CIP', 'required,maxSize[5]');
        }
        if(f::isEmpty(v::getError()))
        {
            $codPersonal=DAO_Personal::getCodPersonalByCodCIP($codCIP);
            if(f::isEmpty($codPersonal))
            {
                v::setError('El codigo CIP no existe');
            }
        }
        if(f::isEmpty(v::getError()))
        {
            $numeroDias=f::request('post', 'normal', f::id('numeroDias'));
            v::valida($numeroDias, 'Numero de Días', 'required,maxSize[3],custom[integer]');
        } 
        if(f::isEmpty(v::getError()))
        {
            $direccion=f::request('post', 'normal', f::id('direccion'));
            v::valida($direccion, 'Direccion', 'required,maxSize[500]');
        }
        if(f::isEmpty(v::getError()))
        {
            $descripcion=f::request('post', 'normal', f::id('descripcion'));
            v::valida($descripcion, 'Descripcion', 'required,maxSize[500]');
        }
        if(f::isEmpty(v::getError()))
        {
            $motivo=f::request('post', 'normal', f::id('motivo'));
            v::valida($motivo, 'Motivo', 'required,maxSize[500]');
        }
        if(f::isEmpty(v::getError()))
        {
            $fechaInicio=f::request('post', 'normal', f::id('fechaInicio'));
            v::valida($fechaInicio, 'Fecha Inicio', 'required,maxSize[10]');
        }
        if(f::isEmpty(v::getError()))
        {
            $fechaFin=f::request('post', 'normal', f::id('fechaFin'));
            v::valida($fechaFin, 'Fecha Fin', 'required,maxSize[10]');
        }
        //v::setError('sape!');
        if(!f::isEmpty(v::getError()))
        {
            v::validaErrorJSON('#divMessagePermiso', 'up');
        }
        else
        {
            $oBE_Permiso=new BE_Permiso();
 
            $oBE_Permiso->setDescripcion($descripcion);
            $oBE_Permiso->setMotivo($motivo);
            $oBE_Permiso->setDireccion($direccion);
            $oBE_Permiso->setNumeroDias($numeroDias);
            $oBE_Permiso->setFechaInicio($fechaInicio);
            $oBE_Permiso->setFechaFin($fechaFin);
            $oBE_Permiso->setCodPersonal($codPersonal);

            $codPermiso=DAO_Permiso::nuevo($oBE_Permiso);

            if(!f::isEmpty($codPermiso))
            {
                v::setTrueJSON();
                v::setJSON('tag', '#divMasterPageRightContent');
                v::setJSON('ubicacion', 'up');
                v::setJSON('descripcion', 'Se realizó correctamente');

                s::set('codPermiso', $codPermiso);
                v::setJSON('tagdata', '#divMasterPageCenterContent');
                v::setJSON('data', c::getViewSystem('modulos/permiso/index.php', false));
            }
            else
            {
                v::setFalseJSON();
                v::setJSON('tag', '#divMessagePermiso');
                v::setJSON('ubicacion', 'up');
                v::setJSON('descripcion', 'No se puede realizar');
            }
            v::printJSON();
        }
    }

    public function editar()
    {
        if(f::isEmpty(v::getError()))
        {
            $this->validaCredencial();
        }
        if(f::isEmpty(v::getError()))
        {
            $codPermiso=f::request('post', 'decode', f::id('codPermiso'));
            v::valida($codPermiso, 'codPermiso', 'required,maxSize[11],custom[integer]');
        }
        if(f::isEmpty(v::getError()))
        {
            $codCIP=f::request('post', 'normal', f::id('codCIP'));
            v::valida($codCIP, 'Código CIP', 'required,maxSize[5]');
        }
        if(f::isEmpty(v::getError()))
        {
            $codPersonal=DAO_Personal::getCodPersonalByCodCIP($codCIP);
            if(f::isEmpty($codPersonal))
            {
                v::setError('El codigo CIP no existe');
            }
        }
        if(f::isEmpty(v::getError()))
        {
            $numeroDias=f::request('post', 'normal', f::id('numeroDias'));
            v::valida($numeroDias, 'Numero de Días', 'required,maxSize[3],custom[integer]');
        }
        if(f::isEmpty(v::getError()))
        {
            $lugarDestino=f::request('post', 'normal', f::id('lugarDestino'));
            v::valida($lugarDestino, 'Lugar Destino', 'required,maxSize[145]');
        }
        if(f::isEmpty(v::getError()))
        {
            $direccion=f::request('post', 'normal', f::id('direccion'));
            v::valida($direccion, 'Direccion', 'required,maxSize[500]');
        }
        if(f::isEmpty(v::getError()))
        {
            $descripcion=f::request('post', 'normal', f::id('descripcion'));
            v::valida($descripcion, 'Descripcion', 'required,maxSize[500]');
        }
        if(f::isEmpty(v::getError()))
        {
            $motivo=f::request('post', 'normal', f::id('motivo'));
            v::valida($motivo, 'Motivo', 'required,maxSize[500]');
        }
        if(f::isEmpty(v::getError()))
        {
            $fechaInicio=f::request('post', 'normal', f::id('fechaInicio'));
            v::valida($fechaInicio, 'Fecha Inicio', 'required,maxSize[10]');
        }
        if(f::isEmpty(v::getError()))
        {
            $fechaFin=f::request('post', 'normal', f::id('fechaFin'));
            v::valida($fechaFin, 'Fecha Fin', 'required,maxSize[10]');
        }
        //v::setError('sape!');
        if(!f::isEmpty(v::getError()))
        {
            v::validaErrorJSON('#divMessagePermiso', 'up');
        }
        else
        {
            $oBE_Permiso=new BE_Permiso();
 
            $oBE_Permiso->setDescripcion($descripcion);
            $oBE_Permiso->setMotivo($motivo);
            $oBE_Permiso->setDireccion($direccion);
            $oBE_Permiso->setNumeroDias($numeroDias);
            $oBE_Permiso->setFechaInicio($fechaInicio);
            $oBE_Permiso->setFechaFin($fechaFin);
            $oBE_Permiso->setCodPersonal($codPersonal);

            $codPermiso=DAO_Permiso::nuevo($oBE_Permiso);

            $filas=DAO_Permiso::editar($oBE_Permiso);

            if($filas > 0)
            {
                v::setTrueJSON();
                v::setJSON('tag', '#divMasterPageRightContent');
                v::setJSON('ubicacion', 'up');
                v::setJSON('descripcion', 'Se realizó correctamente');

                s::set('codPermiso', $codPermiso);
                v::setJSON('tagdata', '#divMasterPageCenterContent');
                v::setJSON('data', c::getViewSystem('modulos/permiso/index.php', false));
            }
            else
            {
                v::setFalseJSON();
                v::setJSON('tag', '#divMessagePermiso');
                v::setJSON('ubicacion', 'up');
                v::setJSON('descripcion', 'No se puede realizar');
            }
            v::printJSON();
        }
    }

    public function eliminar()
    {
        if(f::isEmpty(v::getError()))
        {
            $this->validaCredencial();
        }
        if(f::isEmpty(v::getError()))
        {
            $codPermiso=f::request('post', 'decode', f::id('codPermiso'));
            v::valida($codPermiso, 'codPermiso', 'required,maxSize[11],custom[integer]');
        }
        //v::setError('sape!');
        if(!f::isEmpty(v::getError()))
        {
            v::validaErrorJSON('#divMessagePermiso', 'up');
        }
        else
        {
            $oBE_Permiso=new BE_Permiso();

            $oBE_Permiso->setCodPermiso($codPermiso);

            $filas=DAO_Permiso::eliminar($oBE_Permiso);

            if($filas > 0)
            {
                v::setTrueJSON();
                v::setJSON('tag', '#divMasterPageRightContent');
                v::setJSON('ubicacion', 'up');
                v::setJSON('descripcion', 'Se realizó correctamente');

                s::set('codPermiso', $codPermiso);
                v::setJSON('tagdata', '#divMasterPageCenterContent');
                v::setJSON('data', c::getViewSystem('modulos/permiso/index.php', false));
            }
            else
            {
                v::setFalseJSON();
                v::setJSON('tag', '#divMessagePermiso');
                v::setJSON('ubicacion', 'up');
                v::setJSON('descripcion', 'No se puede realizar');
            }
            v::printJSON();
        }
    }
}