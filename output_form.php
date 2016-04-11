<!DOCTYPE html>
<html lang="en-us">
<!--
 - Name        : output_form.php
 - Author      : Luke Sathrum
 - Description : Outputs a form sent via POST
 -->
	<head>
		<title>Form Output</title>
		<meta charset="utf-8" />
		<!-- Pure CSS Framework -->
		<link rel="stylesheet" href="//cdn.rawgit.com/yahoo/pure-release/v0.6.0/pure-min.css">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
	</head>
	<body>
		<table class="pure-table pure-table-striped">
			<thead>
				<tr>
		            <th>Input Name</th>
		            <th>Input Value</th>
        		</tr>
			</thead>
			<tbody>
		<?php foreach ($_POST as $key => $value): ?>
		        <tr>
		        	<td><?=$key?></td>
		        	<td><?=$value?></td>
		        </tr>
		<?php endforeach; ?>
			</tbody>
		</table>
	</body>
</html>