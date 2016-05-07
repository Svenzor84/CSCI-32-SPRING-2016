<?php
/**
* Filename:    db_setup.php
* Author:      Steve Ross-Byers (Luke Sathrum)  
* Description: Created from In-Class Example of Connecting to MySQL using PDO (with exception handling)
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