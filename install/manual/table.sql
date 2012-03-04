# As of January 1st this project has changed CeresCP for
# my distrobution purposes. I have rewritten major componets
# to fit my needs of the software.



CREATE TABLE `cp_bruteforce` (
  `action_id` int(11) NOT NULL auto_increment,
  `user` varchar(24) NOT NULL default '',
  `IP` varchar(20) NOT NULL default '',
  `date` int(11) NOT NULL default '0',
  `ban` int(11) NOT NULL default '0',
  PRIMARY KEY  (`action_id`),
  KEY `user` (`user`),
  KEY `IP` (`IP`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;

CREATE TABLE `cp_links` (
  `cod` int(11) NOT NULL auto_increment,
  `name` varchar(30) NOT NULL,
  `url` varchar(255) NOT NULL,
  `desc` text NOT NULL,
  `size` int(11) default '0',
  PRIMARY KEY  (`cod`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;

CREATE TABLE `cp_querylog` (
  `action_id` int(11) NOT NULL auto_increment,
  `Date` datetime NOT NULL default '0000-00-00 00:00:00',
  `User` varchar(24) NOT NULL default '',
  `IP` varchar(20) NOT NULL default '',
  `page` varchar(24) NOT NULL default '',
  `query` text NOT NULL,
  PRIMARY KEY  (`action_id`),
  KEY `action_id` (`action_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;

CREATE TABLE `cp_server_status` (
  `last_checked` datetime NOT NULL default '0000-00-00 00:00:00',
  `status` tinyint(1) NOT NULL default '0'
) ENGINE=MyISAM;

CREATE TABLE `vote_point` (
	  `account_id` int(11) NOT NULL default '0',
	  `point` int(11) NOT NULL default '0',
	  `last_vote1` int(11) NOT NULL default '0',
	  `last_vote2` int(11) NOT NULL default '0',
	  `last_vote3` int(11) NOT NULL default '0',
	  `date` text NOT NULL,
	  PRIMARY KEY  (`account_id`)
	) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `dc_comments` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `transaction_id` varchar(64) collate utf8_unicode_ci NOT NULL default '',
  `name` varchar(128) collate utf8_unicode_ci NOT NULL default '',
  `amount` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `account_id` int(11) NOT NULL,
  `dt` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `transaction_id` (`transaction_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `dc_donations` (
  `transaction_id` varchar(64) collate utf8_unicode_ci NOT NULL default '',
  `donor_email` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `amount` double NOT NULL default '0',
  `account_id` int(11) NOT NULL,
  `original_request` text collate utf8_unicode_ci NOT NULL,
  `dt` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`transaction_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `dc_Subscription` (
  `transaction_id` varchar(64) collate utf8_unicode_ci NOT NULL default '',
  `donor_email` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `amount` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `account_id` int(11) NOT NULL,
  `original_request` text collate utf8_unicode_ci NOT NULL,
  `dt` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`transaction_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `cash_points` (
  `account_id` int(11) NOT NULL,
  `points_to_add` int(11) NOT NULL DEFAULT '0',
  UNIQUE KEY `account_id` (`account_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8-unicode_ci;