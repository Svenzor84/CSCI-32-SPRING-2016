<?php

/**
* Filename:    guitar_shop_crud.php
* Author:      Steve Ross-Byers
* Description: CRUD interface for the customer table in the guitar shop database
*/

//include the guitar shop database class
require_once "guitar_shop_db.php";

//function that displays the form for adding and updating customers (the optional parameter $results is for passing query results when inserting a form to the update customer page)
function InsertForm($string, $results = null) {
    
    //add quotes to the results array so that fields with white spaces are properly displayed
    //foreach ($results as $result) {
        
        //$result = '"' . $result . '"';
        //echo $result;
    //}
    
    echo "<form action='guitar_shop_crud.php/?action=$string' method='POST' class='form-horizontal'>
            <div class='form-group'>
              <label for='first_name' class='control-label col-md-2'>First Name: </label>
              <div class='col-md-5'>
                <input type='Text' name='first_name' id='first_name' class='form-control' value='" . (isset($results['firstName']) ? $results['firstName'] : '') . "'>
              </div>
            </div>
            <div class='form-group'>
              <label for='last_name' class='control-label col-md-2'>Last Name: </label>
              <div class='col-md-5'>
                <input type='Text' name='last_name' id='last_name' class='form-control' value='" . (isset($results['lastName']) ? $results['lastName'] : '') . "'>
              </div>
            </div>
            <div class='form-group'>
              <label for='email' class='control-label col-md-2'>Email Address: </label>
              <div class='col-md-5'>
                <input type='Text' name='email' id='email' class='form-control' value='" . (isset($results['emailAddress']) ? $results['emailAddress'] : '') . "'>
              </div>
            </div>
            <div class='form-group'>
              <label for='password' class='control-label col-md-2'>Password: </label>
              <div class='col-md-5'>
                <input type='Text' name='password' id='password' class='form-control' value='" . (isset($results['password']) ? $results['password'] : '') . "'>
              </div>
            </div>
            <div class='form-group'>
              <div class='col-md-offset-2 col-md-3'>
                <input type='Submit' value='Submit' class='form-control btn btn-success'>
              </div>
            </div>
          </form>";
    
}

//form validation function
function Validate($post_keys) {
    
    //set up the post array
    $post_data = [];
    
    //loop through our parameter array and ensure that each $_POST variable is set
    foreach($post_keys as $post_key) {
        
        //ensure that the current post key is set and not empty
        if (isset($_POST[$post_key]) && trim($_POST[$post_key]) != "") {
            
            //sterilize, trim, and save the validated POST data
            $post_data[$post_key] = htmlentities(trim($_POST[$post_key]));
            
        //otherwise
        } else {
            
            //end the function now and return false
            return false;
        }
    }
    
    //if we made it through the loop without returning false, then all is good and we can return the post data array
    return $post_data;
}

