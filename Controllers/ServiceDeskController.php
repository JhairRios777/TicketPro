<?php
    namespace Controllers;
    use Models\ServiceDesk as ServiceDesk;
    use Entity\eServiceDesk as eServiceDesk;

    class ServiceDeskController {
        private $serviceDeskModel;
        
        public function __construct() {
            $this->serviceDeskModel = new ServiceDesk();
        }
        
        public function index() {
            $serviceDesks = $this->serviceDeskModel->toList();
            return $serviceDesks;  
        }

        public function Registry($id) {
            $success = true;
            if(isset($_POST) && isset($_POST['Registrar'])) {
                $serviceDesk = new eServiceDesk();

                foreach($_POST as $key => $value) {
                    $serviceDesk->$key = $value;
                }

                if(empty($serviceDesk->desk_name)) {
                    echo '<div class="alert alert-danger" role="alert">El nombre de la estación de servicio es obligatorio</div>';
                    $success = false;
                }

                $this->serviceDeskModel->save($serviceDesk);
                return $serviceDesk;
            }

            $data = $this->serviceDeskModel->getForId($id); 
            
            if(!$data) {
                $data = new eServiceDesk();
                $data->id = $this->serviceDeskModel->getNewId();
            }

            return $data;
        }
    }
?>