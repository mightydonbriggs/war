<?php
    require_once("./dboinit.php");  //Initialize DBO
    
    $db = $_SESSION['db'];  //Get a database object from the session
    $player1 = new \war\Player();
    $player2 = new \war\Player();
    
    //--- Set up the player
    $players = array();   //Will hold a the player objects
    $playersInGame = 2;  //Total number of players in a hand
    $numPlayers = $player1->countPlayers();
    $playerList = range(1, $numPlayers);
    shuffle($playerList);
    for($i=0; $i<$playersInGame; $i++) {
        $player = new \war\Player();
        $player->setPlayer($playerList[$i]);
        $players[] = $player;
    }
    
    
    //--- Deal cards frome the deck to the players
    $deck = new \war\Deck();
    if($deck->countCards() != 52) {
        print "Initializing\n";        
        $deck->initialize();
    }
//    $deck->shuffle(); //always shuffle the deck before we begin     
    $deck->deal($players);
 
    //---And now the combat begins

