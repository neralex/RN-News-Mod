<?php
######################################################################
# PHP-NUKE: Web Portal System: AvantGo Add-on
# ===========================================
#
# This module is to view your last news items via Palm or Windows CE
# devices, using AvantGo software or compatible palm device browsers
#
# This program is free software. You can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License.
#
# Copyright (c) 2000 by Tim Litwiller - http://linux.made-to-order.net
#
# W3C Compliant Fixes by ViRuS - (virus@wildghosts.net)
#
######################################################################

if (!defined('MODULE_FILE')){die('You can\'t access this file directly...');}
$module_name = basename(dirname(__FILE__));
get_lang($module_name);
global $sitename, $slogan, $db, $prefix, $module_name, $site_logo, $Default_Theme;
if (file_exists('themes/' . $Default_Theme . '/images/logo.gif')) {
$avantgo_logo = 'themes/' . $Default_Theme . '/images/logo.gif';
} elseif (file_exists('images/' . $site_logo)) {
$avantgo_logo = 'images/' . $site_logo;
} elseif (file_exists('images/logo.gif')) {
$avantgo_logo = 'images/logo.gif';
} else {
$avantgo_logo = '';
}
Header('Content-Type: text/html');
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitinal//EN"', PHP_EOL, ' "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">', PHP_EOL
	,'<html xmlns="http://www.w3.org/1999/xhtml">', PHP_EOL
	,'<head>', PHP_EOL
	,'<title>', $sitename , ' - AvantGo</title>', PHP_EOL
	,'<meta name="HandheldFriendly" content="True" />', PHP_EOL
	,'</head>', PHP_EOL
	,'<body>', PHP_EOL
	,'<div align="center">', PHP_EOL;
$result = $db->sql_query('SELECT `sid`, `title`, `time` FROM `' . $prefix . '_stories` WHERE `slock` = 0 ORDER BY `sid` DESC LIMIT 10');
if (!$result) {
	echo 'An error occured';
} else {
	echo '<a href="index.php"><img src="', $avantgo_logo, '" alt="', $slogan, '" title="', $slogan, '" border="0" /></a><br />', PHP_EOL
		,'<h1>' , $sitename , '</h1>' , PHP_EOL
		,'<table border="0" align="center">' , PHP_EOL
		,'	<tr>', PHP_EOL
		,'		<td bgcolor="#efefef">', _TITLE, '</td>', PHP_EOL
		,'		<td bgcolor="#efefef">', _DATE, '</td>', PHP_EOL
		,'	</tr>' , PHP_EOL;
	for ($m=0; $m < $db->sql_numrows($result); $m++) {
		$row = $db->sql_fetchrow($result);
		$sid = intval($row['sid']);
		$title = stripslashes(check_html($row['title'], 'nohtml'));
		$time = $row['time'];
		echo '	<tr>', PHP_EOL
			,'		<td><a href="modules.php?name=', $module_name, '&amp;file=print&amp;sid=', $sid, '">', $title, '</a></td>', PHP_EOL
			,'		<td>', $time, '</td>', PHP_EOL
			,'	</tr>', PHP_EOL;
	}
	echo '</table>', PHP_EOL
		,'<br /><br />', _GOBACK, '<br />', PHP_EOL;
}
echo '</div>', PHP_EOL
	,'</body>', PHP_EOL
	,'</html>', PHP_EOL;
include_once('includes/counter.php');
die();