<?php
include_once('database.php');

class SessionController
{

	var $uname;
	var $uid;
	var $is_logged_in;
	var $is_admin;
	
	function SessionController()
	{
		$this->startSession();
	}

	function isLoggedIn()
	{
		global $database;
		
		// If remember me feature was selected (cookies set)
		if( isset( $_COOKIE['cname'] ) && isset( $_COOKIE['cid'] ) )
		{
			$this->uname = $_SESSION['uname'] = $_COOKIE['cname'];
			$this->uid = $_SESSION['uid'] = $_COOKIE['cid'];		
			$this->is_admin = $database->isAdminPrivilege($this->uname);
			return true;
		}
		
		if( isset( $_SESSION['uname'] ) && isset( $_SESSION['uid'] ) )
		{
			if( $database->verifyUser( $_SESSION['uname'], $_SESSION['uid'] ) >= 0 )
			{
				// The users logged in in the db ID does not correspond to his current id
				unset( $_SESSION['uname'] );
				unset( $_SESSION['uid']  );
				return false;
			}
			
			$this->uname = $_SESSION['uname'];
			$this->uid = $_SESSION['uid'];
			$this->is_admin = $database->isAdminPrivilege($this->uname);
			return true;
		}
		else
		{
			return false;
		}
	
	}

	
	// Decides users logged in status and updates the super globals accordinglys
	function startSession()
	{
		session_start();
		
		$this->is_logged_in = $this->isLoggedIn();
	}


	function login( $user, $pass, $is_remembered )
	{
		global $database;
		
		// No user name entered...
		if( !$user || strlen( $user = trim($user) ) == 0 )
		{
			$_SESSION['login_error'] = "Wrong Username and password combination.";
			return false;
		}
		else
		{
			// Using regular expressions to check if user is alpha numeric or not.
			if( !preg_match("/^[A-Za-z0-9]+$/", $user) )
			{
				$_SESSION['login_error'] = "Wrong Username and password combination.";
				return false;
			}
		}

		// No password entered...
		if( !pass )
		{
			$_SESSION['login_error'] = "Wrong Username and password combination.";
			return false;
		}
		
		$user = stripslashes( $user );
		// Incorrect password...
		if( !$results = $database->verifyPass( $user, md5($pass) ) >= 0 )
		{
			$_SESSION['login_error'] = "Wrong Username and password combination.";
			return false;
		}
		else
		{
			$this->uname = $_SESSION['uname'] = $user;
			$this->uid = $_SESSION['uid'] = $this->randomUID();		
			$this->is_admin = $database->isAdminPrivilege($this->uname);
		}

		// Used to log in users automagically if these cookies are present and correct.
		if($is_remembered)
		{
			setcookie("cname", $this->uname, time()+60*60*24*100, "/");
			setcookie("cid",   $this->uid,   time()+60*60*24*100, "/");
		}
		return true;
	}

	function login_a( $user )
	{
		global $database;
		
		// No user name entered...
		if( !$user || strlen( $user = trim($user) ) == 0 )
		{
			$_SESSION['login_error'] = "User does not exist.";
			$_SESSION['redirect'] = "admin.php";
			return false;
		}
		else
		{
			// Using regular expressions to check if user is alpha numeric or not.
			if( !preg_match("/^[A-Za-z0-9]+$/", $user) )
			{
				$_SESSION['login_error'] = "User does not exist.";
				$_SESSION['redirect'] = "admin.php";
				return false;
			}
		}
		$user = stripslashes( $user );
		// Incorrect password...
		if( !$results = $database->verifyPass( $user, $database->getUserPass( $user ) ) >= 0 )
		{
			$_SESSION['login_error'] = "User does not exist.";
			$_SESSION['redirect'] = "admin.php";
			return false;
		}
		$this->logout();
		$this->uname = $_SESSION['uname'] = $user;
		$this->uid = $_SESSION['uid'] = $this->randomUID();		
		$this->is_admin = $database->isAdminPrivilege($this->uname);
		$_SESSION['redirect'] = "index.php";
		return true;
	}
	
	function logout()
	{
		global $database;
		// If user explicitly logs out we should delete the previously set cookies
		// (if remember me feature was enabled at login, duh ).
		if( isset( $_COOKIE['cname'] ) && isset( $_COOKIE['cid'] ) )
		{
			setcookie("cname", "", time()-60*60*24*100, "/" );
			setcookie("cid",   "", time()-60*60*24*100, "/" );
		}
		
		unset( $_SESSION['uname'] );
		unset( $_SESSION['uid'] );
		
		$this->logged_in = false;
		$this->uname = NULL;
		$this->uid = NULL;
		$this->is_admin = false;
	}

	
	function isAdmin()
	{
		return $this->is_admin;
	}

