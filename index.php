<?php
    require_once("./dboinit.php");
//    print "<pre>\n";
//    print_r($_SERVER);
//    print_r($_SESSION);
//    print_r($_REQUEST);
//    $errors = array();
    $view = new DBO\View('index.phtml'); //Set default view
    $view->render();
    print "<pre>\n";
print_r($view);
print "</pre>\n";
die("DEATH!!\n");        
