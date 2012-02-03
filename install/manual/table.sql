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
