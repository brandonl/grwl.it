<?php 
	include_once('session_controller.php');
	if( !$session_ctrl->isLoggedIn() )
	{
		header( "Location: index.php" );
	}
    $currinfo = $database->getUserInfo( $_SESSION['uname'] );

?>	
<!doctype html>	
<html>
<head>
	<title><?php echo $_SESSION['uname'];?>'s grwl.it</title>
	
	<script src="/js/jquery-1.5.js"></script>
	<script src="/js/site.js"></script>
	<link rel="stylesheet" href="/css/style.css">
	</head>

		<div id="container">
			<?php include('topbar.php'); ?>


		<div id="_error_panel">
			<?php if( isset( $_SESSION['edit_error'] ) ) { echo "</br>"; echo "<p class='error'>".$_SESSION['edit_error']."</p>"; } unset($_SESSION['edit_error']); ?>
			<?php if( isset( $_SESSION['edit_success'] ) ) { echo "</br>"; echo "<p class='error'>".$_SESSION['edit_success']."</p>"; } unset($_SESSION['edit_success']); ?>
			<?php if( isset( $_SESSION['edit_pass_error'] ) ) { echo "</br>"; echo "<p class='error'>".$_SESSION['edit_pass_error']."</p>"; } unset($_SESSION['edit_pass_error']); ?>
			<?php if( isset( $_SESSION['edit_pass_success'] ) ) { echo "</br>"; echo "<p class='error'>".$_SESSION['edit_pass_success']."</p>"; } unset($_SESSION['edit_pass_success']); ?>	
		</div>
			<div id="_edit_container">
							<ul class="tabs">
					<li><a href="#tab1">Edit Information</a></li>
					<li><a href="#tab2">Edit Password</a></li>
				</ul>
				<div class="clear"></div>
				<div id="tab1" class="tab_content">
<form class="_home_form" action="handler.php" method="POST">
			<ul>

			<li>Email:<input type="text" name="email" value='<?php echo $currinfo['user_email']; ?>'>
			<?php  if( isset( $_SESSION['edit_email_error'] ) ) {  echo "</br>"; echo "<p class='error'>".$_SESSION['edit_email_error']."</p>"; } unset($_SESSION['edit_email_error']);?></li>
			<li>City:<input type="text" name="city" value='<?php echo $currinfo['city']; ?>'>
			<?php if( isset( $_SESSION['edit_city_error'] ) ) { echo "</br>"; echo "<p class='error'>".$_SESSION['edit_city_error']."</p>"; } unset($_SESSION['edit_city_error']);?></li>
			<li>State:<select id="state" name="state">
									<option value="">Select One</option> 
									<option value="AK">Alaska</option>
									<option value="AL">Alabama</option>
									<option value="AR">Arkansas</option>
									<option value="AZ">Arizona</option>
									<option value="CA">California</option>
									<option value="CO">Colorado</option>
									<option value="CT">Connecticut</option>
									<option value="DC">District of Columbia</option>
									<option value="DE">Delaware</option>
									<option value="FL">Florida</option>
									<option value="GA">Georgia</option>
									<option value="HI">Hawaii</option>
									<option value="IA">Iowa</option>
									<option value="ID">Idaho</option>
									<option value="IL">Illinois</option>
									<option value="IN">Indiana</option>
									<option value="KS">Kansas</option>
									<option value="KY">Kentucky</option>
									<option value="LA">Louisiana</option>
									<option value="MA">Massachusetts</option>
									<option value="MD">Maryland</option>
									<option value="ME">Maine</option>
									<option value="MI">Michigan</option>
									<option value="MN">Minnesota</option>
									<option value="MO">Missouri</option>
									<option value="MS">Mississippi</option>
									<option value="MT">Montana</option>
									<option value="NC">North Carolina</option>
									<option value="ND">North Dakota</option>
									<option value="NE">Nebraska</option>
									<option value="NH">New Hampshire</option>
									<option value="NJ">New Jersey</option>
									<option value="NM">New Mexico</option>
									<option value="NV">Nevada</option>
									<option value="NY">New York</option>
									<option value="OH">Ohio</option>
									<option value="OK">Oklahoma</option>
									<option value="OR">Oregon</option>
									<option value="PA">Pennsylvania</option>
									<option value="PR">Puerto Rico</option>
									<option value="RI">Rhode Island</option>
									<option value="SC">South Carolina</option>
									<option value="SD">South Dakota</option>
									<option value="TN">Tennessee</option>
									<option value="TX">Texas</option>
									<option value="UT">Utah</option>
									<option value="VA">Virginia</option>
									<option value="VT">Vermont</option>
									<option value="WA">Washington</option>
									<option value="WI">Wisconsin</option>
									<option value="WV">West Virginia</option>
									<option value="WY">Wyoming</option>
								</select>
		    <?php  if( isset( $_SESSION['edit_state_error'] ) ) {  echo "</br>"; echo "<p class='error'>".$_SESSION['edit_state_error']."</p>"; } unset($_SESSION['edit_state_error']);?></li>
		    <li>Zipcode:<input type="text" name="zip" value='<?php echo $currinfo['zipcode']; ?>'>
		    <?php  if( isset( $_SESSION['edit_zip_error'] ) ) {  echo "</br>"; echo "<p class='error'>".$_SESSION['edit_zip_error']."</p>"; } unset($_SESSION['edit_zip_error']);?></li>
			<li>Bio:<input type="textarea" name="bio" value='<?php echo $currinfo['description']; ?>'>
			<?php  if( isset( $_SESSION['edit_bio_error'] ) ) {  echo "</br>"; echo "<p class='error'>".$_SESSION['edit_bio_error']."</p>"; } unset($_SESSION['edit_bio_error']);?></li>
			<li>Privacy:<select id="privacy" name="privacy">
									<option value="">Select One</option> 
									<option value="3">Public</option>
									<option value="1">Semi-Private</option>
									<option value="2">Private</option>
								    </select>

		    <li><input type="submit" name="edit" value="Submit"></li>
								</form>	
		    <a href="/confirm_delete.php">delete my account</a>		

				</div>
				<div id="tab2" class="tab_content">
				<form class="_home_form" action="handler.php" method="POST">
					<ul>

					<li><label for="_signup_pass">Current Password:</label><input id="_signup_pass" type="password" name="oldpass">
					<li><label for="_signup_pass">New Password:</label><input id="_signup_pass" type="password" name="newpass">
					<li><label for="_signup_pass">Verify New Password:</label><input id="_signup_pass" type="password" name="confirmpass">	
					<li><input type="submit" name="edit_pass" value="Submit"></li>
					</form>	
					</ul>
				</div>
			</ul>
			</div>
			<div class="clear"></div>
			<footer>
				<p>Copyright 2011 - a BJKM production</p>
			</footer>
		</div><!--end of #container-->


		<script>

		$(document).ready(function() {

			//When page loads...
			$(".tab_content").hide(); //Hide all content
			$("ul.tabs li:first").addClass("active").show(); //Activate first tab
			$(".tab_content:first").show(); //Show first tab content

			//On Click Event
			$("ul.tabs li").click(function() {

				$("ul.tabs li").removeClass("active"); //Remove any "active" class
				$(this).addClass("active"); //Add "active" class to selected tab
				$(".tab_content").hide(); //Hide all tab content

				var activeTab = $(this).find("a").attr("href"); //Find the href attribute value to identify the active tab + content
				$(activeTab).fadeIn(); //Fade in the active ID content
				return false;
			});

		});

	
		</script>
	</body>
	

</html>



