<?php
/**
 * @PHP-NUKE: Web Portal System
 * @package Tricked Out News
 * @version 2.6 (RN News-Mod)
 * @file: articlebox.php
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
if (!isset($op)) $op = '';
$module_name = basename(dirname(__FILE__));
get_lang($module_name);
if (isset($sid)) { $sid = intval($sid); } else { $sid = ''; }
if (stristr($_SERVER['REQUEST_URI'],'mainfile')) {
	Header('Location: modules.php?name=' . $module_name . '&file=articlebox&sid=' . $sid);
} elseif (empty($sid) && !isset($tid)) {
	Header('Location: ./');
}
$mode = $order = $thold = '';
if (isset($user)) {
	cookiedecode($user);
	if (is_user($user)) {
		getusrinfo($user);
		$mode = strtolower($userinfo['umode']);
		$order = (int)$userinfo['uorder'];
		$thold = (int)$userinfo['thold'];
	}
}
if (empty($mode) || ($mode != 'thread' && $mode != 'nested' && $mode != 'flat' && $mode != 'nocomments')) {
	$mode = 'nested';
}
if (empty($order)) {
	$order = 0;
}
if (empty($thold)) {
	$thold = -1;
}
if ($op == 'Reply') {
	Header('Location: modules.php?name=' . $module_name . '&file=comments&op=Reply&pid=0&sid=' . $sid . $display);
}
function Topics($sid) {
	global $db, $prefix, $topicimage, $topicname, $topictext;
	$sid = intval($sid);
	$result = $db->sql_query('SELECT t.`topicname`, t.`topicimage`, t.`topictext` FROM `' . $prefix . '_stories` s LEFT JOIN `' . $prefix . '_topics` t ON t.`topicid` = s.`topic` WHERE s.`sid` = \'' . $sid . '\'');
	$row = $db->sql_fetchrow($result);
	$topicname = htmlentities(htmlspecialchars_decode(check_html($row['topicname'], 'nohtml'), ENT_QUOTES), ENT_QUOTES, _CHARSET);
	$topicimage = htmlentities(htmlspecialchars_decode(check_html($row['topicimage'], 'nohtml'), ENT_QUOTES), ENT_QUOTES, _CHARSET);
	$topictext = htmlentities(html_entity_decode(check_html($row['topictext'], 'nohtml'), ENT_QUOTES, _CHARSET), ENT_QUOTES, _CHARSET); 
}
list($usenotes) = $db->sql_fetchrow($db->sql_query('SELECT `usenotes` FROM `' . $prefix . '_ton`'));
if (is_admin($admin)) {
	$storylock = '';
} else {
	$storylock = '`slock` = 0 AND';
}
$result = $db->sql_query('SELECT `catid`, `aid`, `time`, `title`, `hometext`, `bodytext`, `topic`, `informant`, `notes`, `acomm`, `haspoll`, `pollID`, `score`, `ratings`, `associated` FROM `' . $prefix . '_stories` s WHERE ' . $storylock . ' `sid` = \'' . $sid . '\'');

$numrows = $db->sql_numrows($result);
if ($numrows!=1) {
	Header('Location: ./');
	exit();
}
$row = $db->sql_fetchrow($result);
$catid = $row['catid'];
$aaid = htmlentities(htmlspecialchars_decode(check_html($row['aid'], 'nohtml'), ENT_QUOTES), ENT_QUOTES, _CHARSET); 
$time = $row['time'];
$title = htmlentities(htmlspecialchars_decode(check_html($row['title'], 'nohtml'), ENT_QUOTES), ENT_QUOTES, _CHARSET); 
$hometext = $row['hometext'];
$bodytext = $row['bodytext'];
$topic = $row['topic'];
$informant = htmlentities(htmlspecialchars_decode(check_html($row['informant'], 'nohtml'), ENT_QUOTES), ENT_QUOTES, _CHARSET);
if ($usenotes == 1) {
	$notes = $row['notes'];
} else {
	$notes = '';
}
$acomm = $row['acomm'];
$haspoll = $row['haspoll'];
$pollID = $row['pollID'];
$score = $row['score'];
$ratings = $row['ratings'];
$associated = check_html($row['associated']);
Topics($sid);
# nukeSEO Social Bookmarking added Tricked Out News
//require_once('includes/nukeSEO_SB.php');
global $nukeurl, $subject;
$subject = htmlentities(htmlspecialchars_decode(check_html($subject, 'nohtml'), ENT_QUOTES), ENT_QUOTES, _CHARSET);
//$articleurl = $nukeurl . '/modules.php?name=News&file=article&sid=' . $sid;
//$articletitle = $title;
//$socialbookmarkHTML = getBookmarkHTML($articleurl, $articletitle, '&nbsp;', 'small');
# nukeSEO Social Bookmarking
if (!is_admin($admin)) {
	$db->sql_query('UPDATE `' . $prefix . '_stories` SET `counter` = counter+1 WHERE `sid` = ' . $sid);
}
$artpage = 1;
$pagetitle = '- ' . $title;
$artpage = 0;
//echo $datetime;
formatTimestamp($time);
/* montego - unfortunately, FB wrote articles.php differently than index.php.  In index.php, no he relies
	on the theme to format each article, which is the right way of doing it. Then, for some reason, in
	article.php, he does it differently.  This wreaks havoc with HTML/XHTML compliance. I see that most of
	the core PHP-Nuke themes do formatting in both themeindex() and themearticle(), therefore, I think it
	best to do this the right way, and remove it from here.  Yes, it could break some themes, but if we
	want to be compliant... we'll just have to help folks out.  We will pass $notes as we should.

if (!empty($notes)) {
	 $notes = '<br /><br /><span class="thick">'._NOTE.'</span> <span class="italic">'.$notes.'</span>';
} else {
	 $notes = '';
}
*/
if(empty($bodytext)) {
	 $bodytext = $hometext;
} else {
	 $bodytext = $hometext . $bodytext;
}
if (!empty($notes)) {
$bodytext = $bodytext . '<span class="thick">' . _NOTE . '</span><br />' . $notes;
}
if(empty($informant)) {
	 $informant = $anonymous;
}
//getTopics($sid);
if ($catid != 0) {
	 $row2 = $db->sql_fetchrow($db->sql_query('SELECT `title` FROM `' . $prefix . '_stories_cat` WHERE `catid` = \'' . $catid . '\''));
	 $title1 = htmlentities(htmlspecialchars_decode(check_html($row2['title'], 'nohtml'), ENT_QUOTES), ENT_QUOTES, _CHARSET); 
	 $title = '<a href="modules.php?name=' . $module_name . '&amp;file=categories&amp;op=newindex&amp;catid=' . $catid . '"><span class="storycat">' . $title1 . '</span></a>: ' . $title;
}
//echo '<div style="width:100%; vertical-align:top;">' . PHP_EOL;
if (is_admin($admin)) {
echo '<div class="text-center centered"><span class="thick">' , _ADMIN , '</span><br />[ <a href="' , $admin_file , '.php?op=adminStory">' , _ADD , '</a> | <a href="' , $admin_file , '.php?op=EditStory&amp;sid=' , $sid , '">' , _EDIT , '</a> | <a href="' , $admin_file , '.php?op=RemoveStory&amp;sid=' , $sid , '">' , _DELETE , '</a> ]</div><br />';
}
//echo '</div>' . PHP_EOL;
themearticle($aaid, $informant, $datetime, $title, $bodytext, $topic, $topicname, $topicimage, $topictext, $subject, $notes);
global $multilingual, $currentlang, $admin_file, $user;
if ($multilingual == 1) {
	 $querylang = 'AND (`alanguage` = \'' . $currentlang . '\' OR `alanguage` = \'\')'; /* the OR is needed to display stories who are posted to ALL languages */
} else {
	 $querylang = '';
}
$row9 = $db->sql_fetchrow($db->sql_query('SELECT `sid`, `title` FROM `' . $prefix . '_stories` WHERE `topic` = \'' . $topic . '\' ' . $querylang . ' ORDER BY `counter` DESC LIMIT 0,1'));
$topstory = $row9['sid'];
$ttitle = htmlentities(htmlspecialchars_decode(check_html($row9['title'], 'nohtml'), ENT_QUOTES), ENT_QUOTES, _CHARSET);

