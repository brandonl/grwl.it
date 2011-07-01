<?php
/*
 * Please add all functions that manipulate or access the tables data
 * in this file. To use such functions elsewhere, include('database.php')
 * and call with $database->myFunctionName( args[...] ). The variable
 * $database is created at the end up of this file.
 *
 */
 include_once('database_info.php');
 include_once('time_manip.php');
class Database
{
	// Local variable holds connection to database.
	var $link;

	// Constructor creates connection to database, places in $link.
	function Database() 
	{
		$this->link = mysql_connect( DB_SERVER, DB_USER, DB_PASS ) or die( mysql_error() );
		mysql_select_db( DB_NAME, $this->link ) or die( mysql_error() );
	}

	// Wrapper to run a small query outside this file without creating an internal function.
	function query( $sql )
	{
		return mysql_query( $sql, $this->link );
	}

	function getAttributes()
	{
		$arr = array();
		$sql = "SELECT * FROM users";
		$res = mysql_query( $sql, $this->link );
		$i = 0;
		while( $i < mysql_num_fields( $res ) )
		{
			$meta = mysql_fetch_field( $res, $i );
			array_push( $arr,  $meta->name );
			$i++;
		}
		return $arr;
	}

	// Password considered to come pre-hashed.
	function verifyPass( $uname, $pass )
	{
		// Checks if all '' "" \ and NULLs are escaped with a backslash already 
		// (known as escaping the data for SQL injection protection).
		if( !get_magic_quotes_gpc() )
		{
			// Escape the string for SQL injection protection.
			$uname = addslashes( $uname );
		}

		// Verify existance
		$sql = "SELECT user_pass FROM users WHERE user_name='$uname'";
		$results = mysql_query( $sql, $this->link );
		if( !$results || (mysql_numrows( $results ) < 1 ) ) 
		{
			return -1; // Failed
		}

		$data = mysql_fetch_array( $results );
		$data['user_pass'] = stripslashes( $data['user_pass'] );
		$pass = stripslashes( $pass );
		
		if( $pass == $data['user_pass'] )
		{
			return 0; // Successful
		}
		else
		{
			return -1;
		}
	}


	function verifyUser( $uname, $id )
	{
		if( !get_magic_quotes_gpc() ) 
		{
			$uname = addslashes( $uname );
		}
		// Verify existance  of user and get there current logged in id if exists
		$sql = "SELECT logged_id FROM users WHERE user_name='$uname'";
		$results = mysql_query( $sql, $this->link );
		if( !$results || (mysql_numrows( $results ) < 1 ) ) 
		{
			return -1; // Failed
		}
		
		$data = mysql_fetch_array( $results );
		$data['logged_id'] = stripslashes( $data['logged_id'] );
		$id= stripslashes( $id );
		
		if( $id == $data['logged_in'] ) 
		{
			return 0; //Success
		}
		else
		{
			return -1;
		}
	}

	function isNameTaken( $uname )
	{
		if( !get_magic_quotes_gpc() ) 
		{
			$uname = addslashes( $uname );
		}
		
		$sql = "SELECT user_name FROM users WHERE user_name='$uname'";
		$result = mysql_query( $sql, $this->link );

		// If there was no tuple returned -> name does not exist.
		return ( mysql_numrows( $result ) > 0 );
	}


	function getUserInfo( $uname )
	{
	    $sql = "SELECT * FROM users WHERE user_name='$uname'";
	    $result = mysql_query( $sql, $this->link );
	    return mysql_fetch_assoc( $result );
	}

	/*
	Used to compare two values in different tables. More specifically, it searches 
	a user id in one table and looks for that specific id number in the other table.
	*/
	function get_user_id( $uname )
	{
		$user_info = "SELECT user_name,user_id FROM users WHERE user_name = '$uname' ";
		$user = $this->query($user_info);
		if($row = mysql_fetch_array($user))
			return $row['user_id'];
		else
			return -1; //does not exist in database		
	}


	function get_username( $compare_id, $search_id = 'user_id' )
	{
		$retrive_info = "SELECT user_id, user_name FROM users";
		$retrieve = $this->query($retrive_info);
		while($retrieve_name = mysql_fetch_array($retrieve))
		{
			if(strcmp($compare_id, $retrieve_name[$search_id]) == 0)
			{
				return $retrieve_name['user_name'];
			}
		}			
	}

