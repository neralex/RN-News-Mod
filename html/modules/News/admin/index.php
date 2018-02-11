<?php
/**
 * @PHP-NUKE: Web Portal System
 * @package Tricked Out News
 * @version 2.6 (RN News-Mod)
 * @file: index.php (admin)
 * @copyright (c) 2002 by Francisco Burzi
 * @Additional security & Abstraction layer conversion 2003 chatserv http://www.nukeresources.com
 * @nukeWYSIWYG Copyright (c) 2005 Kevin Guske http://nukeseo.com
 * @kses developed by Ulf Harnhammar http://kses.sf.net
 * @RavenNuke(tm) Support:
 * 2012 - Nuken http://www.trickedoutnews.com
 * 2013 - rework of all functions by neralex http://www.media.soefm.de
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
if (!defined('ADMIN_FILE')) {die ('Access Denied');}
if (!defined('PHP_EOL')) define ('PHP_EOL', strtoupper(substr(PHP_OS,0,3) == 'WIN') ? "\r\n" : "\n");
$module_name = basename(dirname(dirname(__FILE__)));
/**
* set theme of ckeditor  - choose 'v2' or 'office2003'
* leave it blank for default theme 'kama'
* you can set this call in your theme.php
*/
// wysiwyg::$theme = ''; 
$modCssFile = 'themes/' . $ThemeSel . '/style/NewsAdmin.css';
if (file_exists($modCssFile)) {
	define('RN_MODULE_CSS', 'NewsAdmin.css');
}

if (is_mod_admin('admin') || is_mod_admin($module_name)) {

		if (!isset($sid)) $sid = '';
		if (!isset($ok)) $ok = '';
		if (!isset($op)) $op = '';
		if (!isset($cat)) $cat = '';
		if (!isset($catid)) $catid = '';
		if (!isset($newcat)) $newcat = '';
		if (!isset($ctitle)) $ctitle = '';
		if (!isset($alanguage)) $alanguage = '';
		if (!isset($pollTitle)) $pollTitle = '';
		if (!isset($optionText)) $optionText = '';
		if (!isset($assotop)) { $assotop = ''; }
		if (!isset($status)) $status = '';
		if (!isset($archive)) $archive = '';
		if (!isset($slocker)) $slocker = '';
		if (!isset($topicsel)) $topicsel = '';
		if (!isset($year)) $year = '';
		if (!isset($month)) $month = '';
		if (!isset($day)) $day = '';
		if (!isset($hour)) $hour = '';
		if (!isset($min)) $min = '';
		if (!isset($automated)) $automated = '';
		if (!isset($automated2)) $automated2 = '';
		if (!isset($uid)) $uid = '';
		if (!isset($notes)) $notes = '';

		include_once 'modules/' . $module_name . '/admin/post.php';
		include_once 'modules/' . $module_name . '/admin/edit.php';
		include_once 'modules/' . $module_name . '/admin/catagories.php';
		include_once 'modules/' . $module_name . '/admin/config.php';
		include_once 'modules/' . $module_name . '/admin/archive.php';

		switch($op) {

			case 'adminStory':
			adminStory($sid);
			break;

			case 'PreviewAdminStory':
			previewAdminStory($automated, $automated2, $year, $day, $month, $hour, $min, $subject, $hometext, $bodytext, $tags, $topic, $catid, $ihome, $alanguage, $acomm, $pollTitle, $optionText, $assotop, $yearselect, $monthselect, $dayselect, $hourselect, $minselect, $secselect, $yearexpire, $monthexpire, $dayexpire, $hourexpire, $minexpire, $slock);
			break;

			case 'PostAdminStory':
			csrf_check();
			postAdminStory($automated, $automated2, $year, $day, $month, $hour, $min, $subject, $hometext, $bodytext, $tags, $topic, $catid, $ihome, $alanguage, $acomm, $pollTitle, $optionText, $assotop, $yearselect, $monthselect, $dayselect, $hourselect, $minselect, $secselect, $yearexpire, $monthexpire, $dayexpire, $hourexpire, $minexpire, $slock);
			break;

			case 'EditStory':
			editStory($sid, $status);
			break;
	
			case 'ChangeStory':
			csrf_check();
			changeStory($sid, $subject, $hometext, $bodytext, $tags, $topic, $uid, $notes, $catid, $ihome, $alanguage, $acomm, $assotop, $automated, $automated2, $year, $month, $day, $hour, $min, $yearselect, $monthselect, $dayselect, $hourselect, $minselect, $secselect, $yearexpire, $monthexpire, $dayexpire, $hourexpire, $minexpire, $counter, $slock);
			break;

			case 'RemoveStory':
			removeStory($sid, $ok, $archive, $topicsel);
			break;

			case 'EditCategory':
			EditCategory($catid);
			break;
				
			case 'DelCategory':
			DelCategory($cat);
			break;
	
			case 'YesDelCategory':
			csrf_check();
			YesDelCategory($catid);
			break;
	
			case 'NoMoveCategory':
			NoMoveCategory($catid, $newcat);
			break;
	
			case 'SaveEditCategory':
			csrf_check();
			SaveEditCategory($catid, $ctitle);
			break;
			
			case 'AddCategory':
			AddCategory();
			break;
	
			case 'SaveCategory':
			csrf_check();
			SaveCategory($ctitle);
			break;

			case 'SelectCategory':
			SelectCategory($cat);
			break;

			case 'newsedit':
			newsedit();
			break;

			case 'tonSave':
			csrf_check();
			tonSave ($newsrows, $bookmark, $rblocks, $linklocation, $articlelink, $artview, $TON_useTitleLink, $TON_usePDF, $TON_useRating, $TON_useSendToFriend, $showtags, $TON_useCharLimit, $TON_CharLimit, $topadact, $topad, $bottomadact, $bottomad, $usedisqus, $shortname, $googlapi, $usegooglsb, $usegooglart, $newssort, $newsorder, $newsyearmin, $newsyearmax, $hideautotimes, $previewstory, $hideautosubmit, $archivedefault, $archivetopics, $jqueryselect, $archive_charlimit, $counttopic, $counttitle, $usenotes);
			break;

			case 'newsarchive':
			newsarchive($slocker, $topicsel);
			break;

			case 'StoryStatus':
			csrf_check();
			storystatus($sid, $topicsel, $offset, $go);
			break;
		}

	} else {
		include_once 'header.php';
		GraphicAdmin();
		OpenTable();
		echo '<div class="text-center"><span class="thick">' , _ERROR , '</span><br /><br />You do not have administration permission!</div>' , PHP_EOL;
		CloseTable();
		include_once 'footer.php';
}
die();

