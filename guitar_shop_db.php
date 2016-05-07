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
    const DSN = 'mysql:host=localhost;dbname=guitar_shop';
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
    private function RunAdvancedQuery($named_parameter_array) {
       // Prepare the Query
       $this->stmt = $this->db->prepare($this->sql);
    
       // Run the Query in the Database, using the named parameters
       $this->stmt->execute($named_parameter_array);
       
       // Store the Number Of Rows Returned
       $this->num_rows = $this->stmt->rowCount();
        
       // Work with the results (as an array of objects)
       $this->rs = $this->stmt->fetchAll();
        
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
    public function ViewResultsAsTable() {
        
        //get an array containing the keys from the first object of the result set (turned into an array)
        $keys = array_keys(get_object_vars($this->rs[0]));
        
        //set up the table
        $string = "<table>";
        
        //loop through the keys array to set up the column headings for the table
        foreach($keys as $head) {
            
            //insert the heading
            $string .= "<td>$head</td>";
        }
        
        //loop through the result set array of objects
        foreach($this->rs as $row) {
            
            //set up a row
            $string .= "<tr>";
            
            //loop through each object, as an array
            foreach (get_object_vars($row) as $item) {
                
                //output the cell value into the table
                $string .= "<td>" . $item . "</td>";
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

    
} // End GuitarShop class