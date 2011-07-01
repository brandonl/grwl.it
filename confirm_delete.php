<?php
    include_once('session_controller.php' );
	if( !$session_ctrl->isLoggedIn() )
	{
		header("Location: index.php" );
	}
?>
<!doctype html>	
<html>
<head>
	<title><?php echo $_SESSION['uname'];?>'s grwl.it</title>
	
	<link rel="stylesheet" href="/css/style.css">
</head>
<div id="container">
		<?php include('topbar.php'); ?>
			<div id="main">
			<div id="_confirm_del">
			<form class="_delete_form" action="handler.php" method="POST">
				    
					<h3>Are you sure you want to leave us?</h3>
					<h3>Before you make this tough decision, consider this:</h3>
					<ul><li>This action is permanent. All account information will be erased from our servers.</li>
					<li>Deleting your account will cause your username to become available for others to use.</li>
					<li>You will lose all of your follower and following contacts.</li></ul>
					<input type="submit" name="delete" value="Yes, delete my account.">
					
					</form>
					</div>
				</div><!--end of #main-->
			<footer>
				<p>Copyright 2011 - a BJKM production</p>
			</footer>
		</div><!--end of #container-->
	</body>
	

</html>

