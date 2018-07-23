
<?php

include'./includes/header.php';

// Check for a valid user ID, through GET or POST:
if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { 
	$id = $_GET['id'];
} elseif ( (isset($_POST['id'])) && (is_numeric($_POST['id'])) ) { // Form submission.
	$id = $_POST['id'];
} else { // No valid ID, kill the script.
	echo '<p class="error">This page has been accessed in error.</p>';
	include ('includes/footer.php'); 
	exit();
}

require_once ('./mysqli_connect.php'); 


if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { 
	$start = $_GET['id'];
} else {
	$start = 0;
}

$raw_results = mysqli_query($dbc,"SELECT * FROM employees WHERE employee_id = $start");

if(mysqli_num_rows($raw_results) >= 0){
	while($results = mysqli_fetch_array($raw_results))
	{
		echo "<td rowspan='5'><img src='images/man.png' style='height:200px;display:block;'>";
		echo "<h3><left>".$results['first_name']."</left></h3><hr>";
		echo "<h3><left>".$results['last_name']."</left></h3><hr>";
		echo "<table><tr><td>";
		echo "<p><font style='font-weight: bold;'>Email: </font>".$results['email']." </p>";
		echo "</td>";
		echo "</td></tr>";
		echo "<tr>";
		echo "<td><p><font style='font-weight: bold;'>Job: </font>".$results['title']."</p></td></tr>";
		echo "</table>";

	}
}
$sal = mysqli_query($dbc,"SELECT * FROM salary WHERE employee_id = $start");
if(mysqli_num_rows($sal) >= 0){
	while($reslts = mysqli_fetch_array($sal)){
		echo "<table><tr><td>";
		echo "<p><font style='font-weight: bold;'>Salary: </font>".$reslts['amount']." </p>";
	}
 
}
$bran = mysqli_query($dbc,"SELECT * FROM branch WHERE employee_id = $start");
if(mysqli_num_rows($sal) >= 0){
	while($resslts = mysqli_fetch_array($bran)){
		echo "<p><font style='font-weight: bold;'>Branch: </font>".$resslts['branch']." </p>";
	}
 
}




include'./includes/footer.php';
?>