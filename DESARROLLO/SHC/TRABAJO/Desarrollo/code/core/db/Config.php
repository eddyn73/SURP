<?php
/**
 * Config
 * 
 * @author epalomino
 */
class Config
{
    private $hostname;
    private $username;
    private $password;
    private $database;
    
    public function getHostname()
    {
        return $this->hostname;
    }

    public function setHostname($v)
    {
        $this->hostname=$v;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($v)
    {
        $this->username=$v;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($v)
    {
        $this->password=$v;
    }

    public function getDatabase()
    {
        return $this->database;
    }

    public function setDatabase($v)
    {
        $this->database=$v;
    }

    /**
     * MySQL:Conexión por defecto
     */
    public function por_defecto_mysql()
    {
        $this->fParametros();
    }

    /**
     * SQL Server:Conexión por defecto
     */
    public function por_defecto_mssql()
    {
        $this->fParametros();
    }
    
    public function fParametros()
    {
        $this->setHostname('127.0.0.1');
        $this->setUsername('root');
        $this->setPassword('root');
        $this->setDatabase('shc2');
    }
}