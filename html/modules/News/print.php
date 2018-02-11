<?php
/**
 * @PHP-NUKE: Web Portal System
 * @package Tricked Out News
 * @version 2.6 (RN News-Mod)
 * @file: print.php
 * @copyright (c) 2002 by Francisco Burzi
 * @Additional security & Abstraction layer conversion 2003 chatserv http://www.nukeresources.com
 * @nukeWYSIWYG Copyright (c) 2005 Kevin Guske http://nukeseo.com
 * @kses developed by Ulf Harnhammar http://kses.sf.net
 * @RavenNuke(tm) Support:
 * 2012 - Nuken http://www.trickedoutnews.com
 * 2013 - rework of all functions by neralex http://www.media.soefm.de
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
if (!defined('MODULE_FILE')) {die('You can\'t access this file directly...');}
if (!defined('PHP_EOL')) define ('PHP_EOL', strtoupper(substr(PHP_OS,0,3) == 'WIN') ? "\r\n" : "\n");
global $datetime, $db, $module_name, $nukeurl, $prefix, $sitename, $site_logo;
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
	
	function Topics($sidnum) {
		global $db, $prefix, $topictext;
		$sid = intval($sidnum);
		$result = $db->sql_query('SELECT t.`topictext` FROM `' . $prefix . '_stories` s LEFT JOIN `' . $prefix . '_topics` t ON t.`topicid` = s.`topic` WHERE s.`sid` = \'' . $sidnum . '\'');
		$row = $db->sql_fetchrow($result);
		$topictext = htmlspecialchars($row['topictext'], ENT_QUOTES, _CHARSET);
	}
	list($usenotes) = $db->sql_fetchrow($db->sql_query('SELECT `usenotes` FROM `' . $prefix . '_ton`'));
	if (is_admin($admin)) {
		$storylock = '';
	} else {
		$storylock = '`slock` = 0 AND';
	}
	$result = $db->sql_query('SELECT `aid`, `time`, `title`, `hometext`, `bodytext`, `topic`, `informant`, `notes` FROM `' . $prefix . '_stories` WHERE ' . $storylock . ' `sid` = \'' . $sidnum . '\'');
	$numrows = $db->sql_numrows($result);
	if (intval($numrows)!=1) {
		Header('Location: ./');
		exit();
	}
	list($aid, $time, $title, $hometext, $bodytext, $topic, $informant, $notes) = $db->sql_fetchrow($result);
	if ($usenotes != 1) {
		$notes = '';
	}
	formatTimestamp($time);
	$title = htmlspecialchars($title, ENT_QUOTES, _CHARSET);
	$informant = htmlspecialchars($informant, ENT_QUOTES, _CHARSET);
	Topics($sid);
	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"' , "\n" , ' "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' , PHP_EOL
	   , '<html xmlns="http://www.w3.org/1999/xhtml">' , PHP_EOL
	   , '<head>' , PHP_EOL
	   , '	<title>' , $sitename , ' - ' , $title , '</title>' , PHP_EOL
	   , '	<meta http-equiv="Content-Type" content="text/html; charset=' , _CHARSET , '" />' , PHP_EOL
	   , '	<meta name="ROBOTS" content="NOINDEX, NOFOLLOW" />' , PHP_EOL 
	   , '</head>' , PHP_EOL
	   , '<body style="color:#000; background:#fff;">' , PHP_EOL
	   , '	<div style="margin:0 auto; border:1px solid #000; width:640px; padding:10px;">' , PHP_EOL
	   , '	<div style="text-align:center;">' , PHP_EOL
	   , '		<img src="images/' , $site_logo , '" border="0" alt="" />' , PHP_EOL
	   , '		<br /><br />' , PHP_EOL
	   , '		<span class="content" style="font-weight:bold;">', $title , '</span><br />' , PHP_EOL
	   , '		<span class="tiny">' , PHP_EOL
	   , '			<span style="font-weight:bold;">' , _PDATE , '</span> ' , $datetime , '<br />' , PHP_EOL;
	if ($aid != '') {
	echo '			<span style="font-weight:bold;">' ,_TONAUTHOR , ':</span> ' , $informant , '<br />' , PHP_EOL;
	}
	if ($topictext != '') {
	echo '			<span style="font-weight:bold;">' , _PTOPIC , '</span> ' , $topictext , PHP_EOL;
	}
	echo '		</span>' , PHP_EOL
	   , '	</div>' , PHP_EOL
	   , '	<div class="content">' , PHP_EOL
	   , '		' , $hometext , '<br /><br />' , PHP_EOL;
	if ($bodytext != '') {
	echo '		' , $bodytext , '<br /><br />' , PHP_EOL;
	}
	if ($notes != '') {
	echo '		' , $notes , '<br /><br />' , PHP_EOL;
	}	   
	echo '	</div>' , PHP_EOL
	   , '	<div style="text-align:center; margin:0 auto; width:100%;">' , PHP_EOL
	   , '		<span class="content">' , PHP_EOL
	   , '			' , _COMESFROM , ' ' , $sitename , '<br />' , PHP_EOL
	   , '			<a href="' , $nukeurl , '">' , $nukeurl , '</a><br /><br />' , PHP_EOL
	   , '			' , _THEURL , '<br />' , PHP_EOL
	   , '			<a href="' , $nukeurl , '/modules.php?name=' , $module_name , '&amp;file=article&amp;sid=' , $sid , '">' , $nukeurl , '/modules.php?name=' , $module_name , '&amp;file=article&amp;sid=' , $sid , '</a>' , PHP_EOL
	   , '		</span>' , PHP_EOL
	   , '	</div>' , PHP_EOL
	   , '</div>' , PHP_EOL
	   , '</body>' , PHP_EOL
	   , '</html>' , PHP_EOL;
	exit();