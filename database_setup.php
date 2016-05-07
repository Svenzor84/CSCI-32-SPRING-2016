<?php
/**
* Filename:    database_setup.php
* Author:      Luke Sathrum  
* Description: Class Example of Connecting to MySQL using PDO
*/
?>
<?php
    // Setup your database name
    $db_name = "guitar_shop";
    
    // Setup your Data Source Name (DSN)
    $dsn = "mysql:host=localhost;dbname=$db_name";
    
    // Setup your database username
    $username = "root";
    
    // Setup your database password
    $password = "";
    
    // Handle Exceptions
    try {
        
        //create a PDO object
        $db = new PDO($dsn, $username, $password);
        echo "<!-- Successfully Connected to: $db_name -->";
    } catch (PDOException $e) {
        
        $error_message = $e->getMessage();
        include 'database_error.php';
        exit();
    }

?>