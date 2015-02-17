<?php
namespace war; 

class Player extends \DBO\DataObject {
    
    //---Fields required for dbo
    protected static $_tableName   = 'player';    //Base database table
    protected static $_primaryKey  = 'id';    //Name of primary key field
    
    protected $_hand = array();  //Array will hold card objects arrays

    /**
     * Count Players
     * 
     * This function will return a count of all of the player records in the
     * players table.
     * 
     * @return integer Total number of records int he players table
     */
    public function countPlayers() {
        $sql = "SELECT count(*) as count FROM "  .self::$_tableName;
        $result = self::$_db->query($sql); //Delete all records to start off
        $count = self::$_db->fetch_array($result);
        return $count['count'];
    }
    
    /**
     * Return count
     * 
     * Return count of cards this player has in their hand.
     * 
     * @return integer
     */
    public function numCards() {
        return count($this->_hand);
    }
    
    /**
     * Take a new card
     * 
     * Take a new card and add it to the players hand
     * 
     * @param type $card
     */
    public function takeCard($card) {
        $this->_hand[] = $card;
    }
    
    /**
     * Get highest card
     * 
     * This function will return the 
     */
    public function getTopCard() {
        
    }
       
    public function setPlayer($id) {
        $this->getById($id);
    }

}