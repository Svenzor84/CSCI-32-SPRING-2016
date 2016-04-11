<!DOCTYPE html>

<!--
 - Name        : welcome.php
 - Author      : Steve Ross-Byers
 - Description : Thank the user for signing up by referring to their specific info
 -->

<html lang="en-us">

<head>
    <title>
        <?=$_POST[name_f]?> Joined!!! </title>
    <meta charset="utf-8" />
    <meta name="author" content="Steve Ross-Byers" />
    <meta name="description" content="" />
    <meta name="keyword" content="" />
    <link rel="icon" href="" />

    <!-- Bootstrap CSS link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="jumbotron">
            <h1 style="text-align: center"> Thanks <?=$_POST[name_f]?>, for joining our cause!</h1>
            <p class="lead" style="text-indent: 3em">We are very grateful that on this date,
                <?=date('l M jS, Y')?> at
                    <?=date('h:m:s A')?>, the paragon of the
                        <?=$_POST[name_l]?> family became a part of our organization! We promise not to tell anyone that your password is
                            <?=$_POST[password]?>, honest. Ok, now just let me sign up
                                <?=$_POST[email]?> for every spam list on the internet...done. Now, since I have already confused you by calling us both a cause and an organization, let me tell you where your local branch is based on your Zip Code...</p>
            <div class="container" style="border: 2px solid purple; padding: 2em">
                <div class="col-md-5 col-md-offset-1">
                    <p style="text-align: center">You entered the Zip Code
                        <?=$_POST[zipCode]?>, is that correct? Of course it is. You can't answer me, by the way.</p>
                </div>
                <div class="col-md-5">
                    <?php 
                        if ($_POST[zipCode] == 95966 || $_POST[zipCode] == 95965 || $_POST[zipCode] == 95926 || $_POST[zipCode] == 95927 || $_POST[zipCode] == 95929 || $_POST[zipCode] == 95973 || $_POST[zipCode] == 95976) {
                            echo "<p style=\"text-align: center\">That is a Butte County zip code.  Your local branch is in Paradise.  Or Magalia.  I am really not sure.</p>";
                        } else if ($_POST[zipCode] == 95501 || $_POST[zipCode] == 95502 || $_POST[zipCode] == 95503 || $_POST[zipCode] == 95518 || $_POST[zipCode] == 95521 || $_POST[zipCode] == 95519) {
                            echo "<p style=\"text-align: center\">That is a Humboldt County zip code.  Nice.  Your local branch is in Arcata, just down the street from the Co Op.  Mmmmm, Sun Buns.";
                        } else {
                            echo "<p style=\"text-align: center\">I am not familiar with your zip code. Sucks to be you.  Who knows if you even have a local branch.  Good luck getting support. I recommend moving to Butte or Humboldt County.";
                        }
                    ?>

                </div>
            </div>
            <div class="container">
                <div class="col-md-10 col-md-offset-1">
                    <p style="padding: 1.5em">Alright, let us see if we can abuse any of the other information you gave us...</p>
                </div>
            </div>
            <div class="container" style="border: 2px solid green; padding: 2em">
                <div class="col-md-6">
                    <?php
                        if ($_POST[website] != "") {
                            echo "<p style=\"text-align: center\">You chose $_POST[website] as your favorite site of all time.</p>";
                        } else {
                            echo "<p style=\"text-align: center\">You chose not to tell us about your favorite site.  Psshhhhhttt.</p>";
                        }
                    ?>
                </div>
                <div class="col-md-6">
                    <?php
                        if ($_POST[website] != "") {
                            if ($_POST[website] == "www.google.com" || $_POST[website] == "http://www.google.com" || $_POST[website] == "google.com") {
                                echo "<p style=\"text-align: center\">Google, eh?  Good choice.  Really, it is the only choice.  Keep up the good work.</p>";
                            } else {
                                echo "<p style=\"text-align: center\">Ya know, there are a lot better sites to choose.  Like Google.  Google is awesome.  It is also a verb. You are welcome.";
                            }
                        } else {
                            echo "<p style=\"text-align: center\">What, like you have something better to do than to share some info with your good buddies?  You are the one that signed up, bro, seriously.</p>";
                        }
                    ?>
                </div>
            </div>
            <div class="container" style="border: 2px solid blue; padding: 2em; margin-top: 0.5em">
                <div class="col-md-10 col-md-offset-1">
                    <?php
                        if ($_POST[address] != "") {
                            echo "<p style=\"text-align: center\">Our webmaster just called 911 and a couple of police officers are on their way to $_POST[address] right now.  Isn't this fun?</p>";
                        } else {
                            echo "<p style=\"text-align: center\">You don't even trust us with your home address?  You are way too paranoid, it is not like we were going to call the cops on you...</p>";
                        }
                    ?>
                </div>
            </div>
            <div class="container" style="border: 2px solid red; padding: 2em; margin-top: 0.5em">
                <div class="col-md-5 col-md-offset-1">
                    <?php
                        if($_POST[city] != "") {
                            if($_POST[state] != "") {
                                echo "<p style=\"text-align: center\">You told us that you live in $_POST[city], $_POST[state]. Very Trusting of you!</p>";
                            } else {
                                echo "<p style=\"text-align: center\">You told us you live in $_POST[city], but you didn't say which state! There are a lot of $_POST[city]s out there...</p>";
                            }
                        } else {
                            if($_POST[state] != "") {
                                echo "<p style=\"text-align: center\">You told us that you live in $_POST[state], but you didn't say which city! Whew, $_POST[state] is a big place...</p>";
                            } else {
                                echo "<p style=\"text-align: center\">You didnt give us your home city OR state? What is the deal?  How are we supposed to find you now?</p>";
                            }
                        }
                    ?>
                </div>
                <div class="col-md-5">
                    <p style="text-align: center">You do realize that since we require your Zip Code, so we don't need any of this other info to track you down, right? Good. As long as we are on the same page.</p>
                </div>
            </div>
            <div class="container" style="margin-top: 1em">
                <div class="col-md-10 col-md-offset-1">
                    <?php
                        if ($_POST[agree] == "on") {
                            echo "<p style=\"text-align: center\">Thank you so much for agreeing to our Terms of Service, even though they do not technically exist yet.  When we get them written up we promise to update you on what you signed up for. Thank you again for supporting us!</p>";
                        } else {
                            echo "<p style=\"text-align: center\">Ummmm, how exactly did you get here? You are required to accept our non-existent Terms so sign up.  I get it, you are a magician.  Well, well, good for you!</p>";
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <!-- JQuery and BootStrap libraries -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</body>

</html>