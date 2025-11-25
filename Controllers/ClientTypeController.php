<?php
    namespace Controllers;
    use Models\ClientType as ClientType;

    class ClientTypeController {
        private $clientTypeModel;
        
        public function __construct() {
            $this->clientTypeModel = new ClientType();
        }
        
        public function index() {
            $clientTypes = $this->clientTypeModel->toList();
            return $clientTypes;  
        }
    }
?>