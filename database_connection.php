<?php 

class DbConnect
{
    public $serverName;
    public $userName;
    public $databaseName;
    public $password;
    public $connect;

    function __construct($serverName = "localhost", $userName = "root", $password = "", $databaseName = "CedHosting")
    {
        $this->serverName = $serverName;
        $this->userName = $userName;
        $this->password = $password;
        $this->databaseName = $databaseName;

        $this->connect = new mysqli($serverName, $userName, $password, $databaseName);
    }
}

?>