	function message_exist ($mid)
	{
		$message = "SELECT message_id FROM messages WHERE message_id = '$mid";
		if($row = $this->query($message))
		return true;
		else
		return false;
	}

	function removeAccount( $uname )
	{
	    $sql = "SELECT user_id FROM users WHERE user_name='$uname'";
	    $result = mysql_query( $sql, $this->link );
	    $row = mysql_fetch_array( $result );
	    $uid = $row['user_id'];
	    $sql = "DELETE FROM followers WHERE follower_id='$uid';";
	    mysql_query( $sql, $this->link );
	    //$sql = "DELETE FROM followers WHERE follower_id='$uid';";
	    //mysql_query( $sql, $this->link );
            $sql = "DELETE FROM users WHERE user_name='$uname'; ";
	    return mysql_query( $sql, $this->link );

	}
	
	function updateField( $uname, $field, $element )
	{
		$sql = "UPDATE users SET ".$field."='$element' WHERE user_name='$uname'";
		return mysql_query( $sql, $this->link );
	}	
	
	function addUser( $uname, $email, $pword, $city, $state, $zip ) 
	{
		// Create User ID
		$sql = "INSERT INTO users ( user_name, user_email, user_pass, city, state, zipcode ) VALUES ( '$uname', '$email', '$pword', '$city', '$state', '$zip' )";
		return mysql_query( $sql, $this->link );
	}

	
	function check_user_exists( $uid, $uname )
	{
		$check_user = "SELECT * FROM users WHERE user_id = '$uid' AND user_name = '$uname'";
		$result = $this->query($check_user);
		//if exist
		if(mysql_num_rows($result) == 1) return 0;
		//if not exist
		else return -1;
		
	}

//REMOVE THIS WE ARE GOING TO REMOVE THESE ATTRIBUTES.
	function profile_details( $sql )
	{
		$profile = $this->query($sql);
		while($row = mysql_fetch_array($profile))
		{
			echo $row['user_email']."<br>";
			echo "Grwls:" .$row['message_count']."<br>";
			echo "Following:". $row['friends_count']."<br>";
			echo "Followers:". $row['followers_count']."<br>";
		}
	}
	
	function pending_count( $uid )
	{
		$pending_info = "SELECT * FROM followers WHERE leader_id = '$uid'";
		$pending = $this->query($pending_info);
		$count = 0;
		while($row = mysql_fetch_array($pending))
		{
			if($row['status'] == 0)
			{
			$count += 1;
			}
		}
			if($count != 0) return "<p>You currently have ". $count ." following request(s):</p>";
		
	}
	
	function pending_push( $uid )
	{
		$pending_info = "SELECT * FROM followers WHERE leader_id = '$uid'";
		$pending = $this->query($pending_info);
		$follower_r = array();
		while($row = mysql_fetch_array($pending))
		{
			if( $row['status'] == 0)
			{
				$follower = $this->get_username($row['follower_id']);
				//array_push($follower_r,"<br>".$follower." sent you a follower's request"."</br></br>");
				array_push($follower_r,$row['follower_id']);
			}
		}		
		return $follower_r;
	}
	
	//adds a new message and returns the message id of the created message
	function add_new_message( $priv, $msg, $lat, $lng, $subloc, $loc, $uid )
	{
		// Create new message
		
		if($priv == on)
			$priv = 1;
		else
			$priv = 0;

		$good = 0;

		$new_mes = "INSERT INTO messages	( user_id, text, created_at, privacy, lat, lng, subloc, loc ) VALUES ( '$uid', '$msg', now(), '$priv', '$lat', '$lng', '$subloc', '$loc' )";

		if(mysql_query( $new_mes, $this->link ))
			$good = 1;

		$find = "SELECT message_id FROM messages WHERE text='$msg'";
		$mes_id = mysql_query( $find, $this->link );
		
		while($row = mysql_fetch_array($mes_id))
		{
			$msgid = $row['message_id'];
		}

		//increment message count
		$this->incr_msg_cnt($uid);

		if($good == 1)
			return $msgid;
		else
			return -1;
	}

