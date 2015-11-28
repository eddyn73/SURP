<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of BE_Modulo
 *
 * @author epalomino
 */
class BE_Modulo extends BE
{
    private $idModulo;
    private $nombre;
    private $carpeta;
    private $descripcion;
    private $imagen;
    private $persistente;
    private $estado;
    private $orden;
    
    public function getIdModulo()
    {
        return $this->idModulo;
    }
    
    public function setIdModulo($v)
    {
        $this->idModulo=$v;
    }
    
    public function getNombre()
    {
        return $this->nombre;
    }
    
    public function setNombre($v)
    {
        $this->nombre=$v;
    }
    
    public function getCarpeta()
    {
        return $this->carpeta;
    }
    
    public function setCarpeta($v)
    {
        $this->carpeta=$v;
    }
    
    public function getDescripcion()
    {
        return $this->descripcion;
    }
    
    public function setDescripcion($v)
    {
        $this->descripcion=$v;
    }
    
    public function getImagen()
    {
        return $this->imagen;
    }
    
    public function setImagen($v)
    {
        $this->imagen=$v;
    }
    public function getPersistente()
    {
        return $this->persistente;
    }
    
    public function setPersistente($v)
    {
        $this->persistente=$v;
    } 
    public function getEstado()
    {
        return $this->estado;
    }
    
    public function setEstado($v)
    {
        $this->estado=$v;
    }
    
    public function getOrden()
    {
        return $this->orden;
    }
    
    public function setOrden($v)
    {
        $this->orden=$v;
    }
}