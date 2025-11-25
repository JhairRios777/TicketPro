<?php
    namespace Controllers;
    use Models\Service as Service;

    class ServiceController {
        private $serviceModel;
        
        public function __construct() {
            $this->serviceModel = new Service();
        }
        
        public function index() {
            $services = $this->serviceModel->toList();
            return $services;  
        }
    }
?>