	// Create new target for given message, and update message table
	function add_new_target( $msg_id, $target_name )
	{
		$new_targ = "INSERT INTO targets	( message_id, target_name ) VALUES ( '$msg_id', '$target_name' )";
		$add_tag = "UPDATE messages SET has_target='1' WHERE message_id='$msg_id'";
		mysql_query( $add_tag, $this->link );
		return mysql_query( $new_targ, $this->link );
	}
	
	//Check to see if a user is a target
	function is_target( $msg_id, $user_name )
	{
		$find = "SELECT target_name FROM targets WHERE message_id='$msg_id'";
		$targets = mysql_query( $find, $this->link );
		
		while($row2 = mysql_fetch_array($targets))
		{
				if($user_name == $row2['target_name'])
					return 1;
		}
		return 0;
	}
	
	// Create new subject for given message
	function add_new_subject( $msg_id, $sub )
	{
		$new_sub = "INSERT INTO subjects	( message_id, subject ) VALUES ( '$msg_id', '$sub' )";
		return mysql_query( $new_sub, $this->link );
	}

	//increments the message count
	function incr_msg_cnt( $uid )
	{
		$info = "SELECT * FROM users WHERE user_id='$uid'";
		$result = $this->query( $info );
		$row = mysql_fetch_array($result);
		$num = $row['message_count'];
		$num = $num + 1;

		$incr = "UPDATE users SET message_count='$num' WHERE user_id='$uid'";
		return mysql_query( $incr, $this->link );
	}
	function decrease_msg_cnt( $uid )
	{
		$info = "SELECT * FROM users WHERE user_id='$uid'";
		$result = $this->query( $info );
		$row = mysql_fetch_array($result);
		$num = $row['message_count'];
		$num = $num - 1;

		$incr = "UPDATE users SET message_count='$num' WHERE user_id='$uid'";
		return mysql_query( $incr, $this->link );
	}

	function follow_request($other_id, $userid)
	{
		$info = "SELECT * FROM users WHERE user_id='$other_id'";
		$result = $this->query( $info );
	
		$row = mysql_fetch_array($result);
		
		//public profiles don't need to be approved(no_pend), others do(pend)
		$pend = "INSERT INTO followers ( leader_id, follower_id, status ) VALUES ( '$other_id', '$userid', 0 )";
		$no_pend = "INSERT INTO followers ( leader_id, follower_id, status ) VALUES ( '$other_id', '$userid', 1 )";
		
		if($row['protected'] == '0')
			return mysql_query( $no_pend, $this->link );
		else
			return mysql_query( $pend, $this->link );
	}

	
		/*This function returns a 1(true) when that person is following that person*/	
	function is_following($user_id, $other_id)
	{
		$f_info = "SELECT * FROM followers WHERE follower_id='$user_id' AND leader_id= '$other_id' AND status ='1' ";
		$follow = $this->query($f_info);
		if($row = mysql_fetch_array($follow) or $user_id == $other_id)
		{
			return 1;
		}
		else
			return 0;
	}
	
