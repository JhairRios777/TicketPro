<?php
    namespace entity;

    class eService {
        public $id;
        public $name;
        public $description;

        public $Found;

        public function __construct() {
            $this->Found = false;
        }
    }
?>