-- phpMyAdmin SQL Dump
-- version 3.3.2deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 03, 2010 at 11:03 PM
-- Server version: 5.1.41
-- PHP Version: 5.3.2-1ubuntu4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `silkpool`
--

-- --------------------------------------------------------

--
-- Table structure for table `silk_ACL`
--

CREATE TABLE IF NOT EXISTS `silk_ACL` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `acl_type` varchar(255) NOT NULL,
  `acl_type_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `silk_ACL_ARO`
--

CREATE TABLE IF NOT EXISTS `silk_ACL_ARO` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `aro_id` int(11) NOT NULL,
  `acl_id` int(11) NOT NULL,
  `access_type` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=925 ;

-- --------------------------------------------------------

--
-- Table structure for table `silk_ARO`
--

CREATE TABLE IF NOT EXISTS `silk_ARO` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `aro_type` varchar(255) NOT NULL,
  `aro_name` varchar(255) NOT NULL,
  `lft` int(11) NOT NULL,
  `rgt` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `item_order` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=42 ;

-- --------------------------------------------------------

--
-- Table structure for table `silk_games`
--

CREATE TABLE IF NOT EXISTS `silk_games` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `segment_id` int(11) NOT NULL,
  `home_id` int(11) NOT NULL,
  `home_score` int(11) NOT NULL DEFAULT '0',
  `away_id` int(11) NOT NULL,
  `away_score` int(11) NOT NULL DEFAULT '0',
  `winner_id` int(11) NOT NULL,
  `loser_id` int(11) NOT NULL,
  `modifier` float NOT NULL,
  `notes` text NOT NULL,
  `status_id` int(11) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `season_segment_id` (`segment_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=347 ;

-- --------------------------------------------------------

--
-- Table structure for table `silk_groups`
--

CREATE TABLE IF NOT EXISTS `silk_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `silk_picks`
--

CREATE TABLE IF NOT EXISTS `silk_picks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL,
  `team_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`game_id`,`team_id`,`status_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=96 ;

-- --------------------------------------------------------

--
-- Table structure for table `silk_points`
--

CREATE TABLE IF NOT EXISTS `silk_points` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL,
  `points` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=309 ;

-- --------------------------------------------------------

--
-- Table structure for table `silk_seasons`
--

CREATE TABLE IF NOT EXISTS `silk_seasons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `start_year` varchar(50) NOT NULL,
  `end_year` varchar(50) NOT NULL,
  `status_id` int(11) NOT NULL,
  `sport_id` int(11) NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `status_id` (`status_id`),
  KEY `sport_id` (`sport_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Table structure for table `silk_seasonusers`
--

CREATE TABLE IF NOT EXISTS `silk_seasonusers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `season_id` int(11) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`season_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

-- --------------------------------------------------------

--
-- Table structure for table `silk_segments`
--

CREATE TABLE IF NOT EXISTS `silk_segments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `season_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `season_id` (`season_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Table structure for table `silk_sports`
--

CREATE TABLE IF NOT EXISTS `silk_sports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status_id` int(11) NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `silk_status`
--

CREATE TABLE IF NOT EXISTS `silk_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `active` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `silk_teams`
--

CREATE TABLE IF NOT EXISTS `silk_teams` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sport_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sport_id` (`sport_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=40 ;

-- --------------------------------------------------------

--
-- Table structure for table `silk_users`
--

CREATE TABLE IF NOT EXISTS `silk_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(25) NOT NULL,
  `password` varchar(75) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `usertype_id` int(11) NOT NULL,
  `openid` varchar(255) NOT NULL,
  `salt` varchar(255) NOT NULL,
  `checksum` varchar(255) NOT NULL,
  `active` int(1) NOT NULL,
  `create_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Table structure for table `silk_usertypes`
--

CREATE TABLE IF NOT EXISTS `silk_usertypes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `silk_user_groups`
--

CREATE TABLE IF NOT EXISTS `silk_user_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `create_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

