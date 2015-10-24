<?php
/**
 * Description of Singleton
 * 
 * @author epalomino
 */
class s
{
    private static $instance=array();

    public static function get($objeto)
    {
        if(!self::existeInstance($objeto))
        {
            self::$instance[$objeto]=null;
        }
        return self::$instance[$objeto];
    }
    public static function set($objeto, $value)
    {
        self::$instance[$objeto]=$value;
    }
    
    private static function existeInstance($objeto)
    {
        $return=null;
        if(isset(self::$instance[$objeto]))
        {
            $return=true;
        }
        return $return;
    }
}
