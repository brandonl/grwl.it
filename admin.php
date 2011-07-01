<?php 
	include_once('session_controller.php');
	if( !$session_ctrl->isLoggedIn() || !$session_ctrl->isAdmin() )
	{
		header( "Location: index.php" );
	}

	/*
		create or delete new users, login as a selected user,
		delete offensive materials, etc. Furthermore, the administrator may modify otherwise unmodifiable
		user information. That is, an administrator has complete access and privilege to modify items in
		the server’s database.

	*/
?>	
<!doctype html>	
<html>
<head>
	<title><?php echo $_SESSION['uname'];?>'s grwl.it</title>
	<script src="/js/jquery-1.5.js"></script>
	<link rel="stylesheet" href="/css/style.css">
	</head>

		<div id="container">
			<?php include('topbar.php'); ?>

		<?php
		if( isset( $_SESSION['admin_success'] ) )
		{
			echo $_SESSION['admin_success'];
			unset( $_SESSION['admin_success'] );
		}
		?>

		<div id="_error_panel">
			<?php if( isset( $_SESSION['search_error'] ) ) { echo "</br>"; echo "<p class='error'>".$_SESSION['search_error']."</p>"; } unset($_SESSION['search_error']);?>
			<?php if( isset( $_SESSION['admin_success'] ) ) { echo "</br>"; echo "<p class='error'>".$_SESSION['admin_success']."</p>"; } unset($_SESSION['admin_success']);?>
			<?php if( isset( $_SESSION['admin_error'] ) ) { echo "</br>"; echo "<p class='error'>".$_SESSION['admin_error']."</p>"; } unset($_SESSION['admin_error']);?>

			<?php if( isset( $_SESSION['signup_success'] ) ) {  echo "</br>"; echo "<p class='error'>".$_SESSION['signup_success']."</p>"; } unset($_SESSION['signup_success']); ?>
			<?php if( isset( $_SESSION['signup_error'] ) ) {  echo "</br>"; echo "<p class='error'>".$_SESSION['signup_error']."</p>"; } unset($_SESSION['signup_error']); ?>
			<?php if( isset( $_SESSION['login_error'] ) ) { echo "</br>"; echo "<p class='error'>".$_SESSION['login_error']."</p>"; } unset($_SESSION['login_error']);?>
			<?php if( isset( $_SESSION['mod_uname_error'] ) ) {  echo "</br>"; echo "<p class='error'>".$_SESSION['mod_uname_error']."</p>"; } unset($_SESSION['mod_uname_error']); ?>
			<?php if( isset( $_SESSION['mod_bio_error'] ) ) {  echo "</br>"; echo "<p class='error'>".$_SESSION['mod_bio_error']."</p>"; } unset($_SESSION['mod_bio_error']); ?>
			<?php if( isset( $_SESSION['mod_zip_error'] ) ) {  echo "</br>"; echo "<p class='error'>".$_SESSION['mod_zip_error']."</p>"; } unset($_SESSION['mod_zip_error']); ?>
			<?php if( isset( $_SESSION['mod_city_error'] ) ) {  echo "</br>"; echo "<p class='error'>".$_SESSION['mod_city_error']."</p>"; } unset($_SESSION['mod_city_error']); ?>
			<?php if( isset( $_SESSION['mod_email_error'] ) ) {  echo "</br>"; echo "<p class='error'>".$_SESSION['mod_email_error']."</p>"; } unset($_SESSION['mod_email_error']); ?>
			<?php if( isset( $_SESSION['mod_pass_error'] ) ) {  echo "</br>"; echo "<p class='error'>".$_SESSION['mod_pass_error']."</p>"; } unset($_SESSION['mod_pass_error']); ?>
			<?php if( isset( $_SESSION['mod_image_error'] ) ) {  echo "</br>"; echo "<p class='error'>".$_SESSION['mod_image_error']."</p>"; } unset($_SESSION['mod_image_error']); ?>
			<?php if( isset( $_SESSION['mod_success'] ) ) { echo "</br>"; echo "<p class='error'>".$_SESSION['mod_success']."</p>"; } unset($_SESSION['mod_success']);?>
			<?php if( isset( $_SESSION['mod_privilege_error'] ) ) {  echo "</br>"; echo "<p class='error'>".$_SESSION['mod_privilege_error']."</p>"; } unset($_SESSION['mod_privilege_error']); ?>
			<?php if( isset( $_SESSION['mod_image_error'] ) ) {  echo "</br>"; echo "<p class='error'>".$_SESSION['mod_image_error']."</p>"; } unset($_SESSION['mod_image_error'] ); ?>
			<?php if( isset( $_SESSION['mod_error'] ) ) {  echo "</br>"; echo "<p class='error'>".$_SESSION['mod_error']."</p>"; } unset($_SESSION['mod_error'] ); ?>

		</div>
		<div id="_admin_main" >	
				<ul class="tabs">
					<li><a href="#tab1">Modify User</a></li>
					<li><a href="#tab2">Create User</a></li>
					<li><a href="#tab3">Login as User</a></li>
				</ul>
				<div class="clear"></div>
				<div id="tab1" class="tab_content">
					<ul>
					<form id="_search_form" action="handler.php" method="POST" >
						<li>Search for a user to modify his/her attributes.</li>
						<li><input class="_admin_input" type="text" name="search_txt" value="Find users">
						<li><input type="hidden" name="referer" value="admin.php"></input></li>
						<input class="_admin_button" type="submit" name="search" value="Search"></li>
					</form>
						<?php 
						/*
						 * MODIFY USERS:
						 * Admin users search for users and are offererd all of the users information at a glance
						 * they can then select which user they wish to modify.
						 * 
						 */
							if( isset( $_SESSION['search_res'] ) ) 
							{
								echo "<form id=\"_admin_table\" action=\"admin.php\" method=\"POST\">";
			
								// First loop outputs table field names extracted from the users table field name.
								$attributes = $database->getAttributes();

								//Main Table for search results
								echo "<table>";

								//First row for field names and empty cell for radio button.
								echo "<tr><td></td>";
								foreach( $attributes as $key => $val )
								{
									if( $val == "message_count" || $val == "profile_image_url" )
									{
										continue;
									}
									echo "<td>".$val."</td>";
								}

								// Next loops output results of user search and all the users informatio (1 user/row).
								foreach( $_SESSION['search_res'] as $value => $k )
								{
									$res_arr = $database->getUserInfo( $k );
									echo "<tr>";
									// Create the radio button to select this row.
									echo "<td><input type=\"radio\" name=\"mod_user\" value=\"".$k."\"></td>";
									foreach( $res_arr as $key => $val )
									{
										if( $key == "message_count" || $key == "profile_image_url" )
										{
											continue;
										}
										echo "<td>".$val ."</td>";
									}
									echo "</tr>";
								}

								echo "</table>";
								echo "<li><input type=\"submit\" name=\"select_user\" value=\"Select\"></input></li>";
								echo "</form>";

								unset( $_SESSION['search_res'] );
							}

							// This will be entered once the admin has selected a desired user to modify.
							else if( isset($_POST["select_user"]) )
							{
								echo "<form id=\"_admin_table\" action=\"handler.php\" method=\"POST\" enctype=\"multipart/form-data\">";
								$res_arr = $database->getUserInfo( $_POST['mod_user'] );
								echo "<table>";
								echo "<tr><td>Field</td><td>Value</td></tr>";
								$uname_temp;
								foreach( $res_arr as $key => $val )
								{
									// IDs are used as keys for the table and changing would be pointless and destructive.
									// Also destructive and pointless to change the message count for a user
									if( $key == 'user_id' || $key == 'message_count' || $key == 'profile_image_url' )
									{
										continue;
									}	
									echo "<tr>";
									echo "<td>".$key."</td>";
									// Since passwords are hashed it is useless to output the hash
									if( $key == 'user_pass' )
									{
										echo "<td><input type=\"password\" name=\"".$key."\"/></td>";
										continue;
									}
									if( $key == 'state' )
									{
										echo "<td><select id=\"state\" name=\"state\">
											<option value=\"\">Select One</option> 
											<option value=\"AK\">Alaska</option>
											<option value=\"AL\">Alabama</option>
											<option value=\"AR\">Arkansas</option>
											<option value=\"AZ\">Arizona</option>
											<option value=\"CA\">California</option>
											<option value=\"CO\">Colorado</option>
											<option value=\"CT\">Connecticut</option>
											<option value=\"DC\">District of Columbia</option>
											<option value=\"DE\">Delaware</option>
											<option value=\"FL\">Florida</option>
											<option value=\"GA\">Georgia</option>
											<option value=\"HI\">Hawaii</option>
											<option value=\"IA\">Iowa</option>
											<option value=\"ID\">Idaho</option>
											<option value=\"IL\">Illinois</option>
											<option value=\"IN\">Indiana</option>
											<option value=\"KS\">Kansas</option>
											<option value=\"KY\">Kentucky</option>
											<option value=\"LA\">Louisiana</option>
											<option value=\"MA\">Massachusetts</option>
											<option value=\"MD\">Maryland</option>
											<option value=\"ME\">Maine</option>
											<option value=\"MI\">Michigan</option>
											<option value=\"MN\">Minnesota</option>
											<option value=\"MO\">Missouri</option>
											<option value=\"MS\">Mississippi</option>
											<option value=\"MT\">Montana</option>
											<option value=\"NC\">North Carolina</option>
											<option value=\"ND\">North Dakota</option>
											<option value=\"NE\">Nebraska</option>
											<option value=\"NH\">New Hampshire</option>
											<option value=\"NJ\">New Jersey</option>
											<option value=\"NM\">New Mexico</option>
											<option value=\"NV\">Nevada</option>
											<option value=\"NY\">New York</option>
											<option value=\"OH\">Ohio</option>
											<option value=\"OK\">Oklahoma</option>
											<option value=\"OR\">Oregon</option>
											<option value=\"PA\">Pennsylvania</option>
											<option value=\"PR\">Puerto Rico</option>
											<option value=\"RI\">Rhode Island</option>
											<option value=\"SC\">South Carolina</option>
											<option value=\"SD\">South Dakota</option>
											<option value=\"TN\">Tennessee</option>
											<option value=\"TX\">Texas</option>
											<option value=\"UT\">Utah</option>
											<option value=\"VA\">Virginia</option>
											<option value=\"VT\">Vermont</option>
											<option value=\"WA\">Washington</option>
											<option value=\"WI\">Wisconsin</option>
											<option value=\"WV\">West Virginia</option>
											<option value=\"WY\">Wyoming</option>
											</select></td>";
											continue;
									}
									// Must save users name
									else if( $key == 'user_name' )
									{
										$uname_temp = $val;
									}
									else if( $key == 'protected' )
									{
										echo"<td><select id=\"protected\" name=\"protected\">
											<option value=\"\">Select One</option> 
											<option value=\"3\">Public</option>
											<option value=\"1\">Semi-Private</option>
											<option value=\"2\">Private</option>
											</select></td>";
										continue;
									}

									else if( $key == 'privilege' )
									{
										echo"<td><select id=\"privilege\" name=\"privilege\">
											<option value=\"\">Select One</option> 
											<option value=\"3\">Regular Privilege</option>
											<option value=\"1\">Admin Privilege</option>
											</select></td>";
										continue;
									}

									else if( $key == "profile_image_url" )
									{
										echo "<td>Current Image</br><image src=\"".$val."\"/></br>";
										echo "<input type=\"file\" name=\"image\"/>";
										continue;
									}

									echo "<td><input type=\"text\" name=\"".$key."\" value=\"".$val."\"></input></td>";
									echo "</tr>";
								}
								echo "</table>";
								unset( $_POST['select_user'] );
								echo "<li><input type=\"hidden\" value=\"". $uname_temp."\" name=\"uname\"";
								echo "<li><input type=\"submit\" name=\"admin_delete\" value=\"Delete\"/></li>";

								echo "<li><input type=\"submit\" name=\"admin_mod\" value=\"Modify\"></input></li>";
								echo "</form>";
							}
						?>
				</ul>
				</div>
				<div id="tab2" class="tab_content">
						<form class="_home_form" action="handler.php" method="POST">
							<ul>
								<li><label for="_signup_name">Username:</label><input id="_signup_name" type="text" name="user">
								<?php  if( isset( $_SESSION['uname_error'] ) ) {  echo "<p class='error'>".$_SESSION['uname_error']."</p>"; } unset($_SESSION['uname_error']); ?></li>
								<li><label for="_signup_pass">Password:</label><input id="_signup_pass" type="password" name="pass">
								<?php  if( isset( $_SESSION['pass_error'] ) ) {  echo "<p class='error'>".$_SESSION['pass_error']."</p>"; } unset($_SESSION['pass_error']); ?></li>
								<li>Email:<input type="text" name="email">
								<?php  if( isset( $_SESSION['email_error'] ) ) {  echo "<p class='error'>".$_SESSION['email_error']."</p>"; } unset($_SESSION['email_error']);?></li>
								<li>City:<input type="text" name="city">
								<?php  if( isset( $_SESSION['city_error'] ) ) {  echo "<p class='error'>".$_SESSION['city_error']."</p>"; } unset($_SESSION['city_error']);?></li>
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
								<?php  if( isset( $_SESSION['state_error'] ) ) {  echo "<p class='error'>".$_SESSION['state_error']."</p>"; } unset($_SESSION['state_error']);?></li>
								<li>Zipcode:<input type="text" name="zip">
								<?php  if( isset( $_SESSION['zip_error'] ) ) {  echo "<p class='error'>".$_SESSION['zip_error']."</p>"; } unset($_SESSION['zip_error']);?></li>
								<li><input type="hidden" name="referer" value="admin.php"></input></li>
								<li><input type="submit" name="signup" value="Submit"></li>
						</form>				
				</div>
				<div id="tab3" class="tab_content">
						<form class="_home_form" action="handler.php" method="POST" >
							<ul>
								<li>Logging in as a different user will automatically log you out of your admin account</li>
								<li><input id="_signin_name" type="text" name="uname"></li>
								<li><input type="submit" name="admin_login" value="Login as user"></li>
						</ul>
						</form>
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


