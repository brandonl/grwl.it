<?php
include_once('session_controller.php');
class Handler
{

	function Handler()
	{
		// Handle login requests, login form sumbit needs to be names 
		// login for this to work as well as other handlers.
		if( isset( $_POST['login'] ) )
		{
			$this->handleLogin();
		}
	
		if( isset( $_POST['admin_login'] ) )
		{
			$this->handleAdminLogin();
		}

		// Hanle logout requests, logout form sumit needs to be named logout
		if( isset( $_POST['logout'] ) )
		{
			$this->handleLogout();
		}
		
		// Handle registration requests, read above.
		if( isset( $_POST['signup'] ) )
		{
			$this->handleSignUp();
		}

		//Handle new messages
		if( isset( $_POST['new_message'] ) )
		{
			$this->handleNewMsg();
		}

		//Handle a follow request
		if( isset( $_POST['follow'] ) )
		{
			$this->handleFollow();
		}
	
		//Handle a confirmation request
		if( isset( $_POST['confirm'] ) )
		{
			$this->handleConfirm();
		}
	
		//Handle a denied request
		if( isset( $_POST['deny'] ) )
		{
			$this->handleDeny();
		}
		
		//Handle a delete message
		if( isset( $_POST['m_delete'] ) )
		{
			$this->handleDelete();
		}
		
		if( isset( $_POST['search'] ) )
		{
			$this->handleSearch();
		}

		//used to filter messages either by subject or by user
		if( isset( $_POST['search_sub'] ) )
		{
			$this->handleSubjectSearch();
		}

		if( isset( $_POST['delete'] ) )
		{
		    $this->handleDeleteAccount();
		}


		if( isset( $_POST['admin_delete'] ) )
		{
		    $this->handleAdminDeleteAccount();
		}	

		if( isset( $_POST['edit'] ) )
		{
			$this->handleEditProfile();
		}

		if( isset( $_POST['edit_pass'] ) )
		{
			$this->handleEditPass();
		}

		if( isset( $_POST['admin_mod'] ) )
		{
			$this->handleAdminMod();
		}
		
		if(isset( $_POST['map_user']))
		{
			$this->handleGeoMap();
		}
	} 
	
	function handleLogin()
	{
		global $session_ctrl;

		$session_ctrl->login( $_POST['uname'], $_POST['pass'], $_POST['remember'] );	
		header( "Location: index.php" );	
	}

	function handleAdminLogin()
	{
		global $session_ctrl;
		$session_ctrl->login_a( $_POST['uname'] );
		header( "Location: ". $_SESSION['redirect'] );
	}
	
	function handleLogout()
	{
		global $session_ctrl;
		
		$session_ctrl->logout();
		header( "Location: index.php" );
	}
	
	function handleSignUp()
	{
		global $session_ctrl;

		$session_ctrl->signup( 		$_POST['user'], 
						$_POST['email'], 
						$_POST['pass'], 
						$_POST['city'],
						$_POST['state'], 
						$_POST['zip'] );
		header( "Location: ". $_POST['referer'] );
	}

	
	function handleNewMsg()
	{
		global $session_ctrl;

		$session_ctrl->new_message( $_POST['privacy'], $_POST['message'],$_POST['lat'], $_POST['lng'],$_POST['subloc'], $_POST['loc'] );

		header( "Location: index.php" );
		
	}

	function handleFollow()
	{
		global $session_ctrl;

		$session_ctrl->follow_req( $_POST['user_id'] );	

		header( "Location: index.php" );
	}

	
	function handleConfirm()
	{
		global $session_ctrl;
		$session_ctrl->confirm_req( $_POST['follower_id'] );
		
		header( "Location: index.php" );
	}
	
	function handleDelete()
	{
		global $session_ctrl;
		$session_ctrl->delete_req( $_POST['message_id'] );	
		
		header( "Location: index.php" );
	}

	function handleDeleteAccount()
	{
	    global $session_ctrl;
	    if ($session_ctrl->deleteAccount( $_SESSION['uname'] ) )
	    {
			$session_ctrl->logout();
			header( "Location: index.php" );
	    }
	    header( "Location: /404.html" ); 
	}
	
	function handleAdminDeleteAccount()
	{
	    global $session_ctrl;
	    if( $session_ctrl->deleteAccount( $_POST['uname'] ) )
	    {
		$_SESSION['admin_success'] = "User successfully deleted.";
	    }
            header( "Location: admin.php" );
	}

	function handleEditProfile()
	{
	    global $session_ctrl;

	    $session_ctrl->editProfile(		$_SESSION['uname'], 
										$_POST['email'],
										$_POST['city'],
										$_POST['state'], 
										$_POST['zip'],
										$_POST['bio'],
										$_POST['privacy'] );
		header( "Location: edit_profile.php" );
	}

	function handleEditPass()
	{
		global $session_ctrl;
		$session_ctrl->editPass( $_SESSION['uname'],
								$_POST['oldpass'], 
								$_POST['newpass'],
								$_POST['confirmpass'] );
		header( "Location: /edit_profile.php" );

	}

	function handleDeny()
	{
		global $session_ctrl;
		
		$session_ctrl->deny_req( $_POST['follower_id'] );
		
		header( "Location: index.php" );
	}

	// Mediator between the users request and session_controllers functionality to handle such a request.
	// handleSearch cleans the user being searched for by trimming, setting all charactesr to lower case, and 
	// stripping any slashes before supply the text to session_controller.
	function handleSearch()
	{
		global $session_ctrl;
		$cleaned = trim( $_POST['search_txt'] );
		$cleaned = strtolower( $cleaned );
		$cleaned = stripslashes( $cleaned );
		$session_ctrl->findUsers( $cleaned );
		header( "Location: ".$_POST['referer'] );
	}

	//handles the search for a subject or a user
	function handleSubjectSearch()
	{
		global $session_ctrl;
		$val = $_POST['search_user'];
		if($val == on)
		{
			$cleaned = trim( $_POST['sub_wanted'] );
			$cleaned = strtolower( $cleaned );
			$cleaned = stripslashes( $cleaned );
			$session_ctrl->filterUsers( $cleaned );
			header( "Location: ".$_POST['searcher'] );
		}
		else
		{
			$subject = $_POST['sub_wanted'];
			$subject = stripslashes( $subject );
			$session_ctrl->findSubject( $subject );
		}
		header( "Location: ".$_POST['searcher'] );
	}

	function handleAdminMod()
	{
	    global $session_ctrl;

	    $session_ctrl->modifyUser_a(	$_POST['uname'],
										$_POST['user_name'], 
										$_POST['user_email'],
										$_POST['user_pass'],
										$_POST['city'],
										$_POST['state'], 
										$_POST['zipcode'],
										$_POST['description'],
										$_POST['protected'],
										$_POST['privilege'] );
		header( "Location: admin.php" );
	}

	function handleGeoMap()
	{	
		global $session_ctrl;
		$session_ctrl->get_geoloc($_POST['map_user']);
	}

	function handleDeleteuser()
	{
		global $session_ctrl;
		$session_ctrl->deleteUser( $_POST['mod_user'] );
	}
};

$handler = new Handler();

?>