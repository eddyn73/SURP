<?php
/**
 * Interface: DataBaseProviderInterface
 *
 * @author epalomino
 */
interface DataBaseProviderInterface
{

    /**
     * Abre Conexion a la BD
     * @param type $funcion : null por defecto
     */
    public function conectar($funcion);
    
    /**
     * Cierra Conexion a la BD
     */
    public function desconectar();
}
?>
