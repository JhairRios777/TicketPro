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
    Config\AutoLoad::run();

    // If the request is for generating a PDF (Audit/View/{id}) we must not
    // include the site template because it outputs HTML which breaks PDF headers.
    $rawUrl = isset($_GET['url']) ? $_GET['url'] : '';
    $isPdfRoute = false;
    if (!empty($rawUrl)) {
        $parts = explode('/', trim($rawUrl, '/'));
        if (isset($parts[0]) && isset($parts[1])) {
            $isPdfRoute = (strtolower($parts[0]) === 'audit' && strtolower($parts[1]) === 'view');
        }
    }

    if (!$isPdfRoute) {
        include_once "Template\index.php";
    }

    Config\JRouter::run(new Config\JRequest());
?>