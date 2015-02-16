<?php
namespace war; 

class Deck extends \DBO\DataObject {
    
    //---Fields required for dbo
    protected static $_tableName   = 'deck';    //Base database table
    protected static $_primaryKey  = 'id';    //Name of primary key field

    
    /**
     * Initialize the deck
     * 
     * This function will initialize the deck. That is, it will delete, and then
     * recreate all records in the deck database table. No not the way we would
     * do it for production. But this is not production.
     */
    
    protected static $_cardNames = array('Ace', 'Duce', 'Three', 'Four', 'Five', 'Six', 'Seven',
                                       'Eight', 'Nine', 'Ten', 'Jack', 'Queen', 'King');
    protected static $_suits = array('Spades', 'Diamonds', 'Hearts', 'Clubs');
    
    
   
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
                $result = $this->saveFromArray($thisCard);
                $pointValue++;
                $sortOrder++;
            }
        }
        return $this;
    }
   
}
