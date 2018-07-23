
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