function storystatus($sid, $topicsel, $offset, $go) {
	global $prefix, $db, $admin_file;
	if (is_numeric($sid)) {
		$check = $db->sql_query('SELECT `sid`, `slock`, `time3` FROM `' . $prefix . '_stories` WHERE `sid` = \'' . $sid . '\'');
		list($csid, $cslock, $ctime3) = $db->sql_fetchrow($check);
		if ($cslock == 0) {
			$newslock = 3;
		} elseif ($cslock == 3) {
			$newslock = 0;
		}
		if (($cslock == 0 || $cslock == 3) && $ctime3 == '') {
			$qry = $db->sql_query('UPDATE `' . $prefix . '_stories` SET `slock` = \'' . $newslock . '\' WHERE `sid` = \'' . $sid . '\'');
			Header('Location: ' . $admin_file . '.php?op=newsarchive&slocker=' . $newslock . ($topicsel != '' ? '&topicsel=' . $topicsel : '') . ($offset != '' ? '&offset=' . $offset : '') . ($go != '' ? '&go=' . $go : '')); exit;
		} else {
			Header('Location: ' . $admin_file . '.php?op=newsarchive'); exit;
		}
	} else {
		Header('Location: ' . $admin_file . '.php?op=newsarchive'); exit;
	}
}

function puthome($ihome, $acomm) {
	echo '<br />' , PHP_EOL
	   , '<span class="thick">' , _PUBLISHINHOME , '</span>&nbsp;&nbsp;' , PHP_EOL;
	if (($ihome == 0) OR (empty($ihome))) {
		$sel1 = ' checked="checked"';
		$sel2 = '';
	}
	if ($ihome == 1) {
		$sel1 = '';
		$sel2 = ' checked="checked"';
	}
	echo '<input type="radio" name="ihome" value="0"' , $sel1 , ' />' , _YES , '&nbsp;' , PHP_EOL
	   , '<input type="radio" name="ihome" value="1"' , $sel2 , ' />' , _NO , PHP_EOL
	   , '&nbsp;&nbsp;<span class="content">[ ' , _ONLYIFCATSELECTED , ' ]</span><br /><br />' , PHP_EOL
	   , '<span class="thick">' , _ACTIVATECOMMENTS , '</span>&nbsp;&nbsp;' , PHP_EOL;
	if (($acomm == 0) OR (empty($acomm))) {
		$sel1 = ' checked="checked"';
		$sel2 = '';
	}
	if ($acomm == 1) {
		$sel1 = '';
		$sel2 = ' checked="checked"';
	}
	echo '<input type="radio" name="acomm" value="0"' , $sel1 , ' />' , _YES , '&nbsp;' , PHP_EOL
	   , '<input type="radio" name="acomm" value="1"' , $sel2 , ' />' , _NO , PHP_EOL
	   , '<br /><br />' , PHP_EOL;
}

