<?php
/************************************************************************/
/* PHP-NUKE: Web Portal System                                          */
/* ===========================                                          */
/*                                                                      */
/* Copyright (c) 2002 by Francisco Burzi                                */
/* http://phpnuke.org                                                   */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/*                                                                      */
/* Additional security checking code 2003 by chatserv                   */
/* http://www.nukefixes.com -- http://www.nukeresources.com             */
/*                                                                      */
/* W3C Compliant Fixes by ViRuS - (virus@wildghosts.net)                */
/*                                                                      */
/************************************************************************/

if ( !defined('MODULE_FILE') ) {die('You can\'t access this file directly...');}
if (!defined('PHP_EOL')) define ('PHP_EOL', strtoupper(substr(PHP_OS,0,3) == 'WIN') ? "\r\n" : "\n");
$module_name = basename(dirname(__FILE__));
get_lang($module_name);

if (isset($sid)) {
	if ($sid == '' || !is_numeric($sid)) {
		Header('Location: ./');	
		exit;
	} elseif (is_numeric($sid)) {
		$sidnum = $sid;
	}
} else {
	$sidnum = '';
}
if (is_admin($admin)) {
	$storylock = '';
} else {
	$storylock = '`slock` = 0 AND';
}
function PrintPage($sidnum) {
	global $site_logo, $nukeurl, $sitename, $datetime, $prefix, $db, $Default_Theme, $storylock;
	if (file_exists('themes/' . $Default_Theme . '/images/logo.jpg')) {
		$avantgo_logo = 'themes/' . $Default_Theme . '/images/logo.jpg';
	} elseif (file_exists('images/' . $site_logo)) {
		$avantgo_logo = 'images/' . $site_logo;
	} elseif (file_exists('images/logo.gif')) {
		$avantgo_logo = 'images/logo.gif';
	} else {
		$avantgo_logo = '';
	}
	$sid = intval(trim($sidnum));
	$row = $db->sql_fetchrow($db->sql_query('SELECT `title`, `time`, `hometext`, `bodytext`, `topic`, `notes` FROM `' . $prefix . '_stories` WHERE ' . $storylock . ' `sid` = \'' . $sid . '\''));
	$title = htmlspecialchars($row['title'], ENT_QUOTES, _CHARSET);
	$time = $row['time'];
	$hometext = check_html($row['hometext']);
	$bodytext = check_html($row['bodytext']);
	$topic = intval($row['topic']);
	$notes = check_html($row['notes']);
	$row2 = $db->sql_fetchrow($db->sql_query('SELECT `topictext` FROM `' . $prefix . '_topics` WHERE `topicid` = \'' . $topic . '\''));
	$topictext = htmlspecialchars($row2['topictext'], ENT_QUOTES, _CHARSET);
	formatTimestamp($time);
	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"', PHP_EOL, ' "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">', PHP_EOL
		,'<html xmlns="http://www.w3.org/1999/xhtml">', PHP_EOL
		,'<head>', PHP_EOL
		,'	<title>', $sitename, ' - ', $title, '</title>', PHP_EOL
		,'</head>', PHP_EOL
		,'<body style="color:#000; background:#fff;">', PHP_EOL
		,'	<div style="margin:0 auto; border:1px solid #000; width:640px; padding:10px;">', PHP_EOL
		,'	<div style="text-align:center;">', PHP_EOL
		,'		<img src="', $avantgo_logo, '" border="0" alt="" />', PHP_EOL
		,'		<br /><br />' , PHP_EOL
		,'		<span class="content" style="font-weight:bold;">', $title, '</span><br />', PHP_EOL
		,'		<span class="tiny">' , PHP_EOL
		,'			<span style="font-weight:bold;">', _PDATE, '</span> ', $datetime, PHP_EOL
		,'			<br />', PHP_EOL;
	if ($topictext != '') {
	echo '			<span style="font-weight:bold;">', _PTOPIC, '</span> ', $topictext, PHP_EOL;
	}
	echo '		</span>', PHP_EOL
		,'		<br /><br />', PHP_EOL
		,'	</div>', PHP_EOL
		,'	<div class="content">', PHP_EOL
		,'		', $hometext, '<br /><br />', PHP_EOL;
	if ($bodytext != '') {
	echo '		', $bodytext, '<br /><br />', PHP_EOL;
	}
	if ($notes != '') {
	echo '		', $notes, '<br /><br />', PHP_EOL;
	}
	echo '	</div>' , PHP_EOL
		,'	<div style="text-align:center; margin:0 auto; width:100%;">', PHP_EOL
		,'		<span class="content">', PHP_EOL
		,'			', _COMESFROM, ' ', $sitename, '<br />', PHP_EOL
		,'			<a href="', $nukeurl, '">', $nukeurl, '</a><br /><br />', PHP_EOL
		,'			', _THEURL, '<br />' , PHP_EOL
		,'			<a href="', $nukeurl, '/modules.php?name=News&amp;file=article&amp;sid=', $sid, '">', $nukeurl, '/modules.php?name=News&amp;file=article&amp;sid=' , $sid , '</a>', PHP_EOL
		,'		</span>', PHP_EOL
		,'	</div>', PHP_EOL
		,'</div>', PHP_EOL
		,'</body>', PHP_EOL
		,'</html>', PHP_EOL;
}
PrintPage($sid);