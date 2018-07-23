<?php

include ('includes/header.php');
require_once ('mysqli_connect.php');

if (isset($_POST['submitted'])) { // Handle the form.
	
	// Validate the incoming data...
	$errors = array();

	// Check for a food name:
	if (!empty($_POST['foodname'])) {
		$foodname = trim($_POST['foodname']);
	} else {
		$errors[] = 'Please enter the foodname!';
	}

	if (!empty($_POST['price'])) {
		$price = trim($_POST['price']);
	} else {
		$errors[] = 'Please enter the foodprice!';
	}
	
	$d = (!empty($_POST['description'])) ? trim($_POST['description']) : NULL;
	$foodtype = trim($_POST['foodtype']);


	if (empty($errors)) { // If everything's OK.
	
		
		// Make the query:
		$q = "INSERT INTO food (food_name, food_type, food_description, food_price) VALUES ('$foodname', '$foodtype', '$d', '$price')";		
		$r = @mysqli_query ($dbc, $q); // Run the query.
		if ($r) { // If it ran OK.
		
			// Print a message:
			echo '<h1>Congratulations!</h1>
		<p>You have added anew fooditem to the menu.</p><p><br /></p>';	
		
		} else { // If it did not run OK.
			
			// Public message:
			echo '<h1>System Error</h1>
			<p class="error">You request could not be completed due to a system error. We apologize for any inconvenience.</p>'; 
			
			// Debugging message:
			echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';
						
		} // End of if ($r) IF.
		
		mysqli_close($dbc); // Close the database connection.

		// Include the footer and quit the script:
		//include ('includes/footer.php'); 
		include ('includes/footer.php'); 
		exit();
		
	}
}


?>


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
<h4>Add an Item to Menu</h4> <br />
<form id="contacts-forms" action="add_menu.php" method="post">

	<fieldset><legend>Fill out the form to add an item to to the catalog:</legend>
	
	
	
	 <p> Food item:<input type="text" name="foodname" size="30" maxlength="60"></p>
	<p><select name="foodtype">
<option value="drinks">Drinks</option>
<option value="solidfood">Solid food</option>
</select><p>
	 <p> Price : <input type="text" name="price" size="30" maxlength="60"></p>
	
	<p><b>Description:</b> <textarea name="description" cols="40" rows="5"><?php if (isset($_POST['description'])) echo $_POST['description']; ?></textarea> (optional)</p>
	
	</fieldset>
		
	<div align="center"><input type="submit" name="submit" value="Submit" /></div>
	<input type="hidden" name="submitted" value="TRUE" />

</form>
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
            </div></div>
<?php
 include ('includes/footer.php');
?>