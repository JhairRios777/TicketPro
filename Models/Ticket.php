<?php
    namespace Models;
    use Config\Conexion as Conexion;

    class Ticket {
        private $Conexion;

        public function __construct() {
            $this->Conexion = new Conexion();
            $this->Conexion = $this->Conexion->getConexion();
        }

        public function toList() {
            $sql = "SELECT * FROM Tickets";
            $stmt = $this->Conexion->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_OBJ);
        }

         public function getForId($id){
            $sql = "SELECT * FROM Tickets WHERE id = :id";
            $stmt = $this->Conexion->prepare($sql);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_OBJ);
        }

        public function getNewId(){
            $sql = "SELECT * FROM Tickets ORDER BY id DESC LIMIT 0,1";
            $stmt = $this->Conexion->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetch(\PDO::FETCH_OBJ);

            if(!$data){
                return "1";
            } else {
                return intval($data->id) + 1;
            }
        }
        public function save($entity){
            $sql = "call SP_Ticket (";
            $sql .= "'".$entity->id."', ";
            $sql .= "'".$entity->ticket_code."', ";
            $sql .= "'".$entity->service_id."', ";
            $sql .= "'".$entity->client_type_id."', ";
            $sql .= "'".$entity->status_id."', ";
            $sql .= "'".$entity->user_id."', ";
            $sql .= "'".$entity->date_time."'";
            $sql .= ");";

            $stmt = $this->Conexion->prepare($sql);
            $stmt->execute();
        }
    }
?>