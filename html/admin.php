<?php
/**
 *
 * @package RavenNuke 2.5
 * @subpackage Core
 * @version $Id$
 * @copyright (c) 2011 Raven Web Services, LLC
 * @link http://www.ravennuke.com
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * PHP-NUKE: Advanced Content Management System
 * Copyright (c) 2002 by Francisco Burzi
 * http://phpnuke.org
 *
*/

define('ADMIN_FILE', true);
require_once 'mainfile.php';

global $admin, $admin_file;

$op = !empty($_REQUEST['op']) ? $_REQUEST['op'] : 'adminMain';

//Do we need to be doing this at all?  If the value is not set that means the config file is not loaded or misedited.
/**
 * Why do this check in every module when it can be done here!
*/
if (!isset($admin_file)) $admin_file = 'admin';

/**
 * Some quick checks to see if everything is legit!
 *
 * @todo not sure about the regex being here.
*/
if(isset($_REQUEST['aid'])) {
	if( ($_REQUEST['aid'] && empty($admin) && $op != 'login') || preg_match('/[^\p{L}\p{N}\p{Pd}\p{Pc}]/', trim($_REQUEST['aid'])) ) {
		header('Location: ' . $admin_file . '.php');
		die('Access Denied');
	}
}

get_lang('admin');

/**
* Check to see if there is an admin and if not create one.
*/
create_first();

/**
* Log the admin in if we need to
*/
if (isset($_POST['aid']) && isset($_POST['pwd']) && $op == 'login') {
	$aid = substr($_POST['aid'], 0, 25);
	$pwd = substr($_POST['pwd'], 0, 40);
	$gfx_check = isset($_POST['gfx_check']) ? $_POST['gfx_check'] : '';
	if (!security_code_check($gfx_check, array(1,5,6,7))) {
		login();
		die();
	}
	if(!empty($aid) && !empty($pwd)) {
		$pwd = md5($pwd);
		$result = $db->sql_query('SELECT `pwd`, `admlanguage` FROM `' . $prefix . '_authors` WHERE `aid`=\'' . addslashes($aid) . '\'');
		list($rpwd, $admlanguage) = $db->sql_fetchrow($result, SQL_NUM);

		if($rpwd == $pwd) {
			$admin = base64_encode($aid . ':' . $pwd . ':' . $admlanguage);
			setcookie('admin', $admin, time() + 2592000);
			$op = 'adminMain';
		}
	}
}

/**
* The brains of the operation
*/
if(!empty($admin) && is_admin($admin)) {
	$aid = is_admin($admin);
	switch($op) {
		/**
		* This is not used in the current code.
		*/
		case 'do_gfx':
			gen_old_gfx();
			break;

		case 'GraphicAdmin':
			GraphicAdmin();
			break;

		case 'adminMain':
			adminMain();
			break;

		case 'logout':
			setcookie('admin', false);
			include_once 'header.php';
			OpenTable();
			echo '<div class="text-center title thick">' , _YOUARELOGGEDOUT , '</div>';
			CloseTable();
			Header('Refresh: 3; url=' . $admin_file . '.php');
			include_once 'footer.php';
			break;

		case 'login';
			$op = '';

		default:
			if (!is_admin($admin)) {
				login();
			}
			$casedir = dir('admin/case');
			while($func=$casedir->read()) {
				if(substr($func, 0, 5) == 'case.') {
					include_once $casedir->path . '/' . $func;
				}
			}
			closedir($casedir->handle);
			$result = $db->sql_query('SELECT `title` FROM `' . $prefix . '_modules` ORDER BY `title` ASC');
			while (list($mod_title) = $db->sql_fetchrow($result)) {
				if (file_exists(NUKE_MODULES_DIR . $mod_title . '/admin/case.php')) {
					include_once NUKE_MODULES_DIR . $mod_title . '/admin/case.php';
				}
			}
			break;
	}

} else {
	login();
	die();
}

/**
* ONLY FUNCTIONS BELOW THIS POINT
*/

