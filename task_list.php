<!DOCTYPE html>

<!--
 - Name        : task_list.php
 - Author      : Steve Ross-Byers
 - Description : An interactive list for tasks, written in php and html
 -->

<html lang="en-us">

    <head>
        <title> Tasks! </title>
        <meta charset="utf-8" />
        <meta name="author" content="Steve Ross-Byers" />
        <meta name="description" content="Interactive task list" />
        <meta name="keyword" content="tasks, lists, php" />
        
        <!-- Bootstrap CSS link -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="style.css" >
    </head>

    <body>
        
        <?php if ($_POST) {
            if ($_POST['action'] === "Sort") {
                array_pop($_POST['task_list']);
                sort($_POST['task_list'], SORT_FLAG_CASE | SORT_NATURAL);
            }
            if ($_POST['action'] === "Remove") {
                array_pop($_POST['task_list']);
                array_shift($_POST['task_list']);
            }
            if ($_POST['action'] === "Add") {
                if ($_POST['task_list'][count($_POST['task_list']) - 1] === "") {
                    array_pop($_POST['task_list']);
                } else {
                    array_unshift($_POST['task_list'], $_POST['task_list'][count($_POST['task_list']) - 1]);
                    array_pop($_POST['task_list']);
                }
            }
            if ($_POST['action'] === "Delete") {
                array_pop($_POST['task_list']);
                $index = array_search($_POST['Select'], $_POST['task_list']);
                unset($_POST['task_list'][$index]);
                array_values($_POST['task_list']);
            }
            if ($_POST['action'] === "Edit") {
                array_pop($_POST['task_list']);
            }
            if ($_POST['action'] === "Modify") {
                $index = array_search($_POST['Select'], $_POST['task_list']);
                $_POST['task_list'][$index] = $_POST['Modified'];
            }
            if ($_POST['action'] === "Promote") {
                array_pop($_POST['task_list']);
                $temp_array = $_POST['task_list'];
                $index = array_search($_POST['Select'], $_POST['task_list']);
                if ($index === 0) {
                    
                } else {
                    $temp_array[$index] = $temp_array[$index - 1];
                    $temp_array[$index - 1] = $_POST['task_list'][$index];
                    $_POST['task_list'] = $temp_array;
                }
            }
            if ($_POST['action'] === "Demote") {
                array_pop($_POST['task_list']);
                $temp_array = $_POST['task_list'];
                $index = array_search($_POST['Select'], $_POST['task_list']);
                if ($index === count($_POST['task_list']) - 1) {
                    
                } else {
                    $temp_array[$index] = $temp_array[$index + 1];
                    $temp_array[$index + 1] = $_POST['task_list'][$index];
                    $_POST['task_list'] = $temp_array;
                }
            }
            if ($_POST['action'] === "Reset") {
                unset($_POST['task_list']);
            }
        } ?>
        <div class="container">
            <div class="jumbotron">
                <h2>Task List</h2>
                <?php if (is_array($_POST['task_list']) && count($_POST['task_list']) > 0) { 
                    echo "<ol>";
                    foreach($_POST['task_list'] as $task): ?>
                        <li><?=$task?></li>
                    <?php endforeach;
                    echo "</ol>";
                } else { ?>
                    <p class="lead">The List is Empty!</p>
                <?php } ?>
                <h3 class="heading">Modify List</h3>
                <form method="post" action="task_list.php" class="form-inline">
                    <?php if (is_array($_POST['task_list'])) {
                        foreach($_POST['task_list'] as $task): ?>
                            <input type="hidden" name="task_list[]" value="<?=$task?>">
                        <?php endforeach;
                    } 
                    if ($_POST['action'] === "Edit") {
                        
                    } else { ?>
                    <div class="form-group">
                        <input type="submit" name="action" value="Add" class="btn btn-success col-md-3">
                        <div class="col-md-4">
                            <input type="text" name="task_list[]" placeholder="Enter New Task Name" class="form-control">
                        </div>
                    </div>
                    <?php } ?>
                    <div class="form-group">
                        <?php if (count($_POST['task_list']) > 0) { ?>
                            
                            <?php if ($_POST['action'] === "Edit") { ?>
                                <input type="hidden" name="Select" value="<?=$_POST['Select']?>">
                                <div class="form-group">
                                    <input type="submit" name="action" value="Modify" class="btn btn-danger col-md-3">
                                    <div class="col-md-3">
                                        <input type="text" name="Modified" placeholder="Enter Modified Task" class="form-control">
                                    </div>
                                </div>
                            <?php } else { ?>
                                <input type="submit" name="action" value="Remove" class="btn btn-info">
                                <input type="submit" name="action" value="Sort" class="btn btn-info">
                                <input type="submit" name="action" value="Reset" class="btn btn-info">
                    </div>
                    <div class="form-group">
                                <select name="Select" class="btn btn-default">
                                    <?php foreach($_POST['task_list'] as $task): ?>
                                        <option><?=$task?></option>
                                    <?php endforeach; ?>
                                </select>
                                <input type="submit" name="action" value="Delete" class="btn btn-warning">
                                <input type="submit" name="action" value="Edit" class="btn btn-warning">
                                <input type="submit" name="action" value="Promote" class="btn btn-warning">
                                <input type="submit" name="action" value="Demote" class="btn btn-warning">
                            <?php } 
                        } ?>
                    </div>
                </form>
            </div>
        </div>
        
        <!--Bootstrap and JQuery libraries-->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    </body>

</html>