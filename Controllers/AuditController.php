<?php
    namespace Controllers;
    use Models\Audit as Audit;

    class AuditController {
        private $auditModel;
        
        public function __construct() {
            $this->auditModel = new Audit();
        }
        
        public function index() {
            $audits = $this->auditModel->toList();
            return $audits;  
        }
    }
?>