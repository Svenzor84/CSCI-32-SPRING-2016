<?php
/**
* Filename:    guitar_shop.php
* Author:      Luke Sathrum  / Steve Ross-Byers
* Description: Implements our Guitar Shop Object
*/
?>
<?php
// Include our Guitar Shop Class
require_once "guitar_shop_db.php";

// Create our Guitar Shop Object
$gs = new GuitarShop();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?=$title?></title>
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
<?php
// Run the Categories Query
$gs->GetCategories();

// Output the Array
echo "<h2>Category Array</h2>";
echo "<h3>There are {$gs->GetNumberOfRows()} Categories</h3>";
$gs->ViewResults();

// Output a <select> for Categories
echo "<h2>Category &lt;select&gt;</h2>";
echo "<select>" . $gs->GetCategoryOptions() . "</select>";

// Get a single category, categoryID = 3
echo "<h2>Category #3</h2>";
$gs->GetCategory(3);
$gs->ViewResults();


// View as a table (haven't written the method yet)
echo "<h2>Category Table</h2>";
// OUTPUT AS TABLE HERE - had to grab the rest of the categories table first
$gs->GetCategories();
echo $gs->ViewResultsAsTable();

// Get the Products and View as an HTML table
echo "<h2>Products Table</h2>";
// GET THE PRODUCTS HERE
$gs->GetProducts();

// OUTPUT AS TABLE HERE
echo $gs->ViewResultsAsTable();

// Get the products, limiting by categoryID = 1
// Output as an HTML table
echo "<h2>Products Table, Only Guitars</h2>";
// GET THE PRODUCTS BY CATEGORY HERE
$gs->GetProductsByCategory(1);

// OUTPUT AS TABLE HERE
echo $gs->ViewResultsAsTable();

// Get a single product, productID = 5
// Output as an HTML Table
echo "<h2>Product #5</h2>";
// GET THE PRODUCTS BY ID HERE
$gs->GetProduct(5);

// OUTPUT AS TABLE HERE
echo $gs->ViewResultsAsTable();
?>

</body>
</html>