/**
* Login function
*
* Creates the login box for admins to login
*
* @global string $admin_file name of admin file
*/
function login() {
	global $admin_file;
	include_once 'header.php';
	OpenTable();
	echo '<div class="text-center title thick">' , _ADMINLOGIN , '</div>';
	CloseTable();
	OpenTable();
	echo '<form action="' , $admin_file , '.php" method="post">'
		, '<table style="border-style: none;">'
		, '<tr><td><label for="aid">' , _ADMINID , ':</label></td>'
		, '<td><input type="text" id="aid" name="aid" size="20" maxlength="25" /></td></tr>'
		, '<tr><td><label for="pwd">' , _PASSWORD , ':</label></td>'
		, '<td><input type="password" id="pwd" name="pwd" size="20" maxlength="40" /></td></tr>'
		, security_code(array(1,5,6,7), 'normal')
		, '<tr><td><input type="hidden" name="op" value="login" />'
		, '<input class="button1" type="submit" value="' , _LOGIN , '" />'
		, '</td></tr></table>'
		, '</form>';
	CloseTable();
	include_once 'footer.php';
}

/**
* Administration Menu Function
*
* @global integer $counter holds the numbe of items so we know when to start a new row
* @global array $nuke_config array of RN config varaialbes
* @param string $url link to module admin
* @param string $title name of module
* @param string $image image name of icon in images/admin/ or themes/your_theme/images/admin/
*/
function adminmenu($url, $title, $image) {
	global $counter, $nuke_config;
	$ThemeSel = get_theme();
	if (file_exists(NUKE_THEMES_DIR . $ThemeSel . '/images/admin/' . $image)) {
		$image = 'themes/' . $ThemeSel . '/images/admin/' . $image;
	} else {
		$image = 'images/admin/' . $image;
	}
	if ($nuke_config['admingraphic']) {
		$img = '<img src="' . $image . '" alt="' . $title . '" title="' . $title . '" /></a><br />';
		$close = '';
	} else {
		$img = '';
		$close = '</a>';
	}
	echo '<td class="text-center content" style="width: 16%; vertical-align: top;"><a href="' , $url , '">' , $img
		, '<span class="thick">' , $title , '</span>' , $close , '<br /><br /></td>';
	if ($counter == 5) {
		echo '</tr><tr>';
		$counter = 0;
	} else {
		$counter++;
	}
}

/**
* Graphic Admin
*
* Creates the main and module administrative menus
*
* @global integer $counter holds the number of items so we know when to start a new row
* @global boolean $showAdminMenu show admin menu if nukeNAV is active
* @global boolean $usenukeNAV whether nukeNAV is enabled
*/
function GraphicAdmin() {
	global $admin_file, $counter, $db, $op, $prefix, $showAdminMenu, $usenukeNAV;
//	$newsubs = $db->sql_numrows($db->sql_query('SELECT `qid` FROM `' . $prefix . '_queue`')); // neralex: not more needed!
	/**
	* Need to provide backward compatability for modules that do not use is_mod_admin()
	*/
	$radminsuper = is_mod_admin('admin');
	if (is_mod_admin('admin') && ($usenukeNAV == 0 || ($usenukeNAV > 0 && $showAdminMenu))) {
		OpenTable();
		echo '<div class="text-center title"><a href="' , $admin_file , '.php">' , _ADMINMENU , '</a>'
			, '<br /><br /></div>';
		if (empty($op) || ($op == 'adminMain')) {
			echo '<table style="border-style: none; width: 100%;"><tr>';
			$linksdir = dir('admin/links');
			$menulist = '';
			while($func = $linksdir->read()) {
				if(substr($func, 0, 6) == 'links.') {
					$menulist .= $func . ' ';
				}
			}
			closedir($linksdir->handle);
			$menulist = explode(' ', $menulist);
			sort($menulist);
			for ($i=0; $i < sizeof($menulist); $i++) {
				if(!empty($menulist[$i])) {
					$sucounter = 0;
					include_once($linksdir->path . '/' . $menulist[$i]);
				}
			}
			adminmenu($admin_file . '.php?op=logout', _ADMINLOGOUT, 'logout.gif');
			if ($counter == 0) echo '<td></td>';
			echo'</tr></table>';
		}
		$counter = '';
		CloseTable();
	}
	if (empty($op) or ($op == 'adminMain')) {
		OpenTable();
		echo '<div class="text-center title"><a href="' , $admin_file , '.php">' , _MODULESADMIN , '</a>'
			, '<br /><br /></div>'
			, '<table style="border-style: none; width: 100%;"><tr>';
		$result = $db->sql_query('SELECT `title` FROM `' . $prefix . '_modules` ORDER BY `title` ASC');
		while ($row = $db->sql_fetchrow($result, SQL_ASSOC)) {
			if (is_mod_admin($row['title'])) {
				if (file_exists(NUKE_MODULES_DIR . $row['title'] . '/admin/links.php')) {
					include_once NUKE_MODULES_DIR . $row['title'] . '/admin/links.php';
				}
			}
		}
		adminmenu($admin_file . '.php?op=logout', _ADMINLOGOUT, 'logout.gif');
		if ($counter == 0) echo '<td></td>';
		echo'</tr></table>';
		CloseTable();
	}
}