//create our new guitar shop
$gs = new GuitarShop();

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?=$title?></title>
        <style type="text/css">
        .heading {
            font-weight: bold;
            text-align: center;
        }
        #search {
            padding-bottom: 1em;
        }
        </style>
        
        <!-- Bootstrap CSS link -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        
    </head>
    <body>
        <div class="jumbotron">
            <div class="container">
                
          
            <?php    
      
                if (!isset($_GET['action'])) {
          
                    echo "<h1>Customers</h1>";
                    
                    if (isset($_GET['err']) && $_GET['err'] == 2) {
                        
                        echo "<div class='col-md-offset-1'>
                                <h3 class='text-danger'>No Search Query Provided!</h3>
                              </div>";
                              
                    } else if (isset($_GET['err']) && $_GET['err'] == 3) {
                        
                        echo "<div class='col-md-offset-1'>
                                <h3 class='text-danger'>No Customers Match the Search Query '{$_GET['search']}'!</h3>
                              </div>";
                    }
                    
                    echo "<div class='container' id='search'>
                            <form action='guitar_shop_crud.php/?action=Search' method='POST' class='form'>
                              <div class='form-group'>
                                <div class='col-md-7'>
                                  <input type='search' name='search' class='form-control'>
                                </div>
                                <div class='col-md-2'>
                                  <input type='submit' value='Search' class='form-control btn btn-success'>
                                </div>
                              </div>
                            </form>
                            <h5 class='text-muted col-md-12'>*Search is restricted to Customer Name fields (firstName + lastName).</h5>
                          </div>";
      
                    $gs->GetCustomers();
      
                    echo $gs->ViewResultsAsTable(true);
                    
                    echo "<div class='col-md-offset-1'>
                            <h3>Add Customer</h3>";
                            
                    if (isset($_GET['err']) && $_GET['err'] == 1) {
                        
                        echo "<div class='col-md-offset-1'>
                                <h3 class='text-danger'>All Fields Are Required To Add!</h3>
                              </div>";
                    }
                    
                    echo "</div>";
                    
                    insertForm("Adding");
            
                } else if (($_GET['action'] == "Updating") && (!empty($_GET['cust']))) {
                
                    $gs->GetCustomer($_GET['cust']);
                
                    $results = get_object_vars($gs->GetResults()[0]);
                
                    echo "<h1>Update Customer</h1>";    
            
                    echo "<h2>$results[firstName] $results[lastName]</h2>";
                
                    echo $gs->ViewResultsAsTable();
            
                    if (!empty($_GET['err'])) {
                
                        echo "<div class='col-md-offset-2'>
                                <h3 class='text-danger'>All Fields Are Required To Update!</h3>
                              </div>";
                    }
            
                    insertForm("Updated&cust={$_GET['cust']}", $results);
            
                    echo "<form class='form-horizontal'>
                            <div class='form-group'>
                              <div class='col-md-offset-2 col-md-3'>
                                <p><a href='guitar_shop_crud.php' class='form-control btn btn-danger'>Cancel</a></p>
                              </div>
                            </div>
                          </form>";
            
                } else if (($_GET['action'] == "Deleting") && (!empty($_GET['cust']))) {
            
                    $gs->GetCustomer($_GET['cust']);
                
                    $results = get_object_vars($gs->GetResults()[0]);
                
                    echo "<h1>Delete Customer</h1>";
                
                    echo "<h2>$results[firstName] $results[lastName]</h2>";
                
                    echo $gs->ViewResultsAsTable();
            
                    echo "<div class='col-md-offset-1'>
                            <h3>Are you sure you want to delete this customer?</h3>
                          </div>";
            
                    echo "<form class='form-horizontal'>
                            <div class='form-group'>
                              <div class='col-md-offset-2 col-md-3'>
                                <p><a href='guitar_shop_crud.php/?action=Deleted&cust=$results[customerID]' class='form-control btn btn-success'>Confirm</a></p>
                                <p><a href='guitar_shop_crud.php' class='form-control btn btn-danger'>Cancel</a></p>
                              </div>
                            </div>
                          </form>";
            
                } else if ($_GET['action'] == "Adding") {
            
                    $fields = [
                        "first_name",
                        "last_name",
                        "email",
                        "password",
                        ];
            
                    if ($post_data = Validate($fields)) {
                
                        $post_data['password'] = md5($post_data['password']);
                
                        $gs->AddCustomer($post_data['email'], $post_data['password'], $post_data['first_name'], $post_data['last_name']);
                
                        header("Location: https://wd2sp16-svenzor.c9users.io/labs/13/guitar_shop_crud.php");
                
                    } else {
                
                        header("Location: guitar_shop_crud.php/?err=1");
                
                    }
            
                } else if ($_GET['action'] == "Updated") {
        
                    $fields = [
                        "first_name",
                        "last_name",
                        "email",
                        "password",
                        ];
                
                    if ($post_data = Validate($fields)) {
                
                        //get the customer's data and put it in an array so we can check it against what was entered
                        $gs->GetCustomer($_GET['cust']);
                        $vals = get_object_vars($gs->GetResults()[0]);
                
                        //ensure that each entered value is different before updating the database
                        if ($post_data['first_name'] != $vals['first_name']) {
                    
                            $gs->UpdateCustomer($_GET['cust'], 'firstName', $post_data['first_name']);
                        }
                
                        if ($post_data['last_name'] != $vals['first_name']) {
                    
                            $gs->UpdateCustomer($_GET['cust'], 'lastName', $post_data['last_name']);
                        }
                
                        if ($post_data['password'] != $vals['password']) {
                    
                            $post_data['password'] = md5($post_data['password']);
                            $gs->UpdateCustomer($_GET['cust'], 'password', $post_data['password']);
                        }
                
                        if ($post_data['email'] != $vals['password']) {
                    
                            $gs->UpdateCustomer($_GET['cust'], 'emailAddress', $post_data['email']);
                        }
                
                        header("Location: https://wd2sp16-svenzor.c9users.io/labs/13/guitar_shop_crud.php");
                
                    } else {
                
                        header("Location: guitar_shop_crud.php/?action=Updating&cust={$_GET['cust']}&err=1");
                
                    }
            
                } else if ($_GET['action'] == "Deleted") {
            
                    $gs->DeleteCustomer($_GET['cust']);
            
                    header("Location: https://wd2sp16-svenzor.c9users.io/labs/13/guitar_shop_crud.php");
            
                } else if ($_GET['action'] == "Search") {
                
                    $field = [
                        "search",
                        ];
                        
                    if ($post_data = Validate($field)) {
                        
                        $gs->SearchCustomer($post_data['search']);
                        
                        if (!empty($gs->GetResults()[0])) {
                            
                            echo "<h1>Customer Search</h1>";
                            
                            echo "<h2>'{$post_data['search']}'</h2>";
                            
                            echo "<form class='form-horizontal'>
                            <div class='form-group'>
                              <div class='col-md-3'>
                                <p><a href='guitar_shop_crud.php' class='form-control btn btn-danger'>Clear Search</a></p>
                              </div>
                            </div>
                          </form>";
                            
                            echo $gs->ViewResultsAsTable(true);
                            
                        } else {
                            
                            header("Location: guitar_shop_crud.php/?err=3&search={$post_data['search']}");
                        }
                        
                    } else {
                        
                        header("Location: guitar_shop_crud.php/?err=2");
                    }
                    
                } else {
            
                    echo "<h1>404</h1>";
                    echo "<h3>You have reached this page in error</h3>";
                }
        
            ?>
    
            </div>
        </div>
    
                <!--Bootstrap and JQuery libraries-->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
          
    </body>
</html>