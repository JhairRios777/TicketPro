<?php
    namespace Controllers;
    use Models\Role as Role;

    class RoleController {
        private $roleModel;
        
        public function __construct() {
            $this->roleModel = new Role();
        }
        
        public function index() {
            $roles = $this->roleModel->toList();
            return $roles;  
        }
    }
?>