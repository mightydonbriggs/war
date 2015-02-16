<?php
    /**
     * Session Reset
     * 
     * This file is a utility to reset the PHP session for development
     * purposes. Please ignore it, and continue on with your life.
     * 
     */
    session_start();
    session_unset();
    session_destroy();
    $return = $_GET['return'];
    header("location: $return");
?>    