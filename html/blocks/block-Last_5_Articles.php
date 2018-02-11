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
/************************************************************************/
/*         Additional security & Abstraction layer conversion           */
/*                           2003 chatserv                              */
/*      http://www.nukefixes.com -- http://www.nukeresources.com        */
/************************************************************************/
/************************************************************************/
/* Additional code clean-up, performance enhancements, and W3C and      */
/* XHTML compliance fixes by Raven and Montego.                         */
/************************************************************************/

if ( !defined('BLOCK_FILE') ) {
	 Header('Location: ../index.php');
	 die();
}

global $prefix, $multilingual, $currentlang, $db;

if ($multilingual == 1) {
	 $querylang = 'WHERE alanguage=\'' . $currentlang . '\'';
} else {
	 $querylang = '';
}
if (!isset($side)) { $side = ''; }
if ($side == 'c' || $side == 'd' || $side == 't') {
	$ListClass = 'ul-box-center';
	addJSToBody('includes/jquery/haslayout.js', 'file');
	} else {
	$ListClass = 'ul-box';
}

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
	$newssorting = 'ORDER BY `sid` ' . $newsordertype;
}

$content = '';
$n = 1;
$sql = 'SELECT `sid`, `title`, `comments`, `counter`, `time`, `time2` FROM `' . $prefix . '_stories` ' . $querylang . ' WHERE `slock` = 0 ' . $newssorting . ' LIMIT 0,5';
$result = $db->sql_query($sql);
$numrows = $db->sql_numrows($result);
if (($numrows > 0 AND $numrows < 5) AND ($multilingual == 1)){
$adjustment = 5 - $numrows;
} else {
$adjustment = 0;
}
if ($numrows == 0 AND $multilingual == 1) {
	$sql = 'SELECT `sid`, `title`, `comments`, `counter`, `time`, `time2` FROM `' . $prefix . '_stories` WHERE `alanguage` = \'\' AND `slock` = 0 ' . $newssorting . ' LIMIT 0,5';
	$result = $db->sql_query($sql);
	$numrows = $db->sql_numrows($result);
}
if ($numrows == 0) {
	$content = _BLOCKPROBLEM2;
	} else {
	 $content .= '<div class="' . $ListClass . ' block-last_5_articles"><ul class="rn-list">';
	 while (list($sid, $title, $comments, $counter) = $db->sql_fetchrow($result)) {
		  $sid = intval($sid);
		  $comtotal = intval($comments);  //RN0000547
		  $counter = intval($counter);
		if ($n > 1 AND $n % 2){$column = ' li-odd';} else if ($n > 1) {$column = ' li-even';} else {$column = ' li-first';}
		  $title = htmlspecialchars($title, ENT_QUOTES, _CHARSET);
		  $content .= '<li class="rn-list' . $column . '"><a href="modules.php?name=News&amp;file=article&amp;sid=' . $sid . '" title="' . $title . '"><span class="thick">' . $title . '</span></a>';
		  $content .= '<ul class="ul-none"><li>' . $comtotal . ' ' . _COMMENTS . '</li><li>' . $counter . ' ' . _READS . '</li></ul>';
		  $content .= '</li>';
		++$n;
	 }
	if ($adjustment > 0){
	$sql = 'SELECT sid, title, comments, counter, time, time2 FROM ' . $prefix . '_stories WHERE alanguage=\'\' AND slock=0 ' . $newssorting . ' LIMIT 0,' . $adjustment;
	$result = $db->sql_query($sql);
		while (list($sid, $title, $comments, $counter) = $db->sql_fetchrow($result)) {
			$sid = intval($sid);
			$comtotal = intval($comments);  //RN0000547
			$counter = intval($counter);
			if ($n > 1 AND $n % 2){$column = ' li-odd';} else if ($n > 1) {$column = ' li-even';} else {$column = ' li-first';}
			$title = htmlspecialchars($title, ENT_QUOTES, _CHARSET);
			$content .= '<li class="rn-list' . $column . '"><a href="modules.php?name=News&amp;file=article&amp;sid=' . $sid . '" title="' . $title . '"><span class="thick">' . $title . '</span></a>';
			$content .= '<ul class="ul-none"><li>' . $comtotal . ' ' . _COMMENTS . '</li><li>' . $counter . ' ' . _READS . '</li></ul>';
			$content .= '</li>';
			++$n;
		}
	}
	if ($n > 1 AND $n % 2){$column = ' li-odd';} else if ($n > 1) {$column = ' li-even';} else {$column = ' li-first';}
	$content .= '<li class="rn-list' . $column . '"><a href="modules.php?name=News" title="' . _MORENEWS . '"><span class="thick">' . _MORENEWS . '</span></a>';
	if (is_active('Topics') || is_active('Stories_Archive')){
		$content .= '<ul class="ul-none ul-mlink">';
		if (is_active('Stories_Archive')) $content .= '<li><a href="modules.php?name=Stories_Archive" title="' . _OLDERARTICLES . '">' . _OLDERARTICLES . '</a></li>';
		if (is_active('Topics')) $content .= '<li><a href="modules.php?name=Topics" title="' . _TOPICS . '">' . _TOPICS . '</a></li>';
		$content .= '</ul>';
	}
	 $content .= '</li></ul></div>';
	// make sure content does not float outside the block
	$content .= '<div class="block-spacer">&nbsp;</div>';
}