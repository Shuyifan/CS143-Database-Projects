<html>
	<body>
		<h1> Add New Actor or Director! </h1>
		<a href="add_actor_director.php"> add actor/director </a>
		<h3> Adding a new director or actor to the database: </h3>
		<form action="add_actor_director.php" method="GET">
		    Type: <input type="radio" name="Type" value="Actor"> Actor
		    	  <input type="radio" name="Type" value="Director"> Director
		    <br>
		    First Name: <input type="text" name="Firstname" placeholder="firstname" size=20 maxlength=20>
		    <br>
		    Last Name: <input type="text" name="Lastname" placeholder="lastname" size=20 maxlength=20>
		    <br>
		    Gender: <input type="radio" name="Gender" value="Male"> Male
		    		<input type="radio" name="Gender" value="Female"> Female
		    		<input type="radio" name="Gender" value="Trans"> Transgender
		    <br>
		    Date of Birth: <input type="text" name="dob" size=20 maxlength=10> (YYYY-MM-DD)
		    <br>
		    Date of Birth: <input type="text" name="dod" size=20 maxlength=10> (YYYY-MM-DD)
		    <br>
		    <input type="submit" value="Submit">
		</form>

	</body>
	<?php
			$db_connection = mysql_connect("localhost", "cs143", "");
			if(!$db_connection) {
			    $errmsg = mysql_error($db_connection);
			    print "Connection failed: " . $errmsg . "<br>";
			    exit(1);
			}

			$db_selected = mysql_select_db("CS143", $db_connection);
			if(!db_selected) {
				$errmsg = mysql_error($db_selected);
			    print "Unable to select the database: " . $errmsg . "<br>";
			    exit(1);
			}

			$query = "select * from MaxPersonID";
			$rs = mysql_query($query, $db_connection);
			$new_id = mysql_fetch_row($rs)[0] + 1;

			$table = $_GET["Type"];
			$sanitized_lastname = mysql_real_escape_string($_GET["Lastname"], $db_connection);
			$sanitized_firstname = mysql_real_escape_string($_GET["Firstname"], $db_connection);
			$gender = $_GET["Gender"];
			$sanitized_dob = mysql_real_escape_string($_GET["dob"], $db_connection);
			$sanitized_dod = mysql_real_escape_string($_GET["dod"], $db_connection);

			$query = "insert into $table (id, last, first, sex, dob, dod) values
						($new_id, '$sanitized_lastname', '$sanitized_firstname', 
						'$gender', '$sanitized_dob', '$sanitized_dod')";
			
			$rs = mysql_query($query, $db_connection);

			if($rs) {
				$query = "update MaxPersonID set id = $new_id";
				mysql_query($query, $db_connection);
			}
			
			mysql_close($db_connection);
		?>
</html>