function putpoll($pollTitle, $optionText) {
	echo '<div class="text-center">' , PHP_EOL
	   , '<span class="title">' , PHP_EOL
	   , '	' , _ATTACHAPOLL , PHP_EOL
	   , '	<br /><br />' , PHP_EOL
	   , '</span>' , PHP_EOL
	   , '<span class="tiny">' , PHP_EOL
	   , '	' , _LEAVEBLANKTONOTATTACH , PHP_EOL
	   , '	<br /><br />' , PHP_EOL
	   , '	' , _POLLTITLE , ': <input type="text" name="pollTitle" size="50" maxlength="100" value="' , htmlspecialchars($pollTitle, ENT_QUOTES, _CHARSET) , '" />' , PHP_EOL
	   , '	<br /><br />' , PHP_EOL
	   , '</span>' , PHP_EOL
	   , '<span class="content">' , _POLLEACHFIELD , '</span>' , PHP_EOL
	   , '	<ul>' , PHP_EOL;
	for($i = 1; $i <= 12; $i++) {
	if (!isset($optionText[$i])) { $optionText[$i] = ''; }
	echo '		<li style="list-style:none">' , _OPTION , ' ' , (strlen($i)>1 ? '' : '0') , $i , ': <input type="text" name="optionText[' , $i , ']" size="50" maxlength="50" value="' , htmlspecialchars($optionText[$i], ENT_QUOTES, _CHARSET) , '" /></li>' , PHP_EOL;
	}
	echo '	</ul>' , PHP_EOL
	   , '</div>' , PHP_EOL;
}

function removeStory($sid, $ok=0, $archive, $topicsel) {
	global $aid, $prefix, $db, $admin_file;
	if (is_numeric($sid)) {
		$result2 = $db->sql_query('SELECT `aid`, `slock` FROM `' . $prefix . '_stories` WHERE `sid` = \'' . $sid . '\'');
		list($aaid, $slock) = $db->sql_fetchrow($result2);
		$result = $db->sql_query('SELECT `counter` FROM `' . $prefix . '_authors` WHERE `aid` = \'' . $aaid . '\'');
		if ($aaid == $aid || is_mod_admin('admin')) {
			if ($ok) {
				csrf_check();
				$db->sql_query('DELETE FROM `' . $prefix . '_stories` WHERE `sid` = \'' . $sid . '\'');
				$db->sql_query('DELETE FROM `' . $prefix . '_comments` WHERE `sid` = \'' . $sid . '\'');
				$db->sql_query('UPDATE `' . $prefix . '_poll_desc` SET `artid` = 0 WHERE `artid` = \'' . $sid . '\'');
				$result = $db->sql_query('UPDATE `' . $prefix . '_authors` SET `counter` = `counter` - 1  WHERE `aid` = \'' . $aid . '\''); 
				$db->sql_query('DELETE FROM `' . $prefix . '_tags` WHERE `whr` = 3 AND `cid` = \'' .$sid. '\'');
				if ($archive == 1) {
					Header('Location: ' . $admin_file . '.php?op=newsarchive&slocker=' . $slock . ($topicsel != '' ? '&topicsel=' . $topicsel : '')); exit;
				} else {
					Header('Location: ' . $admin_file . '.php'); exit;
				}
			} else {
				include_once 'header.php';
				GraphicAdmin();
				OpenTable();
				echo '<div class="text-center thick">' , _ARTICLEADMIN , '</div>' , PHP_EOL
				   , '<br />' , PHP_EOL
				   , '<div class="text-center title">' , _REMOVESTORY , ' ' , $sid , ' ' , _ANDCOMMENTS , '</div>' , PHP_EOL
				   , '<div class="text-center"><br />[ <a href="' , $admin_file , '.php' , ($archive == 1 ? '?op=newsarchive' : '') , '">' , _NO , '</a> | '
				   , '<a class="rn_csrf" href="' , $admin_file , '.php?op=RemoveStory' , ($archive == 1 ? '&amp;archive=' . $archive : '') , ($topicsel != '' ? '&amp;topicsel=' . $topicsel : '' ) , '&amp;sid=' , $sid , '&amp;ok=1">' , _YES , '</a> ]</div><br />' , PHP_EOL;
				CloseTable();
				include_once 'footer.php';
			}
		} else {
			include_once 'header.php';
			GraphicAdmin();
			OpenTable();
			echo '<div class="text-center title">' , _ARTICLEADMIN , '<br />' , PHP_EOL
			   , _NOTAUTHORIZED1 , '<br /><br />' , PHP_EOL
			   , _NOTAUTHORIZED2 , '<br /><br />' , PHP_EOL
			   , _GOBACK , '</div>' , PHP_EOL;
			CloseTable();
			include_once 'footer.php';
		}
	} else {
		Header('Location: ' . $admin_file . '.php'); exit;
	}
}