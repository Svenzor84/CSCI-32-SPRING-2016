<?php
/**
* Filename:     library.php
* Description:  A library of functions, written in php
* Author:       Steve Ross-Byers 
*/
?>
<?php
/*
 * Function Name:   factors()
 * Description:     Outputs an unordered list containing all factors for the integer arument
 * Parameters:      $value - the value for which all factors are displayed
 * Returns:         nothing
 */
function factors($value) {
  echo "<ul>";
  for ($i = $value; $i > 0; $i--) {
    if ($value % $i === 0) {
      echo "<li> $i </li>";
    }
  }
  echo "</ul>";
}

/*
 * Function Name:   prime()
 * Description:     Determines if the argument passed into the function is a prime number
 * Parameters:      $value - the value to be checked for prime status
 * Returns:         $prime - a boolean that is true for a prime number, or false otherwise
 */
function prime($value) {
  $prime = true;
  for ($i = ($value - 1); $i > 1; $i--) {
    if ($value % $i === 0) {
      $prime = false;
    }
  }
  if ($value === 1) {
    $prime = false;
  }
  return $prime;
}

/*
 * Function Name:   reverse()
 * Description:     Reverses the order of the characters in a string
 * Parameters:      &$string - the string to be reversed (passed by reference, so the original string is altered)
 * Returns:         nothing
 */
function reverse(&$string) {
  $string = strrev($string);
}

/*
 * Function Name:   random_string()
 * Description:     Generates a string of random length, containing only alphanumeric characters (upper and lower case)
 * Parameters:      $length - the length of the string to be returned
 * Returns:         $string - the string of requested length
 */
function random_string($length) {
  $letters = "AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz0123456789";
  $string = "";
  while (strlen($string) < $length) {
    $string = $string . substr($letters, mt_rand(0,(strlen($letters) - 1)), 1);
  }
  return $string;
}

/*
 * Function Name:   ul()
 * Description:     Outputs each argument as an item in an unordered list
 * Parameters:      nothing
 * Returns:         nothing
 */
function ul() {
  $arguments = func_get_args();
  echo "<ul>";
  foreach ($arguments as $arg) {
    echo "<li>$arg</li>";
  }
  echo "</ul>";
}

/*
 * Function Name:   anchor()
 * Description:     Outputs an anchor <a> tag with an href attribute value equal to the first argument (url)[default], or returns the first argument if the second argument is [TRUE]
 * Parameters:      $url - the value to be inserted as the href attribute of the anchor tag
                    [$return] - an optional parameter, returns the anchor instead
 * Returns:         nothing[default], or the anchor if the optional second parameter is set to true
 */
function anchor($url, $return = false) {
  $anchor = "<a href=\"$url\">$url<a>";
  if ($return === false) {
    echo $anchor;
  } else {
    return $anchor;
  }
}

?>