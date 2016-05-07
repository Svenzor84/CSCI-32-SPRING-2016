<?php
/** 
*  Filename: products.php
*  Author: Steve Ross-Byers
*  Description: Display contents of the products table in our database, either complete or limited by category of item
*/

    //setup the database connection
    require_once "db_setup.php";

    //prepare our query statement (get product info including category name by joining the category table on categoryID)
    $query = "SELECT products.productName, products.listPrice, products.discountPercent, products.categoryID, categories.categoryName
              FROM products
              JOIN categories
              ON categories.categoryID = products.categoryID";

    //setup the prepared statement
    $statement = $db->prepare($query);

    //run the query in the database
    $statement->execute();

    //fetch the results as an object
    $statement->setFetchMode(PDO::FETCH_OBJ);
    
    //we want to fetch all rows into our variable
    $results = $statement->fetchAll();
    
    //finally free the statement
    $statement->closeCursor();

?>

<!DOCTYPE html>
<html lang="en-us">

<head>
    <title> Guitar Shop Products </title>
    <meta charset="utf-8" />
    <meta name="author" content="Steve Ross-Byers" />
    <meta name="description" content="The current products for the guitar shop, complete listing or limited by category" />
    <meta name="keyword" content="guitar shop, php, database, mysql" />

    <style>
        
        .table-hover tbody tr:hover td, .table-hover tbody tr:hover th {
            
            background-color: #ff8c1a;
            
        }
        
        body {
            
            background-color: #ff8c1a !important;
            
        }
        
        .main {
            
            background-color: #000000;
            color: #ff8c1a;
            
        }
        
    </style>

     <!-- Bootstrap CSS link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
</head>

<body>
    
<h1 class="main text-center">Guitar Shop Inventory</h1>
    
<div class="container">
    <div class="jumbotron">
            
    <?php
        if (!$_GET) { ?>
            <h3>Inventory</h3>
            <table class="table table-hover table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Category</th>
                        <th>List Price</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $row): ?>
                        <tr>
                            <td><?=$row->productName?></td>
                            <td><?=$row->categoryName?></td>
                            <td><?=$row->listPrice?></td>
                            <td><?= number_format($row->listPrice - ($row->listPrice * ($row->discountPercent / 100)), 2)?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
        <?php } else { 
            if ($_GET["cat"] == 1) {
                echo "<h3>Guitars</h3>";
            } else if ($_GET["cat"] == 2) {
                echo "<h3>Basses</h3>";
            } else if ($_GET["cat"] == 3) {
                echo "<h3>Drums</h3>";
            } ?>
            
            <table class="table table-hover table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>List Price</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $row):
                        if ($_GET["cat"] == $row->categoryID) { ?>
                            <tr>
                                <td><?=$row->productName?></td>
                                <td><?=$row->listPrice?></td>
                                <td><?= number_format($row->listPrice - ($row->listPrice * ($row->discountPercent / 100)), 2)?></td>
                            </tr>
                        <?php }
                    endforeach; ?>
                </tbody>
            </table>
            
        <?php } ?>
        <div class="row text-center">
            <?php if ($_GET) {
                if ($_GET["cat"] == 1) { ?>
                    <a class="btn btn-danger" href="https://wd2sp16-svenzor.c9users.io/labs/11/products.php/?cat=1">Guitars</a>
                <?php } else { ?>
                    <a class="btn btn-success" href="https://wd2sp16-svenzor.c9users.io/labs/11/products.php/?cat=1">Guitars</a>
                <?php }
                if ($_GET["cat"] == 2) { ?>
                    <a class="btn btn-danger" href="https://wd2sp16-svenzor.c9users.io/labs/11/products.php/?cat=2">Basses</a>
                <?php } else { ?>
                    <a class="btn btn-success" href="https://wd2sp16-svenzor.c9users.io/labs/11/products.php/?cat=2">Basses</a>
                <?php }
                if ($_GET["cat"] == 3) { ?>
                    <a class="btn btn-danger" href="https://wd2sp16-svenzor.c9users.io/labs/11/products.php/?cat=3">Drums</a>
                <?php } else { ?>
                    <a class="btn btn-success" href="https://wd2sp16-svenzor.c9users.io/labs/11/products.php/?cat=3">Drums</a>
                <?php } ?>
                <a class="btn btn-success" href="https://wd2sp16-svenzor.c9users.io/labs/11/products.php/">All</a>
            <?php } else { ?>
                <a class="btn btn-success" href="https://wd2sp16-svenzor.c9users.io/labs/11/products.php/?cat=1">Guitars</a>
                <a class="btn btn-success" href="https://wd2sp16-svenzor.c9users.io/labs/11/products.php/?cat=2">Basses</a>
                <a class="btn btn-success" href="https://wd2sp16-svenzor.c9users.io/labs/11/products.php/?cat=3">Drums</a>
                <a class="btn btn-danger" href="https://wd2sp16-svenzor.c9users.io/labs/11/products.php/">All</a>
            <?php } ?>
        </div>
    </div>
</div>
    
    <!-- JQuery and BootStrap libraries -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</body>

</html>