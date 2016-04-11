<?php
  echo "<!DOCTYPE html>\n";
  echo "<!--\n
         - Name: $_POST[filename] \n
         - Author: $_POST[author] \n
         - Description: $_POST[descrip] \n
         --> \n";
  echo "<html lang=\"$_POST[lang]\">\n";
  echo "<head>\n
        <title>$_POST[title]</title>\n
        <meta charset=\"utf-8\" />\n
        <link rel=\"stylesheet\" href=\"$_POST[url]\" />\n
        </head>\n";
  echo "<body>\n
        <section>\n
        <h1>$_POST[heading]</h1> \n
        <ul> \n
        <li>$_POST[list1]</li> \n
        <li>$_POST[list2]</li> \n
        <li>$_POST[list3]</li> \n
        </ul> \n
        </section> \n";
  echo "<footer> \n
        <p>&copy; " . date(Y) . " $_POST[copy] </p> \n
        </footer> \n
        </body> \n
        </html> \n";