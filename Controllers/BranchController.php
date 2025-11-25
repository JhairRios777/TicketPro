<?php
    namespace Controllers;
    use Models\Branch as Branch;

    class BranchController {
        private $branchModel;
        
        public function __construct() {
            $this->branchModel = new Branch();
        }
        
        public function index() {
            $branches = $this->branchModel->toList();
            return $branches;  
        }
    }
?>