	function get_user_pic($username)
	{
			$p_pic = "SELECT * FROM users WHERE user_name='$username'";
			$profile_pic = $this->query($p_pic);
			while($row = mysql_fetch_array($profile_pic))
			{
				return $row['profile_image_url'];
				
			}
	}
 
	
	/*Print messages of the people that they are following*/
	function retrieve_messages($username)
	{
		$user_id = $this->get_user_id($username);
		$feed_info = "SELECT * FROM messages ORDER BY created_at DESC";
		$feed = $this->query($feed_info);
		$msgs_r = array();
		array_push($msgs_r,'<ul>');
		while($row = mysql_fetch_array($feed))
		{
			$other_id = $row['user_id'];
			$subloc = $row['subloc'];
			$loc = $row['loc'];
			$other_name = $this->get_username($other_id);
			$msg_id = $row['message_id'];
			$flag = 0;
			$text = $row['text']." ";
			if($row['has_target'])
			{
				if($this->is_target($msg_id, $username) == '1' || $username == $other_name)
				{
					$name = $this->get_username($row['user_id']);
					$pic = $this->get_user_pic($name);
					$timestamp = convert_to_seconds($row['created_at']);
					
					$num_targ = preg_match_all("/@[a-zA-Z]+[,\s\r\n]/", $text, $matches, PREG_SET_ORDER);
					foreach($matches as &$value)
					{
						$new_var = substr($value[0], 0, -1);
						$new_var2 = substr($value[0], 1, -1);
						$text = str_replace(substr($value[0], 0, -1), "<a href=/$new_var2>$new_var</a>", $text);
					}
				
					if($user_id == $other_id)
					{
						$edit = "canedit" ;
					}
					else
					{
						$edit ="cannotedit";
					}

					if($row['privacy'] == 1)
					{
						if(strlen($subloc) > 0){
						array_push($msgs_r,"<li><img src='$pic' alt='$other_name&lsquo;s profile picture ' /><strong><a href=\"/$name\">$name</a></strong><p>",$edit.$row['message_id'],$text,time_between($timestamp,time()).'</p><span style="color:#0404B4;"> (private)</span><p>From:'.$subloc.','.$loc.'</p></li>');
						}
						else array_push($msgs_r,"<li><img src='$pic' alt='$other_name&lsquo;s profile picture ' /><strong><a href=\"/$name\">$name</a></strong><p>",$edit.$row['message_id'],$text,time_between($timestamp,time()).'</p><span style="color:#0404B4;"> (private)</span></li>');

					}/*
					else
						array_push($msgs_r,"<li><img src='$pic' alt='$other_name&lsquo;s profile picture' /><strong><a href=\"/$name\">$name</a></strong><p>",$edit.$row['message_id'],$row['text'],time_between($timestamp,time()).'</p></li>');	
*/

				}
			}
			else if($this->is_following($user_id, $other_id)==1)
			{
				$name = $this->get_username($row['user_id']);
				$other_name = $this->get_username($other_id);
				$pic = $this->get_user_pic($name);
				$timestamp = convert_to_seconds($row['created_at']);
				
				if($user_id == $other_id)
				{
					$edit = "canedit" ;
				}
				else
				{
					$edit ="cannotedit";
				}
					if($row['privacy'] == 1)
				{
						if(strlen($subloc) > 0){
						array_push($msgs_r,"<li><img src='$pic' alt='$other_name&lsquo;s profile picture ' /><strong><a href=\"/$name\">$name</a></strong><p>",$edit.$row['message_id'],$text,time_between($timestamp,time()).'</p><span style="color:#0404B4;"> (private)</span><p>From:'.$subloc.','.$loc.'</p></li>');
						}
						else array_push($msgs_r,"<li><img src='$pic' alt='$other_name&lsquo;s profile picture ' /><strong><a href=\"/$name\">$name</a></strong><p>",$edit.$row['message_id'],$text,time_between($timestamp,time()).'</p><span style="color:#0404B4;"> (private)</span></li>');
				}
				else{
						if(strlen($subloc) > 0){
						array_push($msgs_r,"<li><img src='$pic' alt='$other_name&lsquo;s profile picture ' /><strong><a href=\"/$name\">$name</a></strong><p>",$edit.$row['message_id'],$text,time_between($timestamp,time()).'</p><p>From:'.$subloc.','.$loc.'</p></li>');
						}
						else array_push($msgs_r,"<li><img src='$pic' alt='$other_name&lsquo;s profile picture ' /><strong><a href=\"/$name\">$name</a></strong><p>",$edit.$row['message_id'],$text,time_between($timestamp,time()).'</p></li>');
				}			
			}
		}
		array_push($msgs_r,'<ul>');
		return $msgs_r;
	}
	
