<?php
    namespace entity;

    class eBranch {
        public $id;
        public $branch_name;
        public $location;

        public $Found;

        public function __construct() {
            $this->Found = false;
        }
    }
?>