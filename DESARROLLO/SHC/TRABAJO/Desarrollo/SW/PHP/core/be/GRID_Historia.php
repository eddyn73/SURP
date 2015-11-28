<?php
/**
 * Description of GRID_Historia
 *
 * @author EDDY
 */
class GRID_Historia
{
    private $idPaciente;
    private $dni;
    private $apellido;
    private $nombre;
    private $altura;
    private $tipoSangre;
    private $registro;
    private $ultimo;
    private $estado;

    function get_idPaciente()
    {
        return $this->idPaciente;
    }

    function get_dni()
    {
        return $this->dni;
    }

    function get_apellido()
    {
        return $this->apellido;
    }

    function get_nombre()
    {
        return $this->nombre;
    }

    function get_altura()
    {
        return $this->altura;
    }

    function get_tipoSangre()
    {
        return $this->tipoSangre;
    }

    function get_registro()
    {
        return $this->registro;
    }

    function get_ultimo()
    {
        return $this->ultimo;
    }

    function get_estado()
    {
        return $this->estado;
    }

    function set_idPaciente($idPaciente)
    {
        $this->idPaciente=$idPaciente;
    }

    function set_dni($dni)
    {
        $this->dni=$dni;
    }

    function set_apellido($apellido)
    {
        $this->apellido=$apellido;
    }

    function set_nombre($nombre)
    {
        $this->nombre=$nombre;
    }

    function set_altura($altura)
    {
        $this->altura=$altura;
    }

    function set_tipoSangre($tipoSangre)
    {
        $this->tipoSangre=$tipoSangre;
    }

    function set_registro($registro)
    {
        $this->registro=$registro;
    }

    function set_ultimo($ultimo)
    {
        $this->ultimo=$ultimo;
    }

    function set_estado($estado)
    {
        $this->estado=$estado;
    }
}