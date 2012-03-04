DROP TABLE IF EXISTS `vote_point`;

CREATE TABLE `vote_point` (
`account_id` int(11) NOT NULL default '0',
`point` int(11) NOT NULL default '0',
`last_vote1` int(11) NOT NULL default '0',
`last_vote2` int(11) NOT NULL default '0',
`last_vote3` int(11) NOT NULL default '0',
`date` text NOT NULL,
PRIMARY KEY  (`account_id`)) 
ENGINE=MyISAM DEFAULT CHARSET=latin1;