<?php
/**
 * Description of DAO
 * 
 * @author epalomino
 */
class DAO
{
    protected static function getDB()
    {
        return new DataBase();
    }
} 