<?php
    namespace Controllers;
    use Models\ServiceDesk as ServiceDesk;

    class ServiceDeskController {
        private $serviceDeskModel;
        
        public function __construct() {
            $this->serviceDeskModel = new ServiceDesk();
        }
        
        public function index() {
            $serviceDesks = $this->serviceDeskModel->toList();
            return $serviceDesks;  
        }
    }
?>