<?php
/**
 * @PHP-NUKE: Web Portal System
 * @package Tricked Out News
 * @version 2.6 (RN News-Mod)
 * @file: catagories.php (admin)
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

function AddCategory() {
	global $admin_file;
	include_once 'header.php';
	GraphicAdmin();
	OpenTable();
	echo '<div class="text-center title">' , _CATEGORIESADMIN , '<br /><br />' , PHP_EOL
	   , '	<div class="option"><span class="thick">' , _CATEGORYADD , '</span><br /><br />' , PHP_EOL
	   , '	<form action="' , $admin_file , '.php" method="post">' , PHP_EOL
	   , '		<span class="thick">' , _CATNAME , ': </span>' , PHP_EOL
	   , '		<input type="text" name="ctitle" size="22" maxlength="20" /> ' , PHP_EOL
	   , '		<input type="hidden" name="op" value="SaveCategory" />' , PHP_EOL
	   , '		<input type="submit" value="' , _SAVE , '" />' , PHP_EOL
	   , '	</form>' , PHP_EOL
	   , '	</div>' , PHP_EOL
	   , '</div>' , PHP_EOL;
	CloseTable();
	include_once 'footer.php';
}

function EditCategory($catid) {
	global $prefix, $db, $admin_file;
	$catid = intval($catid);
	$result = $db->sql_query('SELECT `title` FROM `' . $prefix . '_stories_cat` WHERE `catid` = \'' . $catid . '\'');
	list($ctitle) = $db->sql_fetchrow($result);
	include_once 'header.php';
	GraphicAdmin();
	OpenTable();
	echo '<div class="text-center title">' , _CATEGORIESADMIN , '<br /><br />' , PHP_EOL
	   , '<div class="option"><span class="thick">' , _EDITCATEGORY , '</span><br />' , PHP_EOL;
	if ($catid==0) {
		$selcat = $db->sql_query('SELECT `catid`, `title` FROM `' . $prefix . '_stories_cat` WHERE `catid` > 0');
		echo '<form action="' , $admin_file , '.php" method="post">' , PHP_EOL
		   , '<span class="thick">' , _ASELECTCATEGORY , '</span> ' , PHP_EOL
		   , '<select name="catid">' , PHP_EOL;
		while(list($catid, $ctitle) = $db->sql_fetchrow($selcat)) {
			echo '	<option value="' , $catid , '">' , htmlspecialchars($ctitle, ENT_QUOTES, _CHARSET) , '</option>' , PHP_EOL;
		}
		echo '</select>' , PHP_EOL
		   , '<input type="hidden" name="op" value="EditCategory" />' , PHP_EOL
		   , '<input type="submit" value="' , _EDIT , '" /><br /><br />' , PHP_EOL
		   , '<span class="option">(' , _NOARTCATEDIT , ')</span>' , PHP_EOL;
	} else {
		echo '<form action="' , $admin_file , '.php" method="post">' , PHP_EOL
		   , '	<span class="title">' , _CATEGORYNAME , ':</span> ' , PHP_EOL
		   , '	<input type="text" name="ctitle" size="22" maxlength="20" value="' , htmlspecialchars($ctitle, ENT_QUOTES, _CHARSET) , '" /> ' , PHP_EOL
		   , '	<input type="hidden" name="catid" value="' , $catid , '" />' , PHP_EOL
		   , '	<input type="hidden" name="op" value="SaveEditCategory" />' , PHP_EOL
		   , '	<input type="submit" value="' , _SAVECHANGES , '" /><br /><br />' , PHP_EOL
		   , '<span class="option">(' , _NOARTCATEDIT , ')</span>' , PHP_EOL;
	}
	echo '</form>' , PHP_EOL
	   , '</div>' , PHP_EOL
	   , '</div>' , PHP_EOL;
	CloseTable();
	include_once 'footer.php';
}

function DelCategory($cat) {
	global $prefix, $db, $admin_file;
	$result = $db->sql_query('SELECT `title` FROM `' . $prefix . '_stories_cat` WHERE `catid` = \'' . $cat . '\'');
	list($ctitle) = $db->sql_fetchrow($result);
	include_once 'header.php';
	GraphicAdmin();
	OpenTable();
	echo '<div class="text-center"><span class="title">' , _CATEGORIESADMIN , '</span>' , PHP_EOL
	   , '<br /><br />' , PHP_EOL
	   , '<span class="option thick">' , _DELETECATEGORY , '</span>' , PHP_EOL
	   , '<br /><br />' , PHP_EOL;
	if (!$cat) {
		$selcat = $db->sql_query('SELECT `catid`, `title` FROM `' . $prefix . '_stories_cat`');
		echo '<form action="' , $admin_file , '.php" method="post">' , PHP_EOL
			   , '<span class="thick">' , _SELECTCATDEL , ': </span>' , PHP_EOL
			   , '<select name="cat">';
		while(list($catid, $ctitle) = $db->sql_fetchrow($selcat)) {
			echo '	<option value="' , $catid , '">' , htmlspecialchars($ctitle, ENT_QUOTES, _CHARSET) , '</option>' , PHP_EOL;
		}
			echo '</select>' , PHP_EOL
			   , '<input type="hidden" name="op" value="DelCategory" />' , PHP_EOL
			   , '<input type="submit" value="Delete" />' , PHP_EOL
			   , '</form>' , PHP_EOL;
	} else {
		csrf_check();
		$result2 = $db->sql_query('SELECT * FROM `' . $prefix . '_stories` WHERE `catid` = \'' . $cat . '\'');
		$numrows = $db->sql_numrows($result2);
		if ($numrows == 0) {
			$db->sql_query('DELETE FROM `' . $prefix . '_stories_cat` WHERE `catid` = \'' . $cat . '\'');
			echo '<br /><br />' , PHP_EOL
			   , _CATDELETED
			   , '<br /><br />' , PHP_EOL
			   , '[ <a href="' , $admin_file , '.php?op=adminStory">' , _GOTOADMIN , '</a> ]' , PHP_EOL;
		} else {
			echo '<br /><br />' , PHP_EOL
			   , '<span class="thick">' , _WARNING , ':</span> ' , _THECATEGORY , ' <span class="thick">' , htmlspecialchars($ctitle, ENT_QUOTES, _CHARSET) , '</span> ' , _HAS , ' <span class="thick">' , $numrows , '</span> ' , _STORIESINSIDE , '<br />'
			   , _DELCATWARNING1 , '<br />' , PHP_EOL
			   , _DELCATWARNING2 , '<br /><br />' , PHP_EOL
			   , _DELCATWARNING3 , '<br /><br />' , PHP_EOL
			   , '<span class="thick">[ <a class="rn_csrf" href="' , $admin_file , '.php?op=YesDelCategory&amp;catid=' , $cat , '">' , _YESDEL , '</a> | ' , PHP_EOL
			   , '<a href="' , $admin_file , '.php?op=NoMoveCategory&amp;catid=' , $cat , '">' , _NOMOVE , '</a> ]</span>' , PHP_EOL;
		}
	}
	echo '</div>' , PHP_EOL;
	CloseTable();
	include_once 'footer.php';
}

function YesDelCategory($catid) {
	global $prefix, $db, $admin_file;
	$db->sql_query('DELETE FROM `' . $prefix . '_stories_cat` WHERE `catid` = \'' . $catid . '\'');
	$result = $db->sql_query('SELECT `sid` FROM `' . $prefix . '_stories` WHERE `catid` = \'' . $catid . '\'');
	while(list($sid) = $db->sql_fetchrow($result)) {
		$db->sql_query('DELETE FROM `' . $prefix . '_stories` WHERE `catid` = \'' . $catid . '\'');
		$db->sql_query('DELETE FROM `' . $prefix . '_comments` WHERE `sid` = \'' . $sid . '\'');
	}
	Header('Location: ' . $admin_file . '.php');
}

function NoMoveCategory($catid, $newcat) {
	global $prefix, $db, $admin_file;
	$result = $db->sql_query('SELECT `title` FROM `' . $prefix . '_stories_cat` WHERE `catid` = \'' . $catid . '\'');
	list($ctitle) = $db->sql_fetchrow($result);
	include_once 'header.php';
	GraphicAdmin();
	OpenTable();
	echo '<div class="text-center title">' , _CATEGORIESADMIN , '</div>' , PHP_EOL
	   , '<div class="text-center option thick">' , _MOVESTORIES , '</div>' , PHP_EOL
	   , '<br /><br />' , PHP_EOL;
	if (!$newcat) {
		echo _ALLSTORIES , ' <span class="thick">' , htmlspecialchars($ctitle, ENT_QUOTES, _CHARSET) , '</span> ' , _WILLBEMOVED , '<br /><br />' , PHP_EOL;
		$selcat = $db->sql_query('SELECT `catid`, `title` FROM `' . $prefix . '_stories_cat`');
		echo '<form action="' , $admin_file , '.php" method="post">' , PHP_EOL
		   , '	<span class="thick">' , _SELECTNEWCAT , ':</span> ' , PHP_EOL
		   , '	<select name="newcat">' , PHP_EOL
		   , '		<option value="0">' , _ARTICLES , '</option>' , PHP_EOL;
		while(list($newcat, $ctitle) = $db->sql_fetchrow($selcat)) {
		echo '		<option value="' , $newcat , '">' , htmlspecialchars($ctitle, ENT_QUOTES, _CHARSET) , '</option>';
		}
		echo '	</select>' , PHP_EOL
		   , '	<input type="hidden" name="catid" value="' , $catid , '" />' , PHP_EOL
		   , '	<input type="hidden" name="op" value="NoMoveCategory" />' , PHP_EOL
		   , '	<input type="submit" value="' , _OK , '" />' , PHP_EOL
		   , '</form>' , PHP_EOL;
	} else {
		csrf_check();
		$resultm = $db->sql_query('SELECT `sid` FROM `' . $prefix . '_stories` WHERE `catid` = \'' . $catid . '\'');
		while(list($sid) = $db->sql_fetchrow($resultm)) {
			$db->sql_query('UPDATE `' . $prefix . '_stories` SET `catid` = \'' . $newcat . '\' WHERE `sid` = \'' . $sid . '\'');
		}
		$db->sql_query('DELETE FROM `' . $prefix . '_stories_cat` WHERE `catid` = \'' . $catid . '\'');
		echo _MOVEDONE;
	}
	CloseTable();
	include_once 'footer.php';
}

function SaveEditCategory($catid, $ctitle) {
	global $prefix, $db, $admin_file;
	$ctitle = $db->sql_escape_string(htmlspecialchars_decode(check_html($ctitle, 'nohtml'), ENT_QUOTES));
	$result = $db->sql_query('SELECT `catid` FROM `' . $prefix . '_stories_cat` WHERE `title` = \'' . $ctitle . '\'');
	if ($db->sql_numrows($result) == 1) {
		$what1 = _CATEXISTS;
		$what2 = _GOBACK;
	} else {
		$what1 = _CATSAVED;
		$what2 = '[ <a href="' . $admin_file . '.php?op=adminStory">' . _GOTOADMIN . '</a> ]';
		$result = $db->sql_query('UPDATE `' . $prefix . '_stories_cat` SET `title` = \'' . $ctitle . '\' WHERE `catid` = \'' . $catid . '\'');
		if (!$result) {
			return;
		}
	}
	include_once 'header.php';
	GraphicAdmin();
	OpenTable();
	echo '<div class="text-center title">' , _CATEGORIESADMIN , '</div>' , PHP_EOL
	   , '<br /><br />' , PHP_EOL
	   , '<div class="text-center content"><span class="thick">' , $what1 , '</span>' , PHP_EOL
	   , '<br /><br />' , PHP_EOL
	   , $what2 , '</div>' , PHP_EOL;
	CloseTable();
	include_once 'footer.php';
}

function SaveCategory($ctitle) {
	global $prefix, $db, $admin_file;
	$ctitle = $db->sql_escape_string(htmlspecialchars_decode(check_html($ctitle, 'nohtml'), ENT_QUOTES));
	$result = $db->sql_query('SELECT `catid` FROM `' . $prefix . '_stories_cat` WHERE `title` = \'' . $ctitle . '\'');
	if ($db->sql_numrows($result) == 1) {
		$what1 = _CATEXISTS;
		$what2 = _GOBACK;
	} else {
		$what1 = _CATADDED;
		$what2 = _GOTOADMIN;
		$result = $db->sql_query('INSERT INTO `' . $prefix . '_stories_cat` VALUES '."(NULL, '$ctitle', 0)");
		if (!$result) {
			return;
		}
	}
	include_once 'header.php';
	GraphicAdmin();
	OpenTable();
	echo '<div class="text-center title">' , _CATEGORIESADMIN , '</div>' , PHP_EOL
	   , '<br /><br />' , PHP_EOL
	   , '<div class="text-center content">' , $what1 , '<br /><br />' , PHP_EOL
	   , '<a href="' , $admin_file , '.php?op=adminStory">' , $what2 , '</a></div>' , PHP_EOL;
	CloseTable();
	include_once 'footer.php';
}

function SelectCategory($cat) {
	global $prefix, $db, $admin_file;
	$sel = '';
	$selcat = $db->sql_query('SELECT `catid`, `title` FROM `' . $prefix . '_stories_cat` ORDER BY `title`');
	echo '<p class="clear-both"><span class="thick">' , _CATEGORY , '</span> ' , PHP_EOL
	   , '<select name="catid">' , PHP_EOL;
	if ($cat == 0 OR empty($cat)) {
		echo '	<option value="0" selected="selected">' , _ARTICLES , '</option>' , PHP_EOL;
	}
	else {
		echo '	<option value="0">' , _ARTICLES , '</option>' , PHP_EOL;
	}
	while(list($catid, $ctitle) = $db->sql_fetchrow($selcat)) {
		$ctitle = htmlspecialchars($ctitle, ENT_QUOTES, _CHARSET);
		if ($catid == $cat) {
			$sel = ' selected="selected"';
		}
		else {
			$sel = '';
		}
		echo '	<option value="' , $catid , '"' , $sel , '>' , $ctitle , '</option>' , PHP_EOL;
	}
	echo '</select>' , PHP_EOL
	   , ' [ <a href="' , $admin_file , '.php?op=AddCategory">' , _ADD , '</a> |'
	   , ' <a href="' , $admin_file , '.php?op=EditCategory">' , _EDIT , '</a> |'
	   , ' <a class="rn_csrf" href="' , $admin_file , '.php?op=DelCategory&amp;cat=' , $catid , '">' , _DELETE , '</a> ]</p>' , PHP_EOL;
}