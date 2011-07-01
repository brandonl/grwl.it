SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


CREATE TABLE IF NOT EXISTS `followers` (
  `leader_id` int(10) unsigned NOT NULL,
  `follower_id` int(10) unsigned NOT NULL,
  `followed_since` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`leader_id`,`follower_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `followers` (`leader_id`, `follower_id`, `followed_since`, `status`) VALUES
(3, 4, '2011-01-24 08:13:20', '1'),
(3, 13, '2011-01-24 08:13:20', '1'),
(4, 3, '2011-01-24 08:13:20', '1'),
(4, 13, '2011-01-24 08:13:20', '1');

CREATE TABLE IF NOT EXISTS `messages` (
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `message_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `text` varchar(140) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sms` int(1) NOT NULL,
  `privacy` int(1) NOT NULL,
  PRIMARY KEY (`user_id`,`message_id`),
  UNIQUE KEY `message_id` (`message_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

INSERT INTO `messages` (`user_id`, `message_id`, `text`, `created_at`, `sms`, `privacy`) VALUES
(3, 3, 'Hello World!', '2011-01-24 08:13:20', 0, 0),
(4, 4, 'Hello World!', '2011-01-24 08:13:20', 0, 0);

CREATE TABLE IF NOT EXISTS `users` (
  `user_name` varchar(32) NOT NULL,
  `user_email` varchar(64) NOT NULL,
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_pass` varchar(32) NOT NULL,
  `city` varchar(20) NOT NULL,
  `state` char(2) NOT NULL,
  `zipcode` int(5) NOT NULL,
  `description` varchar(300) DEFAULT NULL,
  `profile_image_url` varchar(400) NOT NULL DEFAULT '/images/default_profile_pic.gif',
  `protected` int(1) unsigned DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `friends_count` int(10) unsigned DEFAULT '0',
  `followers_count` int(10) unsigned DEFAULT '0',
  `message_count` int(10) unsigned DEFAULT '0',
  `logged_in` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_name` (`user_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

INSERT INTO `users` (`user_name`, `user_email`, `user_id`, `user_pass`, `city`, `state`, `zipcode`, `description`, `profile_image_url`, `protected`, `created_at`, `updated_at`, `friends_count`, `followers_count`, `message_count`, `logged_in`) VALUES
('jaycee', 'jaycee@gmail.com', 3, '819b0643d6b89dc9b579fdfc9094f28e', 'riverside', 'CA', 91725, 'Test description', '/images/blank.png', 0, '2011-01-24 08:13:20', '2011-01-24 08:13:20', 3, 3, 0, NULL),
('mark', 'mark@gmail.com', 4, '34cc93ece0ba9e3f6f235d4af979b16c', 'riverside', 'CA', 91725, 'Test description', '/images/blank.png', 0, '2011-01-24 08:13:20', '2011-01-24 08:13:20', 3, 3, 0, NULL),
('joey', 'joey@gmail.com', 6, 'db0edd04aaac4506f7edab03ac855d56', 'Riverside', 'CA', 91725, NULL, '/images/blank.png', 0, '2011-01-24 10:09:47', '2011-01-24 10:09:47', 0, 0, 0, NULL),
('john', 'john@gmail.com', 7, '218dd27aebeccecae69ad8408d9a36bf', 'Riverside', 'CA', 91725, NULL, '/images/blank.png', 0, '2011-01-24 10:14:35', '2011-01-24 10:14:35', 0, 0, 0, NULL),
('jim', 'jim2@gmail.com', 8, '7c6a180b36896a0a8c02787eeafb0e4c', 'Chino', 'CA', 91710, NULL, '/images/blank.png', 0, '2011-01-31 10:52:06', '2011-01-31 10:52:06', 0, 0, 0, NULL),
('georg', 'goerg@gmail.com', 9, '7c6a180b36896a0a8c02787eeafb0e4c', 'Chino', 'CA', 91871, NULL, '/images/blank.png', 0, '2011-01-31 10:53:04', '2011-01-31 10:53:04', 0, 0, 0, NULL),
('fred', 'fred@gmail.com', 10, '7c6a180b36896a0a8c02787eeafb0e4c', 'Chino', 'CA', 91710, NULL, '/images/blank.png', 0, '2011-01-31 10:53:46', '2011-01-31 10:53:46', 0, 0, 0, NULL),
('rich', 'rich@gmail.com', 11, '7c6a180b36896a0a8c02787eeafb0e4c', 'Chino', 'CA', 91710, NULL, '/images/blank.png', 0, '2011-01-31 10:55:48', '2011-01-31 10:55:48', 0, 0, 0, NULL),
('brad', 'bam@gmail.com', 12, '7c6a180b36896a0a8c02787eeafb0e4c', 'chino', 'CA', 91710, NULL, '/images/default_profile_pic.gif', 0, '2011-02-06 15:07:05', '2011-02-06 15:07:05', 0, 0, 0, NULL),
('brandon', 'bam@gmail.com', 14, '5f4dcc3b5aa765d61d8327deb882cf99', 'CA', '91', 0, NULL, '/images/default_profile_pic.gif', 0, '2011-02-06 19:06:09', '2011-02-06 19:06:09', 0, 0, 0, NULL);


ALTER TABLE `followers`
  ADD CONSTRAINT `followers_ibfk_1` FOREIGN KEY (`leader_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;
