<?php
    namespace Controllers;
    use Models\Role as Role;
    use Entity\eRole as eRole;

    class RoleController {
        private $roleModel;
        
        public function __construct() {
            $this->roleModel = new Role();
        }
        
        public function index() {
            $roles = $this->roleModel->toList();
            return $roles;  
        }

        public function Registry($id) {
            $success = true;
            if(isset($_POST) && isset($_POST['Registrar'])){
                $role = new eRole();

                foreach($_POST as $key => $value) {
                    $role->$key = $value;
                }

                if(empty($role->name)) {
                    echo '<div class="alert alert-danger" role="alert">El nombre del rol es obligatorio</div>';
                    $success = false;
                }

                $this->roleModel->save($role);
                return $role;
            }

            $data = $this->roleModel->getForId($id); 
            
            if(!$data) {
                $data = new eRole();
                $data->id = $this->roleModel->getNewId();
            }

            return $data;
        }
    }
?>