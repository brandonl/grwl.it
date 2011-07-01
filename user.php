<?php  
	include('session_controller.php');

include_once('database.php');
include_once('time_manip.php');

$username = $_GET['username'];
$userid = $database->get_user_id($username);
$visitors_uname = $session_ctrl->uname;
$visitors_id = $database->get_user_id($visitors_uname);
$user_id = $database->get_user_id($username);
if($database->check_user_exists($userid,$username)  == -1)
{
	header('Location:/404.html');
}
else
{
$check_prot = "SELECT protected FROM users WHERE user_id = '$userid'";
$result = mysql_query($check_prot);
$row = mysql_fetch_array($result);
$privacy = $row['protected'];
?>
<!doctype html>	
<html>
<head>
	<title><?php echo $username?>'s grwl.it</title>
	<link rel="stylesheet" href="/css/style.css">
</head>
	<body>
		<div id="container">
			<?php if( $session_ctrl->isLoggedIn() ) { include('topbar.php'); }
			else{ ?>						<header>
							<h1><a href="/">grwl.it</a></h1>
							<p>Because Highlanders Don't tweet.</p>
						</header><?}php?>

				<div id="main">

<?php
/*PUBLIC*/
if($privacy == "0" OR $database->is_following($visitors_id, $userid))
{
	$follower = $database->is_following($visitors_id, $userid);
	$p_info = "SELECT * FROM users WHERE user_name='$username'";
	$profile = $database->query($p_info);
	while($row = mysql_fetch_array($profile))
	{
	?><div id="_profile_details"><!--Start #_profile_details"-->
	
	<?php
		$pic = $row['profile_image_url'];
		$var = "<img src='$pic' alt='No Profile Picture Uploaded' />"."</br>";
		echo $var;
		
		echo "<h2>".$row['user_name']."</h2>";
		echo "<p>".$row['city'].", ";
		echo $row['state']."</p>";
		echo "<h3>Description:</h3><p>".$row['description']."</p>";

		if(!$follower){	?><!--Follow Button-->
<form id="_follow_button" action="handler.php" method="POST" >
<?php echo "</br>"; echo "<p class='error'>".$_SESSION['fol_error']."</p>"; unset($_SESSION['fol_error']);?>
<?php echo "<p class='error'>".$_SESSION['follow_self_error']."</p>"; unset($_SESSION['follow_self_error']);?>
<?php echo "<p class='error'>".$_SESSION['is_follow_error']."</p>"; unset($_SESSION['is_follow_error']);?>
	<input type="hidden" name="user_id" value="<?php echo $userid ?>" />
	<input type="submit" name="follow" value="Follow">
</form>

	<?php }?><!--End Follow Button-->
	
	
	</div><!--End #_profile_details"-->
	<?php
	}
	/*Retrieves the public messages from the user that it was linked to.*/
	?><div id="_profile_stream"><!--Start #_profile_details"-->
	<?php
	if($follower and $session_ctrl->isLoggedIn() )
	{
		$public_message = $database->retrieve_public_messages($userid,'1');
	}
	else
		$public_message = $database->retrieve_public_messages($userid);
	
	if(count($public_message)>0){
	foreach($public_message as $value)
	{
		echo($value);
	}
	}
	else echo '<ul><li><h3>No grwls</h3></li></ul>';
	?></div><!--End #_profile_stream-->
	<div id="_profile_follows"><!--Start #_profile_details-->
<?php
		$followers = $database->get_followers($userid);
		foreach($followers as $vals)
		{
			echo $vals;
		}
		$stalkers = $database->get_stalkers($userid);
		foreach($stalkers as $vals1)
		{
			echo $vals1;
		}
		/*End Pending*/
?>
</div>
	<?php
}
/*SEMI*/
else if($privacy == "1")
{
	$follower = $database->is_following($user_id, $visitor_id);
	$p_info = "SELECT * FROM users WHERE user_name='$username'";
	$profile = $database->query($p_info);
	while($row = mysql_fetch_array($profile))
	{
		?><div id="_profile_details"><!--Start #_profile_details"-->
	
	<?php
		$pic = $row['profile_image_url'];
		$var = "<img src='$pic' alt='No Profile Picture Uploaded' />"."</br>";
	echo $var;
	echo "<h2>".$row['user_name']."</h2>";
	echo "<p>".$row['city'].", ";
	echo $row['state']."</p>";
	echo "<h3>Description:</h3><p>".$row['description']."</p>";
	}

			if(!$follower){	?><!--Follow Button-->
<form id="_follow_button" action="handler.php" method="POST" >
<?php echo "</br>"; echo "<p class='error'>".$_SESSION['fol_error']."</p>"; unset($_SESSION['fol_error']);?>
<?php echo "<p class='error'>".$_SESSION['follow_self_error']."</p>"; unset($_SESSION['follow_self_error']);?>
<?php echo "<p class='error'>".$_SESSION['is_follow_error']."</p>"; unset($_SESSION['is_follow_error']);?>
	<input type="hidden" name="user_id" value="<?php echo $userid ?>" />
	<input type="submit" name="follow" value="Follow">
</form>

	<?php }?>
<!--End Follow Button--></div><!--End #_profile_details"-->
	<div id="_profile_stream"><!--Start #_profile_details"-->
	<?php
	$public_message = $database->retrieve_public_messages($userid);
	foreach($public_message as $value)
	{
		echo($value);
	}
	?></div><!--End #_profile_stream-->
	<?php
}
/*PRIVATE*/
else if($privacy == "2")
{
	$follower = $database->is_following($user_id, $visitor_id);
	$p_info = "SELECT * FROM users WHERE user_name='$username'";
	$profile = $database->query($p_info);
	while($row = mysql_fetch_array($profile))
	{
		?><div id="_profile_details"><!--Start #_profile_details"-->
	
	<?php
		$pic = $row['profile_image_url'];
		$var = "<img src='$pic' alt='No Profile Picture Uploaded' />"."</br>";
	echo $var;
	echo "<h2>".$row['user_name']."</h2>";
	}
	/*echo "$username's Profile is Semi-Private!";
	echo "Description: ".$row['desription']."<br>"."<br>";
	echo "Name: ".$row['user_name']."<br>";
	echo "User since: ".date("m-d-Y",$user_since)."<br>";
	echo "Last Updated: ".time_between($last_update,time()," ago","")."<br>"."<br>";				
	echo "General Information:"."<br>";
	echo "Grwls:" .$row['message_count']."<br>";
	echo "Following:". $row['friends_count']."<br>";
	echo "Followers:". $row['followers_count']."<br>";
	*/
		if(!$follower){	?><!--Follow Button-->
<form id="_follow_button" action="handler.php" method="POST" >
<?php echo "</br>"; echo "<p class='error'>".$_SESSION['fol_error']."</p>"; unset($_SESSION['fol_error']);?>
<?php echo "<p class='error'>".$_SESSION['follow_self_error']."</p>"; unset($_SESSION['follow_self_error']);?>
<?php echo "<p class='error'>".$_SESSION['is_follow_error']."</p>"; unset($_SESSION['is_follow_error']);?>
	<input type="hidden" name="user_id" value="<?php echo $userid ?>" />
	<input type="submit" name="follow" value="Follow">
</form>

	<?php }?>
<!--End Follow Button--></div><!--End #_profile_details"-->
	<div id="_profile_stream"><!--Start #_profile_details"-->
	<?php
		echo "<ul><li><strong>$username's Profile is Private.</strong></li></ul>";
	?></div><!--End #_profile_stream-->
	<?php
}

?>
<?php }?>
				</div><!--end of #main-->
			<div class="clear"></div>
			<footer>
				<p>Copyright 2011 - a BJKM production</p>
			</footer>
		</div><!--end of #container-->
	</body>
</html>

