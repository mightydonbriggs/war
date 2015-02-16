<?php
    require_once("./dboinit.php");
    $deck = new \war\Deck();
    $deck->initialize();
    $db = $_SESSION['db'];  //Get a database object from the session
    
    $result = $deck->getAll();
    $rows = $db->fetch_array_set($result);
    
    $decklist = new DBO\Tableizer($rows);
   
    $view = new DBO\View();
    $view->setTemplate('deckList.phtml')
            ->setContent($decklist)
            ->render();    
    
//print "<pre>\n";
//print_r($result);
//print "</pre>\n";
//die("DEATH!!\n");    
    
    

