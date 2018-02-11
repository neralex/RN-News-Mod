<?php
/**************************************************************************/
/* RN Your Account: Advanced User Management for RavenNuke
/* =======================================================================*/
/*
/* Copyright (c) 2008-2011, RavenPHPScripts.com	http://www.ravenphpscripts.com
/*
/* This program is free software. You can redistribute it and/or modify it
/* under the terms of the GNU General Public License as published by the
/* Free Software Foundation, version 2 of the license.
/*
/**************************************************************************/
/* RN Your Account is the based on:
/*  CNB Your Account http://www.phpnuke.org.br
/*  NSN Your Account by Bob Marion, http://www.nukescripts.net
/**************************************************************************/
if (!defined('RNYA')) {
	header('Location: ../../../../index.php');
	die();
}
if (is_active('News')) {
	$uid = (int)$usrinfo['user_id'];
	// Last 10 Comments
	if ($articlecomm == 1) {
		$result6 = $db->sql_query('SELECT c.`tid`, c.`sid`, c.`subject` FROM `' . $prefix . '_comments` c, `' . $prefix . '_stories` s WHERE c.`sid` = s.`sid` AND s.`slock` = 0 AND c.`name` = \'' . addslashes($usrinfo['username']) . '\' ORDER BY c.`tid` DESC LIMIT 0,10');
		if (($db->sql_numrows($result6) > 0)) {
			echo '<br />';
			OpenTable();
			echo '<strong>' , $usrinfo['username'] , '\'s ' , _LAST10COMMENT , ':</strong><ul>';
			while ($row6 = $db->sql_fetchrow($result6)) {
				$tid = $row6['tid'];
				$sid = $row6['sid'];
				$subject = htmlspecialchars(htmlspecialchars_decode(check_html($row6['subject'], 'nohtml'), ENT_QUOTES), ENT_QUOTES, _CHARSET);
				echo '<li><a href="modules.php?name=News&amp;file=article&amp;sid=' , $sid , '#' , $tid , '">' , $subject , '</a></li>';
			}
			echo '</ul>';
			CloseTable();
		}
	}
	// Last 10 Submissions
	$result7 = $db->sql_query('SELECT `sid`, `title` FROM `' . $prefix . '_stories` WHERE `informant` = \'' . addslashes($usrinfo['username']) . '\' AND `slock` = 0 ORDER BY `sid` DESC LIMIT 0,10');
	if (($db->sql_numrows($result7) > 0)) {
		echo '<br />';
		OpenTable();
		echo '<strong>' , $usrinfo['username'] , '\'s ' , _LAST10SUBMISSION , ':</strong><ul>';
		while ($row7 = $db->sql_fetchrow($result7)) {
			$sid = $row7['sid'];
			$title = htmlspecialchars($row7['title'], ENT_QUOTES, _CHARSET);
			echo '<li><a href="modules.php?name=News&amp;file=article&amp;sid=' , $sid , '">' , $title , '</a></li>';
		}
		echo '</ul>';
		CloseTable();
	}
}
?>