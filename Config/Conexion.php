<?php

 namespace Config;

$conn= new \Config\Conexion("ControlTickets");
class Conexion{
    private $host="localhost";
    private $dbName="ControlTickets";
    private $user="root";
    private $pwd="";
    private $conn=null;

    public function __construct()
    {
        try{
            $this->conn = 
            new \PDO("mysql:host=".$this->host.";dbname=".$this->dbName, $this->user, $this->pwd);

            //echo "Conexion exitosa";
        }catch(\Throwable $th){
            die("Conexion Fallida...".$th->getMessage());  
        }

    }

    //metodo para obtener la conexion

    public function getConexion(){
        return $this->conn;
    }
}
?>