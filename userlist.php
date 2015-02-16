<?php
    require_once("./dboinit.php");

    $db = $_SESSION['db'];
    $sql = 'select * from player';
    $result = $db->query($sql);
    $rows = $db->fetch_array_set($result);
    
    $userlist = new DBO\Tableizer($rows);
   
    $view = new DBO\View();
    $view->setTemplate('userlist.phtml')
            ->setContent($userlist)
            ->render();