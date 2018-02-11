<?php
/**
 * @PHP-NUKE: Web Portal System
 * @package Tricked Out News
 * @version 2.6 (RN News-Mod)
 * @file: index.php (Submit News)
 * @copyright (c) 2002 by Francisco Burzi
 * @Additional security & Abstraction layer conversion 2003 chatserv http://www.nukeresources.com
 * @nukeWYSIWYG Copyright (c) 2005 Kevin Guske http://nukeseo.com
 * @kses developed by Ulf Harnhammar http://kses.sf.net
 * @RavenNuke(tm) Support:
 * 2012 - Nuken http://www.trickedoutnews.com
 * 2012 - rework of all admin functions by Ron Holzhey (neralex)
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

if (!defined('MODULE_FILE')) {die('You can\'t access this file directly...');}

//$module_name = basename(dirname(__FILE__));
$module_name = 'News';
global $db, $prefix, $currentlang;
$modCssFile = 'themes/' . $ThemeSel . '/style/NewsAdmin.css';
if (file_exists($modCssFile)) {
	define('RN_MODULE_CSS', 'NewsAdmin.css');
}

	if (!isset($sid)) $sid = '';
	if (!isset($op)) $op = '';
	if (!isset($catid)) $catid = '';
	if (!isset($newcat)) $newcat = '';
	if (!isset($ctitle)) $ctitle = '';
	if (!isset($alanguage)) $alanguage = '';
	if (!isset($pollTitle)) $pollTitle = '';
	if (!isset($optionText)) $optionText = '';
	if (!isset($assotop)) $assotop = '';
	if (!isset($status)) $status = '';
	if (!isset($year)) $year = '';
	if (!isset($month)) $month = '';
	if (!isset($day)) $day = '';
	if (!isset($hour)) $hour = '';
	if (!isset($min)) $min = '';
	if (!isset($ihome)) $ihome = '';
	if (!isset($acomm)) $acomm = '';
	if (!isset($automated)) $automated = '';
	if (!isset($automated2)) $automated2 = '';
	if (!isset($year)) $year = '';
	if (!isset($month)) $month = '';
	if (!isset($day)) $day = '';
	if (!isset($hour)) $hour = '';
	if (!isset($min)) $min = '';
	if (!isset($sec)) $sec = '';
	if (!isset($yearselect)) $yearselect = '';
	if (!isset($monthselect)) $monthselect = '';
	if (!isset($dayselect)) $dayselect = '';
	if (!isset($hourselect)) $hourselect = '';
	if (!isset($minselect)) $minselect = '';
	if (!isset($secselect)) $secselect = '';
	if (!isset($yearexpire)) $yearexpire = '';
	if (!isset($monthexpire)) $monthexpire = '';
	if (!isset($dayexpire)) $dayexpire = '';
	if (!isset($hourexpire)) $hourexpire = '';
	if (!isset($minexpire)) $minexpire = '';

	require_once 'modules/' . $module_name . '/admin/language/lang-' . $currentlang . '.php';
	require_once 'modules/' . $module_name . '/admin/post.php';

	switch($op) {

		default:
		adminStory($sid);
		break;

		case 'PreviewAdminStory':
		previewAdminStory($automated, $automated2, $year, $day, $month, $hour, $min, $subject, $hometext, $bodytext, $tags, $topic, $catid, $ihome, $alanguage, $acomm, $pollTitle, $optionText, $assotop, $yearselect, $monthselect, $dayselect, $hourselect, $minselect, $secselect, $yearexpire, $monthexpire, $dayexpire, $hourexpire, $minexpire, $slock);
		break;

		case 'PostAdminStory':
		csrf_check();
		postAdminStory($automated, $automated2, $year, $day, $month, $hour, $min, $subject, $hometext, $bodytext, $tags, $topic, $catid, $ihome, $alanguage, $acomm, $pollTitle, $optionText, $assotop, $yearselect, $monthselect, $dayselect, $hourselect, $minselect, $secselect, $yearexpire, $monthexpire, $dayexpire, $hourexpire, $minexpire, $slock);
		break;

	}
