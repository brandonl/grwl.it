<header id="_top_bar">
	<h1><a href="/">grwl.it</a></h1>
	<form id="_search_form" action="handler.php" method="POST" >
		<ul>
				<?php if( isset( $_SESSION['search_error'] ) ){ echo "<p class='error'>".$_SESSION['search_error']."</p>"; unset( $_SESSION['search_error'] ); } ?>
				<li><input class="_form_input" type="text" name="search_txt" value="Find users"/></li>
				<li><input type="hidden" name="referer" value="index.php"/></li>
				<li><input class="_form_button" type="submit" name="search" value="Search"/></li>
		</ul>
	</form>
	<nav>
		<ul>
			<li><a href="/">Home</a></li>
			<?php echo "<li><a href='".$_SESSION['uname']."'>Profile</a></li>"; ?>
			<?php if( $session_ctrl->isAdmin() ) { echo "<li><a id='_admin_button' href='/admin.php'>Admin Control Panel</a></li>"; } ?>
			<li><a href="/edit_profile.php">Settings</a></li>
			<li><form id="_logout_form" action="handler.php" method="POST" ><input class="_form_button" type="submit" name="logout" value="Logout"/></form></li>							
		</ul>
	</nav>
</header>
