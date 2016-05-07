<?php
/**
* Filename:    guitar_shop_db.php
* Author:      Luke Sathrum / Steve Ross-Byers
* Description: A Guitar Shop Class to facilitate connection and queries to the
*              guitar_shop database
*/

/*
 * GuitarShop Class
 * Facilitates connection to the database
 * Facilitates easy running of queries
 */
class GuitarShop {
    // Class's Data
    private $db;
    private $sql;
    private $stmt;
    private $rs;
    private $num_rows;
    
    // Class Constants
    //added the charset attribute to ensure that the customer search function works properly
    const DSN = 'mysql:host=localhost;dbname=guitar_shop;charset=utf8';
    const UN = 'root';
    const PW = '';
    
    /*
     * A constructor, gets called when we create an object from the class
     * Sets up our DB Connection
     */
    public function __construct() {
        // Handle Exceptions
        try {
            // Setup PDO attributes
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            ];
            
            // Create a PDO Object
            $this->db = new PDO(self::DSN, self::UN, self::PW, $options);
            
        } catch (PDOException $e) {
            // Output Connection Errors
            echo $e->getMessage();
            // End the script's execution
            exit();
        }
    }
    
    /*
     * A destructor, gets called when our object is no longer being used
     * Closes our DB Connection
     */
    public function __destruct() {
        $this->db = NULL;
    }

/** Base Methods - Used by all other methods */
    
    /*
     * Facilitates the running of a query with no named parameters
     * Uses the class variable $sql ($this->sql) to run the query
     */
    private function RunBasicQuery() {
       // Prepare the Query
       $this->stmt = $this->db->prepare($this->sql);
    
       // Run the Query in the Database
       $this->stmt->execute();
       
       // Store the Number Of Rows Returned
       $this->num_rows = $this->stmt->rowCount();
        
       // Work with the results (as an array of objects)
       $this->rs = $this->stmt->fetchAll();
        
       // Free the statement
       $this->stmt->closeCursor(); 
    }
    
    /*
     * Facilitates the running of a query with named parameters
     * The array should be in the format:
     * [
     *    ':named_parameter' => $parameter_value,
     * ]
     * Uses the class variable $sql ($this->sql) to run the query
     */
    private function RunAdvancedQuery($named_parameter_array, $insert = false) {
       // Prepare the Query
       $this->stmt = $this->db->prepare($this->sql);
    
       // Run the Query in the Database, using the named parameters
       $this->stmt->execute($named_parameter_array);
       
       // Store the Number Of Rows Returned
       $this->num_rows = $this->stmt->rowCount();
        
       //if we are not inserting or updating the database
       if($insert == false) {
        
        // Work with the results (as an array of objects)
        $this->rs = $this->stmt->fetchAll();
        
       }
       
       // Free the statement
       $this->stmt->closeCursor(); 
    }
    
    /*
     * Accessor for $num_rows
     * @return - The number of rows returned by the query
     */
    public function GetNumberOfRows() {
        return $this->num_rows;
    }
    
    /*
     * Returns the result set, which is an array of objects
     * Note: The result set will be NULL if the query failed
     * @return - An array of objects, or NULL on failure
     */
    public function GetResults() {
        return $this->rs;   
    }
    
    /*
     * Easily view your result set array
     */
    public function ViewResults() {
        echo "<pre>" . print_r($this->rs, TRUE) . "</pre>";
    }
    
    /*
     * Display a result set as a Table
     * Helpful: http://php.net/manual/en/function.get-object-vars.php
     * And: http://php.net/manual/en/function.array-keys.php
     * @return - An HTML Table as a string
     */
    public function ViewResultsAsTable($crud = false) {
        
        //get an array containing the keys from the first object of the result set (turned into an array)
        $keys = array_keys(get_object_vars($this->rs[0]));
        
        //set up the table
        $string = "<table class='table table-striped'>";
        
        //loop through the keys array to set up the column headings for the table
        foreach($keys as $head) {
            
            //insert the heading
            $string .= "<td class='heading'>$head</td>";
        }
        
        //if we are outputting the table for use in the crud interface
        if ($crud == true) {
            
            //add in the column headings for the update and delete columns
            $string .= "<td class='heading'>Modify</td>";
            $string .= "<td class='heading'>Remove</td>";
        }
        
        //loop through the result set array of objects
        foreach($this->rs as $row) {
            
            //save the object members into an array
            $vars = get_object_vars($row);
            
            //set up a row
            $string .= "<tr>";
            
            //loop through each object, as an array
            foreach ($vars as $item) {
                
                //output the cell value into the table
                $string .= "<td>" . $item . "</td>";
            }
            
            //if we are outputting this table for use in the crud interface
            if ($crud == true) {
                
                //add in the update and delete columns at the end of the row
                $string .= "<td><a href='guitar_shop_crud.php/?action=Updating&cust=$vars[customerID]' class='btn btn-primary'>Update</a></td>";
                $string .= "<td><a href='guitar_shop_crud.php/?action=Deleting&cust=$vars[customerID]' class='btn btn-danger'>Delete</a></td>";
                
            }
            
            //close the row
            $string .= "</tr>";
        }
        
        //close the table
        $string .= "</table>";
        
        //return the string containing the html table
        return $string;
    }
    
/** END Base Methods - Used by all other methods */

