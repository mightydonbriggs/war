<?php
/**
 * This is the bootstrapper for Don! Briggs Objects. It's function is to initialize
 * the environment required for DBO. This script also contains the "Autoloader",
 * which will load classes dynically when they are first called. This prevents
 * having to either load a class manually before you use it, or having to load
 * ALL clases to insure that they are all available.
 * 
 * @name dboinit.php
 * @author Don Briggs <donbriggs@donbriggs.com>
 * @since 20130623
 * @category framework
 * @package Don Briggs Objects (DBO)
 */
    if(!isset($_SESSION['baseUrl'])) {
        $_SESSION['baseUrl'] = $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']);
    }
    if(!isset($_SESSION['DBODEBUG']))
    $_SESSION['DBODEBUG'] = false;
    
    //Normally I would put the db params in a config file, or in the .htaccess file for security
    $dbName     = 'war';
    $dbUsername = 'root';
    $dbPassword = 'root';
    $dbHost     = 'localhost';
    
    if(empty($_SESSION)) { 
        $_SESSION = array();
        session_start();         
    } 
    
    //--- Store some basic path info in the session
    $_SESSION['docRoot'] = $_SERVER['DOCUMENT_ROOT'] . $_SERVER['REQUEST_URI'];
    $_SESSION['appRoot'] = __DIR__; // This file (dboinit.php) should be in app root
    $_SESSION['libPath'] = $_SESSION['appRoot'] .DIRECTORY_SEPARATOR .'lib';
    $_SESSION['viewPath'] = $_SESSION['appRoot'] .DIRECTORY_SEPARATOR .'view';
    $_SESSION['includePath'] = $_SESSION['appRoot'] .DIRECTORY_SEPARATOR .'inc';
     
    /**
     * This is the Autoloader. It allows us to instanciate classes without having
     * to first include the class file. It presumes that the file containing the class to
     * be loaded follows the format: "ClassName.class.php". Note that the class
     * name must be the same as the first part of the filename, or the load will
     * fail.
     * 
     * @param type $className
     * @return void
     */
    function __autoload($className) {
        if($_SESSION['DBODEBUG']) { print"<pre> Autoloading Class Name: $className </pre>"; }
        $classFile = ($_SESSION['libPath'] .DIRECTORY_SEPARATOR .$className .".class.php");
        $classFile = str_replace("\\", DIRECTORY_SEPARATOR, $classFile);
        $classFile = str_replace("/", DIRECTORY_SEPARATOR, $classFile);
        if($_SESSION['DBODEBUG']) {print"<pre> Src Filename: $classFile </pre>"; }
        if(!is_readable($classFile)) {
            throw new \Exception("Class file not readable: " .$classFile);
        }
        if(!file_exists($classFile)) {
            print "<pre>ERROR: Could not find class file.\n";
            print "Class Name: $className \n";
            print "Class File: *$classFile* \n";
            throw new \Exception("Could not find class file.");
        }
        require_once(trim($classFile));
    }
    //Create a new instance of the database class, and store in session for eveybody to use.
    $_SESSION['db'] = new \dbo\MySqlDatabase($dbHost, $dbUsername, $dbPassword, $dbName);
?>