	function signUp( $user, $email, $pass, $city, $state, $zip ) 
	{
		global $database;
		$failure = false;
		// Error Check User name
		if( !$user || strlen( $user = trim( $user ) ) == 0 )
		{
			$_SESSION['uname_error'] = "Username must be alphanumeric and 4 to 30 characters long.";
	  		$failure = true; //"Sorry, the username is empty"
   		}
		else
		{
			if( strlen( $user ) < 4 )
			{

				$_SESSION['uname_error'] = "Username must be alphanumeric and 4 to 30 characters long.";
				$failure = true; //"Sorry, the username is shorter than 4 characters in length, please lengthen it."
			}
			else if( strlen( $user ) > 30 )
			{

				$_SESSION['uname_error'] = "Username must be alphanumeric and 4 to 30 characters long.";
				$failure = true; //"Sorry, the username is longer than 30 characters, please shorten it."
			}
			if( !preg_match( "/^[A-Za-z0-9]+$/", $user ) )
			{

				$_SESSION['uname_error'] = "Username must be alphanumeric and 4 to 30 characters long.";
				$failure = true;
			}
			// Name is taken.
			if( $database->isNameTaken( $user ) )
			{

				$_SESSION['uname_error'] = "Username is taken.";
				$failure = true; // "Sorry, the username: <strong>$user</strong> is already taken, please pick another one."
			}
		}
	
		// Error Check password
		if( !$pass )
		{
			$_SESSION['signup_error'] = "Please fill out all fields.";
			$_SESSION['pass_error'] = "*";
			$failure = true; // No password entered.
		}
		else
		{
			// We do not count spaces as part of a password, design decision?
			$pass = stripslashes( $pass );
			if( strlen($pass) < 4 )
			{

				$_SESSION['pass_error'] = "Your password must be greater then 3 characters long.";
				$failure = true; // Password entered is too short.
			}
			if( !preg_match( "/^[A-Za-z0-9]+$/", ($pass = trim( $pass ) ) ) )
			{

				$_SESSION['pass_error'] = "Password may only consist of letters and numbers.";
				$failure = true; // Password is not alpha numeric.
			}
		}
		
		// Error Check Email
		if( !$email || strlen( $email = trim( $email ) ) == 0 )
		{
			$_SESSION['signup_error'] = "Please fill out all fields.";
			$_SESSION['email_error'] = "*";
			$failure = true; // No email entered or just spaces.
		}
		else
		{
			if( !preg_match( "/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $email ) )
			{

				$_SESSION['email_error'] = "Valid email required.";
				return false; // Email does not match regex string, i.e. does not have @ after string and at least a 3 letter become .*
			}
			$email = stripslashes( $email );
		}
		
		// Error check city
		if( !$city )
		{
			
			$_SESSION['city_error'] = "*";
			$failure = true;
		}
		else if( !preg_match( "/^[a-zA-Z\s]+$/", $city ) )
		{
			$_SESSION['city_error'] = "Must be a valid U.S. city.";
			$failure = true;
		}
		
		// Error check zip code
		if( !$zip )
		{
			
			$_SESSION['zip_error'] = "*";
			$failure = true;
		}
		if( !preg_match( "/^([0-9]{5})(-[0-9]{4})?$/i", $zip ) )
		{
			
			$_SESSION['zip_error'] = "Must be a valid U.S. zipcode.";
			$failure = true;
		}

		if( !$state )
		{
			
			$_SESSION['state_error'] = "*";
			$failure = true;
		}
		
		
		if( !$failure )
		{
			if( $database->addUser( strtolower( $user ), $email, md5( $pass ), stripslashes( $city ), $state, stripslashes( $zip ) ) )
			{
				$_SESSION['signup_success'] = "You're account has been successfully created!";
				return true;
			}

		}
		$_SESSION['signup_error'] = "Please fill out all fields.";
		return false;
	}

	function editPass( $user, $oldpass, $newpass, $confirmpass )
	{
		global $database;
		// If the password field is not empty the user wishes to update pass.
		if( $newpass )
		{
		    if( $newpass != $confirmpass )
		    {
				$_SESSION['edit_pass_error'] = "The two passwords do not equal";
		    	return false;
			}
		    else if( $oldpass )
		    {
				$user = stripslashes( $user );
				if( !$results = $database->verifyPass( $user, md5($oldpass) ) >= 0 )
				{   
					$_SESSION['edit_error'] = "Password incorrect.";
					return false;	
				}
				else
				{
					$newpass = stripslashes( $newpass );
					if( strlen($newpass) < 4 )
					{
						$_SESSION['edit_pass_error'] = "Your password must be greater then 3 characters long.";
						return false;
					}
					else if( !preg_match( "/^[A-Za-z0-9]+$/", ($newpass = trim( $newpass ) ) ) )
					{
						$_SESSION['edit_pass_error'] = "Your password may only consist of letters and numbers.";
						return false;
					}
					else if( $database->updateField( $user, "user_pass", md5($newpass) ) )
					{
						$_SESSION['edit_pass_success'] = "Password successfully updated";
						return true;
					}
				}
		    }
			
		}
		$_SESSION['edit_pass_error'] = "Please fill out all fields.";
		return false;

	}

	function editProfile( $user, $email, $city, $state, $zip, $bio, $privacy )
	{
		global $database;
		$failure = false;
		$edited = false;	
	
		if( $email || strlen( $email = trim( $email ) ) > 0 )
		{
			if( !preg_match( "/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $email ) )
			{
				$_SESSION['edit_email_error'] = "Valid email required.";
				$failure = true; // Email does not match regex string, i.e. does not have @ after string and at least a 3 letter become .*
			}

			else if( $database->updateField( $user, "user_email", stripslashes( $email ) ) )
			{
			    $edited = true;
			    $_SESSION['edit_email_success'] = "Email successfully updated";
			}
		}

		if( $city )
		{
			
		    if( !preg_match( "/^[a-zA-Z]+$/", $city ) )
		    {
			$_SESSION['edit_city_error'] = "Must be a valid U.S. city.";
			$failure = true;
		    }
		    else if( $database->updateField($user, "city", stripslashes( $city ) ) )
		    {
			$edited = true;
			$_SESSION['edit_city_success'] = "City successfully udpated";
		    }
		}
		
		if( $zip )
		{
		    if( !preg_match( "/^([0-9]{5})(-[0-9]{4})?$/i", $zip ) )
		    {
			
			    $_SESSION['edit_zip_error'] = "Must be a valid U.S. zipcode.";
			    $failure = true;
		    }
		    else if( $database->updateField($user, "zipcode", stripslashes( $zip ) ) )
		    {
				$edited = true;
				$_SESSION['edit_zip_success'] = "Zip successfully udpated";
		    }

		}

		if( $state )
		{
		    if( $database->updateField($user, "state", $state ) )
		    {
				$edited = true;	
				$_SESSION['edit_state_success'] = "State successfully udpated";
		    }
		}
		
		if( $bio )
		{
		   	if( !preg_match( "/[\pL\pN_\-]+/", $bio ) )
			{
				$_SESSION['edit_bio_error'] = "Invalid description input.";
				$failure = true;
			}
		    else if( $database->updateField( $user, "description", $bio ) )
		    {
				$edited = true;
				$_SESSION['edit_desc_success'] = "Bio successfully updated";
		    }
		}	

		if( $privacy )
		{
		    if( $database->updateField( $user, "protected", $privacy ) )
		    {
				$edited = true;
		    }
		}
		if( !$failure && $edited )
		{
		    $_SESSION['edit_success'] = "You're account has been successfully updated!";
		    return true;
		}
		return false;

	}
    	
	function randomUID()
	{
		$ruid = "";
		for( $i = 0; $i < 16; $i++)
		{
			$randnum = mt_rand( 0, 61 );
			if( $randnum < 10 )
			{
				$ruid .= chr( $randnum+48 );
			}
			else if($randnum < 36)
			{
				$ruid .= chr( $randnum+55 );
			}
			else
			{
				$ruid .= chr( $randnum+61 );
			}
		}
		return md5( $ruid );
	}

	function deleteAccount( $uname )
	{
	    global $database;
	    if( $database->removeAccount( $uname ) )
		return true;
	    return false;
	}

	function new_message( $priv, $msg, $lat, $lng, $subloc, $loc )
	{
		global $database;

		$msg = $msg." ";

		//Parse for tags (deliminator: @)
		$num_targ = preg_match_all("/@[a-zA-Z]+[,\s\r\n]/", $msg, $matches, PREG_SET_ORDER);
		
		//Parse for tags (deliminator: #)
		$num_sub = preg_match_all("/#[a-zA-Z0-9]+[,\s\r\n]/", $msg, $match_sub, PREG_SET_ORDER);

		// No message entered
		if( !$msg || strlen( $msg = trim($msg) ) == 0 )
		{
			$_SESSION['msg_error'] = "No message entered.";
			return false;
		}
		
		$un = $_SESSION['uname'];
		$results = $database->get_user_id( $un );

		$problem = 0;

		$msg = stripslashes( $msg );

		//if there is a target, only certain people can see message, and message is private
		if($num_targ != 0)
			$priv = on;

		$msg_id = $database->add_new_message( $priv, $msg, $lat, $lng, $subloc, $loc, $results);
		if( $msg_id == -1)
		{
			return false;
		}
		else
		{
			//Parse for tags (deliminator: @)
			foreach($matches as &$value)
			{
				if(!$database->add_new_target($msg_id, substr($value[0], 1, -1)));
					$problem = 1;
			}
			if($num_sub != 0)
			{
				//Parse for tags (deliminator: #)
				foreach($match_sub as &$value2)
				{
					if(!$database->add_new_subject($msg_id, substr($value2[0], 1, -1)));
						$problem = 1;
				}
			}

			if($problem == 0)
			{
				return true;
			}
			else
			{
				return false;
			}

		}

	}

	function follow_req( $userid )
	{
		global $database;
		
		$un = $_SESSION['uname'];
		$sql = "SELECT user_id FROM users WHERE user_name='$un'";
		$results = $database->query( $sql );

		$row = mysql_fetch_array( $results );
		$var = $row['user_id'];
		
		if($this->is_logged_in == false)
		{
			$_SESSION['fol_error'] = "You must be logged in to follow someone.";
			return false;
		}
		
		
		if($userid == $var)
		{
			$_SESSION['follow_self_error'] = "You can not follow yourself.";
			return false;
		}
		if( $database->is_following($var, $userid) )
		{
			$_SESSION['is_follow_error'] = "You are already following this person.";
			return false;
		}

		if( $database->follow_request( $userid, $var ) )
		{
			return true;
		}
		else
		{
			return false;
		}

	}
	
	
	function confirm_req( $follid )
	{
		global $database;
		$un = $_SESSION['uname'];
		$sql = "SELECT user_id FROM users WHERE user_name='$un'";
		$results = $database->query( $sql );
		
		$row = mysql_fetch_array( $results );
		$my_id = $row['user_id'];
		
		if( $database->is_following($follid,$my_id))
		{
			$_SESSION['conf_err'] = "You are already following this person";
			return false;
		}
		
		if( $database->confirm_request( $follid , $my_id) )
		{
			return true;
		}
		else
		{
			return false;
		}
		
	}
	
	function deny_req( $follid )
	{
		global $database;
		//echo $follid;
		$un = $_SESSION['uname'];
		$sql = "SELECT user_id FROM users WHERE user_name='$un'";
		$results = $database->query( $sql );
		
		$row = mysql_fetch_array( $results );
		$my_id = $row['user_id'];
		
		if( $database->is_following($follid,$my_id) == 1)
		{
			$_SESSION['den_err'] = "You have already denied this person";
			return false;
		}
		
		if( $database->deny_request( $follid , $my_id) )
		{
			return true;
		}
		else
		{
			return false;
		}
		
	}
	
	function delete_req ( $message_id )
	{
		global $database;
		
		if( $database->message_exist($message_id) )
		{
			$_SESSION['delete_err'] = "This message does not exist";
			return false;
		}
		
		if( $database->delete_message($message_id) )
		{
			return true;
		}
		else
		{
			return false;
		}
		
	}
	
	// This function checks if the supplied username exists in the database. If it does we simply return true
	// to notify session_controller that the user being searched for is in fact valid. This will then end up redirecting the
	// searchee to the serached for users profile. The $uname is considered to come pre-cleaned, this includes triming the variable
	// and making all lowercase since user names are stored in the database as all lowercase. That is BrAnDon == brandon.
	function findUsers( $uname )
	{
		global $database;
		if( !$_SESSION['search_res'] = $database->searchDB( $uname ) )
		{
			$_SESSION['search_error'] = "No users found matching your search.";
			unset( $_SESSION['search_res'] );
		}
	}

	//checks to see if the subject is in the subject table
	function findSubject( $sub )
{
global $database;
if( !$_SESSION['sub_fnd'] = $database->searchDB_for_sub( $sub, $_SESSION['uname'] ) )
{
$_SESSION['no_sub_found'] = "No subjects were found matching your search. $sub";
unset( $_SESSION['sub_fnd'] );
}
}

//filters the users by username
function filterUsers( $user_name )
{
global $database;
if( !$_SESSION['sub_fnd'] = $database->searchDB_for_user( $user_name, $_SESSION['uname'] ) )
{
$_SESSION['no_sub_found'] = "No users were found matching your search.";
unset( $_SESSION['sub_found'] );
}
}

	// This is an admin function that allows admins with proper privilege to modify any information 
	// on any user other user in the system. Admins cannot edit other admins.
	function modifyUser_a( $user, $newname, $email, $pass, $city, $state, $zip, $bio, $privacy, $privilege )
	{
		global $database;
		$failure = false;
		$edited = false;
		
		if( $_SESSION['uname'] == $user )
		{
			$_SESSION['mod_error'] = "You cannot edit your own account through the admin panel.";
			return false;
		}
		if( $pass )
		{
			$pass = stripslashes( $pass );
			if( strlen($pass) < 4 )
			{
				$_SESSION['mod_pass_error'] = "Password must be greater then 3 characters long.";
				$failure = true;		
			}
			else if( !preg_match( "/^[A-Za-z0-9]+$/", ($pass = trim( $pass ) ) ) )
			{
				$_SESSION['mod_pass_error'] = "Password may only consist of letters and numbers.";
				$failure = true;
			}
			else if( $database->updateField( $user, "user_pass", md5($pass) ) )
			{
				$edited = true;
			}
		}	

		if( $email || strlen( $email = trim( $email ) ) > 0 )
		{
			if( !preg_match( "/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $email ) )
			{
				$_SESSION['mod_email_error'] = "Valid email required.";
				$failure = true;
			}

			else if( $database->updateField( $user, "user_email", stripslashes( $email ) ) )
			{
			    $edited = true;
			}
		}

		if( $city )
		{
			
		    if( !preg_match( "/^[a-zA-Z]+$/", $city ) )
		    {
				$_SESSION['mod_city_error'] = "Must be a valid U.S. city.";
				$failure = true;
		    }
		    else if( $database->updateField($user, "city", stripslashes( $city ) ) )
		    {
				$edited = true;
		    }
		}
		
		if( $zip )
		{
		    if( !preg_match( "/^([0-9]{5})(-[0-9]{4})?$/i", $zip ) )
		    {
			
			    $_SESSION['mod_zip_error'] = "Must be a valid U.S. zipcode.";
			    $failure = true;
		    }
		    else if( $database->updateField($user, "zipcode", stripslashes( $zip ) ) )
		    {
				$edited = true;
		    }

		}

		if( $state )
		{
		    if( $database->updateField($user, "state", $state ) )
		    {
				$edited = true;	
		    }
		}
		
		if( $bio )
		{
			if( !preg_match( "/[\pL\pN_\-]+/", $bio ) )
			{
				$_SESSION['mod_bio_error'] = "Invalid description input.";
				$failure = true;
			}
		    else if( $database->updateField( $user, "description", $bio ) )
		    {
				$edited = true;
		    }
		}	

		if( $privacy )
		{
		    if( $database->updateField( $user, "protected", $privacy ) )
		    {
				$edited = true;
		    }
			else
			{
				$_SESSION['mod_privacy_error'] = "Failed to edit user privacy.";
				$failure = true;
			}
		}

		if( $privilege )
		{
		    if( $database->updateField( $user, "privilege", $privilege ) )
		    {
 				$edited = true;
		    }
			else
			{
				$_SESSION['mod_privilege_error'] = "Failed to edit user privacy.";
				$failure = true;
			}

		}

		if( $newname && $user != $newname )
		{
			$newname = stripslashes( $newname );
			if( strlen( $newname ) < 4 )
			{
				$_SESSION['mod_uname_error'] = "Username must be alphanumeric and 4 to 30 characters long.";
				$failure = true; 
			}

			else if( strlen( $newname ) > 30 )
			{
				$_SESSION['mod_uname_error'] = "Username must be alphanumeric and 4 to 30 characters long.";
				$failure = true; 
			}

			else if( !preg_match( "/^[A-Za-z0-9]+$/", $newname ) )
			{
				$_SESSION['mod_uname_error'] = "Username must be alphanumeric and 4 to 30 characters long.";
				$failure = true;
			}
			
			else if( $database->isNameTaken( $newname ) )
			{
				$_SESSION['mod_uname_error'] = "Username is taken.";
				$failure = true; 
			}

			else if( $database->updateField( $user, "user_name", $newname ) )
			{
				$edited = true;
			}
		}

		if( !$failure && $edited )
		{
		    $_SESSION['mod_success'] = "You have successfully modified this user.";
		    return true;
		}
		return false;
	}

	function get_geoloc($_uname)
	{	
		global $database;
		$database->get_geoloc($_uname);
	}

};

$session_ctrl = new SessionController;

?>