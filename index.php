<?php
    require_once("./dboinit.php");

    $view = new DBO\View('index.phtml'); //Set default view
    $view->render();
