<?php 


/* This function determines and returns an absolute URL.
 * It takes one argument: the page that concludes the URL.
 * The argument defaults to index.php.
 */
function absolute_url ($page = 'index.php') {

	// Start defining the URL...
	// URL is http:// plus the host name plus the current directory:
	$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
	
	// Remove any trailing slashes:
	$url = rtrim($url, '/\\');
	
	// Add the page:
	$url .= '/' . $page;
	
	// Return the URL:
	return $url;

} // End of absolute_url() function.


/* This function validates the form data (the email address and password).
 * If both are present, the database is queried.
 * The function requires a database connection.
 * The function returns an array of information, including:
 * - a TRUE/FALSE variable indicating success
 * - an array of either errors or the database result
 */
function check_login($dbc, $email = '', $pass = '') {

	$errors = array(); // Initialize error array.
	
	// Validate the email address:
	if (empty($email)) {
		$errors[] = 'You forgot to enter your email address.';
	} else {
		$e = mysqli_real_escape_string($dbc, trim($email));
	}
	
	// Validate the password:
	if (empty($pass)) {
		$errors[] = 'You forgot to enter your password.';
	} else {
		$p = mysqli_real_escape_string($dbc, trim($pass));
	}

	if (empty($errors)) { // If everything's OK.

		// Retrieve the user_id and first_name for that email/password combination:
		$q = "SELECT employee_id, first_name FROM employees WHERE email='$e' AND pass=('$p')";		
		$r = @mysqli_query ($dbc, $q); // Run the query.

		$qa = "SELECT artist_id FROM artists WHERE email='$e' AND password=('$p')";		
		$ra = @mysqli_query ($dbc, $qa); // Run the query.

		// Check the result:
		if (mysqli_num_rows($r) == 1){
		
			// Fetch the record:
			$row = mysqli_fetch_array ($r, MYSQLI_ASSOC);
			
			// Return true and the record:
			return array(true, $row);
			
		}
		else if(mysqli_num_rows($ra) == 1) {

			$row1 = mysqli_fetch_array ($ra, MYSQLI_ASSOC);
				return array(true, $row1);
		}
	
		else { // Not a match!
			$errors[] = 'The email address and password entered do not match those on file.';
		}
		
	}// End of empty($errors) IF.
	
else {	// Return false and the errors:
	return array(false, $errors);

} // End of check_login() function.
}
?>