if ($multilingual == 1) {
	 $querylang = 'AND (`blanguage` = \'' . $currentlang . '\' OR `blanguage` = \'\')';
} else {
	 $querylang = '';
}
cookiedecode($user);
//RN0000453 - montego - unnecessary include and SQL call
if (!empty($associated)) {
	 OpenTable();
	 echo '<div class="text-center centered"><p class="thick">' , _ASSOTOPIC , '</p>';
	 $asso_t = explode('-',$associated);
	 for ($i=0; $i<sizeof($asso_t); $i++) {
		  if (!empty($asso_t[$i])) {
				$row10 = $db->sql_query('SELECT `topicimage`, `topictext` FROM `' . $prefix . '_topics` WHERE `topicid` = \'' . (int)$asso_t[$i] . '\'');
				list($topicimage, $topictext) = $db->sql_fetchrow($row10);
				$topicimage = htmlentities(htmlspecialchars_decode(check_html($topicimage, 'nohtml'), ENT_QUOTES), ENT_QUOTES, _CHARSET);
				if (_CHARSET == 'UTF-8') {
					$topictext = htmlspecialchars(htmlspecialchars_decode(check_html($topictext, 'nohtml'), ENT_QUOTES), ENT_QUOTES, _CHARSET);				
				} else {
					$topictext = htmlentities(htmlspecialchars_decode(check_html($topictext, 'nohtml'), ENT_QUOTES), ENT_QUOTES, _CHARSET);
				}
				echo '<a href="modules.php?name=' , $module_name , '&amp;new_topic=' , (int)$asso_t[$i] , '"><img src="' , $tipath , $topicimage , '" border="0" hspace="10" alt="' , $topictext , '" title="' , $topictext , '" /></a>';
		  }
	 }
	 echo '</div>';
	 CloseTable();
}