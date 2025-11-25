<?php
    namespace Controllers;
    use Models\Service as Service;
    use Entity\eService as eService;

    class ServiceController {
        private $serviceModel;
        
        public function __construct() {
            $this->serviceModel = new Service();
        }
        
        public function index() {
            $services = $this->serviceModel->toList();
            return $services;  
        }

        public function Registry($id) {
            $success = true;
            if(isset($_POST) && isset($_POST['Registrar'])) {
                $service = new eService();

                foreach($_POST as $key => $value) {
                    $service->$key = $value;
                }

                if(empty($service->name)) {
                    echo '<div class="alert alert-danger" role="alert">El nombre del servicio es obligatorio</div>';
                    $success = false;
                }

                $this->serviceModel->save($service);
                return $service;
            }

            $data = $this->serviceModel->getForId($id); 
            
            if(!$data) {
                $data = new eService();
                $data->id = $this->serviceModel->getNewId();
            }

            return $data;
        }
    }
?>