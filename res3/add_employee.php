<?php 

session_start(); // Start the session.
global $employee_id;
$employee_id = 1;

// If no session value is present, redirect the user:
if (!isset($_SESSION['employee_id'])) {
	require_once ('includes/login_functions.inc.php');
	$url = absolute_url('login.php');
	header("Location: $url");
	exit();		
}
$page_title = 'Register';
include ('includes/header.php');
echo '<!-- content -->
   <div id="content">
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
               
                    <h3>Add Employee</h3>
                        
';

// Check if the form has been submitted:
if (isset($_POST['submitted'])) {

	require_once ('mysqli_connect.php'); // Connect to the db.
		
	$errors = array(); // Initialize an error array.
	
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
	
	if (empty($_POST['salary'])) {
		$errors[] = 'You forgot to enter your salary.';
	} else {
		$sal = mysqli_real_escape_string($dbc, trim($_POST['salary']));
	}

	if (empty($_POST['branch'])) {
		$errors[] = 'You forgot to enter your branch.';
	} else {
		$b = mysqli_real_escape_string($dbc, trim($_POST['branch']));
	}
	

	// Check for a password and match against the confirmed password:
	if (!empty($_POST['pass1'])) {
		if ($_POST['pass1'] != $_POST['pass2']) {
			$errors[] = 'Your password did not match the confirmed password.';
		} else {
			$p = mysqli_real_escape_string($dbc, trim($_POST['pass1']));
		}
	} else {
		$errors[] = 'You forgot to enter your password.';
	}
	
	if (empty($errors)) { // If everything's OK.
	
		// Register the user in the database...
		$pos = mysqli_real_escape_string($dbc, trim($_POST['position']));	
		// Make the query:
		$employee_id = $employee_id + 3;
		$q = "INSERT INTO employees (employee_id,first_name, last_name, email, pass,title, date_created) VALUES ('$employee_id','$fn', '$ln', '$e', '$p','$pos', NOW() )";
		$ss = "INSERT INTO salary (employee_id,amount) VALUES ('$employee_id','$sal')";
		$br = "INSERT INTO branch (employee_id,branch) VALUES ('$employee_id','$b')";	
		$r = @mysqli_query ($dbc, $q); // Run the query.
		$rs = @mysqli_query ($dbc, $ss);
		$rb = @mysqli_query ($dbc, $br); // Run the query.

		if ($r) { // If it ran OK.
		
			// Print a message:
			echo '<h1>Thank you!</h1>
		<p>You are now registered. You will actually be able to log in!</p><p><br /></p>';	
		
		} else { // If it did not run OK.
			
			// Public message:
			echo '<h1>System Error</h1>
			<p class="error">You could not be registered due to a system error. We apologize for any inconvenience.</p>'; 
			
			// Debugging message:
			echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';
						
		} // End of if ($r) IF.
		
		mysqli_close($dbc); // Close the database connection.

		// Include the footer and quit the script:
		include ('includes/footer.php'); 
		exit();
		
	} else { // Report the errors.
	
		echo '<h1>Error!</h1>
		<p class="error">The following error(s) occurred:<br />';
		foreach ($errors as $msg) { // Print each error.
			echo " - $msg<br />\n";
		}
		echo '</p><p>Please try again.</p><p><br /></p>';
		
	} // End of if (empty($errors)) IF.
	
	mysqli_close($dbc); // Close the database connection.

} // End of the main Submit conditional.
?>
<form id="contacts-form" action="add_employee.php" method="post">
                           <fieldset>

	<p>First Name: <input type="text" name="first_name" size="15" maxlength="20" value="<?php if (isset($_POST['first_name'])) echo $_POST['first_name']; ?>" /></p>
	<p>Last Name: <input type="text" name="last_name" size="15" maxlength="40" value="<?php if (isset($_POST['last_name'])) echo $_POST['last_name']; ?>" /></p>
	<p>Email Address: <input type="text" name="email" size="20" maxlength="80" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>"  /> </p>
	<p>Position: <input type="text" name="position" size="15" maxlength="40" value="<?php if (isset($_POST['position'])) echo $_POST['position']; ?>" /></p>
	<p>Salary: <input type="text" name="salary" size="15" maxlength="40" value="<?php if (isset($_POST['salary'])) echo $_POST['salary']; ?>" /></p>
	<p>Branch: <input type="text" name="branch" size="30" maxlength="40" value="<?php if (isset($_POST['branch'])) echo $_POST['branch']; ?>" /></p>
	<p>Password: <input type="password" name="pass1" size="10" maxlength="20" /></p>
	<p>Confirm Password: <input type="password" name="pass2" size="10" maxlength="20" /></p>
	<p><input type="submit" name="submit" value="Register" /></p>
	<input type="hidden" name="submitted" value="TRUE" />
</form>
</form>
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
         </div>
      </div>
   </div>";
<?php
   include ('includes/footer.php');
?>
