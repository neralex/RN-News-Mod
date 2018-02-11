<?php
/**
 * @PHP-NUKE: Web Portal System
 * @package Tricked Out News
 * @version 2.6 (RN News-Mod)
 * @file: friend.php
 * @copyright (c) 2002 by Francisco Burzi
 * @Additional security & Abstraction layer conversion 2003 chatserv http://www.nukeresources.com
 * @nukeWYSIWYG Copyright (c) 2005 Kevin Guske http://nukeseo.com
 * @kses developed by Ulf Harnhammar http://kses.sf.net
 * @RavenNuke(tm) Support:
 * 2012 - Nuken http://www.trickedoutnews.com
 * 2013 - rework of all functions by neralex http://www.media.soefm.de
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
if (!defined('MODULE_FILE')) die('You can\'t access this file directly...');
if (!defined('PHP_EOL')) define ('PHP_EOL', strtoupper(substr(PHP_OS,0,3) == 'WIN') ? "\r\n" : "\n");
require_once 'mainfile.php';
if (!file_exists('includes/nukesentinel.php')) {
	if (stripos_clone($_SERVER['QUERY_STRING'], '%25')) header('Location: index.php');
}
$module_name = basename(dirname(__FILE__));
get_lang($module_name);
$pagetitle = '- ' . _RECOMMEND;
if (!is_user($user)) {
	Header('Location: ./');
	exit();
}
switch ($op) {
	case 'SendStory':
		csrf_check();
		SendStory($sid, $yname, $ymail, $fname, $fmail);
		break;
	case 'FriendSend':
		FriendSend($sid);
		break;
}
die();
//Only functions below this line
function FriendSend($sid) {
	global $user, $cookie, $prefix, $db, $user_prefix, $module_name, $admin;
	$sid = intval($sid);
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

	include_once 'header.php';
	list($title) = $db->sql_fetchrow($db->sql_query('SELECT `title` FROM `' . $prefix . '_stories` WHERE ' . $storylock . ' `sid` = \'' . $sidnum . '\''));
	$title = htmlspecialchars($title, ENT_QUOTES, _CHARSET);
	title(_FRIEND);
	OpenTable();
	echo '<div class="text-center"><p class="content thick">' , _FRIEND , '</p></div><br /><br />' , PHP_EOL
	   , _YOUSENDSTORY , ' <strong>' , $title , '</strong> ' , _TOAFRIEND , '<br /><br />' , PHP_EOL
	   , '<form action="modules.php?name=' , $module_name , '&amp;file=friend" method="post">' , PHP_EOL
	   , '<input type="hidden" name="sid" value="' , $sidnum , '" />';
	if (is_user($user)) {
		$row2 = $db->sql_fetchrow($db->sql_query('SELECT `name`, `username`, `user_email` FROM `' . $user_prefix . '_users` WHERE `user_id` = \'' . intval($cookie[0]) . '\''));
		if (empty($row['name'])) {
			$yn = htmlspecialchars($row2['username'], ENT_QUOTES, _CHARSET);
		} else {
			$yn = htmlspecialchars($row2['name'], ENT_QUOTES, _CHARSET);
		}
		$ye = htmlspecialchars($row2['user_email'], ENT_QUOTES, _CHARSET);
	}
	echo '<strong>' , _FYOURNAME , ' </strong> ' , $yn , ' <input type="hidden" name="yname" value="' , $yn , '" /><br /><br />' , PHP_EOL
	   , '<strong>' , _FYOUREMAIL , ' </strong> ' , $ye , ' <input type="hidden" name="ymail" value="' , $ye , '" /><br /><br /><br />' , PHP_EOL
	   , '<strong>' , _FFRIENDNAME , ' </strong> <input type="text" name="fname" /><br /><br />' , PHP_EOL
	   , '<strong>' , _FFRIENDEMAIL , ' </strong> <input type="text" name="fmail" /><br /><br />' , PHP_EOL;
	/*****[BEGIN]******************************************
	[ Base:    GFX Code                           v1.0.0 ]
	******************************************************/
	global $modGFXChk;
	echo security_code($modGFXChk[$module_name], 'stacked');
	/*****[END]********************************************
	[ Base:    GFX Code                           v1.0.0 ]
	******************************************************/
	echo '<input type="hidden" name="op" value="SendStory" />' , PHP_EOL
	   , '<input type="submit" value="' , _SEND , '" />' , PHP_EOL
	   , '</form>';
	CloseTable();
	include_once 'footer.php';
}
function SendStory($sid, $yname, $ymail, $fname, $fmail) {
	global $sitename, $nukeurl, $prefix, $db, $module_name;
	/*****[BEGIN]******************************************
	[ Base:    GFX Code                           v1.0.0 ]
	******************************************************/
	global $modGFXChk;
	if (isset($_POST['gfx_check'])) $gfx_check = $_POST['gfx_check'];
	else $gfx_check = '';
	if (!security_code_check($gfx_check, $modGFXChk[$module_name])) {
		include_once 'header.php';
		OpenTable();
		echo '<div class="text-center"><p class="option thick italic">' , _SECCODEINCOR , '</p><br /><br />' , PHP_EOL;
		echo '[ <a href="javascript:history.go(-2)">' , _GOBACK2 , '</a> ]</div>' , PHP_EOL;
		CloseTable();
		include_once 'footer.php';
		die();
	}
	/*****[END]********************************************
	[ Base:    GFX Code                           v1.0.0 ]
	******************************************************/
	$fname = stripslashes(removecrlf($fname));
	$fmail = validateEmailFormat(stripslashes(removecrlf($fmail)));
	$yname = stripslashes(removecrlf($yname));
	$ymail = validateEmailFormat(stripslashes(removecrlf($ymail)));
	// Begin - Added by Raven 1/14/2007
	if (!($fmail AND $ymail)) {
		include_once 'header.php';
		OpenTable();
		echo '<div class="text-center"><span class="thick">' , _ERRORINVEMAIL , '</span><br /><br />' , PHP_EOL;
		echo _GOBACK , '<br /></div>' , PHP_EOL;
		CloseTable();
		include_once 'footer.php';
		die();
	}
	// End - Added by Raven 1/14/2007
	$sid = intval($sid);
	$row = $db->sql_fetchrow($db->sql_query('SELECT `title`, `time`, `topic` FROM `' . $prefix . '_stories` WHERE `sid` = \'' . $sid . '\''));
	$title = htmlspecialchars($row['title'], ENT_QUOTES, _CHARSET);
	$time = $row['time'];
	$topic = $row['topic'];
	$row2 = $db->sql_fetchrow($db->sql_query('SELECT `topictext` FROM `' . $prefix . '_topics` WHERE `topicid` = \'' . $topic . '\''));
	$topictext = htmlspecialchars($row['topictext'], ENT_QUOTES, _CHARSET);
	$subject = _INTERESTING . ' ' . $sitename;
	 $message = _HELLO . " $fname:\n\n" . _YOURFRIEND . ' ' . $yname . ' ' . _CONSIDERED . "\n\n\n$title\n(" . _FDATE . " $time)\n" . _FTOPIC . " $topictext\n\n" . _URL . ": $nukeurl".'/modules.php?name=' . $module_name . '&file=article&sid=' . $sid . "\n\n" . _YOUCANREAD . " $sitename\n$nukeurl";
	// TegoNuke Mailer added by montego for 2.20.00
	$mailsuccess = false;
	if (defined('TNML_IS_ACTIVE')) {
		$to = array(array($fmail, $fname));
		$mailsuccess = tnml_fMailer($to, $subject, $message, $ymail, $yname);
	} else {
		  $mailsuccess = mail($fmail, $subject, $message, 'From: ' . $yname . ' <' . "$ymail>\r\n" . 'X-Mailer: PHP/ ' . phpversion());
	}
	include_once 'header.php';
	OpenTable();
	if ($mailsuccess) {
		update_points(6);
		echo '<div class="text-center">' , _FSTORY , ' <span class="thick">' , $title , '</span> ' , _HASSENT , ' ' , $fname , '... ' , _THANKS , '</div>' , PHP_EOL;
		echo '<div class="text-center"><br />' , _GOBACK , '</div><br />' , PHP_EOL;
	} else {
		echo '<div class="text-center"><span class="thick">' , _HASSENTERROR , '</span><br /><br />' , PHP_EOL;
		echo _GOBACK , '</div><br />' , PHP_EOL;
	}
	CloseTable();
	include_once 'footer.php';
	// end of TegoNuke Mailer add
}