-- phpMyAdmin SQL Dump
-- version 3.3.7deb5build0.10.10.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 26, 2011 at 04:14 AM
-- Server version: 5.1.49
-- PHP Version: 5.3.3-1ubuntu9.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cs180`
--

-- --------------------------------------------------------

--
-- Table structure for table `followers`
--

CREATE TABLE IF NOT EXISTS `followers` (
  `leader_id` int(10) unsigned NOT NULL,
  `follower_id` int(10) unsigned NOT NULL,
  `followed_since` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`leader_id`,`follower_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `followers`
--

INSERT INTO `followers` (`leader_id`, `follower_id`, `followed_since`, `status`) VALUES
(4, 13, '2011-01-24 08:13:20', '1'),
(4, 21, '2011-03-07 04:47:26', '1'),
(4, 28, '2011-03-08 21:24:24', '1'),
(4, 29, '2011-03-08 03:45:29', '1'),
(6, 29, '2011-03-08 03:40:28', '1'),
(7, 29, '2011-03-08 03:45:43', '1'),
(8, 29, '2011-03-08 03:40:14', '1'),
(9, 28, '2011-03-08 21:07:16', '1'),
(9, 29, '2011-03-08 03:45:59', '1'),
(14, 19, '2011-02-07 09:33:31', '1'),
(16, 18, '2011-02-07 02:42:13', '1'),
(16, 50, '2011-03-10 21:14:52', '1'),
(16, 54, '2011-03-13 21:31:37', '0'),
(19, 18, '2011-02-07 09:55:02', '0'),
(21, 25, '2011-03-07 04:44:19', '1'),
(21, 26, '2011-03-07 04:45:10', '1'),
(21, 29, '2011-03-08 20:46:20', '0'),
(28, 4, '2011-03-14 21:43:41', '1'),
(28, 29, '2011-03-08 03:49:49', '1'),
(29, 4, '2011-03-14 21:43:46', '1'),
(29, 28, '2011-03-08 21:16:15', '1'),
(30, 32, '2011-03-08 06:09:44', '1'),
(30, 33, '2011-03-08 06:13:24', '1'),
(30, 34, '2011-03-08 06:11:50', '1'),
(30, 35, '2011-03-08 22:44:52', '1'),
(32, 30, '2011-03-08 06:09:01', '1'),
(32, 33, '2011-03-08 06:13:51', '1'),
(32, 34, '2011-03-08 06:12:04', '1'),
(33, 30, '2011-03-08 06:08:50', '1'),
(33, 32, '2011-03-08 06:10:16', '1'),
(33, 34, '2011-03-08 06:12:15', '1'),
(34, 30, '2011-03-08 06:08:38', '1'),
(34, 32, '2011-03-08 06:10:30', '1'),
(34, 33, '2011-03-08 06:13:41', '1'),
(38, 39, '2011-03-08 20:40:56', '1'),
(38, 40, '2011-03-08 20:47:02', '1'),
(39, 38, '2011-03-08 20:43:38', '1'),
(39, 40, '2011-03-08 21:26:09', '1'),
(40, 38, '2011-03-08 20:49:00', '1'),
(43, 57, '2011-03-15 03:07:58', '1'),
(50, 54, '2011-03-13 21:31:54', '1'),
(51, 16, '2011-03-12 01:01:38', '1'),
(58, 59, '2011-03-18 00:26:18', '1'),
(61, 59, '2011-04-06 23:33:58', '1');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `message_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `text` varchar(140) NOT NULL,
  `lat` text NOT NULL COMMENT 'message latitude',
  `lng` text NOT NULL COMMENT 'message longitude',
  `subloc` text NOT NULL COMMENT 'sub location',
  `loc` text NOT NULL COMMENT 'location',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `privacy` int(1) NOT NULL,
  `has_target` int(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`,`message_id`),
  UNIQUE KEY `message_id` (`message_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=123 ;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`user_id`, `message_id`, `text`, `lat`, `lng`, `subloc`, `loc`, `created_at`, `privacy`, `has_target`) VALUES
(6, 38, 'Just woke up from a long nap!', '', '', '', '', '2011-03-08 03:41:04', 0, 0),
(6, 39, 'Have so much work to do!', '34.1042576', '-117.70545349999998', 'Claremont', 'CA', '2011-03-08 03:41:27', 0, 0),
(6, 40, 'Time for sushi...!', '', '', '', '', '2011-03-08 03:41:42', 0, 0),
(7, 41, 'Why didnt taht work..', '34.1042576', '-117.70545349999998', 'Claremont', 'CA', '2011-03-08 03:42:53', 0, 0),
(7, 42, 'Dont watch me', '34.1042576', '-117.70545349999998', 'Claremont', 'CA', '2011-03-08 03:43:15', 0, 0),
(7, 43, 'Is it the period.', '', '', '', '', '2011-03-08 03:43:26', 0, 0),
(9, 44, 'This party is a rager!', '34.1042576', '-117.70545349999998', 'Claremont', 'CA', '2011-03-08 03:46:26', 0, 0),
(9, 45, 'Whats going on in #egypt', '', '', '', '', '2011-03-08 03:47:51', 0, 0),
(9, 46, 'Why are you still looking at this?', '34.1042576', '-117.70545349999998', 'Claremont', 'CA', '2011-03-08 03:48:14', 0, 0),
(16, 5, 'Tweet1 public', '', '', '', '', '2011-02-06 23:38:11', 0, 0),
(16, 6, 'Private duh!', '', '', '', '', '2011-02-06 23:57:03', 1, 0),
(16, 8, 'lawl what?', '', '', '', '', '2011-02-07 01:13:34', 0, 0),
(16, 12, 'this redirects..', '', '', '', '', '2011-02-21 05:04:41', 1, 0),
(16, 13, 'testing new message redirect to another page..', '', '', '', '', '2011-02-21 16:50:05', 1, 0),
(16, 14, 'lol', '', '', '', '', '2011-02-21 16:52:41', 1, 0),
(16, 15, 'fuuukyouuu', '', '', '', '', '2011-02-21 17:12:04', 1, 0),
(16, 16, 'lololol', '', '', '', '', '2011-02-21 17:13:20', 1, 0),
(16, 17, 'wtf', '', '', '', '', '2011-02-21 17:25:23', 1, 0),
(16, 20, '@admin wazzzup', '', '', '', '', '2011-03-02 11:11:59', 1, 0),
(16, 21, '@jaycee', '', '', '', '', '2011-03-02 21:50:49', 1, 0),
(16, 22, '@kirby', '', '', '', '', '2011-03-02 21:50:59', 1, 0),
(18, 9, 'My First Growl!', '', '', '', '', '2011-02-07 02:39:00', 0, 0),
(19, 11, 'hi all', '', '', '', '', '2011-02-07 09:31:17', 0, 0),
(20, 18, 'askdjhalskdjaskdjaklsdjaksjdakldjakljdakldjakldjaklsjdkalsjdklasjdklasjdklasjdlaksjdaksjdalksdjlkasdj', '', '', '', '', '2011-02-26 22:46:28', 0, 0),
(20, 19, '@kirby lol', '', '', '', '', '2011-03-01 13:04:38', 1, 0),
(21, 27, 'asdasdasd', '', '', '', '', '2011-03-03 13:47:14', 0, 0),
(21, 29, 'lolololthis is dynamic', '', '', '', '', '2011-03-06 13:46:25', 0, 0),
(21, 31, 'this should not have geot tagging', '', '', '', '', '2011-03-06 15:07:35', 0, 0),
(21, 32, 'this SHOULD have geo tagging', '33.953348', '-117.39615600000002', 'Riverside', 'CA', '2011-03-06 15:08:23', 0, 0),
(21, 33, 'again this should not have taggs', '', '', '', '', '2011-03-06 15:08:56', 0, 0),
(21, 34, 'siiick', '33.953348', '-117.39615600000002', 'Riverside', 'CA', '2011-03-06 15:09:22', 0, 0),
(21, 35, '@test2 wassup we be talking about #gps yo where you at?! ajshdljkashdjlasdhlkasjdklajhdlkajdklasjkldajdlkasdas', '33.953348', '-117.39615600000002', 'Riverside', 'CA', '2011-03-06 15:57:10', 0, 0),
(21, 36, 'DO YOU WORK!?', '34.006062', '-117.3769926', 'Riverside', 'CA', '2011-03-07 05:21:06', 1, 0),
(21, 37, '@jaycee #tester #likeomg', '34.0060598', '-117.3769967', 'Riverside', 'CA', '2011-03-07 05:31:46', 1, 1),
(27, 104, 'WOW', '', '', '', '', '2011-03-10 02:46:13', 0, 0),
(27, 106, 'I am #hungry', '', '', '', '', '2011-03-13 21:50:25', 0, 0),
(27, 107, 'gdf', '34.012234', '-117.68894399999999', 'Chino', 'CA', '2011-03-13 21:59:10', 0, 0),
(27, 108, 'I am screwed for #CS164', '33.953348', '-117.39615600000002', 'Riverside', 'CA', '2011-03-14 21:40:42', 0, 0),
(27, 120, 'ahh', '', '', '', '', '2011-03-26 16:12:38', 0, 0),
(28, 80, 'I love you too @jessie', '', '', '', '', '2011-03-08 21:15:32', 1, 1),
(29, 47, 'I love @greg !', '34.1042576', '-117.70545349999998', 'Claremont', 'CA', '2011-03-08 03:49:41', 1, 1),
(29, 88, 'Maybe I am better off ALONE :(', '33.953348', '-117.39615600000002', 'Riverside', 'CA', '2011-03-08 21:53:26', 0, 0),
(29, 89, 'Met this new guy :D', '', '', '', '', '2011-03-08 21:53:53', 0, 0),
(30, 49, 'The CS 500 Midterm was not fair!', '', '', '', '', '2011-03-08 06:07:19', 0, 0),
(32, 72, 'Animal Kingdom in #florida is so fun!', '', '', '', '', '2011-03-08 20:58:32', 0, 0),
(33, 51, '@jaycircle I know dude. I cannot believe some of the stuff on there', '', '', '', '', '2011-03-08 06:14:36', 1, 1),
(33, 53, 'Srsly? I studied for weeks and I still did horrible', '33.953348', '-117.39615600000002', 'Riverside', 'CA', '2011-03-08 06:19:41', 0, 0),
(34, 52, 'I did not think it was that difficult', '', '', '', '', '2011-03-08 06:16:41', 0, 0),
(36, 56, 'meeting on wed at 5', '', '', '', '', '2011-03-08 17:07:28', 0, 0),
(36, 57, '#free pizza on wed at meeting', '', '', '', '', '2011-03-08 17:07:54', 0, 0),
(37, 58, 'meeting on thrursday, #free pancakes', '', '', '', '', '2011-03-08 17:13:42', 0, 0),
(38, 59, 'work is really busy this week', '', '', '', '', '2011-03-08 20:37:58', 0, 0),
(38, 62, 'thanks, see you in class @amber', '', '', '', '', '2011-03-08 20:43:15', 1, 1),
(38, 67, 'pretty hectic, but I will live @bonnie', '', '', '', '', '2011-03-08 20:49:25', 1, 1),
(38, 91, 'Work is pretty heavy this week', '', '', '', '', '2011-03-08 22:43:39', 0, 0),
(38, 92, 'going home tonight', '', '', '', '', '2011-03-08 22:44:11', 1, 0),
(39, 60, 'dont forget hw for psych @eric', '', '', '', '', '2011-03-08 20:41:15', 1, 1),
(39, 61, 'chapter 5 problems 1 to 15 @eric', '', '', '', '', '2011-03-08 20:42:01', 1, 1),
(40, 64, 'finally, my last year', '', '', '', '', '2011-03-08 20:47:53', 0, 0),
(40, 66, 'how has work been so far @eric', '', '', '', '', '2011-03-08 20:48:19', 1, 1),
(43, 69, 'At the beach tanning it up! #florida', '25.81291387834543', '-80.18646240234375', 'Miami', 'Florida', '2011-03-02 20:53:18', 0, 0),
(43, 70, 'Getting the daily tan at miami beaches! #florida', '25.81291387834543', '-80.18646240234375', 'Miami', 'Florida', '2011-03-08 20:53:45', 0, 0),
(43, 84, 'getting lunch at my favorite place #florida', '', '', '', '', '2011-03-08 21:29:57', 0, 0),
(46, 83, 'Cool beans.', '33.953348', '-117.39615600000002', 'Riverside', 'CA', '2011-03-08 21:29:14', 0, 0),
(46, 103, '@jaycee Thanks!', '33.9364782', '-117.94014709999999', 'La Habra', 'CA', '2011-03-09 23:48:55', 1, 1),
(47, 95, 'hello', '', '', '', '', '2011-03-09 00:18:08', 0, 0),
(47, 96, 'im here', '33.953348', '-117.39615600000002', 'Riverside', 'CA', '2011-03-09 00:18:33', 0, 0),
(48, 98, 'This is me posting something', '33.953348', '-117.39615600000002', 'Riverside', 'CA', '2011-03-09 01:46:17', 0, 0),
(48, 99, '''; DROP TABLE users; --', '', '', '', '', '2011-03-09 01:51:19', 0, 0),
(48, 100, '""; DROP TABLE users; --', '', '', '', '', '2011-03-09 01:53:34', 0, 0),
(48, 101, '"; DROP TABLE users; --', '', '', '', '', '2011-03-09 01:53:43', 0, 0),
(49, 102, 'This is pretty cool.', '', '', '', '', '2011-03-09 18:44:18', 0, 0),
(54, 105, 'pretty cool', '', '', '', '', '2011-03-13 21:31:13', 0, 0),
(57, 113, 'Hello! this is where I am!', '33.953348', '-117.39615600000002', 'Riverside', 'CA', '2011-03-15 03:03:29', 0, 0),
(57, 114, '@karl hello!', '', '', '', '', '2011-03-15 03:11:34', 1, 1),
(58, 116, 'supporting old teammates. wooot.', '', '', '', '', '2011-03-18 00:24:27', 0, 0),
(59, 117, '@cooltimproductions wassup and welcome!', '', '', '', '', '2011-03-18 00:26:33', 1, 1),
(60, 118, 'Is this alive!', '', '', '', '', '2011-03-23 01:10:11', 0, 0),
(60, 119, 'LA', '34.052234', '-118.24368400000003', 'Los Angeles', 'CA', '2011-03-23 01:10:53', 0, 0),
(62, 121, 'Kirby Domingo!', '', '', '', '', '2011-04-17 09:49:14', 0, 0),
(62, 122, 'Me', '', '', '', '', '2011-04-17 09:49:48', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE IF NOT EXISTS `subjects` (
  `message_id` int(10) unsigned NOT NULL,
  `subject` varchar(32) NOT NULL,
  PRIMARY KEY (`message_id`,`subject`),
  UNIQUE KEY `subject` (`subject`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`message_id`, `subject`) VALUES
(108, 'CS164'),
(45, 'egypt'),
(57, 'free'),
(106, 'hungry'),
(37, 'likeomg'),
(37, 'tester');

-- --------------------------------------------------------

--
-- Table structure for table `targets`
--

CREATE TABLE IF NOT EXISTS `targets` (
  `message_id` int(10) unsigned NOT NULL,
  `target_name` varchar(32) NOT NULL,
  PRIMARY KEY (`message_id`,`target_name`),
  KEY `target_name` (`target_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `targets`
--

INSERT INTO `targets` (`message_id`, `target_name`) VALUES
(20, 'admin'),
(62, 'amber'),
(67, 'bonnie'),
(117, 'cooltimproductions'),
(60, 'eric'),
(61, 'eric'),
(66, 'eric'),
(47, 'greg'),
(51, 'jaycircle'),
(80, 'jessie'),
(114, 'karl'),
(19, 'kirby'),
(22, 'kirby');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

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
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `privilege` int(1) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_name` (`user_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=63 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_name`, `user_email`, `user_id`, `user_pass`, `city`, `state`, `zipcode`, `description`, `profile_image_url`, `protected`, `created_at`, `privilege`) VALUES
('mark', 'mark@gmail.com', 4, '34cc93ece0ba9e3f6f235d4af979b16c', 'riverside', 'CA', 91725, 'Test description', '/images/default_profile_pic.gif', 0, '2011-01-24 08:13:20', 0),
('joey', 'joey@gmail.com', 6, 'db0edd04aaac4506f7edab03ac855d56', 'Riverside', 'CA', 91725, NULL, '/images/default_profile_pic.gif', 0, '2011-01-24 10:09:47', 0),
('john', 'john@gmail.com', 7, '218dd27aebeccecae69ad8408d9a36bf', 'Riverside', 'CA', 91725, NULL, '/images/default_profile_pic.gif', 0, '2011-01-24 10:14:35', 0),
('jim', 'jim2@gmail.com', 8, '7c6a180b36896a0a8c02787eeafb0e4c', 'Chino', 'CA', 91710, NULL, '/images/default_profile_pic.gif', 0, '2011-01-31 10:52:06', 0),
('georg', 'goerg@gmail.com', 9, '7c6a180b36896a0a8c02787eeafb0e4c', 'Chino', 'CA', 91871, NULL, '/images/default_profile_pic.gif', 0, '2011-01-31 10:53:04', 0),
('fred', 'fred@gmail.com', 10, '7c6a180b36896a0a8c02787eeafb0e4c', 'Chino', 'CA', 91710, NULL, '/images/default_profile_pic.gif', 0, '2011-01-31 10:53:46', 0),
('rich', 'rich@gmail.com', 11, '7c6a180b36896a0a8c02787eeafb0e4c', 'Chino', 'CA', 91710, NULL, '/images/default_profile_pic.gif', 0, '2011-01-31 10:55:48', 0),
('brad', 'bam@gmail.com', 12, '7c6a180b36896a0a8c02787eeafb0e4c', 'chino', 'CA', 91710, NULL, '/images/default_profile_pic.gif', 0, '2011-02-06 15:07:05', 1),
('brandon', 'bam@gmail.com', 14, '7c6a180b36896a0a8c02787eeafb0e4c', 'CA', '91', 0, NULL, '/images/default_profile_pic.gif', 0, '2011-02-06 19:06:09', 0),
('kirby', 'kirby@gmail.com', 16, '5f4dcc3b5aa765d61d8327deb882cf99', 'chula', 'CA', 91913, NULL, '/images/default_profile_pic.gif', 2, '2011-02-06 23:27:28', 0),
('grwluser', 'grwluser@ucr.edu', 18, '5f4dcc3b5aa765d61d8327deb882cf99', 'Riverside', 'CA', 92507, NULL, '/images/default_profile_pic.gif', 0, '2011-02-07 02:37:54', 0),
('mrGROWL', 'growl@gmail.com', 19, '5f4dcc3b5aa765d61d8327deb882cf99', 'Riverside', 'CA', 92507, NULL, '/images/default_profile_pic.gif', 0, '2011-02-07 09:31:04', 0),
('admin', 'asd@asd.com', 20, '5f4dcc3b5aa765d61d8327deb882cf99', 'asd', 'CA', 92501, 'aasdaasdasd', '/images/default_profile_pic.gif', 0, '2011-02-21 05:12:31', 1),
('test1', 'test1@gmail.com', 21, '5f4dcc3b5aa765d61d8327deb882cf99', 'riverside', 'CA', 92501, NULL, '/images/default_profile_pic.gif', 2, '0000-00-00 00:00:00', 0),
('testuser', 'test1@gmail.com', 23, '5f4dcc3b5aa765d61d8327deb882cf99', 'chula vista', 'CA', 92134, NULL, '/images/default_profile_pic.gif', 0, '0000-00-00 00:00:00', 0),
('user1', 'user@gmail.com', 24, '5f4dcc3b5aa765d61d8327deb882cf99', 'three name city', 'CA', 91913, NULL, '/images/default_profile_pic.gif', 0, '0000-00-00 00:00:00', 0),
('test3', 'test3@gmail.com', 25, '5f4dcc3b5aa765d61d8327deb882cf99', 'chula', 'CA', 12345, NULL, '/images/default_profile_pic.gif', 0, '0000-00-00 00:00:00', 0),
('test4', 'test4@gmail.com', 26, '5f4dcc3b5aa765d61d8327deb882cf99', 'chula', 'CA', 12345, NULL, '/images/default_profile_pic.gif', 0, '0000-00-00 00:00:00', 0),
('moderator', 'admin@grwl.it', 27, '7c6a180b36896a0a8c02787eeafb0e4c', 'Riverside', 'CA', 91710, NULL, '/images/default_profile_pic.gif', 0, '2011-03-01 00:00:00', 1),
('greg', 'greg21@gmail.com', 28, '7c6a180b36896a0a8c02787eeafb0e4c', 'Riverside', 'CA', 91710, 'Grow UP!', '/images/default_profile_pic.gif', 0, '2011-03-01 00:00:00', 0),
('jessie', 'jessiesgrl@gmail.com', 29, '7c6a180b36896a0a8c02787eeafb0e4c', 'Claremont', 'CA', 91710, NULL, '/images/default_profile_pic.gif', 0, '2011-03-01 00:00:00', 0),
('jaycircle', 'jay@gmail.com', 30, '5f4dcc3b5aa765d61d8327deb882cf99', 'Riverside', 'CA', 92507, NULL, '/images/default_profile_pic.gif', 2, '2011-03-01 00:00:00', 0),
('bernard', 'bernard@gmail.com', 31, '5f4dcc3b5aa765d61d8327deb882cf99', 'Riverside', 'CA', 92507, NULL, '/images/default_profile_pic.gif', 0, '2011-03-01 00:00:00', 0),
('kweree', 'Kweree@gmail.com', 32, '5f4dcc3b5aa765d61d8327deb882cf99', 'riverside', 'CA', 92507, NULL, '/images/default_profile_pic.gif', 0, '2011-03-01 00:00:00', 0),
('ajax', 'ajax@gmail.com', 33, '5f4dcc3b5aa765d61d8327deb882cf99', 'Los Angeles', 'CA', 90065, NULL, '/images/default_profile_pic.gif', 0, '2011-03-01 00:00:00', 0),
('bruce', 'bruce@gmail.com', 34, '5f4dcc3b5aa765d61d8327deb882cf99', 'Glendale', 'CA', 91208, NULL, '/images/default_profile_pic.gif', 0, '2011-03-01 00:00:00', 0),
('jack', 'jack@gmail.com', 35, '5f4dcc3b5aa765d61d8327deb882cf99', 'Riverside', 'CA', 92507, NULL, '/images/default_profile_pic.gif', 0, '2011-03-01 00:00:00', 0),
('ieee', 'ieee@something.com', 36, '5f4dcc3b5aa765d61d8327deb882cf99', 'riverside', 'CA', 92507, NULL, '/images/default_profile_pic.gif', 0, '0000-00-00 00:00:00', 0),
('acmclub', 'acm@sd.com', 37, '5f4dcc3b5aa765d61d8327deb882cf99', 'riverside', 'CA', 92507, NULL, '/images/default_profile_pic.gif', 0, '0000-00-00 00:00:00', 0),
('eric', 'asd@asd.com', 38, '5f4dcc3b5aa765d61d8327deb882cf99', 'riverside', 'CA', 92507, NULL, '/images/default_profile_pic.gif', 0, '0000-00-00 00:00:00', 0),
('amber', 'asd@asd.com', 39, '5f4dcc3b5aa765d61d8327deb882cf99', 'riverside', 'CA', 92507, NULL, '/images/default_profile_pic.gif', 0, '2011-03-08 20:38:51', 0),
('bonnie', 'asd@asd.com', 40, '5f4dcc3b5aa765d61d8327deb882cf99', 'lancaster', 'CA', 93536, NULL, '/images/default_profile_pic.gif', 0, '2011-03-08 20:46:10', 0),
('karl', 'karl@kmail.com', 43, 'f7fb934b706d6c29c354c3c569e8a82a', 'Miami', 'FL', 12345, NULL, '/images/default_profile_pic.gif', 0, '2011-03-08 20:48:19', 0),
('yoshi', 'yoshi@ymail.com', 44, '73a02e68f553fd19e5d670101cc38623', 'New York', 'NY', 12345, NULL, '/images/default_profile_pic.gif', 0, '2011-03-08 20:50:25', 0),
('daphne', 'asd@asd.com', 45, '5f4dcc3b5aa765d61d8327deb882cf99', 'lancaster', 'CA', 93536, NULL, '/images/default_profile_pic.gif', 0, '2011-03-08 21:19:39', 0),
('nights4saturn', 'cviles@rocketmail.com', 46, '5f4dcc3b5aa765d61d8327deb882cf99', 'Riverside', 'CA', 92521, 'I AM SO AWESOME THAT IT IS KIND OF SCARY.  FOR YOU, THAT IS.', '/images/default_profile_pic.gif', 0, '2011-03-08 21:26:00', 0),
('luis', 'luis@email.com', 47, '5f4dcc3b5aa765d61d8327deb882cf99', 'riverside', 'CA', 91913, NULL, '/images/default_profile_pic.gif', 0, '2011-03-09 00:17:55', 0),
('cameron', 'cameronrb@msn.com', 48, 'bb36feaac46d7aaab418138b578fd7e0', 'Riverside', 'CA', 92507, NULL, '/images/default_profile_pic.gif', 0, '2011-03-09 01:44:25', 0),
('mcphearson', 'stella.alessandro@gmail.com', 49, '98338a5750ff6a327074a94a638c8c5a', 'Moreno Valley', 'CA', 92557, NULL, '/images/default_profile_pic.gif', 0, '2011-03-09 18:40:29', 0),
('iamkirby', 'somehwere@gmail.com', 50, 'b7249222be50228f5fffe0612d41f001', 'omnicron', 'CA', 22222, NULL, '/images/default_profile_pic.gif', 0, '2011-03-10 21:14:10', 0),
('garrett', 'garrett@garrettmaster.com', 51, '241fe8af1e038118cd817048a65f803e', 'garrettland', 'CA', 82592, NULL, '/images/default_profile_pic.gif', 0, '2011-03-12 00:47:17', 0),
('masterg', 'masterg@masterg.com', 52, '9ce1197171ad34e8b67b9a3ae20a500e', 'Riverside', 'CA', 92507, NULL, '/images/default_profile_pic.gif', 3, '2011-03-12 00:48:24', 0),
('brandon23', 'brandon@email.com', 53, '7c6a180b36896a0a8c02787eeafb0e4c', 'Chino', 'CA', 91710, NULL, '/images/default_profile_pic.gif', 0, '2011-03-13 21:21:38', 0),
('erick', 'echen011@student.ucr.edu', 54, '7b55f59d034002b5fdb7eee735c8846f', 'erick', 'CA', 12345, NULL, '/images/default_profile_pic.gif', 0, '2011-03-13 21:30:54', 0),
('milestone1', 'm1@ucr.edu', 57, '5f4dcc3b5aa765d61d8327deb882cf99', 'Riverside', 'CA', 92501, NULL, '/images/default_profile_pic.gif', 0, '2011-03-15 02:52:18', 0),
('cooltimproductions', 'tim@cooltimproductions.com', 58, 'f8d08533cff71b0573cded671eed0fc9', 'Los Angeles', 'CA', 90025, NULL, '/images/default_profile_pic.gif', 0, '2011-03-18 00:22:46', 0),
('kirbdee', 'kirby@maill.com', 59, 'd14d049e9197a0e69ed3afaeb2fe5b96', 'Riverside', 'CA', 92501, 'A recent graduate from The University of California Riverside', '/images/default_profile_pic.gif', 0, '2011-03-18 00:25:59', 0),
('ijayceeyou', 'ijayceeyou@gmail.com', 60, 'bbce09bf6ea8e479fde5164587e20205', 'GLendale', 'CA', 91208, NULL, '/images/default_profile_pic.gif', 0, '2011-03-23 01:09:32', 0),
('isunktheship', 'isunktheship@gmail.com', 61, '544894d3b1f5b4ed3ebebc3c0a59bc25', 'Poway', 'CA', 92064, NULL, '/images/default_profile_pic.gif', 0, '2011-03-28 15:59:37', 0),
('brokenlink', 'brokenlink@yahoo.com', 62, '9504a74ced74ee17d731a5e085d5652e', 'bronkenlin', 'AR', 91204, NULL, '/images/default_profile_pic.gif', 0, '2011-04-17 09:41:35', 0);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `followers`
--
ALTER TABLE `followers`
  ADD CONSTRAINT `followers_ibfk_3` FOREIGN KEY (`leader_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `followers_ibfk_2` FOREIGN KEY (`leader_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `subjects`
--
ALTER TABLE `subjects`
  ADD CONSTRAINT `subjects_ibfk_1` FOREIGN KEY (`message_id`) REFERENCES `messages` (`message_id`) ON DELETE CASCADE;

--
-- Constraints for table `targets`
--
ALTER TABLE `targets`
  ADD CONSTRAINT `targets_ibfk_4` FOREIGN KEY (`message_id`) REFERENCES `messages` (`message_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `targets_ibfk_3` FOREIGN KEY (`target_name`) REFERENCES `users` (`user_name`) ON DELETE CASCADE;
