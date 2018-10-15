<?php
	//checking connection and connecting to a database
	require_once('connection/config.php');
	//Connect to mysqli server
	$link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD);
	if(!$link) {
		die('Failed to connect to server: ' . mysqli_error());
	}

	//Select database
	$db = mysqli_select_db($link,DB_DATABASE);
	if(!$db) {
		die("Unable to select database");
	}

 //Function to sanitize values received from the form. Prevents SQL injection
	function clean($str) {
		$str = @trim($str);
		if(get_magic_quotes_gpc()) {
			$str = stripslashes($str);
		}
		return mysqli_real_escape_string($str);
	}

	//Sanitize the POST values
	$OldPassword = clean($_POST['opassword']);
	$NewPassword = clean($_POST['npassword']);
	$ConfirmNewPassword = clean($_POST['cpassword']);

     // check if the 'id' variable is set in URL
     if (isset($_GET['id']))
     {
         // get id value
         $id = $_GET['id'];

         // update the entry
         $result = mysqli_query($link,"UPDATE pizza_admin SET Password='$NewPassword' WHERE Admin_ID='$id' AND Password='$OldPassword'")
         or die("The admin does not exist ... \n". mysqli_error());

         // redirect back to the member profile
         header("Location: profile.php");
     }
     else
     // if id isn't set, give an error
     {
        die("Password changing failed ..." . mysqli_error());
     }

?>
