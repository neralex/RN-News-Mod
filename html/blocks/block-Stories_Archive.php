<?php
/**
 * @PHP-NUKE: Web Portal System
 * @package Tricked Out News
 * @version 2.6 (RN News-Mod)
 * @file: block-Stories_Archive.php
 * @copyright (c) 2002 by Francisco Burzi
 * @Additional security & Abstraction layer conversion 2003 chatserv http://www.nukeresources.com
 * @nukeWYSIWYG Copyright (c) 2005 Kevin Guske http://nukeseo.com
 * @kses developed by Ulf Harnhammar http://kses.sf.net
 * @RavenNuke(tm) Support:
 * 2012 - Nuken http://www.trickedoutnews.com
 * 2013 - rework of all functions by neralex http://www.media.soefm.de
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
if ( !defined('BLOCK_FILE') ) {Header('Location: ../index.php'); die();}
	global $prefix, $db, $content;
	$module_name = 'Stories_Archive';
	$tonquery = $db->sql_query('SELECT `newssort`, `newsorder` FROM `' . $prefix . '_ton`');
	list($newssort, $newsorder) = $db->sql_fetchrow($tonquery);
	if ($newsorder == 1) {
		$newsordertype = 'ASC';
	} elseif ($newsorder == 0) {
		$newsordertype = 'DESC';
	}	
	if ($newssort == 1) {
		$newssorting = 'ORDER BY `time2` ' . $newsordertype . ', `time` ' . $newsordertype;
	} elseif ($newssort == 0) {
		$newssorting = 'ORDER BY `time` ' . $newsordertype;
	}		
	$result = $db->sql_query('SELECT `time`, `time2` FROM `' . $prefix . '_stories` WHERE `slock` = 0 ' . $newssorting . '');
	$thismonth = '';
	$content = '<br />';

    while(list($time, $time2) = $db->sql_fetchrow($result)) {
    preg_match ('([0-9]{4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})', ($newssort == 1 ? $time2 : $time), $getdate);
    if ($getdate[2] == '01') { $month = _JANUARY; } elseif ($getdate[2] == '02') { $month = _FEBRUARY; } elseif ($getdate[2] == '03') { $month = _MARCH; } elseif ($getdate[2] == '04') { $month = _APRIL; } elseif ($getdate[2] == '05') { $month = _MAY; } elseif ($getdate[2] == '06') { $month = _JUNE; } elseif ($getdate[2] == '07') { $month = _JULY; } elseif ($getdate[2] == '08') { $month = _AUGUST; } elseif ($getdate[2] == '09') { $month = _SEPTEMBER; } elseif ($getdate[2] == '10') { $month = _OCTOBER; } elseif ($getdate[2] == '11') { $month = _NOVEMBER; } elseif ($getdate[2] == '12') { $month = _DECEMBER; }
    if ($month != $thismonth) {
        $year = $getdate[1];
        $content .= '&rarr;&nbsp;<a href="modules.php?name=' . $module_name . '&amp;sa=show_month&amp;year=' . $year . '&amp;month=' . $getdate[2] . '&amp;month_l=' . $month . '"><span class="thick">' . $month . '</span>, ' . $year . '</a><br />';
        $thismonth = $month;
    }
    }
$content .= '<br />';