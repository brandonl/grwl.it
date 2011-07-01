<?php  
	include_once('session_controller.php');
	include_once('time_manip.php');
?>	
<!doctype html>	
<html>
<head>
	<title><?php if( isset($_SESSION['uname']) )echo $_SESSION['uname']."'s ";?>grwl.it</title>
	<script src="/js/jquery-1.5.js"></script>
	<link href="http://code.google.com/apis/maps/documentation/javascript/examples/default.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
	<script src="/js/geolocation.js"></script>
	<link rel="stylesheet" href="/css/style.css">
</head>
	<?php if( isset($_SESSION['signup_error'])){echo "<body onLoad=\"signup_error()\">";}
			else{ echo "<body onload='initialize()'>";}
	?>
		<div id="container">
			<?php if( $session_ctrl->isLoggedIn() ) { include('topbar.php'); } ?>
				<div id="main">
					<?php
					if ( !$session_ctrl->isLoggedIn() )
					{ 
					?>
						<header>
							<h1><a href="/">grwl.it</a></h1>
							<p>Because Highlanders Don't tweet.</p>
						</header>

					<div id="_login_signup"><!-- Start Forms -->
					<h3>Log In</h3>
					<div class="_signin_home">
					
						<!--Sign in Form-->		
						<form class="_home_form" action="handler.php" method="POST" >
							<ul>
								<?php  if( isset( $_SESSION['login_error'] ) ) {  echo "</br>"; echo "<p class='error'>".$_SESSION['login_error']."</p>"; } unset($_SESSION['login_error']);?>
								<?php  if( isset( $_SESSION['signup_success'] ) ) {  echo "</br>"; echo "<p class='error'>".$_SESSION['signup_success']."</p>"; } unset($_SESSION['signup_success']); ?>
								<li><label for="_signin_name">Username</label><input id="_signin_name" type="text" name="uname"/></li>
								<li><label for="_signin_pass">Password</label><input id="_signin_pass" type="password" name="pass" /></li>
								<li><label for="_signin_remember">Remember me</label><input id="_signin_remember" type="checkbox" name="remember"></li>
								<li><input class="_btn" type="submit" name="login" value="Sign In"></li>
						</ul>
						</form>
						<!--End Sign in Form-->
					</div><!--End Sign in Div-->
					<h3>Sign Up</h3>
					<div class="_signup_home">
					
						<!--Registration Form Section-->
						<form class="_home_form" action="handler.php" method="POST">
							<ul>
								<?php  if( isset( $_SESSION['signup_error'] ) ) {  echo "</br>"; echo "<p class='error'>".$_SESSION['signup_error']."</p>"; } unset($_SESSION['signup_error']); ?>
								<li><label for="_signup_name">Username</label><input id="_signup_name" type="text" name="user"/>
								<?php  if( isset( $_SESSION['uname_error'] ) ) {  echo "</br>"; echo "<p class='error'>".$_SESSION['uname_error']."</p>"; } unset($_SESSION['uname_error']); ?></li>
								<li><label for="_signup_pass">Password</label><input id="_signup_pass" type="password" name="pass"/>
								<?php  if( isset( $_SESSION['pass_error'] ) ) {  echo "</br>"; echo "<p class='error'>".$_SESSION['pass_error']."</p>"; } unset($_SESSION['pass_error']); ?></li>
								<li><label for="_signup_email">E-mail</label><input id="_signup_email" type="text" name="email"/>
								<?php  if( isset( $_SESSION['email_error'] ) ) {  echo "</br>"; echo "<p class='error'>".$_SESSION['email_error']."</p>"; } unset($_SESSION['email_error']);?></li>
								<li><label for="_signup_city">City</label><input id="_signup_city" type="text" name="city"/>
								<?php  if( isset( $_SESSION['city_error'] ) ) {  echo "</br>"; echo "<p class='error'>".$_SESSION['city_error']."</p>"; } unset($_SESSION['city_error']);?></li>
								<li><label for="_signup_state">State</label><select id="_signup_state" name="state"/>
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
								<?php  if( isset( $_SESSION['state_error'] ) ) {  echo "</br>"; echo "<p class='error'>".$_SESSION['state_error']."</p>"; } unset($_SESSION['state_error']);?></li>
								<li><label for="_signup_zip">Zipcode</label><input id="_signup_zip" type="text" name="zip"/>
								<?php  if( isset( $_SESSION['zip_error'] ) ) {  echo "</br>"; echo "<p class='error'>".$_SESSION['zip_error']."</p>"; } unset($_SESSION['zip_error']);?></li>
								<li><input type="hidden" name="referer" value="index.php"></input></li>
								<li><input class="_btn" type="submit" name="signup" value="Register"></li>
						</form>				

						<!--End Registration Form Section-->
					</div><!--End of Sign up Div-->
					</div><!--End Forms-->
					
					<div class="clear"></div>
					<?php
					}
		
					else
					{
						if( isset( $_SESSION['search_res'] ) )
						{
							echo "<div id='_search_results'><ul>";
							foreach( $_SESSION['search_res'] as $value => $k )
							{
								echo "<li><a href=\"/$k\">$k</a></li>";
							}
							echo "</ul></div>";
							unset( $_SESSION['search_res'] );
						}
				
						else
						{
							include( "userhome.php" );
						}
					}
					?>
				</div><!--end of #main-->
			<footer>
				<p>copyright 2011 grwl.it</p>
			</footer>
		</div><!--end of #container-->
		
		
		<script>
		function signup_error(){
		$("._signin_home").toggle();
    	$("._signup_home").toggle();
		};
    	
  

		$(document).ready(function() {

			//When page loads...
			$(".tab_content").hide(); //Hide all content
			if( $("#tab2 .filtering").val() )
			{
			    $("ul.tabs li+li").addClass("active").show(); //Activate first tab
			    $(".tab_content+.tab_content").show(); //Show first tab content

			}
			else
			{
				$("ul.tabs li:first").addClass("active").show(); //Activate first tab
				$(".tab_content:first").show(); //Show first tab content
			}
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

$('#_login_signup h3').click(function() {
  $('._signup_home').slideToggle('slow');
	$('._signin_home').slideToggle('slow');
});

		</script>
	</body>
	

</html>


