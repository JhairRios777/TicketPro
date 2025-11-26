<?php
    namespace Controllers;
    use Models\Branch as Branch;
    use Entity\eBranch as eBranch;

    class BranchController {
        private $branchModel;
        
        public function __construct() {
            $this->branchModel = new Branch();
        }
        
        public function index() {
            $branches = $this->branchModel->toList();
            return $branches;  
        }

        public function Registry($id) {
            $success = true;
            if (isset($_POST) && isset($_POST['Registrar'])) {
                $branch = new eBranch();

                foreach ($_POST as $key => $value) {
                    $branch->$key = $value;
                }

                $this->branchModel->save($branch);
                return $branch;
            }

            $data = $this->branchModel->getForId($id); 
            
            if (!$data) {
                $data = new eBranch();
                $data->id = $this->branchModel->getNewId();
            }

            return $data;
        }
    }
?>