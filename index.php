<?php
    session_start();

    require_once "Define.php";
    require_once "Config\JRequest.php";
    require_once "Config\JRouter.php";
    require_once "Config\AutoLoad.php";

    if(!isset($_SESSION["system"]["username"])){
        header("Location: /Login");
        exit();
    }

    Config\AutoLoad::run();
    include_once "Template\index.php";
    Config\JRouter::run(new Config\JRequest());
?>