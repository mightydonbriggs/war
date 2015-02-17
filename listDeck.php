<?php
    require_once("./dboinit.php");
    $db = $_SESSION['db'];  //Get a database object from the session
    $deck = new \war\Deck();
    
    if($deck->countCards() != 52) {
        print "Initializing Deck <br />";
        $deck->initialize();    
    }
    
    $sql = 'select * from deck order by sortlocation';
    $result = $deck->getBySql($sql);
    $rows = $db->fetch_array_set($result);
    
    $decklist = new DBO\Tableizer($rows);
   
    $view = new DBO\View();
    $view->setTemplate('deckList.phtml')
            ->setContent($decklist)
            ->render();    

    
    

