<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of BE_Evacuacion
 *
 * @author epalomino
 */
class BE_Evacuacion extends BE
{
    private $codEvacuacion;
    private $fecha;
    private $estado;
    private $lugarDestino; 
    private $fechaInicio; 
    private $fechaFin; 
    private $motivo; 
    private $observaciones;
    private $codPersonal;
    
    private $codTipoEvacuacion;
    private $codMedioEvacuacion;
    private $codPersonalAcompaniante;
    
    public function getCodEvacuacion()
    {
        return $this->codEvacuacion;
    }
    
    public function setCodEvacuacion($v)
    {
        $this->codEvacuacion=$v;
    }
    
    public function getFecha()
    {
        return $this->fecha;
    }
    
    public function setFecha($v)
    {
        $this->fecha=$v;
    }
    
    public function getEstado()
    {
        return $this->estado;
    }
    
    public function setEstado($v)
    {
        $this->estado=$v;
    }
    
    public function getLugarDestino()
    {
        return $this->lugarDestino;
    }
    
    public function setLugarDestino($v)
    {
        $this->lugarDestino=$v;
    } 
    
    public function getFechaInicio()
    {
        return $this->fechaInicio;
    }
    
    public function setFechaInicio($v)
    {
        $this->fechaInicio=$v;
    }
    
    public function getFechaFin()
    {
        return $this->fechaFin;
    }
    
    public function setFechaFin($v)
    {
        $this->fechaFin=$v;
    }
    
    public function getMotivo()
    {
        return $this->motivo;
    }
    
    public function setMotivo($v)
    {
        $this->motivo=$v;
    }
    
    public function getObservaciones()
    {
        return $this->observaciones;
    }
    
    public function setObservaciones($v)
    {
        $this->observaciones=$v;
    }
    
    public function getCodPersonal()
    {
        return $this->codPersonal;
    }
    
    public function setCodPersonal($v)
    {
        $this->codPersonal=$v;
    } 
    
    public function getCodTipoEvacuacion()
    {
        return $this->codTipoEvacuacion;
    }
    
    public function setCodTipoEvacuacion($v)
    {
        $this->codTipoEvacuacion=$v;
    }
    
    public function getCodMedioEvacuacion()
    {
        return $this->codMedioEvacuacion;
    }
    
    public function setCodMedioEvacuacion($v)
    {
        $this->codMedioEvacuacion=$v;
    }
    
    public function getCodPersonalAcompaniante()
    {
        return $this->codPersonalAcompaniante;
    }
    
    public function setCodPersonalAcompaniante($v)
    {
        $this->codPersonalAcompaniante=$v;
    }
}