/**
 * Administration Main Function
*/
function adminMain() {
	global $admin, $admin_file, $db, $nuke_config, $prefix, $user_prefix;

	//The following is needed to determine new users from today and yesterday
	$userCount = 0;
	$userCount2 = 0;
	$todayDST = date('I', time()) * 3600;
	$yesterdayDST = date('I', time() - 86400) * 3600;
	$Today = date('M d, Y', time() - $todayDST);
	$Yesterday = date('M d, Y', time() - 86400 - $yesterdayDST);
	$sql = 'SELECT `user_regdate`, COUNT(user_regdate) FROM `' . $user_prefix . '_users` WHERE `user_regdate` IN(\'' . $Today . '\', \'' . $Yesterday . '\') GROUP BY `user_regdate` LIMIT 0,2';
	$result = $db->sql_query($sql);
	while ($row = $db->sql_fetchrow($result, SQL_NUM)) {
		if ($row[0] == $Today) {
			$userCount = $row[1];
		} elseif ($row[0] == $Yesterday) {
			$userCount2 = $row[1];
		}
	}
	$ThemeSel = get_theme(true);
	include_once 'header.php';	
	GraphicAdmin();
	$aid = is_admin($admin);
	list($admlanguage) = $db->sql_fetchrow($db->sql_query('SELECT `admlanguage` FROM `' . $prefix . '_authors` WHERE `aid`=\'' . addslashes($aid) . '\''), SQL_NUM);
	$radminsuper = is_mod_admin('admin');
	$radminarticle = is_mod_admin('News');
	if (!empty($admlanguage)) {
		$queryalang = 'WHERE `alanguage`=\'' . addslashes($admlanguage) . '\'';
	} else {
		$queryalang = '';
	}
	list($main_module) = $db->sql_fetchrow($db->sql_query('SELECT `main_module` FROM `' . $prefix . '_main`'));
	OpenTable();
	echo '<div class="text-center"><span class="thick">' , htmlspecialchars($nuke_config['sitename'], ENT_QUOTES, _CHARSET) , '.: ' , _DEFHOMEMODULE , '</span><br /><br />'
		, _MODULEINHOME , ' <span class="thick">' , $main_module , '</span><br />[ <a href="' , $admin_file , '.php?op=modules">' , _CHANGE , '</a> ]</div>';
	CloseTable();

	$guest_online_num = (int) $db->sql_numrows($db->sql_query('SELECT `uname` FROM `' . $prefix . '_session` WHERE `guest`=1'));
	$member_online_num = (int) $db->sql_numrows($db->sql_query('SELECT `uname` FROM `' . $prefix . '_session` WHERE `guest`=0'));
	$who_online_num = $guest_online_num + $member_online_num;
	OpenTable();
	echo '<div class="text-center"><span class="option">' , _WHOSONLINE , '</span><br /><br /><span class="content">' , _CURRENTLY , ' ' , $guest_online_num
		, ' ' , _GUESTS , ' ' , $member_online_num , ' ' , _MEMBERS , '<br /><br />'
		, _BTD , ': <span class="thick">' , $userCount , '</span> - ' , _BYD , ': <span class="thick">' , $userCount2 , '</span></span></div>';
	CloseTable();

	if (is_active('News')) {
		OpenTable();
		echo $queryalang;
		$tonquery = $db->sql_query('SELECT `newssort`, `newsorder`, `archivedefault`, `archivetopics`, `archive_charlimit`, `counttopic`, `counttitle` FROM `' . $prefix . '_ton`');
		list($newssort, $newsorder, $archivedefault, $archivetopics, $archive_charlimit, $counttopic, $counttitle) = $db->sql_fetchrow($tonquery);
		$result = $db->sql_query('SELECT `sid`, `aid`, `title`, `time`, s.`counter` as `scounter`, `informant`, `alanguage`, `time2`, `time3`, `slock`, `topicid`, `topicname`, `topictext` FROM `' . $prefix . '_stories` s LEFT JOIN `' . $prefix . '_topics` ON `topicid` = `topic` ' . ($queryalang != '' ? $queryalang . ' AND ' : ' WHERE ') . ' `slock` = 0 ORDER BY `time` DESC LIMIT 0,20');
		$numarticles = $db->sql_numrows($result);
		if ($numarticles) {
			$slockres0 = $db->sql_query('SELECT COUNT(*) FROM ' . $prefix . '_stories WHERE slock = 0');
			list($slocknum0) = $db->sql_fetchrow($slockres0, SQL_NUM);	
			$slockres1 = $db->sql_query('SELECT COUNT(*) FROM ' . $prefix . '_stories WHERE slock = 1');
			list($slocknum1) = $db->sql_fetchrow($slockres1, SQL_NUM);
			$slockres2 = $db->sql_query('SELECT COUNT(*) FROM ' . $prefix . '_stories WHERE slock = 2');
			list($slocknum2) = $db->sql_fetchrow($slockres2, SQL_NUM);	
			$slockres3 = $db->sql_query('SELECT COUNT(*) FROM ' . $prefix . '_stories WHERE slock = 3');
			list($slocknum3) = $db->sql_fetchrow($slockres3, SQL_NUM);	   
			function headfoot($newssort, $archivetopics) {
			  echo '<tr>' , PHP_EOL
				 , '<td class="text-center">ID</td>' , PHP_EOL
				 , '<td class="archivetitle">' , ($archivetopics == 0 ? _TOPIC . ' &amp; ' . _TITLE : _TITLE) , '</td>' , PHP_EOL
				 , '<td class="text-center">';
				  echo _TONPOSTTIME , '</td>' , PHP_EOL;
			  if ($newssort == 1) { 
			  echo '<td class="text-center">',_TONSORTTIME , '</td>' , PHP_EOL;
			  }
			  echo '<td class="text-center">' , _TONEXPTIME , '</td>' , PHP_EOL
				 , '</tr>' , PHP_EOL;
			}
			function hoveritems($editdel, $slockstatus, $informant, $scounter, $alanguage) {
				global $multilingual;
				echo '<div>' , PHP_EOL
				   , '<p>' , $editdel , '</p>' , PHP_EOL
				   , ($multilingual == 1 && $alanguage != '' ? '<p>' . _LANGUAGE . ': ' . $alanguage . '</p>' . PHP_EOL : '')
				   , '<p>' , _TONSTORYLOCK , ': ' , $slockstatus , '</p>' , PHP_EOL
				   , '<p>' , _TONAUTHOR , ': ' , $informant , '</p>' , PHP_EOL
				   , '<p>' , _TONREADS , ': ' , $scounter , '</p>' , PHP_EOL
				 , '</div>' , PHP_EOL;
			}
			 echo '<div align="center" class="archiveswitch">' , PHP_EOL
			   //, '<p class="thick large">' , _LAST , ' 20 ' , _ARTICLES , '</p>' , PHP_EOL	
			   , '<p class="thick large">' , _LAST , ' ' , _ARTICLES , '</p>' , PHP_EOL
			   , '<a href="' , $admin_file , '.php?op=newsarchive&amp;slocker=0">' , _TONSTORYLOCKACTIVE , '<br />(' , ($slocknum0 > 0 ? $slocknum0 : '0') , ')</a>' , PHP_EOL
			   , '<a href="' , $admin_file , '.php?op=newsarchive&amp;slocker=1">' , _TONSTORYLOCKSUBMIT , '<br />(' , ($slocknum1 > 0 ? $slocknum1 : '0') , ')</a>' , PHP_EOL
			   , '<a href="' , $admin_file , '.php?op=newsarchive&amp;slocker=2">' , _TONSTORYLOCKTIMED , '<br />(' , ($slocknum2 > 0 ? $slocknum2 : '0') , ')</a>' , PHP_EOL
			   , '<a href="' , $admin_file , '.php?op=newsarchive&amp;slocker=3">' , _TONSTORYLOCKFULL , '<br />(' , ($slocknum3 > 0 ? $slocknum3 : '0') , ')</a>' , PHP_EOL
			   , '</div>' , PHP_EOL
			   , '<br />' , PHP_EOL;
			if ($radminarticle == 1 || $radminsuper == 1) {
				 echo '<div class="text-center">'
					, '<form action="' , $admin_file , '.php" method="post">'
					, '<label for="sid">', _STORYID , ':</label><input style="margin: 5px;" type="text" id="sid" name="sid" size="10" />'
					, '<select style="margin: 5px;" name="op">'
					, '<option value="EditStory" selected="selected">' , _EDIT , '</option>'
					, '<option value="RemoveStory">' , _DELETE , '</option>'
			   		, '</select>'
			   		, '<input class="button1" type="submit" value="' , _GO , '" />'
			   		, '</form></div>'
			   		, '<br />' , PHP_EOL;					
			}
			echo '<table border="0" cellpadding="0" cellspacing="0" class="archivelist centered">' , PHP_EOL;				
			headfoot($newssort, $archivetopics);
			while (list($sid, $said, $title, $time, $scounter, $informant, $alanguage, $time2, $time3, $slock, $topicid, $topicname, $topictext) = $db->sql_fetchrow($result, SQL_NUM)) {
				if ((empty($alanguage))) {
					$alanguage = _ALL;
				}
				formatTimestamp($time);
				$timestamp1 = new DateTime($time);
				$timestamp2 = new DateTime($time2);
				$timestamp3 = new DateTime($time3);	
				$postingtime = $timestamp1->format('d.m.Y - H:i');
				$sortingtime = $timestamp2->format('d.m.Y - H:i');
				if ($time3 != '0000-00-00 00:00:00') {
					$expiretime = $timestamp3->format('d.m.Y - H:i');
				} else {
					$expiretime = '&nbsp;';
				}
				$informant = htmlspecialchars($informant, ENT_QUOTES, _CHARSET);
				if($archive_charlimit == 1 && strlen(trim($topictext)) > ($counttopic != 0 ? $counttopic : '20')) {
					$topictext = substr(trim($topictext),0, ($counttopic != 0 ? $counttopic : '20')) . '...';
				}
				$topictext = htmlspecialchars($topictext, ENT_QUOTES, _CHARSET);
				if($archive_charlimit == 1 && strlen(trim($title)) > ($counttitle != 0 ? $counttitle : '40')) {
					$title = substr(trim($title),0, ($counttitle != 0 ? $counttitle : '40')) . '...';
				}
				$title = htmlspecialchars($title, ENT_QUOTES, _CHARSET);
				if ($slock == 0) {$slockstatus = _TONSTORYLOCKACTIVE;}
				if ($radminarticle == 1 OR $radminsuper == 1) {
					if (($radminarticle == 1) OR ($aid == $said) OR ($radminsuper == 1)) {
						$editdel = '<a href="' . $admin_file . '.php?op=EditStory&amp;sid=' . $sid . '">' . _EDIT . '</a><a href="' . $admin_file . '.php?op=RemoveStory&amp;sid=' . $sid . '">' . _DELETE . '</a>';
					}
				}
				echo '<tr class="archivehover">' , PHP_EOL
				   , '<td class="text-center">' , $sid , '</td>' , PHP_EOL
				   , '<td>' , PHP_EOL
				   , '<div class="tooltip">';
				if ($topicid != '' && $archivetopics == 0) {
					echo '<a href="modules.php?name=News&amp;new_topic=' , $topicid , '">' , $topictext , '</a> - ';
				}
					echo '<a href="modules.php?name=News&amp;file=article&amp;sid=' , $sid , '">' , $title , '</a>' , PHP_EOL;
					hoveritems($editdel, $slockstatus, $informant, $scounter, $alanguage);
				echo '</div>' , PHP_EOL
				   , '</td>' , PHP_EOL
				   , '<td class="text-center">' , PHP_EOL
				   , '<div class="tooltip">' , $postingtime , "\n";
					hoveritems($editdel, $slockstatus, $informant, $scounter, $alanguage);
				echo '</div>' , PHP_EOL
				   , '</td>' , PHP_EOL;
				if ($newssort == 1) {   
				echo '<td class="text-center">' , PHP_EOL
				   , '<div class="tooltip">' , $sortingtime , "\n";
					hoveritems($editdel, $slockstatus, $informant, $scounter, $alanguage);	
				echo '</div>' , PHP_EOL
				   , '</td>' , PHP_EOL;
				}
				echo '<td class="text-center">' , PHP_EOL
				   , '<div class="tooltip">' , $expiretime , "\n";
					hoveritems($editdel, $slockstatus, $informant, $scounter, $alanguage);
				echo '</div>' , PHP_EOL
				   , '</td>' , PHP_EOL
				   , '</tr>' , PHP_EOL;
			}
			headfoot($newssort, $archivetopics);
			echo '</table>' , PHP_EOL;
		}
		CloseTable();
	}

	if (is_active('Surveys')) {
		list($pollID, $pollTitle) = $db->sql_fetchrow($db->sql_query('SELECT `pollID`, `pollTitle` FROM `' . $prefix . '_poll_desc` WHERE `artid`=0 ORDER BY `pollID` DESC LIMIT 1'), SQL_NUM);
		OpenTable();
		echo '<div class="text-center"><span class="thick">' , _CURRENTPOLL , ':</span> ' , htmlspecialchars($pollTitle, ENT_QUOTES, _CHARSET)
			, ' [ <a href="' , $admin_file , '.php?op=polledit&amp;pollID=' , $pollID , '">' , _EDIT , '</a> | <a href="' , $admin_file , '.php?op=create">' , _ADD , '</a> ]</div>';
		CloseTable();
	}

	include_once 'footer.php';
}

