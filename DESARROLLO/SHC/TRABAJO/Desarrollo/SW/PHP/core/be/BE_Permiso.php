<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of BE_Permiso
 *
 * @author epalomino
 */
class BE_Permiso
{
    private $codPermiso;
    private $estado;
    private $descripcion;
    private $fechaSolicitud;
    private $motivo;
    private $direccion;
    private $numeroDias;
    private $fechaInicio;
    private $fechaFin;
    private $codPersonal;
    
    public function getCodPermiso()
    {
        return $this->codPermiso;
    }
    
    public function setCodPermiso($v)
    {
        $this->codPermiso=$v;
    }
    
    public function getEstado()
    {
        return $this->estado;
    }
    
    public function setEstado($v)
    {
        $this->estado=$v;
    }
    
    public function getDescripcion()
    {
        return $this->descripcion;
    }
    
    public function setDescripcion($v)
    {
        $this->descripcion=$v;
    }
    
    public function getFechaSolicitud()
    {
        return $this->fechaSolicitud;
    }
    
    public function setFechaSolicitud($v)
    {
        $this->fechaSolicitud=$v;
    }
    
    public function getMotivo()
    {
        return $this->motivo;
    }
    
    public function setMotivo($v)
    {
        $this->motivo=$v;
    }
    
    public function getDireccion()
    {
        return $this->direccion;
    }
    
    public function setDireccion($v)
    {
        $this->direccion=$v;
    }
    
    public function getNumeroDias()
    {
        return $this->numeroDias;
    }
    
    public function setNumeroDias($v)
    {
        $this->numeroDias=$v;
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
    
    public function getCodPersonal()
    {
        return $this->codPersonal;
    }
    
    public function setCodPersonal($v)
    {
        $this->codPersonal=$v;
    }
}