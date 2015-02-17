<?php
namespace war; 

class Deck extends \DBO\DataObject {
    
    //---Fields required for dbo
    protected static $_tableName   = 'deck';    //Base database table
    protected static $_primaryKey  = 'id';    //Name of primary key field

    /*
     * Card names and suits are held in static arrays. We are presuming that the
     * card values never change (ie, jacks are wild), and that the Ace is always
     * worth one. Also I am am counting all suits as equal in value.
     */
    protected static $_suits = array('Spades', 'Diamonds', 'Hearts', 'Clubs');
    protected static $_cardNames = array('Ace', 'Duce', 'Three', 'Four', 'Five', 'Six', 'Seven',
                                         'Eight', 'Nine', 'Ten', 'Jack', 'Queen', 'King');
    
    
   /**
    * This function will initialize the deck. That is, it will delete all card
    * records and recreate them. It does NOT shuffle the cards. In a real-world
    * solution, this type of functionality would be handled by an SQL 
    * loader script to load initial data into the database.
    * 
    * @return \war\Deck
    */
    public function initialize() {
        $sql = "delete from " .self::$_tableName ." where 1=1";
        $result = self::$_db->query($sql); //Delete all records to start off
        
        //--- Now iterate through suits and cards to build the fresh deck
        $sortOrder = 1;
        foreach (self::$_suits as $suit) {
            $pointValue = 1;
            foreach(self::$_cardNames as $cardName) {
                $thisCard = array();
                $thisCard['id'] = null;
                $thisCard['facename'] = $cardName;
                $thisCard['suit'] = $suit;
                $thisCard['pointvalue'] = $pointValue;
                $thisCard['sortlocation'] = $sortOrder;
                $thisCard['playerassign'] = 0;
                $result = $this->saveFromArray($thisCard);
                $pointValue++;
                $sortOrder++;
            }
        }
    }
    
    /**
     * Count Deck
     * 
     * This function will returnt he total number of cards in the deck. That is
     * to say the total number of records in the 'deck' table. Here on earth,
     * that number should be 51 for the deck to be valic.
     * 
     * @return integer Total number of cards in deck
     */
    public function countCards() {
        $sql = "SELECT count(*) as count FROM "  .self::$_tableName;
        $result = self::$_db->query($sql); //Delete all records to start off
        $count = self::$_db->fetch_array($result);
        return $count['count'];
    }
    
    /**
     * Shuffle Deck
     * 
     * This functionw will shuffle the deck of cards.
     */
    public function shuffle() {

        //--- Create a sort-order list
        $sortOrder = array();
        $sortOrder = range(1, 52);
        shuffle($sortOrder);
         
        //--- Get all cards to be shuffled
        $result = $this->getAll();
        $rows = static::$_db->fetch_array_set($result);
        $i=0; //Initialize index for $sortOrder array
        
        //---Set new shuffle order and save record to db
        foreach($rows as $row) {
           $row['sortlocation'] = $sortOrder[$i];
           $result = $this->saveFromArray($row);       
           $i++;           
        }
    }
    
    public function findBySortLocation($sortLocation) {
        $sql = "select * from " .static::$_tableName ." where sortlocation=" .$sortLocation;
        
        $result = static::$_db->query($sql);
        $row = array_pop($this->fetch_array_set($result));
        return $row;
    }
    
    /**
     * Deal from deck
     * 
     * This function will deal cards from the deck
     * @param array $players
     */
    public function deal(array $players) {
       
        $numPlayers = count($players);
        $numCards = $this->countCards(); //Obviousaly, this should always be 52
        
        for($i=1; $i<=$numCards; $i++) {
            $playerSlot = (integer) $i % $numPlayers;
            
            $card = $this->findBySortLocation($i);
            $card['playerassign'] = $players[$playerSlot]->getId();
            $this->saveFromArray($card); //Save record back to database
            $players[$playerSlot]->takeCard($card);            
        }      
    }
       
}