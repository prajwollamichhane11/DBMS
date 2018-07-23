<?php 

session_start(); // Start the session.

// If no session value is present, redirect the user:
if (!isset($_SESSION['employee_id'])) {
	require_once ('includes/login_functions.inc.php');
	$url = absolute_url('login.php');
	header("Location: $url");
	exit();		
}
$page_title = 'Edit a User';
include ('includes/header.php');
echo '<div id="content">
      <div class="container">
         <div class="inside">
            <!-- box begin -->
            <div class="box alt">
            	<div class="left-top-corner">
               	<div class="right-top-corner">
                  	<div class="border-top"></div>
                  </div>
               </div>
               <div class="border-left">
               	<div class="border-right">
                  	<div class="inner">
                     	<div class="wrapper">
<h3>Edit Employees</h3>';


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
		echo "<p><font style='font-weight: bold;'>Email: </font>".$results['email']." years</p>";
		echo "</td>";
		echo "</td></tr>";
		echo "<tr>";
		echo "<td><p><font style='font-weight: bold;'>Job: </font>".$results['title']."</p></td></tr>";
		echo "</table>";

	}
}



// Check if the form has been submitted:
if (isset($_POST['submitted'])) {

	$errors = array();
	
	// Check for a first name:
	if (empty($_POST['first_name'])) {
		$errors[] = 'You forgot to enter your first name.';
	} else {
		$fn = mysqli_real_escape_string($dbc, trim($_POST['first_name']));
	}
	
	// Check for a last name:
	if (empty($_POST['last_name'])) {
		$errors[] = 'You forgot to enter your last name.';
	} else {
		$ln = mysqli_real_escape_string($dbc, trim($_POST['last_name']));
	}
	
	// Check for an email address:
	if (empty($_POST['email'])) {
		$errors[] = 'You forgot to enter your email address.';
	} else {
		$e = mysqli_real_escape_string($dbc, trim($_POST['email']));
	}

		// Check for an email address:
	if (empty($_POST['pass'])) {
		$errors[] = 'You forgot to enter your password.';
	} else {
		$p = mysqli_real_escape_string($dbc, trim($_POST['pass']));
	}
	
	if (empty($errors)) { // If everything's OK.
	
		//  Test for unique email address:
		$q = "SELECT * FROM employees WHERE email='$e' AND employee_id != $id";
		$r = @mysqli_query($dbc, $q);
		if (mysqli_num_rows($r) == 0) {

			// Make the query:
			$q = "UPDATE employees SET first_name='$fn', last_name='$ln', email='$e', pass=SHA1('$p') WHERE employee_id=$id LIMIT 1";
			$r = @mysqli_query ($dbc, $q);
			if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.
			
				// Print a message:
				echo '<p>The employee has been edited.</p>';	
							
			} else { // If it did not run OK.
				echo '<p class="error">The user could not be edited due to a system error. We apologize for any inconvenience.</p>'; // Public message.
				echo '<p>' . mysqli_error($dbc) . '<br />Query: ' . $q . '</p>'; // Debugging message.
			}
				
		} else { // Already registered.
			echo '<p class="error">The email address has already been registered.</p>';
		}
		
	} else { // Report the errors.
	
		echo '<p class="error">The following error(s) occurred:<br />';
		foreach ($errors as $msg) { // Print each error.
			echo " - $msg<br />\n";
		}
		echo '</p><p>Please try again.</p>';
		
	} // End of if (empty($errors)) IF.

} // End of submit conditional.


if (isset($_POST['del_user']))
{

	$e = mysqli_real_escape_string($dbc, trim($_POST['email']));
	//  Test for unique email address:
		$quer = "SELECT * FROM employees WHERE email='$e' AND employee_id != $id";
		$res = @mysqli_query($dbc, $quer);
		if (mysqli_num_rows($res) == 0) {

			// Make the query:
			$quer = "DELETE from employees WHERE employee_id=$start LIMIT 1";
			$res = @mysqli_query ($dbc, $quer);
			if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.
			
				// Print a message:
				echo '<p>The employee has been deleted.</p>';
				exit();	
							
			} 
		}
		
		
}

// Always show the form...
// Retrieve the user's information:
$q = "SELECT * FROM employees WHERE employee_id=$id";		
$r = @mysqli_query ($dbc, $q);

if (mysqli_num_rows($r) == 1) { // Valid user ID, show the form.

	// Get the user's information:
	$row = mysqli_fetch_array ($r, MYSQLI_ASSOC);
	 //pass=SHA1('$p')
	// Create the form:
	echo '<form action="edit_employee.php" method="post">
<p>First Name: <input type="text" name="first_name" size="15" maxlength="15" value="' . $row['first_name'] . '" /></p>
<p>Last Name: <input type="text" name="last_name" size="15" maxlength="30" value="' . $row['last_name'] . '" /></p>
<p>Email Address: <input type="text" name="email" size="20" maxlength="40" value="' . $row['email'] . '"  /> </p>
<p>Password: <input type="password" name="pass" size="20" maxlength="40" value="' . $row['pass'] . '"  /> </p>
<p> <a href="employees.php"> Return to all employees
</a> * <a href="edit_employee.php?id=' . $row['employee_id'] . '">
<a href="logout.php"> LogOut </a></p>
<p><input type="submit" name="submit" value="update" /></p>
<input type="hidden" name="submitted" value="TRUE" />
<input type="hidden" name="id" value="' . $id . '" />
</form>';

}

mysqli_close($dbc);
echo '                        	<dl class="special fright">
                           	</div>
                     </div>
                  </div>
               </div>
               <div class="left-bot-corner">
               	<div class="right-bot-corner">
                  	<div class="border-bot"></div>
                  </div>
               </div>
            </div>
            <!-- box end -->
	
<!--Recent articles list ends -->	 
 </div>
      </div>
   </div>';
		
include ('includes/footer.php');
?>
