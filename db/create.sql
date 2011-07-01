CREATE TABLE users
(
	user_name varchar(32) NOT NULL,
	user_email varchar(64) NOT NULL,
	user_id int(10) unsigned NOT NULL AUTO_INCREMENT,
	user_pass varchar(32) NOT NULL,
	dob date NOT NULL,
	city varchar(20) NOT NULL,
	state char(2) NOT NULL,
	zipcode int(5) NOT NULL,
	description varchar(300) default NULL,
	profile_image_url varchar(400) NOT NULL default '/images/blank.png',
	protected int(1) unsigned default '0',
	created_at timestamp NOT NULL default '0000-00-00 00:00:00',
	updated_at timestamp NOT NULL default now(),
	friends_count int(10) unsigned default '0',
	followers_count int(10) unsigned default '0',
	message_count int(10) unsigned default '0',
	PRIMARY KEY  (user_id),
	UNIQUE KEY user_name (user_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE messages
(
	user_id int(10) unsigned NOT NULL,
	message_id int(10) unsigned NOT NULL AUTO_INCREMENT,
	text varchar(140) NOT NULL,
	created_at timestamp NOT NULL default now(),
	sms int(1) unsigned default 0 NOT NULL,
	privacy int(1) unsigned default 0 NOT NULL,
	PRIMARY KEY (user_id, message_id),
	FOREIGN KEY (user_id) references users(user_id),
	UNIQUE KEY message_id (message_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE followers
(
	leader_id int(10) unsigned NOT NULL,
	follower_id int(10) unsigned NOT NULL,
	followed_since timestamp NOT NULL default now(),
	status varchar(10) default NULL,
	PRIMARY KEY (leader_id, follower_id),
	FOREIGN KEY (leader_id) references users(user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE targets
(
	message_id int(10) unsigned NOT NULL,
	target_name varchar(32) NOT NULL,
	PRIMARY KEY (message_id, target_name),
	FOREIGN KEY (target_name) references users(user_name),
	FOREIGN KEY (message_id) references messages(message_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE subjects
(
	message_id int(10) unsigned NOT NULL,
	subject varchar(32) NOT NULL,
	PRIMARY KEY (message_id, subject),
	UNIQUE KEY subject (subject),
	FOREIGN KEY (message_id) references messages(message_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;