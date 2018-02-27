<?php 
/**
 * @PHP-NUKE: Web Portal System
 * @package Tricked Out News
 * @version 2.6 (RN News-Mod)
 * @file: newsinstall.php
 * @copyright (c) 2002 by Francisco Burzi
 * @Additional security & Abstraction layer conversion 2003 chatserv http://www.nukeresources.com
 * @nukeWYSIWYG Copyright (c) 2005 Kevin Guske http://nukeseo.com
 * @kses developed by Ulf Harnhammar http://kses.sf.net
 * @RavenNuke(tm) Support:
 * 2012 - Nuken http://www.trickedoutnews.com
 * 2018 - rework of all functions by neralex http://www.media.soefm.de
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
define('ADMIN_FILE', true);
require_once 'mainfile.php';
$active = '<span class="thick">&radic;</span>';
$exclamation = '<span class="thick larger">&otimes;</span>';
if (file_exists('modules/News/admin/rnnewsmod.txt')) {
	$ready2move = 1;
} else {
	$ready2move = 0;
}
$style  = '<style type="text/css">' . PHP_EOL
		. '.num {color: gray; font-size:12px; font-family:monospace; padding-right:5px; padding-left:5px; padding-bottom:5px; background:#ECECEC;}' . PHP_EOL
		. '.head {background: -moz-linear-gradient(#FAFAFA, #EAEAEA) transparent; border-bottom:1px solid #D8D8D8; color:#555555; font-size:1.2em; height:22px; overflow:hidden; padding-top:6px; padding-left:5px; text-align:left; text-shadow:0 1px 0 #FFFFFF;}' . PHP_EOL
		. '.mainwrap {border:1px solid #CCCCCC; margin:0 auto; width:100%; background:#EEEEEE;}' . PHP_EOL
		. '.codewrap {position:relative; width:100%; overflow-y:scroll; overflow-x:auto;}' . PHP_EOL
		. '.code {border:none !important;}' . PHP_EOL
		. '.codeblock {padding-top:5px; padding-left:5px;}' . PHP_EOL
		. '</style>' . PHP_EOL;
addCSSToHead($style, 'inline');

if (is_mod_admin('admin')) {

	if (!isset($op)) {$op = '';}
	if (!isset($newssort)) {$newssort = '';}
	if (!isset($newsorder)) {$newsorder = '';}
	if (!isset($newsyearmin)) {$newsyearmin = '';}
	if (!isset($newsyearmax)) {$newsyearmax = '';}
	if (!isset($hideautotimes)) {$hideautotimes = '';}
	if (!isset($previewstory)) {$previewstory = '';}
	if (!isset($hideautosubmit)) {$hideautosubmit = '';}
	if (!isset($archivedefault)) {$archivedefault = '';}
	if (!isset($archivetopics)) {$archivetopics = '';}
	if (!isset($jqueryselect)) {$jqueryselect = '';}
	if (!isset($submitnews)) {$submitnews = '';}
	if (!isset($archive_charlimit)) {$archive_charlimit = '';}
	if (!isset($counttopic)) {$counttopic = '';}
	if (!isset($counttitle)) {$counttitle = '';}
	if (!isset($usenotes)) {$usenotes = '';}
	if (!isset($time2)) {$time2 = '';}
	if (!isset($time3)) {$time3 = '';}
	if (!isset($slock)) {$slock = '';}
	if (!isset($neededfields)) {$neededfields = '';}
	if (!isset($moveautonews)) {$moveautonews = '';}
	if (!isset($movesubmitnews)) {$movesubmitnews = '';}
	if (!isset($dropautonews)) {$dropautonews = '';}
	if (!isset($dropqueue)) {$dropqueue = '';}
	if (!isset($droptagstemp)) {$droptagstemp = '';}

	switch($op) {

		case 'install':
		install($newssort, $newsorder, $newsyearmin, $newsyearmax, $hideautotimes, $previewstory, $hideautosubmit, $archivedefault, $archivetopics, $jqueryselect, $archive_charlimit, $counttopic, $counttitle, $usenotes, $time2, $time3, $slock, $moveautonews, $movesubmitnews);
		break;

		case 'dbupdate':
		dbupdate();
		break;

		default:
		index();
		break;

	}
} else {
	include_once 'header.php';
	OpenTable();
	echo '<div class="text-center"><span class="thick">ERROR</span><br /><br />You do not have administration permission!</div>';
	CloseTable();
	include_once 'footer.php';
}
die();

function dbupdate() {
	global $prefix, $db, $admin_file, $radminsuper;
	include_once 'header.php';
	OpenTable();
	echo '<p class="thick large">RN News-Mod Database Update (1.0.6)</p>', PHP_EOL;
	$result = $db->sql_query('SELECT `Version_Num` FROM `' . $prefix . '_config`');
	list($rnConfig_value) = $db->sql_fetchrow($result);
	if (!$result) {
		echo 'An error occurred reading your RavenNuke configuration table; please check this since the program cannot continue without a value here.', PHP_EOL;
	}
	if ($rnConfig_value != 'rn2.52.00') {
		echo '<p><span class="thick">ERROR:</span> You are not using the latest RavenNuke Version 2.5.2! Please do an update!</p>', PHP_EOL;
	} else {
		$row = $db->sql_fetchrow($db->sql_query('SELECT `time2` FROM `' . $prefix . '_stories` ORDER BY `sid` DESC LIMIT 1'));
		if (isset($row['time2'])) {
			$time2query = $db->sql_query('ALTER TABLE `' . $prefix . '_stories` CHANGE `time2` `time2` DATETIME NULL DEFAULT NULL');
			if ($time2query) {
				echo '<p>Update time2-field done!</p>', PHP_EOL;
			} else {
				echo '<p>Update time2-field failed!</p>', PHP_EOL;
			}
			$time3query = $db->sql_query('ALTER TABLE `' . $prefix . '_stories` CHANGE `time3` `time3` DATETIME NULL DEFAULT NULL');
			if ($time3query) {
				echo '<p>Update time3-field done!</p>', PHP_EOL;
			} else {
				echo '<p>Update time3-field failed!</p>', PHP_EOL;
			}
		} else {
			echo '<p><span class="thick">ERROR:</span> Needed database-fields not found - News-Mod already installed?!</p>', PHP_EOL;
		}
	}
	echo '<br/>[ <a href="newsinstall.php">GO BACK</a> ]';
	CloseTable();
	include_once 'footer.php';
}

function index() {
	global $prefix, $db, $admin_file, $radminsuper, $currentlang, $multilingual, $querylang, $active, $exclamation, $dropmode, $ready2move;
	$newssort = 0;	$newsorder = 0; $newsyearmin = 0; $newsyearmax = 0; $hideautotimes = 0;	$previewstory = 0; $hideautosubmit = 0;	$archivedefault = 0; $archivetopics = 0; $jqueryselect = 0; $submitnews = 0; $archive_charlimit = 0; $counttopic = 0; $counttitle = 0; $usenotes = 0; $time2 = 0; $time3 = 0; $slock = 0; $neededfields = 0;
	include_once 'header.php';
	OpenTable();
	echo '<p class="thick large">RN News-Mod Installer</p>' , PHP_EOL;
	$tonquery = $db->sql_query('SHOW COLUMNS FROM `' . $prefix . '_ton` WHERE field IN("newssort", "newsorder", "newsyearmin", "newsyearmax", "hideautotimes", "previewstory", "hideautosubmit", "archivedefault", "archivetopics", "jqueryselect", "archive_charlimit", "counttopic", "counttitle", "usenotes")');	
	while (list($toncheck) = $db->sql_fetchrow($tonquery)) {
		if ($toncheck == 'newsorder') {$newssort = 1;}
		if ($toncheck == 'newssort') {$newsorder = 1;}
		if ($toncheck == 'newsyearmin') {$newsyearmin = 1;}
		if ($toncheck == 'newsyearmax') {$newsyearmax = 1;}
		if ($toncheck == 'hideautotimes') {$hideautotimes = 1;}
		if ($toncheck == 'previewstory') {$previewstory = 1;}
		if ($toncheck == 'hideautosubmit') {$hideautosubmit = 1;}
		if ($toncheck == 'archivedefault') {$archivedefault = 1;}
		if ($toncheck == 'archivetopics') {$archivetopics = 1;}
		if ($toncheck == 'jqueryselect') {$jqueryselect = 1;}
		if ($toncheck == 'archive_charlimit') {$archive_charlimit = 1;}
		if ($toncheck == 'counttopic') {$counttopic = 1;}
		if ($toncheck == 'counttitle') {$counttitle = 1;}	
		if ($toncheck == 'usenotes') {$usenotes = 1;}
	}
	echo '<form action="newsinstall.php" method="post">', PHP_EOL
		,'<p><span class="thick">News Config Table</span>:</p>', PHP_EOL;
	if ($newssort == 1) {
		echo 'News Sorting - existent ', $active, '<br />', PHP_EOL;
	} else {
		echo 'News Sorting - non-existent ', $exclamation, '<br />', PHP_EOL
			,'<input type="hidden" name="newssort" value="1" />', PHP_EOL;
	}
	if ($newsorder == 1) {
		echo 'News Order-Type - existent ', $active, '<br />', PHP_EOL;
	} else {
		echo 'News Order-Type - non-existent ', $exclamation, '<br />', PHP_EOL
			,'<input type="hidden" name="newsorder" value="1" />', PHP_EOL;
	}
	if ($newsyearmin == 1) {
		echo 'Counting Years (smallest value) - existent ', $active, '<br />', PHP_EOL;
	} else {
		echo 'Counting Years (smallest value) - non-existent ', $exclamation, '<br />', PHP_EOL
			,'<input type="hidden" name="newsyearmin" value="1" />', PHP_EOL;
	}
	if ($newsyearmax == 1) {
		echo 'Counting Years (biggest value) - existent ', $active, '<br />', PHP_EOL;
	} else {
		echo 'Counting Years (biggest value) - non-existent ', $exclamation, '<br />', PHP_EOL
			,'<input type="hidden" name="newsyearmax" value="1" />', PHP_EOL;
	}
	if ($hideautotimes == 1) {
		echo 'Hide the autopost and/or expiration input fields (post and edit) - existent ', $active, '<br />', PHP_EOL;
	} else {
		echo 'Hide the autopost and/or expiration input fields (post and edit) - non-existent ', $exclamation, '<br />', PHP_EOL
			,'<input type="hidden" name="hideautotimes" value="1" />', PHP_EOL;
	}
	if ($previewstory == 1) {
		echo 'Replace story preview with colorbox - existent ', $active, '<br />', PHP_EOL;
	} else {
		echo 'Replace story preview with colorbox - non-existent ', $exclamation, '<br />' , PHP_EOL
			,'<input type="hidden" name="previewstory" value="1" />', PHP_EOL;
	}
	if ($hideautosubmit == 1) {
		echo 'Hide the autopost and expiration input fields (Submit News) - existent ', $active, '<br />', PHP_EOL;
	} else {
		echo 'Hide the autopost and expiration input fields (Submit News) - non-existent ', $exclamation, '<br />', PHP_EOL
			,'<input type="hidden" name="hideautosubmit" value="1" />', PHP_EOL;
	}
	if ($archivedefault == 1) {
		echo 'Set a archive default value of results per page - existent ', $active, '<br />', PHP_EOL;
	} else {
		echo 'Set a archive default value of results per page - non-existent ', $exclamation, '<br />', PHP_EOL
			,'<input type="hidden" name="archivedefault" value="1" />', PHP_EOL;
	}
	if ($archivetopics == 1) {
		echo 'Hide the topics in the archive - existent ', $active, '<br />', PHP_EOL;
	} else {
		echo 'Hide the topics in the archive - non-existent ', $exclamation, '<br />', PHP_EOL
			,'<input type="hidden" name="archivetopics" value="1" />', PHP_EOL;
	}
	if ($jqueryselect == 1) {
		echo 'Use "jQuery Selectboxes" - existent ', $active, '<br />', PHP_EOL;
	} else {
		echo 'Use "jQuery Selectboxes" - non-existent ', $exclamation, '<br />', PHP_EOL
			,'<input type="hidden" name="jqueryselect" value="1" />', PHP_EOL;
	}	
	if ($archive_charlimit == 1) {
		echo 'Use Archive Charlimit - existent ' , $active , '<br />' , PHP_EOL;
	} else {
		echo 'Use "Archive Charlimit" - non-existent ', $exclamation, '<br />', PHP_EOL
			,'<input type="hidden" name="archive_charlimit" value="1" />', PHP_EOL;
	}
	if ($counttopic == 1) {
		echo 'Count the topictext in the archive - existent ', $active, '<br />', PHP_EOL;
	} else {
		echo 'Count topictext in the archive - non-existent ', $exclamation, '<br />', PHP_EOL
			,'<input type="hidden" name="counttopic" value="1" />', PHP_EOL;
	}
	if ($counttitle == 1) {
		echo 'Count the story title in the archive - existent ', $active, '<br />', PHP_EOL;
	} else {
		echo 'Count the story title in the archive - non-existent ', $exclamation, '<br />', PHP_EOL
			,'<input type="hidden" name="counttitle" value="1" />', PHP_EOL;
	}

	if ($usenotes == 1) {
		echo 'Use admin notes - existent ', $active, '<br />', PHP_EOL;
	} else {
		echo 'Activate admin notes - non-existent ', $exclamation, '<br />', PHP_EOL
			,'<input type="hidden" name="usenotes" value="1" />', PHP_EOL;
	}
	echo '<p><span class="thick">News Table</span>:</p>', PHP_EOL;
	$storyquery = $db->sql_query('SHOW COLUMNS FROM `' . $prefix . '_stories` WHERE field IN("time2", "time3", "slock")');
	while (list($storyquerycheck) = $db->sql_fetchrow($storyquery)) {
		if ($storyquerycheck == 'time2') {$time2 = 1;}
		if ($storyquerycheck == 'time3') {$time3 = 1;}
		if ($storyquerycheck == 'slock') {$slock = 1;}
	}
	if ($time2 == 1) {
		echo 'Sorting-Time - existent ' , $active , '<br />', PHP_EOL;
	} else {
		echo 'Sorting-Time - non-existent ' , $exclamation , '<br />', PHP_EOL
			,'<input type="hidden" name="time2" value="1" />' , PHP_EOL;
	}
	if ($time3 == 1) {
		echo 'Expiration-Time - existent ' , $active , '<br />' , PHP_EOL;
	} else {
		echo 'Expiration-Time - non-existent ', $exclamation, '<br />', PHP_EOL
			,'<input type="hidden" name="time3" value="1" />', PHP_EOL;
	}
	if ($slock == 1) {
		echo 'Story Status - existent ', $active, '<br />', PHP_EOL;
	} else {
		echo 'Story Status - non-existent ', $exclamation, '<br />', PHP_EOL
			,'<input type="hidden" name="slock" value="1" />', PHP_EOL;
	}
# old auto news
	if ($multilingual == 1) {
		$querylang = 'WHERE (`alanguage`=\'' . $currentlang . '\' OR `alanguage`=\'\')';
	} else {
		$querylang = '';
	}
	$autonewsresult = $db->sql_query('SELECT * FROM `' . $prefix . '_autonews` ' . $querylang);
	$autonewscount = 0;
	while ($autonews = $db->sql_fetchrow($autonewsresult, SQL_NUM)) {
		$autonewscount++;
	}
	$sql_tagsautonews = $db->sql_query('SELECT `tag` FROM `' . $prefix . '_tags_temp` WHERE `whr`=5');
	if ($db->sql_numrows($sql_tagsautonews) > 0) {
		$tagcount = 0;
		while (list($tag) = $db->sql_fetchrow($sql_tagsautonews, SQL_NUM)) {
			$tagcount++;
		}
	}
	if ($autonewscount > 0 && $tagcount == 0 && $ready2move == 1) {
		echo '<p><span class="thick">Submit-News</span>:</p>', PHP_EOL
			,$autonewscount , ' Autonews - ready to move ', $exclamation, '<br />', PHP_EOL
			,($ready2move == 1 ? '<input type="hidden" name="moveautonews" value="1" />' . PHP_EOL : '');
	} elseif ($autonewscount > 0 && $tagcount > 0 && $ready2move == 1) {
		echo '<p><span class="thick">Autonews</span>:</p>', PHP_EOL
			,$autonewscount, ' Autonews and ', $tagcount, ' Tag(s) - ready to move ', $exclamation, '<br />', PHP_EOL
			,($ready2move == 1 ? '<input type="hidden" name="moveautonews" value="1" />' . PHP_EOL : '');
	} else {
		echo '<input type="hidden" name="moveautonews" value="0" />', PHP_EOL;
	}
# old submit news
	$queueresult = $db->sql_query('SELECT * FROM `' . $prefix . '_queue` ' . $querylang);
	$queuecount = 0;
	while ($autonews = $db->sql_fetchrow($queueresult, SQL_NUM)) {
		$queuecount++;
	}
	$sql_tags_queue = $db->sql_query('SELECT `tag` FROM `' . $prefix . '_tags_temp` WHERE `whr`=6');
	if ($db->sql_numrows($sql_tags_queue) > 0) {
		$queuetagcount = 0;
		while (list($tag) = $db->sql_fetchrow($sql_tags_queue, SQL_NUM)) {
			$queuetagcount++;
		}
	}
	if ($queuecount > 0 && $queuetagcount == 0 && $ready2move == 1) {
		echo '<p><span class="thick">Submit-News</span>:</p>', PHP_EOL
			,$queuecount, ' Submit-Queue(s) - ready to move ', $exclamation, '<br />', PHP_EOL
			,($ready2move == 1 ? '<input type="hidden" name="movesubmitnews" value="1" />' . PHP_EOL : '');
	} elseif ($queuecount > 0 && $queuetagcount > 0&& $ready2move == 1) {
		echo '<p><span class="thick">Submit-News</span>:</p>', PHP_EOL
			,$queuecount, ' Submit-Queue(s) and ', $queuetagcount, ' Tag(s) - ready to move ', $exclamation, '<br />', PHP_EOL
			,($ready2move == 1 ? '<input type="hidden" name="movesubmitnews" value="1" />' . PHP_EOL : '');
	}
	
// submit actions
	if ($newssort == 0 || $newsorder == 0 || $newsyearmin == 0 || $newsyearmax == 0 || $hideautotimes == 0 || $previewstory == 0 || $hideautosubmit == 0 || $archivedefault == 0 || $archivetopics == 0 || $jqueryselect == 0 || $archive_charlimit == 0 || $counttopic == 0 || $counttitle == 0 || $usenotes == 0 || $time2 == 0 || $time3 == 0 || $slock == 0 && $ready2move == 0) {	
		echo '<p><input type="hidden" name="op" value="install" />', PHP_EOL
			,'<input type="submit" style="cursor:pointer;" value=" database install" /></p>', PHP_EOL;
	} else {
		$neededfields = 1;
		if ($ready2move == 0) {
			echo '<p><strong>All needed database fields are installed</strong>!</p>', PHP_EOL
				,'<p>', PHP_EOL
				,'Now you can upload the new files from the package!<br />', PHP_EOL
				,'After the upload run this script again to move old submit and/or autonews!<br />', PHP_EOL
				,'</p>', PHP_EOL;
		}
	}
	if ($autonewscount > 0  && $queuecount == '' && $neededfields == 1 && $ready2move == 1) {
		echo '<p><strong>All needed database fields are installed</strong>!</p>' , PHP_EOL
			,'<p>' , PHP_EOL
			,'<input type="hidden" name="op" value="install" />' , PHP_EOL
			,'<input type="submit" style="cursor:pointer;" value="transfer autonews" /></p>' , PHP_EOL;
	} elseif ($autonewscount == ''  && $queuecount > 0 && $neededfields == 1 && $ready2move == 1) { 
		echo '<p><input type="hidden" name="op" value="install" />' , PHP_EOL
			,'<input type="submit" style="cursor:pointer;" value="transfer submit news" /></p>' , PHP_EOL;
	} elseif ($autonewscount > 0  && $queuecount > 0 && $neededfields == 1 && $ready2move == 1) { 
		echo '<p><input type="hidden" name="op" value="install" />' , PHP_EOL
			,'<input type="submit" style="cursor:pointer;" value="transfer old news" /></p>' , PHP_EOL;
	} elseif ($autonewscount == ''  && $queuecount  == '' && $neededfields == 1 && $ready2move == 1) {
		echo '<p>' , PHP_EOL
			,'You have installed the new database fields and/or moved old autonews and submit news,<br />', PHP_EOL
			,'Now you can go into the [ <a href="', $admin_file, '.php?op=newsedit"><strong>News Config</strong></a> ] and choose the new options!<br />', PHP_EOL
			,'</p><br />', PHP_EOL
			,'<p><span class="thick larger">This package requires the php7-ready RavenNuke 2.5.2 with already integrated nukeWYSIWYG 3.6.3.1 Editor by nukeSEO!</span></p>', PHP_EOL
			,'<p>All related files of nukeWYSIWYG 3.6.3.1 were removed from this package, which were provided in prio versions of this News-Mod. If you are using an prio version <= 1.0.5, then you have to do an update for this News-Mod <u>AFTER</u> the update to RavenNuke 2.5.2! This package <u>will not more work</u> with prior versions of RavenNuke like RN251. So take care and do an backup of all your files and the database before you are trying updates!</p><br />', PHP_EOL
			,'<p class="thick larger">Update to the latest News-Mod 1.0.6:</p>', PHP_EOL
			,'<p>1. Download and install the latest RavenNuke 2.5.2 or do an update from prior versions. Check wiki for more details!<p>', PHP_EOL
			,'<p>2. Copy over the files from this package and run: <a href="newsinstall.php?op=dbupdate"><strong>/newsinstall.php?op=dbupdate</strong></a><p>', PHP_EOL
			,'<p><strong>Please note:</strong> This is the last update of this News-Mod for RN25x and it contains only fixes for the usage of PHP7.x and MySQL5.x without any new features! Future updates will be only released, if new PHP/MySQL issue will be located. The new version of this News-Mod will be supported only in RavenCMS.<p><br />', PHP_EOL;
		function highlight_num($input) {
			$content = highlight_string($input, true);
			echo '<div class="mainwrap">', PHP_EOL
				,'<div class="head"><strong>code</strong>:</div>', PHP_EOL
				,'<div class="codewrap">', PHP_EOL
				,'<table class="codeblock" cellspacing="0">', PHP_EOL
				,'<tr>', PHP_EOL
				,'<td class="num">', $content, '</td>', PHP_EOL
				,'</tr>', PHP_EOL
				,'</table>', PHP_EOL
				,'</div>', PHP_EOL
				,'</div>'. PHP_EOL;
		}
		echo '<p><strong>Changing CK-Editor Skin</strong>:</p>', PHP_EOL
			,'The CK Editor comes with 3 skins. They called \'v2\' (default skin) \'kama\' and \'Office2003\' (MS look). If you want change the skin, you have to set an call to a new class inside your theme.php or in your modules. Leave it blank for default theme kama.:<br /><br />', PHP_EOL;
		$snippet3 = 'wysiwyg::$theme = \'\';';
		highlight_num($snippet3);
		echo '<p><strong>change it to</strong>:</p>', PHP_EOL;
		$snippet4 = 'wysiwyg::$theme = \'v2\';';
		highlight_num($snippet4);
		echo '<p><strong>or change it to</strong>:</p>', PHP_EOL;
		$snippet5 = 'wysiwyg::$theme = \'office2003\';';
		highlight_num($snippet5);
		echo '<p><strong>Enter Mode</strong>:</p>', PHP_EOL
			,'<p>Source: <a href="http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.config.html#.enterMode" target="_blank">docs.cksource.com</a></p>', PHP_EOL
			,'Sets the behavior of the Enter key. It also determines other behavior rules of the editor, like whether the &lt;br /&gt; element is to be used as a paragraph separator when indenting text. The allowed values are the following constants that cause the behavior outlined below.<br />', PHP_EOL
			,'<p>&bull; CKEDITOR.ENTER_P (1) - new &lt;p&gt; paragraphs are created;<br />', PHP_EOL
			,'&bull; CKEDITOR.ENTER_BR (2) - lines are broken with &lt;br /&gt; elements;<br />', PHP_EOL
			,'&bull; CKEDITOR.ENTER_DIV (3) - new  &lt;div&gt; blocks are created.</p>', PHP_EOL
			,'<strong>Note</strong>: It is recommended to use the CKEDITOR.ENTER_P setting because of its semantic value and correctness. The editor is optimized for this setting.', PHP_EOL
			,'<p><strong>includes/ckeditor/config.js</strong></p>', PHP_EOL
			,'<p><strong>find</strong>:</p>', PHP_EOL;
		$snippet6 = 'CKEDITOR.editorConfig = function( config )' . PHP_EOL
				  . '{' . PHP_EOL;
		highlight_num($snippet6);
		echo '<p><strong>for example after add</strong>:</p>', PHP_EOL;
		$snippet7 = 'config.enterMode = CKEDITOR.ENTER_BR; // set enter mode from p to br';
		highlight_num($snippet7);
		echo '<p>Thats all!</p>', PHP_EOL
			,'<p style="font-weight:bold; font-size:1.5em; color:darkred">Please delete this installation file from your server!</p>', PHP_EOL;
	}
	echo '</form>', PHP_EOL;
	CloseTable();
	include_once 'footer.php';
}
function install($newssort, $newsorder, $newsyearmin, $newsyearmax, $hideautotimes, $previewstory, $hideautosubmit, $archivedefault, $archivetopics, $jqueryselect, $archive_charlimit, $counttopic, $counttitle, $usenotes, $time2, $time3, $slock, $moveautonews, $movesubmitnews) {
	global $prefix, $db, $admin_file, $currentlang, $multilingual, $querylang, $active, $exclamation, $ready2move;
	include_once 'header.php';
	OpenTable();
	if ($newssort == 1) {
		$newssortquery = $db->sql_query('ALTER TABLE `' . $prefix . '_ton` ADD `newssort` INT(1) NOT NULL DEFAULT \'0\'');
		if ($newssortquery) {
			echo 'News Sorting - added ', $active, '<br />', PHP_EOL;
		} else {
			echo 'News Sorting - query failed! ', $exclamation, '<br />', PHP_EOL;
		}
	} else {
		$newssortquery = '';
		echo 'News Sorting - existent ', $exclamation, '<br />', PHP_EOL;
	}
	if ($newsorder == 1) {
		$newsorderquery = $db->sql_query('ALTER TABLE `' . $prefix . '_ton` ADD `newsorder` INT(1) NOT NULL DEFAULT \'0\'');
		if ($newsorderquery) {
		  echo 'News Order-Type - added ', $active, '<br />', PHP_EOL;
		} else {
			echo 'News Order-Type - query failed! ', $exclamation, '<br />', PHP_EOL;
		}
	} else {
		echo 'News Order-Type - existent ', $exclamation, '<br />', PHP_EOL;
	}
	if ($newsyearmin == 1) {
		$newsyearminquery = $db->sql_query('ALTER TABLE `' . $prefix . '_ton` ADD `newsyearmin` INT(1) NOT NULL DEFAULT \'0\'');
		if ($newsyearminquery) {
		  echo 'Counting Years (smallest value) - added ', $active, '<br />', PHP_EOL;
		} else {
			echo 'Counting Years (smallest value) - query failed! ', $exclamation, '<br />', PHP_EOL;
		}
	} else {
		echo 'Counting Years (smallest value) - existent ', $exclamation, '<br />', PHP_EOL;
	}
	if ($newsyearmax == 1) {
		$newsyearmaxquery = $db->sql_query('ALTER TABLE `' . $prefix . '_ton` ADD `newsyearmax` INT(1) NOT NULL DEFAULT \'0\'');
		if ($newsyearmaxquery) {
			echo 'Counting Years (biggest value) - added ', $active, '<br />', PHP_EOL;
		} else {
			echo 'Counting Years (biggest value) - query failed! ', $exclamation, '<br />', PHP_EOL;
		}
	} else {
		echo 'Counting Years (biggest value) - existent ', $exclamation, '<br />', PHP_EOL;
	}
	if ($hideautotimes == 1) {
		$hideautotimesquery = $db->sql_query('ALTER TABLE `' . $prefix . '_ton` ADD `hideautotimes` INT(1) NOT NULL DEFAULT \'0\'');
		if ($hideautotimesquery) {
			echo 'Hide the autopost/expiration input fields (post and edit) - added ', $active, '<br />', PHP_EOL;
		} else {
			echo 'Hide the autopost/expiration input fields (post and edit) - query failed! ', $exclamation, '<br />', PHP_EOL;
		}
	} else {
		echo 'Hide the autopost/expiration input fields (post and edit) - existent ', $exclamation, '<br />', PHP_EOL;
	}
	if ($previewstory == 1) {
		$previewstoryquery = $db->sql_query('ALTER TABLE `' . $prefix . '_ton` ADD `previewstory` INT(1) NOT NULL DEFAULT \'0\'');
		if ($previewstoryquery) {
			echo 'Replace story preview with colorbox - added ' , $active , '<br />' , PHP_EOL;
		} else {
			echo 'Replace story preview with colorbox - query failed! ', $exclamation, '<br />', PHP_EOL;
		}
	} else {
		echo 'Replace story preview with colorbox - existent ', $exclamation, '<br />', PHP_EOL;
	}
	if ($hideautosubmit == 1) {
		$hideautosubmitquery = $db->sql_query('ALTER TABLE `' . $prefix . '_ton` ADD `hideautosubmit` INT(1) NOT NULL DEFAULT \'0\'');
		if ($hideautosubmitquery) {
			echo 'Hide the autopost and expiration input fields (Submit News) - added ', $active, '<br />', PHP_EOL;
		} else {
			echo 'Hide the autopost and expiration input fields (Submit News) - query failed! ', $exclamation, '<br />', PHP_EOL;
		}
	} else {
		echo 'Hide the autopost and expiration input fields (Submit News) - existent ', $exclamation, '<br />', PHP_EOL;
	}
	if ($archivedefault == 1) {
		$archivedefaultquery = $db->sql_query('ALTER TABLE `' . $prefix . '_ton` ADD `archivedefault` INT(1) NOT NULL DEFAULT \'0\'');
		if ($archivedefaultquery) {
			echo 'Set a archive default value of results per page - added ', $active, '<br />', PHP_EOL;
		} else {
			echo 'Set a archive default value of results per page - query failed! ', $exclamation, '<br />', PHP_EOL;
		}
	} else {
		echo 'Set a archive default value of results per page - existent ', $exclamation, '<br />', PHP_EOL;
	}
	if ($archivetopics == 1) {
		$archivetopicsquery = $db->sql_query('ALTER TABLE `' . $prefix . '_ton` ADD `archivetopics` INT(1) NOT NULL DEFAULT \'0\'');
		if ($archivetopicsquery) {
			echo 'Hide topics in archive - added ', $active, '<br />', PHP_EOL;
		} else {
			echo 'Hide topics in archive - query failed! ', $exclamatio , '<br />', PHP_EOL;
		}
	} else {
		echo 'Hide topics in archive - existent ', $exclamation, '<br />', PHP_EOL;
	}
	if ($jqueryselect == 1) {
		$jqueryselectquery = $db->sql_query('ALTER TABLE `' . $prefix . '_ton` ADD `jqueryselect` INT(1) NOT NULL DEFAULT \'0\'');
		if ($jqueryselectquery) {
			echo 'Use jQuery Selectboxes - added ', $active, '<br />', PHP_EOL;
		} else {
			echo 'Use jQuery Selectboxes - query failed! ', $exclamation, '<br />', PHP_EOL;
		}
	} else {
		echo 'Use jQuery Selectboxes - existent ', $exclamation, '<br />', PHP_EOL;
	}
	if ($archive_charlimit == 1) {
		$archivelimitquery = $db->sql_query('ALTER TABLE `' . $prefix . '_ton` ADD `archive_charlimit` INT(1) NOT NULL DEFAULT \'0\'');
		if ($archivelimitquery) {
			echo 'Use Archive Charlimit - added ', $active, '<br />', PHP_EOL;
		} else {
			echo 'Use Archive Charlimit - query failed! ', $exclamation, '<br />', PHP_EOL;
		}
	} else {
		echo 'Use Archive Charlimit - existent ', $exclamation, '<br />', PHP_EOL;
	}
	if ($counttopic == 1) {
		$counttopicquery = $db->sql_query('ALTER TABLE `' . $prefix . '_ton` ADD `counttopic` INT(3) NOT NULL DEFAULT \'0\'');
		if ($counttopicquery) {
			echo 'Count the topictext in the archive - added ', $active, '<br />', PHP_EOL;
		} else {
			echo 'Count the topictext in the archive - query failed! ', $exclamation, '<br />', PHP_EOL;
		}
	} else {
		echo 'Count the topictext in the archive - existent ', $exclamation, '<br />', PHP_EOL;
	}
	if ($counttitle == 1) {
		$counttitlequery = $db->sql_query('ALTER TABLE `' . $prefix . '_ton` ADD `counttitle` INT(3) NOT NULL DEFAULT \'0\'');
		if ($counttitlequery) {
			echo 'Count the story title in the archive - added ', $active, '<br />', PHP_EOL;
		} else {
			echo 'Count the story title in the archive - query failed! ', $exclamation, '<br />', PHP_EOL;
		}
	} else {
		echo 'Count the story title in the archive - existent ', $exclamation, '<br />', PHP_EOL;
	}
	if ($usenotes == 1) {
		$usenotesquery = $db->sql_query('ALTER TABLE `' . $prefix . '_ton` ADD `usenotes` INT(1) NOT NULL DEFAULT \'0\'');
		if ($usenotesquery) {
			echo 'Use admin notes - added ', $active, '<br />', PHP_EOL;
		} else {
			echo 'Use admin notes - query failed! ', $exclamation, '<br />', PHP_EOL;
		}
	} else {
		echo 'Use admin notes - existent ', $exclamation, '<br />', PHP_EOL;
	}
	if ($time2 == 1) {
		$time2query = $db->sql_query('ALTER TABLE `' . $prefix . '_stories` ADD `time2` DATETIME NULL DEFAULT NULL');
		if ($time2query) {
			echo 'Sorting-Time - added ', $active, '<br />', PHP_EOL;
		} else {
			echo 'Sorting-Time - query failed! ', $exclamation, '<br />', PHP_EOL;
		}
	} else {
		echo 'Sorting-Time - existent ', $exclamation, '<br />', PHP_EOL;
	}
	if ($time2 == 1) {
		$time2timequery = $db->sql_query('UPDATE `' . $prefix . '_stories` SET `time2` = `time`;');
		if ($time2timequery) {
			echo 'Posting-Time duplicated into Sorting-Time - done ', $active, '<br />', PHP_EOL;
		} else {
			echo 'Posting-Time duplicated into Sorting-Time - query failed! ', $exclamation, '<br />', PHP_EOL;
		}
	}
	if ($time3 == 1) {
		$time3query = $db->sql_query('ALTER TABLE `' . $prefix . '_stories` ADD `time3` DATETIME NULL DEFAULT NULL');
		if ($time3query) {
			echo 'Expiration-Time - added ', $active, '<br />', PHP_EOL;
		} else {
			echo 'Expiration-Time - query failed! ', $exclamation, '<br />', PHP_EOL;
		}
	} else {
		echo 'Expiration-Time - existent ', $exclamation, '<br />', PHP_EOL;
	}
	if ($slock == 1) {
		$slockquery = $db->sql_query('ALTER TABLE `' . $prefix . '_stories` ADD `slock` INT(1) NOT NULL DEFAULT \'0\'');
		if ($slockquery) {
			echo 'Story Status - added ', $active, '<br />', PHP_EOL;
		} else {
			echo 'Story Status - query failed! ', $exclamation, '<br />' , PHP_EOL;
		}
	} else {
		echo 'Story Status - existent ', $exclamation, '<br />', PHP_EOL;
	}
	$anmoveres = '';
	if ($moveautonews == 1 && $ready2move == 1) {
		if ($multilingual == 1) {
			$querylang = 'WHERE (`alanguage`=\'' . $currentlang . '\' OR `alanguage`=\'\')';
		} else {
			  $querylang = '';
		}
		$anresult = $db->sql_query('SELECT `anid` FROM `' . $prefix . '_autonews` ' . $querylang);
		$autonewscount = 0;
		while (list($anid) = $db->sql_fetchrow($anresult, SQL_NUM)) {
			if ($anid > 0) {
				$anresult2 = $db->sql_query('SELECT * FROM `' . $prefix . '_autonews` WHERE `anid` = \'' . $anid . '\'');
				while ($row2 = $db->sql_fetchrow($anresult2, SQL_ASSOC)) {
					$anmoveres = $db->sql_query('INSERT INTO `' . $prefix . '_stories` VALUES (NULL, 
					\'' . $row2['catid'] . '\', 
					\'' . $row2['aid'] . '\', 
					\'' . $db->sql_escape_string($row2['title']) . '\', 
					\'' . $row2['time']  . '\', 
					\'' . $db->sql_escape_string($row2['hometext']) . '\''. ', 
					\'' . $db->sql_escape_string($row2['bodytext']) . '\', 
					0, 
					0, 
					\'' . $db->sql_escape_string($row2['topic']) . '\', 
					\'' . $db->sql_escape_string($row2['informant']) . '\', 
					\'' . $db->sql_escape_string($row2['notes']) . '\', 
					\'' . $row2['ihome'] . '\', 
					\'' . $db->sql_escape_string($row2['alanguage']) . '\'' . ', 
					\'' . $row2['acomm'] . '\', 
					0, 
					0, 
					0, 
					0, 
					\'' . $db->sql_escape_string($row2['associated']) . '\', 
					\'' . $row2['time'] . '\', 
					0, 
					2)');
					$lastid = $db->sql_nextid();
					$db->sql_query('DELETE FROM `' . $prefix . '_autonews` WHERE `anid` = \'' . $anid . '\'');
					$sql_tags_autonews = $db->sql_query('SELECT `tag` FROM `' . $prefix . '_tags_temp` WHERE `whr` = 5 AND `cid` = \'' . $anid . '\'');
					if ($db->sql_numrows($sql_tags_autonews) > 0) {
						while (list($tag) = $db->sql_fetchrow($sql_tags_autonews, SQL_NUM)) {
							$tags[] = $tag;
						}
						$sql = '';
						foreach ($tags as $tag) {
							if (!empty($sql)) $sql .= ', ';
							$sql .= '("' . $db->sql_escape_string($tag) . '", "' . $lastid . '", "3")';
							unset($tags);
						}
						$db->sql_query('INSERT INTO `' . $prefix . '_tags` (tag,cid,whr) VALUES ' . $sql);
						$db->sql_query('DELETE FROM `' . $prefix . '_tags_temp` WHERE `cid` = "' . $anid . '" AND `whr` = 5');
					}
				}
			}
		$autonewscount ++;
		}
		if ($anmoveres) {
			echo $autonewscount, ' Autonews - moved &amp; deleted ', $active, '<br />', PHP_EOL;
		} else {
			echo 'No Autonews are moved ', $exclamation, '<br />', PHP_EOL;
		}
	} else {
		echo 'Autonews - non-existent or not moved ', $exclamation, '<br />' , PHP_EOL;
	}

	$qumoveres = '';
	if ($movesubmitnews == 1 && $ready2move == 1) {
		if ($multilingual == 1) {
			$querylang = 'WHERE (`alanguage`=\'' . $currentlang . '\' OR `alanguage`=\'\')';
		} else {
			$querylang = '';
		}
		$qidresult = $db->sql_query('SELECT `qid` FROM `' . $prefix . '_queue` ' . $querylang);
		$qidcount = 0;
		while (list($qid) = $db->sql_fetchrow($qidresult, SQL_NUM)) {
			if ($qid > 0) {
				$qidresult2 = $db->sql_query('SELECT * FROM `' . $prefix . '_queue` WHERE `qid`=\'' . $qid . '\'');
				while ($row2 = $db->sql_fetchrow($qidresult2, SQL_ASSOC)) {		  
					$qumoveres = $db->sql_query('INSERT INTO `' . $prefix . '_stories` VALUES (NULL, 
					0, 
					\'\', 
					\'' . $db->sql_escape_string($row2['subject']) . '\', 
					\'' . $row2['timestamp']	. '\', 
					\'' . $db->sql_escape_string($row2['story']) . '\''. ', 
					\'' . $db->sql_escape_string($row2['storyext']) . '\', 
					0, 
					0, 
					\'' . $db->sql_escape_string($row2['topic']) . '\', 
					\'' . $db->sql_escape_string($row2['uname']) . '\', 
					\'\', 
					0, 
					\'' . $db->sql_escape_string($row2['alanguage']) . '\'' . ', 
					0, 
					0, 
					0, 
					0, 
					0, 
					\'\', 
					\'' . $row2['timestamp'] . '\', 
					0, 
					1)');
					$qlastid = $db->sql_nextid();
					$db->sql_query('DELETE FROM `' . $prefix . '_queue` WHERE `qid`=\'' . $qid . '\'');
					$sql_tags_queue = $db->sql_query('SELECT `tag` FROM `' . $prefix . '_tags_temp` WHERE `whr` = 6 AND `cid` = \'' . $qid . '\'');
					if ($db->sql_numrows($sql_tags_queue) > 0) {
						while (list($qtag) = $db->sql_fetchrow($sql_tags_queue, SQL_NUM)) {
							$qtags[] = $qtag;
						}
						$qsql = '';
						foreach ($qtags as $qtag) {
							if (!empty($qsql)) $qsql .= ', ';
								$qsql .= '("' . $db->sql_escape_string($qtag) . '", "' . $qlastid . '", "3")';
								unset($qtags);
							}
							$db->sql_query('INSERT INTO `' . $prefix . '_tags` (tag,cid,whr) VALUES ' . $qsql);
							$db->sql_query('DELETE FROM `' . $prefix . '_tags_temp` WHERE `cid` = "' . $qid . '" AND `whr`= 6');
						}
					}
			}
			$qidcount++;
		}
		if ($qumoveres) {
			echo $qidcount, ' Submit News - moved &amp; deleted ', $active, '<br />', PHP_EOL;
		} else {
			echo 'No Submit News are moved ', $exclamation, '<br />', PHP_EOL;
		}
	} else {
		echo 'Submit News - non-existent or not moved ', $exclamation, '<br />', PHP_EOL;
	}
	if ($newssortquery  && $newsorderquery && $newsyearminquery && $newsyearmaxquery && $hideautotimesquery && $previewstoryquery && $hideautosubmitquery && $archivedefaultquery  && $archivetopicsquery && $jqueryselectquery && $archivelimitquery && $counttopicquery && $counttitlequery && $usenotesquery && $slockquery && $time2query && $time3query && $slockquery && $anmoveres && $qumoveres) {
		echo '<p><strong>done</strong>!</p>', PHP_EOL
			,'<p>', PHP_EOL
			,'You have installed the new database fields and/or moved old autonews and submit news,<br />', PHP_EOL
			,'Go into the <a href="', $admin_file, '?op=newsedit"><strong>News Config</strong></a> and choose your new options!<br />', PHP_EOL
			,'</p>', PHP_EOL
			,'<p style="font-weight:bold; font-size:1.5em; color:darkred">Please delete this installation file from your server!</p>', PHP_EOL
			,'<p>[ <a href="newsinstall.php"><strong>go back</strong></a> ]</p>', PHP_EOL;
	} else {
		echo '<p><strong>done</strong>!</p>', PHP_EOL
			,'<p>[ <a href="newsinstall.php"><strong>go back</strong></a> ]</p>', PHP_EOL;
	}
	CloseTable();
	include_once 'footer.php';
}
?>