<?php
    namespace Models;
    use Config\Conexion as Conexion;

    class Audit {
        private $Conexion;

        public function __construct() {
            $this->Conexion = new Conexion();
            $this->Conexion = $this->Conexion->getConexion();
        }

        public function toList() {
            $sql = "SELECT * FROM Audits";
            $stmt = $this->Conexion->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_OBJ);
        }

        public function getForId($id){
            $sql = "SELECT * FROM Audits WHERE id = :id";
            $stmt = $this->Conexion->prepare($sql);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_OBJ);
        }

        public function getNewId(){
            $sql = "SELECT * FROM Audits ORDER BY id DESC LIMIT 0,1";
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
            $sql = "call SP_Audit (";
            $sql .= "'".$entity->id."', ";
            $sql .= "'".$entity->user_id."', ";
            $sql .= "'".$entity->desk_id."', ";
            $sql .= "'".$entity->ticket_id."', ";
            $sql .= "'".$entity->action."', ";
            $sql .= "'".$entity->details."', ";
            $sql .= "'".$entity->date_time."'";
            $sql .= ");";

            $stmt = $this->Conexion->prepare($sql);
            $stmt->execute();
        }
    }
?>