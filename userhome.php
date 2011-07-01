<div id="_geo_map"></div>

<div id="_profile_details"><!--Start #_profile_details"-->
<?php	

	$p_info = "SELECT * FROM users WHERE user_name='$session_ctrl->uname'";
	$profile = $database->query($p_info);
	while($row = mysql_fetch_array($profile))
	{
		$pic = $row['profile_image_url'];
		$var = "<img src='$pic' alt='$session_ctrl->uname' />";

		echo $var;
		echo "<h2>".$row['user_name']."</h2>";
		echo "<p>".$row['city'].", ";
		echo $row['state']."</p>";
		echo "<h3>Description:</h3><p>".$row['description']."</p>";
		
	}
?>

</div><!--End #_profile_details"-->
<div class="clear"></div>
	<?php  if( isset( $_SESSION['msg_error'] ) ) { echo "<p class='error'>".$_SESSION['msg_error']."</p>"; } unset($_SESSION['msg_error']);?>
	<?php  if( isset( $_SESSION['conf_err'] ) ) {  echo "<p class='error'>".$_SESSION['conf_err']."</p>"; } unset($_SESSION['conf_err']);?>
	<?php  if( isset( $_SESSION['den_err'] ) ) {  echo "<p class='error'>".$_SESSION['den_err']."</p>"; } unset($_SESSION['den_err']);?>
			
			<div id="_profile_msg">
			<!--New Message Form-->
			<form action="handler.php" method="POST" >
			<input class="_form_input" type="text" name="message" value="What's grwl'n you?"></input>
			<input id="lat" type="hidden" name="lat" value="">
  			<input id="lng" type="hidden" name="lng" value="">
  			<input id="subloc" type="hidden" name="subloc" value="">
  			<input id="loc" type="hidden" name="loc" value="">
			<input class="_form_button" type="submit" name="new_message" value="Post">
			<?php

				$info = "SELECT * FROM users WHERE user_name='$session_ctrl->uname'";
				$result = $database->query($info); //using database function

				$row = mysql_fetch_array($result);

				$strt = "<label for='_private_check'>Make Message Private:</label>";
				$priv = "<input id='_private_check' type='checkbox' checked='yes' name='privacy' />";
				$nopriv = "<input id='_private_check' type='checkbox' name='privacy' />";

				if($row['protected'] != 0)
					echo $strt.$priv;
				else
					echo $strt.$nopriv;
				
					
			?>
			</form>
			<button id="geo_btn" onclick="getGeolocation()" type="button">Add your location</button>
			<!--New Message Form-->
			</div>

<div id="_user_stream" >
		<ul class="tabs">
			<li><a href="#tab1">Message Stream</a></li>
			<li><a href="#tab2">Filter Messages</a></li>
		</ul>
		<div class="clear"></div>
		<div id="tab1" class="tab_content">
			<div id="_profile_stream"><!--Start #_profile_details"-->


			<!--Message Stream-->
			<?php
						$msgs = $database->retrieve_messages($session_ctrl->uname);
						foreach($msgs as $value)
						{
						if(substr($value, 0, 7) == "canedit")
						{
						//extracts the message_id
						$value1 = substr($value,7,strlen($value)-6);
			?>
						<!--Delete a message-->
						<form action="handler.php" method="POST" >
						<?php    if( isset( $_SESSION['delete_err'] ) ) { echo "<p class='error'>".$_SESSION['delete_err']."</p>"; } unset($_SESSION['delete_err']);?>
						<input class="_form_button" type="submit" name="m_delete" value="delete">
						<input type="hidden" name="message_id" value="<?php echo $value1 ?>" />
						</form>
						<!--End Delete a message-->
			<?php
						}
						else if(substr($value, 0, 10) == "cannotedit")
						{
						}
						else
							echo($value);
						}
			?>
			<!--End Message Stream-->

			</div><!--End #_profile_details-->
		</div>

		<div id="tab2" class="tab_content">
			<div id="_subject_filter"><!--Start #_subject_filter"-->
				<form id="_search_sub_form" action="handler.php" method="POST" >
				<ul>
					<?php echo "</br>"; echo "<div class='error'>".$_SESSION['no_sub_found']."</div>"; unset($_SESSION['no_sub_found']);?>
					<li><input class="_form_input" type="text" name="sub_wanted" value="Find subject">
					<input type="hidden" name="searcher" value="index.php"></input>
					<p>Filter by user</p>
					<input id='_search_user' type='checkbox' name='search_user' />
					<input class="_form_button" type="submit" name="search_sub" value="Search"></li>
				</ul>
				<?php
					if( isset( $_SESSION['sub_fnd'] ) )
					{
						echo "<ul>";
						$msgs = $database->retrieve_messages($session_ctrl->uname);
						foreach($_SESSION['sub_fnd'] as $value)
						{
							if(substr($value, 0, 7) == "canedit")
							{
							//extracts the message_id
							$value1 = substr($value,7,strlen($value)-6);
				?>
							<!--Delete a message-->
							<form action="handler.php" method="POST" >
							<?php    if( isset( $_SESSION['delete_err'] ) ) { echo "<p class='error'>".$_SESSION['delete_err']."</p>"; } unset($_SESSION['delete_err']);?>
							<input class="_form_button" type="submit" name="m_delete" value="delete">
							<input type="hidden" class="filtering" name="message_id" value="<?php echo $value1 ?>" />
							</form>
							<!--End Delete a message-->
				<?php
							}
							else if(substr($value, 0, 10) == "cannotedit")
							{
							}
							else
								echo($value);
						}
						unset( $_SESSION['sub_fnd'] );
					}
				?>
				</form>
			</div><!--End #_subject_filter"-->
		</div>
</div>


<div id="_profile_follows"><!--Start #_profile_details-->
<?php
			
			/*Gets the pending vector of user_ids, if the vector 
			has contents then it will display pending request*/
			$username = $session_ctrl->uname;
			$userid = $database->get_user_id($username);
			$pending_count = $database->pending_count($userid);
			$pending = $database->pending_push($userid);
			echo $pending_count;
				foreach($pending as $value1)
				{
					$follow_uname = $database->get_username($value1);
					echo "<p>".$follow_uname." would like to follow you</p>";
				
?>
		<!--Confirm/Deny Button-->
		<form action="handler.php" method="POST" >
			<ul>
			<li><input class="_form_button" type="submit" name="confirm" value="Confirm!"></li>
			<li><input class="_form_button" type="submit" name="deny" value="Deny!"></li><br><br>
			<li><input type="hidden" name="follower_id" value="<?php echo $value1 ?>" /></li>
			</ul>
		</form>
		<!--end Confirm/Deny Button-->
<?php  			}
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
<div class="clear"></div>

