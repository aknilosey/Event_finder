
<?php 
include("includes/header.php");
include("includes/form_handlers/settings_handler.php");
?>

<div class="main_column column">
  
	<h4>Account Settings</h4>
	<?php
	echo "<img src='" . $user['profile_pic'] ."' class='small_profile_pic'>";
	?>
	<br>
	<a href="upload.php">Upload new profile picture</a> <br><br><br>

	Modify the values and click 'Update Details'
	<br>

	<?php
	$user_data_query = mysqli_query($con, "SELECT firstname, lastname, emailid FROM User WHERE username='$userLoggedIn'");
	$row = mysqli_fetch_array($user_data_query);

	$first_name = $row['first_name'];
	$last_name = $row['last_name'];
	$email = $row['email'];
	?>
<div class="container">
	<form action="settings.php" method="POST">
		<div class="form-group">
		    First Name: <input type="text" name="first_name" value="<?php echo $first_name; ?>" id="settings_input"><br>
	    </div>
		<div class="form-group">
		    Last Name: <input type="text" name="last_name" value="<?php echo $last_name; ?>" id="settings_input"><br>
	    </div>
		<div class="form-group">
		   Email: <input type="text" name="email" value="<?php echo $email; ?>" id="settings_input"><br>
        </div>
		<?php echo $message; ?>
        <div class="form-group">
		   <input type="submit" name="update_details" id="save_details" value="Update Details" class="info settings_submit"><br>
	    </div>
	</form>
</div>

<br>
<div class="container">
	<h4>Change Password</h4>
	<form action="settings.php" method="POST">
		<div class="form-group">
		    Old Password: <input type="password" name="old_password" id="settings_input"><br>
	    </div>
		<div class="form-group">
		    New Password: <input type="password" name="new_password_1" id="settings_input"><br>
		</div>
		<div class="form-group">
		    New Password Again: <input type="password" name="new_password_2" id="settings_input"><br>
        </div>
		<?php echo $password_message; ?>
        <div class="form-group">
		   <input type="submit" name="update_password" id="save_details" value="Update Password" class="info settings_submit"><br>
		</div>  
	</form>
</div>	
<!--
	<h4>Close Account</h4>
	<form action="settings.php" method="POST">
		<input type="submit" name="close_account" id="close_account" value="Close Account" class="danger settings_submit">
	</form>
	-->


</div>