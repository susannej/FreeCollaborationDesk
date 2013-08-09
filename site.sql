
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- --------------------------------------------------------

--
-- Table structure for table `site_calls`
--

CREATE TABLE IF NOT EXISTS `site_calls` (
  `call_id` int(11) NOT NULL AUTO_INCREMENT,
  `call_first_name` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `call_last_name` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `call_phone` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `call_email` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `call_department` int(11) NOT NULL DEFAULT '0',
  `call_request` int(11) NOT NULL DEFAULT '0',
  `call_device` int(11) NOT NULL DEFAULT '0',
  `call_details` text COLLATE latin1_general_ci NOT NULL,
  `call_date` int(11) NOT NULL DEFAULT '0',
  `call_date2` int(11) NOT NULL DEFAULT '0',
  `call_status` int(11) NOT NULL DEFAULT '0',
  `call_solution` text COLLATE latin1_general_ci NOT NULL,
  `call_user` int(11) NOT NULL DEFAULT '0',
  `call_staff` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`call_id`),
  KEY `call_department` (`call_department`),
  KEY `call_request` (`call_request`),
  KEY `call_device` (`call_device`),
  KEY `call_status` (`call_status`),
  KEY `call_user` (`call_user`),
  KEY `call_staff` (`call_staff`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1000 ;

--
-- Dumping data for table `site_calls`
--

INSERT INTO `site_calls` (`call_id`, `call_first_name`, `call_last_name`, `call_phone`, `call_email`, `call_department`, `call_request`, `call_device`, `call_details`, `call_date`, `call_date2`, `call_status`, `call_solution`, `call_user`, `call_staff`) VALUES
(4, 'Chris', '', '555-1313', 'chriss@example.com', 15, 8, 10, 'I opened a zip file, now my computer is running really slow.', 1210773480, -1, 0, '', 1008, 18),
(5, 'Sally', '', '555-1414', 'sally@example.com', 17, 3, 11, 'I forgot my password to the network.', 1210593840, -1, 1, 'reset sally''s password.', 1007, 7);

-- --------------------------------------------------------

--
-- Table structure for table `site_notes`
--

CREATE TABLE IF NOT EXISTS `site_notes` (
  `note_id` int(11) NOT NULL AUTO_INCREMENT,
  `note_title` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `note_body` text COLLATE latin1_general_ci NOT NULL,
  `note_relation` int(11) NOT NULL DEFAULT '0',
  `note_type` int(1) NOT NULL DEFAULT '0',
  `note_post_date` int(11) NOT NULL DEFAULT '0',
  `note_post_ip` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `note_post_user` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`note_id`),
  KEY `note_relation` (`note_relation`),
  KEY `note_type` (`note_type`),
  KEY `note_post_user` (`note_post_user`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=10 ;

--
-- Dumping data for table `site_notes`
--

INSERT INTO `site_notes` (`note_id`, `note_title`, `note_body`, `note_relation`, `note_type`, `note_post_date`, `note_post_ip`, `note_post_user`) VALUES
(9, 'Every Monday', 'This happens to Sally every Monday.', 5, 1, 1210773801, '127.0.0.1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `site_types`
--

CREATE TABLE IF NOT EXISTS `site_types` (
  `type_id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(1) NOT NULL DEFAULT '0',
  `type_name` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `type_email` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `type_location` text COLLATE latin1_general_ci NOT NULL,
  `type_phone` varchar(100) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`type_id`),
  KEY `type` (`type`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=19 ;

--
-- Dumping data for table `site_types`
--

INSERT INTO `site_types` (`type_id`, `type`, `type_name`, `type_email`, `type_location`, `type_phone`) VALUES
(1, 1, 'Sales', '', '', ''),
(2, 1, 'Marketing', '', '', ''),
(3, 2, 'Urgent', '', '', ''),
(4, 2, 'Question', '', '', ''),
(5, 3, 'Monitor', '', '', ''),
(6, 3, 'Keyboard', '', '', ''),
(7, 0, 'Jon Techie', 'jon@example.com', 'Anytown, USA', '555-help'),
(8, 2, 'Non-Urgent', '', '', ''),
(9, 3, 'Mouse', '', '', ''),
(10, 3, 'Network', '', '', ''),
(11, 3, 'Other', '', '', ''),
(12, 3, 'Computer Unit', '', '', ''),
(13, 3, 'Printer', '', '', ''),
(14, 3, 'Software', '', '', ''),
(15, 1, 'Accounting', '', '', ''),
(16, 1, 'Customer Service', '', '', ''),
(17, 1, 'Design', '', '', ''),
(18, 0, 'Sara Fixit', 'sara@example.com', 'Eastern branch', '555-work');

-- --------------------------------------------------------

--
-- Table structure for table `site_users`
--

CREATE TABLE IF NOT EXISTS `site_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_login` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `user_password` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `user_name` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `user_address` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `user_city` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `user_state` char(3) COLLATE latin1_general_ci NOT NULL,
  `user_zip` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `user_country` char(3) COLLATE latin1_general_ci NOT NULL,
  `user_phone` varchar(39) COLLATE latin1_general_ci NOT NULL,
  `user_email` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `user_email2` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `user_im_aol` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `user_im_icq` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `user_im_msn` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `user_im_yahoo` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `user_im_other` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `user_status` int(1) NOT NULL DEFAULT '0',
  `user_level` int(1) NOT NULL DEFAULT '0',
  `user_pending` int(11) NOT NULL DEFAULT '0',
  `user_date` int(11) NOT NULL DEFAULT '0',
  `last_login` int(11) NOT NULL DEFAULT '0',
  `last_ip` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `user_msg_send` int(1) NOT NULL DEFAULT '0',
  `user_msg_subject` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `user_protect_delete` int(1) DEFAULT '0',
  `user_protect_edit` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`),
  KEY `user_pending` (`user_pending`),
  KEY `user_level` (`user_level`),
  KEY `user_status` (`user_status`),
  KEY `user_protect_edit` (`user_protect_edit`),
  KEY `user_msg_send` (`user_msg_send`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci PACK_KEYS=0 AUTO_INCREMENT=1009 ;

--
-- Dumping data for table `site_users`
--

INSERT INTO `site_users` (`user_id`, `user_login`, `user_password`, `user_name`, `user_address`, `user_city`, `user_state`, `user_zip`, `user_country`, `user_phone`, `user_email`, `user_email2`, `user_im_aol`, `user_im_icq`, `user_im_msn`, `user_im_yahoo`, `user_im_other`, `user_status`, `user_level`, `user_pending`, `user_date`, `last_login`, `last_ip`, `user_msg_send`, `user_msg_subject`, `user_protect_delete`, `user_protect_edit`) VALUES
(1, 'admin', 'test', 'Site Admin', '', '', '', '', '', '', 'admin@example.com', 'someone@example.com', '', '', '', '', '', 0, 0, 0, 0, 1117030100, '127.0.0.1', 1, 'New Message', 1, 0),
(1006, 'mark', 'test', 'Mark Johnson', '', '', '', '', '', '', 'markj@example.com', '', '', '', '', '', '', 0, 1, 0, 1117033601, 1117033624, '127.0.0.1', 0, '', 0, 0),
(1007, 'sally', 'test', 'Sally Lot', '', '', '', '', '', '', 'sallyl@example.com', '', '', '', '', '', '', 0, 1, 0, 1210772181, 0, '', 0, '', 0, 0),
(1008, 'chris', 'test', 'Chris Smith', '', '', '', '', '', '', 'chriss@example.com', '', '', '', '', '', '', 0, 1, 0, 1368057600, 0, '', 0, '', 0, 0);