	//displays messages onto the poublic view of the user
	function retrieve_public_messages($userid,$dis_private = '0')
	{
		$user_id = $this->get_user_id($username);
		$user_name = $this->get_username($userid);
		$feed_info = "SELECT * FROM messages WHERE user_id='$userid' OR has_target='1' ORDER BY created_at DESC";
		$feed = $this->query($feed_info);
		$msgs_r = array();
		while($row = mysql_fetch_array($feed))
		{
			$text = $row['text']." ";
			$subloc = $row['subloc'];
			$loc = $row['loc'];
			$pic = $this->get_user_pic($user_name);
			if($row['has_target'] == 1)
			{
				if($row['user_id'] == $userid || $this->is_target($row['message_id'], $user_name))
				{
					if($row['privacy'] == 0 AND $dis_private == '0')
					{
						$timestamp = convert_to_seconds($row['created_at']);
						array_push($msgs_r,"<li>".$row['text'],time_between($timestamp,time())."</li>");
					}
					else if($dis_private == '1')
					{
						$num_targ = preg_match_all("/@[a-zA-Z]+[,\s\r\n]/", $text, $matches, PREG_SET_ORDER);
						foreach($matches as &$value)
						{
							$new_var = substr($value[0], 0, -1);
							$new_var2 = substr($value[0], 1, -1);
							$text = str_replace(substr($value[0], 0, -1), "<a href=/$new_var2>$new_var</a>", $text);
						}
				
						$timestamp = convert_to_seconds($row['created_at']);
						if($row['privacy'] == 1)
						{
							array_push($msgs_r,"<li><img src='$pic' alt='$user_name&lsquo;s profile picture ' /><strong><a href=\"/$user_name\">$user_name</a></strong>".$text,time_between($timestamp,time()).'<span style="color:#0404B4;"> (private)</span></li>');
						}
						else
							array_push($msgs_r,"<li><img src='$pic' alt='$user_name&lsquo;s profile picture ' /><strong><a href=\"/$user_name\">$user_name</a></strong>".$row['text'],time_between($timestamp,time()).'</li>');	

					}
				}
			}
			else
			{
				if($row['privacy'] == 0 AND $dis_private == '0')
				{
					$timestamp = convert_to_seconds($row['created_at']);
					array_push($msgs_r,"<li>".$row['text'],time_between($timestamp,time())."</li>");
				}
				else if($dis_private == '1')
				{
					$text = $row['text']." ";
					$num_targ = preg_match_all("/@[a-zA-Z]+[,\s\r\n]/", $text, $matches, PREG_SET_ORDER);
					foreach($matches as &$value)
					{
						$new_var = substr($value[0], 0, -1);
						$new_var2 = substr($value[0], 1, -1);
						$text = str_replace(substr($value[0], 0, -1), "<a href=/$new_var2>$new_var</a>", $text);
					}
				
					$timestamp = convert_to_seconds($row['created_at']);
					if($row['privacy'] == 1)
				{
						if(strlen($subloc) > 0){
						array_push($msgs_r,"<li><img src='$pic' alt='$user_name&lsquo;s profile picture ' /><strong><a href=\"/$user_name\">$user_name</a></strong><p>",$text,time_between($timestamp,time()).'</p><span style="color:#0404B4;"> (private)</span><p>From:'.$subloc.','.$loc.'</p></li>');
						}
						else array_push($msgs_r,"<li><img src='$pic' alt='$user_name&lsquo;s profile picture ' /><strong><a href=\"/$user_name\">$user_name</a></strong><p>",$text,time_between($timestamp,time()).'</p><span style="color:#0404B4;"> (private)</span></li>');
				}
				else{
						if(strlen($subloc) > 0){
						array_push($msgs_r,"<li><img src='$pic' alt='$user_name&lsquo;s profile picture ' /><strong><a href=\"/$user_name\">$user_name</a></strong><p>",$text,time_between($timestamp,time()).'</p><p>From:'.$subloc.','.$loc.'</p></li>');
						}
						else array_push($msgs_r,"<li><img src='$pic' alt='$user_name&lsquo;s profile picture ' /><strong><a href=\"/$user_name\">$user_name</a></strong><p>",$text,time_between($timestamp,time()).'</p></li>');
				}			

				}
			}
			
		}
		return $msgs_r;
	}
	
	function confirm_request($other_id, $userid)
	{	
		$confirm = "UPDATE followers SET status='1' WHERE leader_id='$userid' AND follower_id='$other_id'  ";
		return mysql_query( $confirm, $this->link );
	}
	
	function deny_request($other_id, $userid)
	{	
		$deny = "DELETE FROM followers WHERE leader_id='$userid' AND follower_id='$other_id'  ";
		return mysql_query( $deny, $this->link );
	}
	
