<?php
/**
* Filename:     test.php
* Description:  Testing for the functions declared in library.php
* Author:       Steve Ross-Byers
*/
?>

<html lang="en-us">

  <head>
    <title> Test </title>
    <meta charset="utf-8" />
    <meta name="author" content="Steve Ross-Byers" />

  </head>

  <body>

    <?php
     // Include library.php
     require 'library.php';
    ?>
   <?php
   
      echo "<h3>-Testing Factor List Function [factor()]-</h3>";
   
      $factorList = 10;
      echo "The factors for $factorList are: ";
      factors($factorList);
      
      $factorList = 15;
      echo "The factors for $factorList are: ";
      factors($factorList);
      
      $factorList = 100;
      echo "The factors for $factorList are: ";
      factors($factorList);
      
      echo "<h3>-Testing Prime Check Function [prime()]-</h3>";
      
      $primeCheck = 1;
      if (prime($primeCheck) === true) {
        echo "$primeCheck is a prime number!";
      } else {
        echo "$primeCheck is not a prime number.";
      }
      
      echo "<br >";
      $primeCheck = 2;
      if (prime($primeCheck) === true) {
        echo "$primeCheck is a prime number!";
      } else {
        echo "$primeCheck is not a prime number.";
      }
      
      echo "<br >";
      
      $primeCheck = 3;
      if (prime($primeCheck) === true) {
        echo "$primeCheck is a prime number!";
      } else {
        echo "$primeCheck is not a prime number.";
      }
      
      echo "<br >";
      
      $primeCheck = 4;
      if (prime($primeCheck) === true) {
        echo "$primeCheck is a prime number!";
      } else {
        echo "$primeCheck is not a prime number.";
      }
           
      echo "<br >";
      
      $primeCheck = 5;
      if (prime($primeCheck) === true) {
        echo "$primeCheck is a prime number!";
      } else {
        echo "$primeCheck is not a prime number.";
      }
           
      echo "<br >";
      
      $primeCheck = 6;
      if (prime($primeCheck) === true) {
        echo "$primeCheck is a prime number!";
      } else {
        echo "$primeCheck is not a prime number.";
      }
           
      echo "<br >";
      $primeCheck = 7;
      if (prime($primeCheck) === true) {
        echo "$primeCheck is a prime number!";
      } else {
        echo "$primeCheck is not a prime number.";
      }
      
      echo "<br >";
      $primeCheck = 8;
      if (prime($primeCheck) === true) {
        echo "$primeCheck is a prime number!";
      } else {
        echo "$primeCheck is not a prime number.";
      }
      
      echo "<br >";
      
      $primeCheck = 9;
      if (prime($primeCheck) === true) {
        echo "$primeCheck is a prime number!";
      } else {
        echo "$primeCheck is not a prime number.";
      }
      
      echo "<br >";
      
      $primeCheck = 10;
      if (prime($primeCheck) === true) {
        echo "$primeCheck is a prime number!";
      } else {
        echo "$primeCheck is not a prime number.";
      }
           
      echo "<br >";
      $primeCheck = 11;
      if (prime($primeCheck) === true) {
        echo "$primeCheck is a prime number!";
      } else {
        echo "$primeCheck is not a prime number.";
      }
      
      echo "<br >";
      
      $primeCheck = 155;
      if (prime($primeCheck) === true) {
        echo "$primeCheck is a prime number!";
      } else {
        echo "$primeCheck is not a prime number.";
      }
                
      echo "<br >";
      
      $primeCheck = 157;
      if (prime($primeCheck) === true) {
        echo "$primeCheck is a prime number!";
      } else {
        echo "$primeCheck is not a prime number.";
      }
            
      echo "<br >";
      
      $primeCheck = 20543;
      if (prime($primeCheck) === true) {
        echo "$primeCheck is a prime number!";
      } else {
        echo "$primeCheck is not a prime number.";
      }
           
      echo "<br > <br >";
      
      echo "<h3>-Testing Reverse String Function [reverse()]-</h3>";
      
      $string = "Hello!";
      echo "Before: $string <br >";
      reverse($string);
      echo "After: $string <br > <br >";
      
      $string = "How goes it?";
      echo "Before: $string <br >";
      reverse($string);
      echo "After: $string <br > <br >";
      
      $string = "This function is pretty fun";
      echo "Before: $string <br >";
      reverse($string);
      echo "After: $string <br > <br >";
      
      $string = "!sracecar evird ot evol I";
      echo "Before: $string <br >";
      reverse($string);
      echo "After: $string <br > <br >";
      
      $string = "!stnaiG oG";
      echo "Before: $string <br >";
      reverse($string);
      echo "After: $string <br > <br >";
      
      echo "<h3>-Testing Random Length String Function [random_string()]-</h3>";
      
      $length = 1;
      echo "Length $length: " . random_string($length) . "<br >";
      
      $length = 2;
      echo "Length $length: " . random_string($length) . "<br >";
      
       $length = 3;
      echo "Length $length: " . random_string($length) . "<br >";
      
      $length = 4;
      echo "Length $length: " . random_string($length) . "<br >";
      
      $length = 5;
      echo "Length $length: " . random_string($length) . "<br >";
      
      $length = 6;
      echo "Length $length: " . random_string($length) . "<br >";
      
      $length = 7;
      echo "Length $length: " . random_string($length) . "<br >";
      
      $length = 8;
      echo "Length $length: " . random_string($length) . "<br >";
      
      $length = 9;
      echo "Length $length: " . random_string($length) . "<br >";
      
      $length = 10;
      echo "Length $length: " . random_string($length) . "<br >";
      
      $length = 15;
      echo "Length $length: " . random_string($length) . "<br >";
      
      echo "<h3>-Testing Argument List Function [ul()]-</h3>";
      
      ul(1, 2, 3, 4, 5, 6, 7, 8, 9, 10);
      ul("these", "are", "all", "of", "the", "arguments", "passed", "into", "the", "function");
      ul("this", "function", "was", "passed", 7, "(7)", "arguments");
      
      echo "<h3>-Testing URL Output Function [anchor()]-</h3>";
      
      anchor("http://www.google.com");
      echo "<br >";
      var_dump(anchor("http://www.google.com", true));
      echo "<br > <br >";
      
      anchor("http://www.sfGiants.com");
      echo "<br >";
      var_dump(anchor("http://www.sfGiants.com", true));
      echo "<br > <br >";
      
      anchor("http://www.butte.edu");
      echo "<br >";
      var_dump(anchor("http://www.butte.edu", true));
      echo "<br > <br >";
      
      anchor("http://www.myspace.edu");
      echo "<br >";
      var_dump(anchor("http://www.myspace.edu", true));
      echo "<br > <br >";
      
      anchor("this one isn't a url");
      echo "<br >";
      var_dump(anchor("this one isn't a url", true));
      echo "<br > <br >";
    ?>
  </body>
  
</html>
