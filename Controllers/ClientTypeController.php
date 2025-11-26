<?php
    namespace Controllers;
    use Models\ClientType as ClientType;
    use Entity\eClientType as eClientType;

    class ClientTypeController {
        private $clientTypeModel;
        
        public function __construct() {
            $this->clientTypeModel = new ClientType();
        }
        
        public function index() {
            $clientTypes = $this->clientTypeModel->toList();
            return $clientTypes;  
        }

        public function Registry($id) {
            $success = true;
            if (isset($_POST) && isset($_POST['Registrar'])) {
                $clientType = new eClientType();

                foreach ($_POST as $key => $value) {
                    $clientType->$key = $value;
                }

                $this->clientTypeModel->save($clientType);
                return $clientType;
            }

            $data = $this->clientTypeModel->getForId($id); 
            
            if (!$data) {
                $data = new eClientType();
                $data->id = $this->clientTypeModel->getNewId();
            }

            return $data;
        }
    }
?>