	//delete a message when the user clicks on the delete button
	function delete_message ( $message_id )
	{
		$delete = "DELETE FROM messages WHERE message_id='$message_id' ";
		$id = $this->userid_from_mid($message_id);
		//echo "poop".$id."poop";
		$this->decrease_msg_cnt($id);
		return mysql_query( $delete, $this->link );
	}
	
	
	//function returns the userid from a message id. 
	function userid_from_mid($mid)
	{
		$info = "SELECT * FROM messages WHERE message_id ='$mid'";
		//$messages_info = "SELECT * FROM users";
		$message = mysql_query($info);
		if($row = mysql_fetch_array($message))
		return $row['user_id'];
		else
		return -1;
	}
	


	//NEW AS OF MILESTONE 1
	function isAdminPrivilege( $uname )
	{
		$row = $this->getUserInfo( $uname );
		if( $row['privilege'] > 0 )
		{
			return true;
		}	
		return false;
	}

	function searchDB( $query )
	{
		$res_arr = array();
		if(preg_match("/^[a-z]+/", $query ) )
		{
			$sql = "SELECT  user_name FROM users WHERE user_name LIKE \"%$query%\""; 
			$result = mysql_query( $sql, $this->link ); 
			while( $row = mysql_fetch_array( $result ) )
			{
				array_push( $res_arr, $row['user_name'] );
			}
			return $res_arr;
		}
	}

		//returns whether or not the given message has the desired subject in it
	function has_subject( $query, $msg_id )
	{
		preg_match("/^[a-zA-Z0-9]+/", $query );
		$sql = "SELECT message_id FROM subjects WHERE subject LIKE \"%$query%\""; 
		$result = mysql_query( $sql, $this->link );

		while( $row2 = mysql_fetch_array( $result ) )
		{
			if($row2['message_id'] == $msg_id)
				return 1;;
		}
		return 0;
	}

	//searches for any messages that include the given subject. Returns a list of approved message's
	function searchDB_for_sub( $query, $username )
	{
		$res_arr = array();
		if(preg_match("/^[a-zA-Z0-9]+/", $query ) )
		{
			$user_id = $this->get_user_id($username);
			$sfeed_info = "SELECT * FROM messages ORDER BY created_at DESC";
			$sfeed = mysql_query($sfeed_info);
			
			while($row = mysql_fetch_array( $sfeed ) )
			{
				$msg_id = $row['message_id'];
				$other_id = $row['user_id'];
				if($row['privacy'] == 0 || $this->is_following($user_id, $other_id)==1)
				{
					if($this->has_subject( $query, $msg_id )==1)
					{
						$name = $this->get_username($row['user_id']);
						$pic = $this->get_user_pic($name);
						$timestamp = convert_to_seconds($row['created_at']);
						$text = $row['text']." ";
						$num_targ = preg_match_all("/@[a-zA-Z]+[,\s\r\n]/", $text, $matches, PREG_SET_ORDER);
						foreach($matches as &$value)
						{
							$new_var = substr($value[0], 0, -1);
							$new_var2 = substr($value[0], 1, -1);
							$text = str_replace(substr($value[0], 0, -1), "<a href=/$new_var2>$new_var</a>", $text);
						}
					
						if($user_id == $other_id)
						{
							$edit = "canedit" ;
						}
						else
						{
							$edit ="cannotedit";
						}

						if($row['privacy'] == 1)
						{
							array_push($res_arr,"<li><img src='$pic' alt='$other_name&lsquo;s profile picture ' /><strong><a href=\"/$name\">$name</a></strong><p>",$edit.$row['message_id'],$text,time_between($timestamp,time()).'</p><span style="color:#0404B4;"> (private)</span></li>');
						}
						else
							array_push($res_arr,"<li><img src='$pic' alt='$other_name&lsquo;s profile picture' /><strong><a href=\"/$name\">$name</a></strong><p>",$edit.$row['message_id'],$text,time_between($timestamp,time()).'</p></li>');
					}

				}
			}
			return $res_arr;
		}
	}

	//returns whether or not the given userid matches a desired id
	function matches_id( $query, $uid )
	{
		preg_match("/^[a-z]+/", $query );
		$sql = "SELECT user_id FROM users WHERE user_name LIKE \"%$query%\""; 
		$result = mysql_query( $sql, $this->link );

		while( $row2 = mysql_fetch_array( $result ) )
		{
			if($row2['user_id'] == $uid)
				return 1;
		}
		return 0;
	}

