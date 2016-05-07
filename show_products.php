<?php
/**
* Filename:    show_products.php
* Author:      Luke Sathrum 
* Description: Class Example of Executing a SQL Statement
*/
?>
<?php
    // Setup the DB Connection
    require_once "database_setup.php";
    
/* Run the Query (Basic) */

    // Setup the Query
    $query = "SELECT COUNT(*) num_products
              FROM products";

    // Prepare the Query
    $statement = $db->prepare($query);

    // Run the Query in the Database
    $statement->execute();
    
    // Work with the results (as an associative array)
    // Since we only have 1 row we use fetch()
    $count_of_products = $statement->fetch();
    
    // Free the statement
    $statement->closeCursor();

/* END Run the Query (Basic) */

/* Run the Query (Advanced) */

    // Setup our Query with Named Parameters Placeholders
    $query = "SELECT *
              FROM products
              WHERE categoryID = :category_id";
              
    // Setup our Prepared Statement
    $statement = $db->prepare($query);
    
    // Bind our values to our Prepared Statement
    $statement->bindValue(':category_id', 1);
    
    // Run the Query in the Database
    $statement->execute();
    
    // Work with the results (as an object)
    $statement->setFetchMode(PDO::FETCH_OBJ);

    // Since we have multiple rows we'll use fetchAll()
    $rs = $statement->fetchAll();
    
    // Free the Statement
    $statement->closeCursor();
    
/* END Run the Query (Advanced) */
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Using PDO to get Data from MySQL</title>
        <style type="text/css">
        table {
        	font-family: verdana,arial,sans-serif;
        	font-size:11px;
        	color:#333333;
        	border-width: 1px;
        	border-color: #666666;
        	border-collapse: collapse;
        }
        table th {
        	border-width: 1px;
        	padding: 8px;
        	border-style: solid;
        	border-color: #666666;
        	background-color: #dedede;
        }
        table td {
        	border-width: 1px;
        	padding: 8px;
        	border-style: solid;
        	border-color: #666666;
        	background-color: #ffffff;
        }
        </style>
    </head>
    <body>
        <h3>Count of Products in the Database</h3>
        <p><?=$count_of_products['num_products']?></p>
        <pre><?php print_r($count_of_products)?></pre>
        
        <h3>Guitars</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>List Price</th>
                <th>Discount %</th>
            </tr>
            <?php foreach($rs as $row): ?>
            <tr>
                <td><?=$row->productID?></td>
                <td><?=$row->productName?></td>
                <td><?=$row->listPrice?></td>
                <td><?=$row->discountPercent?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <pre></pre>
    </body>
</html>