/** Category Methods - Queries on the Categories table */

    /*
     * Gets a single category based on categoryID
     * @param $category_id - The categoryID to limit the query
     */
    public function GetCategory($category_id) {
        // Setup the Query
        $this->sql = "SELECT *
                      FROM categories
                      WHERE categoryID = :category_id";
                      
        // Run the Query
        $this->RunAdvancedQuery([
            ':category_id' => $category_id,
        ]);
    }
    
    /*
     * Gets ALL category data
     */ 
    public function GetCategories() {
        // Setup the Query
        $this->sql = "SELECT *
                      FROM categories";
                  
        // Run the query 
        $this->RunBasicQuery();
    }
    
    // Will return the <options> for Categories
    public function GetCategoryOptions() {
        $return = "";
        $this->GetCategories();
        
        // Create the Options
        foreach ($this->rs as $row) {
            $return .= '<option value="' . $row->categoryID .'">'. $row->categoryName .'</option>';
        }
        
        // Return the <options>
        return $return;
    }
    
/** END Category Methods - Queries on the Categories table */

/** Product Methods - Queries on the Products table */
    
    /*
     * Gets a single product based on productID
     * @param $product_id - The productID to limit the query
     */
    public function GetProduct($product_id) {

        //set up the query
        $this->sql = "SELECT *
                      FROM products
                      WHERE productID = :product_id";
                      
        //execute the query
        $this->RunAdvancedQuery([
            ':product_id' => $product_id,
            ]);
    }
    
    /*
     * Gets ALL product data
     */
    public function GetProducts() {
        
        //set up the query
        $this->sql = "SELECT *
                      FROM products";
                      
        //execute the query
        $this->RunBasicQuery();
    }
    
    /*
     * Gets products that match a certain categoryID
     * @param $category_id - The categoryID to limit the query
     */ 
    public function GetProductsByCategory($category_id) {
        
        //set up the query
        $this->sql = "SELECT *
                      FROM products
                      WHERE categoryID = :category_id";
                      
        //execute the query
        $this->RunAdvancedQuery([
            ':category_id' => $category_id,
            ]);
    }
    
/** END Product Methods - Queries on the Products table */  
/** Customer Methods - Queries on the Customers table */

/*
     * Gets a single customer based on customerID
     * @param $customer_id - The customerID to limit the query
     */
    public function GetCustomer($customer_id) {

        //set up the query
        $this->sql = "SELECT *
                      FROM customers
                      WHERE customerID = :customer_id";
                      
        //execute the query
        $this->RunAdvancedQuery([
            ':customer_id' => $customer_id,
            ]);
    }
    
    /*
     * Gets ALL customer data
     */
    public function GetCustomers() {
        
        //set up the query
        $this->sql = "SELECT *
                      FROM customers";
                      
        //execute the query
        $this->RunBasicQuery();
    }
    
    /*
     * Adds a customer to the table
     */
     public function AddCustomer($email_address, $password, $first_name, $last_name) {
         
         //set up the query
         $this->sql = "INSERT INTO customers (emailAddress, password, firstName, lastName)
                       VALUES (:email_address, :password, :first_name, :last_name)";
                       
        //execute the query
        $this->RunAdvancedQuery([
            ':email_address' => $email_address,
            ':password'      => $password,
            ':first_name'    => $first_name,
            ':last_name'     => $last_name,
            ], true);
     }
     
     /*
      * Removes a customer from the table
      */
    public function DeleteCustomer($customer_id) {
        
        //set up the query
        $this->sql = "DELETE FROM customers
                      WHERE customerID = :customer_id";
                      
        //execute the query
        $this->RunAdvancedQuery([
            ':customer_id' => $customer_id,
            ], true);
    }
    
    /*
     * Updates a single field in the customer table
     */
     public function UpdateCustomer($customer_id, $column, $value) {
         
         //set up the query
         $this->sql = "UPDATE customers
                       SET $column = :value
                       WHERE customerID = :customer_id";
                       
        //execute the query
        $this->RunAdvancedQuery([
            ':customer_id' => $customer_id,
            ':value'       => $value,
            ], true);
     }
     
     /*
      * Searches the Customers table for rows that match first and/or last name to the provided search query
      */
      public function SearchCustomer($string) {
          
        //replace troublesome special characters with escaped versions to make them searchable
        $characters = array('/\\\/', '/\*/', '/\?/', '/\^/', '/\./', '/\+/', '/\$/', '/\|/', '/\(/', '/\)/', '/\[/', '/\]/', '/\{/', '/\}/', '/\,/');
        $replacements = array('\\\\\\', '\*', '\?', '\^', '\.',  '\+', '\$', '\|',  '\(', '\)', '\[', '\]', '\{', '\}', '\,',);
        $string = preg_replace($characters, $replacements, $string);
        
        //modify the search string for regex (replace all white space with | for use with RLIKE query)
        $search = preg_replace('/\s+/','|', $string);
          
        //set up the query
        $this->sql = "SELECT *
                      FROM customers
                      WHERE CONCAT_WS(' ', firstName, lastName) RLIKE :search";
                        
        //execute the query
        $this->RunAdvancedQuery([
            ':search' => $search,
            ]);
      }
/** END Customer Methods - Queries on the Customers table */ 
} // End GuitarShop class