/**
* Create first admin and user
*/
function create_first() {
	global $admin_file, $db, $nuke_config, $prefix, $user_prefix;

	$first = $db->sql_numrows($db->sql_query('SELECT * FROM ' . $prefix . '_authors'));
	if (!$first) {
		if (!empty($_POST['op']) && $_POST['op'] == 'create_first') {
			$name = isset($_POST['name']) ? check_html($_POST['name'], 'nohtml') : '';
			$url = isset($_POST['url']) ? check_html($_POST['url'], 'nohtml') : '';
			$email = isset($_POST['email']) ? check_html($_POST['email'], 'nohtml') : '';
			$pwd = isset($_POST['pwd']) ? check_html($_POST['pwd'], 'nohtml') : '';
			$user_new = isset($_POST['user_new']) ? (int) $_POST['user_new'] : 0;

			if (empty($pwd) || empty($name)) {
				header('Location: ' . $admin_file . '.php');
				die();
			}
			if ($url == 'http://') $url = '';
			$aid_name = 'God';
			$pwd = md5($pwd);
			$email = validate_mail($email);
			$db->sql_query('INSERT INTO `' . $prefix . '_authors` VALUES ("' . addslashes($name) . '", "' . $aid_name . '", "' . addslashes($url) . '", "' . addslashes($email) . '", "' . addslashes($pwd) . '", "0", "1", "")');

			if ($user_new == 1) {
				$user_regdate = date('M d, Y');
				$user_avatar = 'gallery/blank.gif';
				$commentlimit = 4096;
				$db->sql_query('INSERT INTO `' . $user_prefix . '_users`'
					. ' (user_id, username, user_email, user_website, user_avatar, user_regdate, user_password, theme, commentmax, user_level, user_lang, user_dateformat) '
					. 'VALUES (NULL, "' . addslashes($name) . '", "' . addslashes($email) . '", "' . addslashes($url) . '", "' . addslashes($user_avatar) . '", "' . addslashes($user_regdate) . '",'
					. '"' . addslashes($pwd) . '", "' . $nuke_config['Default_Theme'] . '", "' . $commentlimit . '", "2", "english", "D M d, Y g:i a")');
			}
			login();
		} else {
			include_once 'header.php';
			title($nuke_config['sitename'] . ': ' . _ADMINISTRATION);
			OpenTable();
			echo '<div class="text-center thick">' , _NOADMINYET , '</div><br />'
				, '<form action="' , $admin_file , '.php" method="post">'
				, '<table style="border-style: none;">'
				, '<tr><td><label for="name">' , _NICKNAME , ':</label></td><td><input type="text" id="name" name="name" size="30" maxlength="25" /></td></tr>'
				, '<tr><td><label for="url">' , _HOMEPAGE , ':</label></td><td><input type="text" id="url" name="url" size="30" maxlength="255" value="http://" /></td></tr>'
				, '<tr><td><label for="email">' , _EMAIL , ':</label></td><td><input type="text" id="email" name="email" size="30" maxlength="255" /></td></tr>'
				, '<tr><td><label for="pwd">' , _PASSWORD , ':</label></td><td><input type="password" id="pwd" name="pwd" size="11" maxlength="40" /></td></tr>'
				, '<tr><td colspan="2"><label for="user_new_yes">' , _CREATEUSERDATA , ' </label>'
				, '<input type="radio" id="user_new_yes" name="user_new" value="1" checked="checked" />', _YES , '&nbsp;&nbsp;'
				, '<input type="radio" id="user_new_no" name="user_new" value="0" />' , _NO , '</td></tr>'
				, '<tr><td><input type="hidden" name="op" value="create_first" />'
				, '<input class="button1" type="submit" value="' , _SUBMIT , '" />'
				, '</td></tr></table></form>';
			CloseTable();
			include_once 'footer.php';
			die();
		}
	}
}

?>