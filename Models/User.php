<?php
    namespace Models;

    use Config\Conexion as Conexion;

    class User{
        private $Conexion;

        public function __construct(){
            $this->Conexion = new Conexion();
            $this->Conexion = $this->Conexion->getConexion();
        }

        public function toList(){
            $sql = "SELECT * FROM Users";
            $stmt = $this->Conexion->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_OBJ);
        }

        public function getForId($id){
            $sql = "SELECT * FROM Users WHERE id = :id";
            $stmt = $this->Conexion->prepare($sql);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_OBJ);
        }

        public function getNewId(){
            $sql = "SELECT * FROM Users ORDER BY id DESC LIMIT 0,1";
            $stmt = $this->Conexion->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetch(\PDO::FETCH_OBJ);

            if(!$data){
                return "1";
            } else {
                return intval($data->id) + 1;
            }
        }

        public function forUserName($username, $password) {
            $sql = "SELECT * FROM Users WHERE username = :username AND password = :password";
            $stmt = $this->Conexion->prepare($sql);
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":password", $password);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_OBJ);
        }

        public function save($entity){
            // Ejecutar el stored procedure SP_User usando parámetros preparados
            try {
                $sql = "CALL SP_User(?,?,?,?,?,?,?,?,?)";
                $stmt = $this->Conexion->prepare($sql);

                $idParam = (isset($entity->id) && $entity->id !== '') ? $entity->id : null;

                $stmt->bindValue(1, $idParam, \PDO::PARAM_INT);
                $stmt->bindValue(2, isset($entity->name) ? $entity->name : null);
                $stmt->bindValue(3, isset($entity->username) ? $entity->username : null);
                $stmt->bindValue(4, isset($entity->password) ? $entity->password : null);
                $stmt->bindValue(5, isset($entity->service_id) ? $entity->service_id : null, \PDO::PARAM_INT);
                $stmt->bindValue(6, isset($entity->role_id) ? $entity->role_id : null, \PDO::PARAM_INT);
                $stmt->bindValue(7, isset($entity->email) ? $entity->email : null);
                $stmt->bindValue(8, isset($entity->phone) ? $entity->phone : null);
                $stmt->bindValue(9, isset($entity->status) ? $entity->status : 'Active');

                $ok = $stmt->execute();

                if ($ok && (is_null($idParam) || $idParam === 0)) {
                    // Si insertó sin id, asignar el id generado
                    $entity->id = $this->Conexion->lastInsertId();
                }

                return $ok;
            } catch (\Throwable $th) {
                // Registrar error para depuración sin alterar la estructura
                try {
                    $logDir = ROOT . 'logs' . DS;
                    if (!is_dir($logDir)) {
                        mkdir($logDir, 0755, true);
                    }
                    $msg = date('Y-m-d H:i:s') . " - Models\\User::save error: " . $th->getMessage() . PHP_EOL;
                    file_put_contents($logDir . 'error_user_save.log', $msg, FILE_APPEND);
                } catch (\Throwable $inner) {
                    // no hacer nada si el logging falla
                }
                return false;
            }
        }
    }
?>