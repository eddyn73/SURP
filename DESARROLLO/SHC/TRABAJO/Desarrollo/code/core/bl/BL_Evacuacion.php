<?php
/**
 * Description of BL_Evacuacion
 *
 * @author epalomino
 */
class BL_Evacuacion extends BL
{

    function __construct()
    {
        
    }

    public function lista()
    {
        return DAO_Evacuacion::lista();
    }

    public function getForm()
    {
        if(f::isEmpty(v::getError()))
        {
            $codEvacuacion=f::request('post', 'decode', f::id('codEvacuacion'));
            v::valida($codEvacuacion, 'codEvacuacion', 'required,maxSize[11]');
        }
        if(!f::isEmpty(v::getError()))
        {
            $codEvacuacion=0;
            v::clearError();
        }

        $table=DAO_Evacuacion::getForm($codEvacuacion);

        if(f::isEmpty($table))
        {  
            $table[0]['codEvacuacion']=null;
            $table[0]['fecha']=null;
            $table[0]['estado']=null;
            $table[0]['fechaInicio']=null;
            $table[0]['fechaFin']=null;
            $table[0]['motivo']=null;
            $table[0]['observaciones']=null;
            $table[0]['codPersonal']=null;
            $table[0]['codTipoEvacuacion']=null;
            $table[0]['codMedioEvacuacion']=null;
            $table[0]['codPersonalAcompaniante']=null;
            $table[0]['codCIP']=null;
            $table[0]['grado']=null;
            $table[0]['nombres']=null;
            $table[0]['apellidoPat']=null;
            $table[0]['apellidoMat']=null; 
            $table[0]['nombresAcompaniante']=null;
            $table[0]['apellidoPatAcompaniante']=null;
            $table[0]['apellidoMatAcompaniante']=null;
            $table[0]['medioEvacuacion']=null;
            $table[0]['lugarOrigen']=null;
            $table[0]['lugarDestino']=null;
            $table[0]['dni']=null;
            $table[0]['edad']=null;
            $table[0]['tipoSangre']=null;
            
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
            $codPersonal=f::request('post', 'normal', f::id('codPersonal'));
            v::valida($codPersonal, 'Código Personal', 'required,maxSize[11],custom[integer]');
        } 
        if(f::isEmpty(v::getError()))
        {
            $codPersonalAcompaniante=f::request('post', 'normal', f::id('codPersonalAcompaniante'));
            v::valida($codPersonalAcompaniante, 'Personal Acompañante', 'required,maxSize[11],custom[integer]');
        } 
        if(f::isEmpty(v::getError()))
        {
            if($codPersonalAcompaniante==$codPersonal)
            {
                v::setError('El personal acompañante no puede ser igual al personal evacuado');
            }
        }
        if(f::isEmpty(v::getError()))
        {
            $lugarDestino=f::request('post', 'normal', f::id('lugarDestino'));
            v::valida($lugarDestino, 'Lugar Destino', 'required,maxSize[11],custom[integer]');
        }
        if(f::isEmpty(v::getError()))
        {
            $motivo=f::request('post', 'decode', f::id('motivo'));
            v::valida($motivo, 'Motivo', 'required,maxSize[11],custom[integer]');
        }
        if(f::isEmpty(v::getError()))
        {
            $medioEvacuacion=f::request('post', 'decode', f::id('medioEvacuacion'));
            v::valida($medioEvacuacion, 'Medio Evacuación', 'required,maxSize[11],custom[integer]');
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
        
        
        
        if(f::isEmpty(v::getError()))
        {
            $observaciones=f::request('post', 'normal', f::id('observaciones'));
            v::valida($observaciones, 'Observaciones', 'maxSize[500]');
        }
        //v::setError('sape!');
        if(!f::isEmpty(v::getError()))
        {
            v::validaErrorJSON('#divMasterPageRightContent', 'up');
        }
        else
        { 
            
            $oBE_Evacuacion=new BE_Evacuacion();

            $oBE_Evacuacion->setCodPersonal($codPersonal);
            $oBE_Evacuacion->setCodPersonalAcompaniante($codPersonalAcompaniante);
            $oBE_Evacuacion->setLugarDestino($lugarDestino);
            $oBE_Evacuacion->setFechaInicio($fechaInicio);
            $oBE_Evacuacion->setFechaFin($fechaFin);
            $oBE_Evacuacion->setCodTipoEvacuacion($motivo);
            $oBE_Evacuacion->setCodMedioEvacuacion($medioEvacuacion);
            $oBE_Evacuacion->setObservaciones(($observaciones)); 
            $oBE_Evacuacion->setEstado(1);
            //solicitado
            //aprobado
            //desaprobado
            $codEvacuacion=DAO_Evacuacion::nuevo($oBE_Evacuacion);

            if(!f::isEmpty($codEvacuacion))
            {
                v::setTrueJSON();
                v::setJSON('tag', '#divMasterPageRightContent');
                v::setJSON('ubicacion', 'up');
                v::setJSON('descripcion', 'Se realizó correctamente');

                s::set('codEvacuacion', $codEvacuacion); 
            }
            else
            {
                v::setFalseJSON();
                v::setJSON('tag', '#divMasterPageRightContent');
                v::setJSON('ubicacion', 'up');
                v::setJSON('descripcion', 'No se puede realizar');
            }
            v::printJSON();
        }
    } 
    
    public function preBuscarPersonal()
    {
        if(f::isEmpty(v::getError()))
        {
            $this->validaCredencial();
        }
        if(f::isEmpty(v::getError()))
        {
            $buscar=f::request('post', 'normal', f::id('buscar'));
            v::valida($buscar, 'Buscar', 'required,minSize[2]');
        }
        if(!f::isEmpty(v::getError()))
        {
            v::validaErrorJSON('#divMasterPageRightContent', 'up', false);
        }
        else
        {
            $sql=null;
            $buscar=trim($buscar);
            foreach(explode(' ', $buscar) as $key=> $value)
            {
                $value=utf8_decode($value);
                if(is_numeric($value))
                {
                    $sql.="AND p.codCIP LIKE '%".$value."%'";
                }
                else
                {
                    $sql.="AND CONCAT(p.nombres,' ',p.apellidoPat,' ',apellidoMat) LIKE'%".$value."%'";
                }
            }

            $autocomplete=array();
            $table=DAO_Evacuacion::listaPersonal($sql);

            //f::message($table);

            v::setTrueJSON();
            v::setJSON('tag', '#divMasterPageRightContent');
            v::setJSON('ubicacion', 'up');
            v::setJSON('cerrar', false);

            if(count($table) > 0)
            {
                foreach($table as $key=> $value)
                {
                    /*
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
                     *                      */
                    $autocomplete[$key]['value'][]=$buscar;
                    $autocomplete[$key]['label'][]=$value['nombres'].' '.$value['apellidoPat'].' '.$value['apellidoMat'];
                    $autocomplete[$key]['codigo'][]=$value['codPersonal'];

                    $autocomplete[$key]['nombres'][]=$value['nombres'];
                    $autocomplete[$key]['apellidoPat'][]=$value['apellidoPat'];
                    $autocomplete[$key]['apellidoMat'][]=$value['apellidoMat'];
                    $autocomplete[$key]['dni'][]=$value['dni'];
                    $autocomplete[$key]['tipoSangre'][]=$value['tipoSangre'];
                    $autocomplete[$key]['grado'][]=$value['grado'];
                    $autocomplete[$key]['codCIP'][]=$value['codCIP'];
                    $autocomplete[$key]['codUnidad'][]=$value['codUnidad'];
                    $autocomplete[$key]['lugarOrigen'][]=$value['lugarOrigen'];
                    $autocomplete[$key]['edad'][]=$value['edad'];
                    
                    $autocomplete[$key]['respuesta'][]=1;
                }
            }
            else
            {
                $autocomplete[0]['value'][]=$buscar;
                $autocomplete[0]['label'][]='Sin Resultados';
                $autocomplete[0]['codigo'][]=null;

                $autocomplete[0]['nombres'][]='&nbsp;';
                $autocomplete[0]['apellidoPat'][]='&nbsp;';
                $autocomplete[0]['apellidoMat'][]='&nbsp;';
                $autocomplete[0]['dni'][]='&nbsp;';
                $autocomplete[0]['tipoSangre'][]='&nbsp;';
                $autocomplete[0]['grado'][]='&nbsp;';
                $autocomplete[0]['codCIP'][]='&nbsp;';
                $autocomplete[0]['codUnidad'][]='&nbsp;';
                $autocomplete[0]['lugarOrigen'][]='&nbsp;';
                $autocomplete[0]['edad'][]='&nbsp;';
                
                $autocomplete[0]['respuesta'][]=0;
            }
            v::setJSON('descripcion', 'ok');
            v::setJSON('autocomplete', $autocomplete);

            v::printJSON();
        }
    }

    public function preBuscarLugarDestino()
    {
        if(f::isEmpty(v::getError()))
        {
            $this->validaCredencial();
        }
        if(f::isEmpty(v::getError()))
        {
            $buscar=f::request('post', 'normal', f::id('buscar'));
            v::valida($buscar, 'Buscar', 'required,minSize[2]');
        }
        if(!f::isEmpty(v::getError()))
        {
            v::validaErrorJSON('#divMasterPageRightContent', 'up', false);
        }
        else
        {
            $sql=null;
            $buscar=trim($buscar);
            foreach(explode(' ', $buscar) as $key=> $value)
            {
                $value=utf8_decode($value);
                
                if($key!=0)
                {
                    $sql.='AND ';
                }
                
                $sql.="nombre LIKE '%".$value."%'";
  
            }

            $autocomplete=array();
            $table=DAO_Unidad::listaUnidades($sql);

            //f::message($table);

            v::setTrueJSON();
            v::setJSON('tag', '#divMasterPageRightContent');
            v::setJSON('ubicacion', 'up');
            v::setJSON('cerrar', false);

            if(count($table) > 0)
            {
                foreach($table as $key=> $value)
                {
                    /*
                      codUnidad
                    , nombre
                     *                      */
                    $autocomplete[$key]['value'][]=$value['nombre'];
                    $autocomplete[$key]['label'][]=$value['nombre'];
                    $autocomplete[$key]['codigo'][]=$value['codUnidad']; 
                      
                    $autocomplete[$key]['respuesta'][]=1;
                }
            }
            else
            {
                $autocomplete[0]['value'][]=$buscar;
                $autocomplete[0]['label'][]='Sin Resultados';
                $autocomplete[0]['codigo'][]=null; 
                
                $autocomplete[0]['respuesta'][]=0;
            }
            v::setJSON('descripcion', 'ok');
            v::setJSON('autocomplete', $autocomplete);

            v::printJSON();
        }
    }

    public function listaMotivos()
    {
        return DAO_Evacuacion::listaMotivos();
    }

    public function listaMedioEvacuacion()
    {
        return DAO_Evacuacion::listaMedioEvacuacion();
    }

    public function preBuscarPersonalAcompaniante()
    {
        if(f::isEmpty(v::getError()))
        {
            $this->validaCredencial();
        }
        if(f::isEmpty(v::getError()))
        {
            $buscar=f::request('post', 'normal', f::id('buscar'));
            v::valida($buscar, 'Buscar', 'required,minSize[2]');
        }
        if(!f::isEmpty(v::getError()))
        {
            v::validaErrorJSON('#divMasterPageRightContent', 'up', false);
        }
        else
        {
            $sql=null;
            $buscar=trim($buscar);
            foreach(explode(' ', $buscar) as $key=> $value)
            {
                $value=utf8_decode($value);
                if(is_numeric($value))
                {
                    $sql.="AND p.codCIP LIKE '%".$value."%'";
                }
                else
                {
                    $sql.="AND CONCAT(p.nombres,' ',p.apellidoPat,' ',apellidoMat) LIKE'%".$value."%'";
                }
            }

            $autocomplete=array();
            $table=DAO_Evacuacion::listaPersonal($sql);

            //f::message($table);

            v::setTrueJSON();
            v::setJSON('tag', '#divMasterPageRightContent');
            v::setJSON('ubicacion', 'up');
            v::setJSON('cerrar', false);

            if(count($table) > 0)
            {
                foreach($table as $key=> $value)
                {
                    /*
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
                     *                      */
                    $autocomplete[$key]['value'][]=$value['nombres'].' '.$value['apellidoPat'].' '.$value['apellidoMat'];
                    $autocomplete[$key]['label'][]=$value['nombres'].' '.$value['apellidoPat'].' '.$value['apellidoMat'];
                    $autocomplete[$key]['codigo'][]=$value['codPersonal'];

                    $autocomplete[$key]['nombres'][]=$value['nombres'];
                    $autocomplete[$key]['apellidoPat'][]=$value['apellidoPat'];
                    $autocomplete[$key]['apellidoMat'][]=$value['apellidoMat'];
                    $autocomplete[$key]['dni'][]=$value['dni'];
                    $autocomplete[$key]['tipoSangre'][]=$value['tipoSangre'];
                    $autocomplete[$key]['grado'][]=$value['grado'];
                    $autocomplete[$key]['codCIP'][]=$value['codCIP'];
                    $autocomplete[$key]['codUnidad'][]=$value['codUnidad'];
                    $autocomplete[$key]['lugarOrigen'][]=$value['lugarOrigen'];
                    $autocomplete[$key]['edad'][]=$value['edad'];
                    
                    $autocomplete[$key]['respuesta'][]=1;
                }
            }
            else
            {
                $autocomplete[0]['value'][]=$buscar;
                $autocomplete[0]['label'][]='Sin Resultados';
                $autocomplete[0]['codigo'][]=null;

                $autocomplete[0]['nombres'][]='&nbsp;';
                $autocomplete[0]['apellidoPat'][]='&nbsp;';
                $autocomplete[0]['apellidoMat'][]='&nbsp;';
                $autocomplete[0]['dni'][]='&nbsp;';
                $autocomplete[0]['tipoSangre'][]='&nbsp;';
                $autocomplete[0]['grado'][]='&nbsp;';
                $autocomplete[0]['codCIP'][]='&nbsp;';
                $autocomplete[0]['codUnidad'][]='&nbsp;';
                $autocomplete[0]['lugarOrigen'][]='&nbsp;';
                $autocomplete[0]['edad'][]='&nbsp;';
                
                $autocomplete[0]['respuesta'][]=0;
            }
            v::setJSON('descripcion', 'ok');
            v::setJSON('autocomplete', $autocomplete);

            v::printJSON();
        }
    }

    public function listaEvcuaciones()
    {
        return DAO_Evacuacion::listaEvcuaciones();
    }
    
    public function aprobar()
    {
        if(f::isEmpty(v::getError()))
        {
            $this->validaCredencial();
        } 
        if(f::isEmpty(v::getError()))
        {
            $codEvacuacion=f::request('post', 'decode', f::id('codEvacuacion'));
            v::valida($codEvacuacion, 'codEvacuacion', 'required,maxSize[11],custom[integer]');
        } 
        //v::setError('sape!');
        if(!f::isEmpty(v::getError()))
        {
            v::validaErrorJSON('#divMasterPageRightContent', 'up');
        }
        else
        {
             
            $estado=2;//aprobar
            $resultado=DAO_Evacuacion::estadoEvacucacion($codEvacuacion,$estado);
            
            if($resultado>=0)
            { 
                v::setTrueJSON();
                v::setJSON('tag', '#divMasterPageRightContent');
                v::setJSON('ubicacion', 'up');
                v::setJSON('descripcion', 'Se realizó correctamente');
                 
                s::set('codEvacuacion', $codEvacuacion);
                v::setJSON('tagdata', '#divMasterPageCenterContent');
                v::setJSON('data', c::getViewSystem('modulos/aprobarevacuacion/index.php', false));
            }
            else
            {
                v::setFalseJSON();
                v::setJSON('tag', '#divMasterPageRightContent');
                v::setJSON('ubicacion', 'up'); 
                v::setJSON('descripcion', 'No se puedo realizar');
            }
            v::printJSON();
        }
    }
    
    public function desaprobar()
    {
        if(f::isEmpty(v::getError()))
        {
            $this->validaCredencial();
        } 
        if(f::isEmpty(v::getError()))
        {
            $codEvacuacion=f::request('post', 'decode', f::id('codEvacuacion'));
            v::valida($codEvacuacion, 'codEvacuacion', 'required,maxSize[11],custom[integer]');
        } 
        //v::setError('sape!');
        if(!f::isEmpty(v::getError()))
        {
            v::validaErrorJSON('#divMasterPageRightContent', 'up');
        }
        else
        {
             
            $estado=3;//desaprobar
            $resultado=DAO_Evacuacion::estadoEvacucacion($codEvacuacion,$estado);
            
            if($resultado>=0)
            { 
                v::setTrueJSON();
                v::setJSON('tag', '#divMasterPageRightContent');
                v::setJSON('ubicacion', 'up');
                v::setJSON('descripcion', 'Se realizó correctamente');
                 
                s::set('codEvacuacion', $codEvacuacion);
                v::setJSON('tagdata', '#divMasterPageCenterContent');
                v::setJSON('data', c::getViewSystem('modulos/aprobarevacuacion/index.php', false));
            }
            else
            {
                v::setFalseJSON();
                v::setJSON('tag', '#divMasterPageRightContent');
                v::setJSON('ubicacion', 'up'); 
                v::setJSON('descripcion', 'No se puedo realizar');
            }
            v::printJSON();
        }
    }

    public function listaMisEvcuaciones()
    {
        $codPersonal=f::getSession('idUsuario');
        return DAO_Evacuacion::listaMisEvcuaciones($codPersonal);
    }

    public function eliminar()
    {
        if(f::isEmpty(v::getError()))
        {
            $this->validaCredencial();
        } 
        if(f::isEmpty(v::getError()))
        {
            $codEvacuacion=f::request('post', 'decode', f::id('codEvacuacion'));
            v::valida($codEvacuacion, 'codEvacuacion', 'required,maxSize[11],custom[integer]');
        } 
        //v::setError('sape!');
        if(!f::isEmpty(v::getError()))
        {
            v::validaErrorJSON('#divMasterPageRightContent', 'up');
        }
        else
        { 
            $resultado=DAO_Evacuacion::eliminar($codEvacuacion);
            
            if($resultado>=0)
            { 
                v::setTrueJSON();
                v::setJSON('tag', '#divMasterPageRightContent');
                v::setJSON('ubicacion', 'up');
                v::setJSON('descripcion', 'Se realizó correctamente');
                 
                s::set('codEvacuacion', $codEvacuacion);
                v::setJSON('tagdata', '#divMasterPageCenterContent');
                v::setJSON('data', c::getViewSystem('modulos/misevacuaciones/index.php', false));
            }
            else
            {
                v::setFalseJSON();
                v::setJSON('tag', '#divMasterPageRightContent');
                v::setJSON('ubicacion', 'up'); 
                v::setJSON('descripcion', 'No se puedo realizar');
            }
            v::printJSON();
        }
    }
}