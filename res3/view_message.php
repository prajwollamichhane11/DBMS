<?php 

session_start(); // Start the session.

// If no session value is present, redirect the user:
if (!isset($_SESSION['employee_id'])) {
	require_once ('includes/login_functions.inc.php');
	$url = absolute_url('login.php');
	header("Location: $url");
	exit();		
}
$page_title = 'Welcome to KU Resturant| View Messages';
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
<h3>Messages View</h3>';

// Check for a valid user ID, through GET or POST:
if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { // From view_users.php
	$id = $_GET['id'];
} elseif ( (isset($_POST['id'])) && (is_numeric($_POST['id'])) ) { // Form submission.
	$id = $_POST['id'];
} else { // No valid ID, kill the script.
	echo '<p class="error">This page has been accessed in error.</p>';
	include ('includes/footer.php'); 
	exit();
}

require_once ('./mysqli_connect.php'); 

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
	
	if (empty($errors)) { // If everything's OK.
	
		//  Test for unique email address:
		$q = "SELECT contact_id FROM contactus WHERE email='$e' AND contact_id != $id";
		$r = @mysqli_query($dbc, $q);
		if (mysqli_num_rows($r) == 0) {

			// Make the query:
			$q = "UPDATE contactus SET first_name='$fn', last_name='$ln', email='$e' WHERE contact_id=$id LIMIT 1";
			$r = @mysqli_query ($dbc, $q);
			if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.
			
				// Print a message:
				echo '<p>The message has been edited.</p>';	
							
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

// Always show the form...

// Retrieve the user's information:
$q = "SELECT first_name, last_name, email, message, contact_id FROM contactus WHERE contact_id=$id";		
$r = @mysqli_query ($dbc, $q);

if (mysqli_num_rows($r) == 1) { // Valid user ID, show the form.

	// Get the user's information:
	$row = mysqli_fetch_array ($r, MYSQLI_ASSOC	);
	
	// Create the form:
	echo '<form action="delete_message.php" method="post">
<p><b>First Name:</b> ' . $row['first_name'] . '</p>
<p><b>Last Name:</b> ' . $row['last_name'] . ' </p>
<p><b>Email Address:</b> ' . $row['email'] . ' </p>
<p><b>Message:</b> ' . $row['message'] . '</p>
<div></div>
<p> <a href="messages.php"> Return to Inbox
</a> * <a href="delete_message.php?id=' . $row['contact_id'] . '">Delete</a> * 	
<a href="logout.php"> LogOut </a></p>
<input type="hidden" name="submitted" value="TRUE" />
<input type="hidden" name="id" value="' . $id . '" />
</form>';

} else { // Not a valid user ID.

	echo '<p class="error">This page has been accessed in error.</p>';
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
   </div>
';	
		
include ('includes/footer.php');
?>
