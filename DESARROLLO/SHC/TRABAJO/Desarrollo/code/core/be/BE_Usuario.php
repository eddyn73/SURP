<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of BE_Usuario
 *
 * @author epalomino
 */
class BE_Usuario extends BE
{
    private $idUsuario;// int(11) NOT NULL AUTO_INCREMENT,
    private $usuario;// varchar(50) DEFAULT NULL,
    private $clave;// varchar(50) DEFAULT NULL,
    private $nombre;// varchar(100) DEFAULT NULL,
    private $apellido;// varchar(100) DEFAULT NULL,
    private $imagen;// varchar(100) DEFAULT NULL,
    private $email;// varchar(100) DEFAULT NULL,
    private $plantillaui;// varchar(250) NOT NULL,
    private $orden;// int(11) DEFAULT NULL,
    private $idPerfil;// int(11) NOT NULL,
    
    public final function getIdUsuario()
    {
        return $this->idUsuario;
    }
    
    public final function setIdUsuario($v)
    {
        $this->idUsuario=$v;
    }
    
    public final function getUsuario()
    {
        return $this->usuario;
    }
    
    public final function setUsuario($v)
    {
        $this->usuario=$v;
    }
    
    public final function getClave()
    {
        return $this->clave;
    }
    
    public final function setClave($v)
    {
        $this->clave=$v;
    }
    
    public final function getNombre()
    {
        return $this->nombre;
    }
    
    public final function setNombre($v)
    {
        $this->nombre=$v;
    }
    
    public final function getApellido()
    {
        return $this->apellido;
    }
    
    public final function setApellido($v)
    {
        $this->apellido=$v;
    }
    
    public final function getImagen()
    {
        return $this->imagen;
    }
    
    public final function setImagen($v)
    {
        $this->imagen=$v;
    }
    
    public final function getEmail()
    {
        return $this->email;
    }
    
    public final function setEmail($v)
    {
        $this->email=$v;
    }
    
    public final function getPlantillaui()
    {
        return $this->plantillaui;
    }
    
    public final function setPlantillaui($v)
    {
        $this->plantillaui=$v;
    }
    
    public final function getOrden()
    {
        return $this->orden;
    }
    
    public final function setOrden($v)
    {
        $this->orden=$v;
    }
    
    public final function getIdPerfil()
    {
        return $this->idPerfil;
    }
    
    public final function setIdPerfil($v)
    {
        $this->idPerfil=$v;
    }
}