	//returns all messages by the user if permissable
	function searchDB_for_user( $query, $username )
	{
		$res_arr = array();
		if(preg_match("/^[a-z]+/", $query ) )
		{
			$user_id = $this->get_user_id($username);

			$sfeed_info = "SELECT * FROM messages ORDER BY created_at DESC";
			$sfeed = mysql_query($sfeed_info);
			
			while($row = mysql_fetch_array( $sfeed ) )
			{
				$msg_id = $row['message_id'];
				$other_id = $row['user_id'];
				if($row['privacy'] == 0 || $this->is_following($user_id, $other_id)==1)
				{
					if($this->matches_id( $query, $other_id )==1)
					{
						$name = $this->get_username($row['user_id']);
						$pic = $this->get_user_pic($name);
						$timestamp = convert_to_seconds($row['created_at']);
						$text = $row['text']." ";
						$num_targ = preg_match_all("/@[a-zA-Z]+[,\s\r\n]/", $text, $matches, PREG_SET_ORDER);
						foreach($matches as &$value)
						{
							$new_var = substr($value[0], 0, -1);
							$new_var2 = substr($value[0], 1, -1);
							$text = str_replace(substr($value[0], 0, -1), "<a href=/$new_var2>$new_var</a>", $text);
						}
					
						if($user_id == $other_id)
						{
							$edit = "canedit" ;
						}
						else
						{
							$edit ="cannotedit";
						}

						if($row['privacy'] == 1)
						{
							array_push($res_arr,"<li><img src='$pic' alt='$other_name&lsquo;s profile picture ' /><strong><a href=\"/$name\">$name</a></strong><p>",$edit.$row['message_id'],$text,time_between($timestamp,time()).'</p><span style="color:#0404B4;"> (private)</span></li>');
						}
						else
							array_push($res_arr,"<li><img src='$pic' alt='$other_name&lsquo;s profile picture' /><strong><a href=\"/$name\">$name</a></strong><p>",$edit.$row['message_id'],$text,time_between($timestamp,time()).'</p></li>');
					}

				}
			}
			return $res_arr;
		}
	}

	//returns the people that user is following
	function get_stalkers( $userid )
	{
		$sql = "SELECT follower_id FROM followers WHERE leader_id='$userid' AND status='1' LIMIT 0, 10";
		$result = mysql_query( $sql, $this->link );
		$res_arr = array();
		array_push($res_arr, '<div class="clear"></div><h3>Followers:</h3><ul>');

		while($row = mysql_fetch_array( $result ) )
		{
			$name = $this->get_username($row['follower_id']);
			$pic = $this->get_user_pic($name);
			array_push($res_arr,"<li><a href='/$name'><img src='$pic' alt='".$name."'&lsquo;s profile picture' /></a></li>");
		}
		array_push($res_arr, '</ul>');
		return $res_arr;
	}

	//returns the people that user is following
	function get_followers( $userid )
	{
		$sql = "SELECT leader_id FROM followers WHERE follower_id='$userid' AND status='1' LIMIT 0, 10";
		$result = mysql_query( $sql, $this->link );
		$res_arr = array();
		array_push($res_arr, '<div class="clear"></div><h3>Following:</h3><ul>');

		while($row = mysql_fetch_array( $result ) )
		{
			$name = $this->get_username($row['leader_id']);
			$pic = $this->get_user_pic($name);
			array_push($res_arr,"<li><a href='/$name'><img src='$pic' alt='".$name."'&lsquo;s profile picture' /></a></li>");
		}
		array_push($res_arr, '</ul>');
		return $res_arr;
	}

	function getUserPass( $uname )
	{
		$sql = "SELECT user_pass FROM users WHERE user_name = '$uname' ";
		$res = mysql_query( $sql, $this->link );
		$pass = mysql_fetch_array( $res );
		return $pass['user_pass'];
	}

	function get_geoloc($_uname)
	{
		$user_id = $this->get_user_id($_uname);
		$sql = "SELECT * FROM messages WHERE user_id='$user_id' and lat !=''";
		$result = mysql_query( $sql, $this->link );
		$res_arr = array();
		while($row = mysql_fetch_array( $result ) )
		{

			array_push($res_arr,$row['lat'].",".$row['lng']);
		}
		//echo $res_arr;
		//echo json_encode($res_arr);
	}
	
};		

// Creating database connection.
$database = new Database;
?>