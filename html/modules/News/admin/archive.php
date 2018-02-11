<?php
/**
 * @PHP-NUKE: Web Portal System
 * @package Tricked Out News
 * @version 2.6 (RN News-Mod)
 * @file: archive.php (admin)
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

function newsarchive($slocker, $topicsel) {
	global $prefix, $db, $admin_file, $op, $multilingual, $aid, $module_name;
	$tonquery = $db->sql_query('SELECT `newssort`, `newsorder`, `archivedefault`, `archivetopics`, `archive_charlimit`, `counttopic`, `counttitle` FROM `' . $prefix . '_ton`');
	list($newssort, $newsorder, $archivedefault, $archivetopics, $archive_charlimit, $counttopic, $counttitle) = $db->sql_fetchrow($tonquery);
	if ($slocker != '') {
		if ($slocker == '' || !is_numeric($slocker) || $slocker > 3) {
			Header('Location: ' . $admin_file . '.php?op=' . $op);
			exit;
		} elseif (is_numeric($slocker)) {
			$slocknumeric = $slocker;
		}
	} else {
		$slocknumeric = '';
	}
	if ($topicsel) {
		if ($topicsel == '' || !is_numeric($topicsel) || $topicsel == '0') {
			Header('Location: ' . $admin_file . '.php?op=' . $op);
			exit;
		} else {
			$topicnumeric = $topicsel;
		}
	} else {
		$topicnumeric = '';
	}	
	if ($slocknumeric != '' && $topicnumeric == '') {
			$urlextension = '';
			$qryslock = $db->sql_query('SELECT `sid` FROM `' . $prefix . '_stories` WHERE `slock` = ' . $slocknumeric . '');	
			$numslock = $db->sql_numrows($qryslock);
			if ($numslock != 0) {
				$WHERE = 'WHERE s.`slock` = ' . $slocknumeric;
				$path = $admin_file . '.php?op=' . $op . '&amp;slocker=' . $slocknumeric;
			} else {
				Header('Location: ' . $admin_file . '.php?op=' . $op);
				exit();
			}
	} elseif ($slocknumeric == '' && $topicnumeric != '') {
			$urlextension = '&amp;topicsel=' . $topicnumeric;
			$checktopic = $db->sql_query('SELECT `sid` FROM `' . $prefix . '_stories` WHERE `topic` = ' . $topicnumeric . '');
			$numtopic = $db->sql_numrows($checktopic);
			if ($numtopic != 0) {		  
				$WHERE = 'WHERE s.`topic` = ' . $topicnumeric;
				$path = $admin_file . '.php?op=' . $op . '&amp;topicsel=' . $topicnumeric;
			} else {
				Header('Location: ' . $admin_file . '.php?op=' . $op);
				exit();
			}
	} elseif ($slocknumeric != '' && $topicnumeric != '') {
			$urlextension = '&amp;topicsel=' . $topicnumeric;
			$qryboth = $db->sql_query('SELECT s.`sid`, t.`topicid` FROM `' . $prefix . '_stories` s, `' . $prefix . '_topics` t WHERE s.`slock` = ' . $slocknumeric . ' AND s.`topic` = ' . $topicnumeric . '');	
			$numboth = $db->sql_numrows($qryboth);
			if ($numboth != 0) {		  
				$WHERE = 'WHERE  s.`slock` = ' . $slocknumeric . ' AND s.`topic` = ' . $topicnumeric;
				$path = $admin_file . '.php?op=' . $op . '&amp;slocker=' . $slocknumeric . '&amp;topicsel=' . $topicnumeric;
			} else {
				Header('Location: ' . $admin_file . '.php?op=' . $op);
				exit();
			}
	} else {
		$WHERE = '';
		$slocknumeric = '';
		$urlextension = '';
		$path = $admin_file . '.php?op=' . $op;
	}
	if ($topicsel != '') {
		$topiccount = ' AND `topic` = \'' . $topicsel . '\'';
	} else {
		$topiccount = '';
	}	
	$slockres0 = $db->sql_query('SELECT COUNT(*) FROM `' . $prefix . '_stories` WHERE `slock` = 0'. ($topiccount != '' ? $topiccount : '') . '');
	list($slocknum0) = $db->sql_fetchrow($slockres0, SQL_NUM);	
	$slockres1 = $db->sql_query('SELECT COUNT(*) FROM `' . $prefix . '_stories` WHERE `slock` = 1'. ($topiccount != '' ? $topiccount : '') . '');
	list($slocknum1) = $db->sql_fetchrow($slockres1, SQL_NUM);
	$slockres2 = $db->sql_query('SELECT COUNT(*) FROM `' . $prefix . '_stories` WHERE `slock` = 2'. ($topiccount != '' ? $topiccount : '') . '');
	list($slocknum2) = $db->sql_fetchrow($slockres2, SQL_NUM);	
	$slockres3 = $db->sql_query('SELECT COUNT(*) FROM `' . $prefix . '_stories` WHERE `slock` = 3'. ($topiccount != '' ? $topiccount : '') . '');
	list($slocknum3) = $db->sql_fetchrow($slockres3, SQL_NUM);
	function headfoot($newssort, $archivetopics) {
	global $slocknumeric;
		echo '<tr>' , PHP_EOL
		   , '	<td class="text-center">ID</td>' , PHP_EOL
		   , '	<td class="archivetitle">' , ($archivetopics == 0 ? _TOPIC . ' &amp; ' . _TITLE : _TITLE) , '</td>' , PHP_EOL
		   , '	<td class="text-center">';
		if ($slocknumeric == 1) { 
			echo _TONSUBMITTIME , '</td>' , PHP_EOL;
		} elseif ($slocknumeric == 2) { 
			echo _TONAUTOTIME , '</td>' , PHP_EOL;
		} else {
			echo _TONPOSTTIME , '</td>' , PHP_EOL;
		}
		if ($newssort == 1) { 
		echo '	<td class="text-center">' , _TONSORTTIME , '</td>' , PHP_EOL;
		}
		echo '	<td class="text-center">' , _TONEXPTIME , '</td>' , PHP_EOL
		   , '</tr>' , PHP_EOL;
	}
	function hoveritems($editdel, $informant, $counter, $alanguage, $storystatus, $slockstatus) {
		global $multilingual;
		echo '			<div>' , PHP_EOL
		   , '				<p>' , $editdel , '</p>' , PHP_EOL
		   , ($multilingual == 1 && $alanguage != '' ? '				<p>' . _LANGUAGE . ': ' . $alanguage . '</p>' . PHP_EOL : '')
		   , '				<p>' , _TONSTORYLOCK , ': ' , ($storystatus != '' ? $storystatus : $slockstatus) , '</p>' , PHP_EOL
		   , '				<p>' , _TONAUTHOR , ': ' , $informant , '</p>' , PHP_EOL
		   , '				<p>' , _TONREADS , ': ' , $counter , '</p>' , PHP_EOL
		   , '			</div>' , PHP_EOL;
	}
	if ($newsorder == 1) {
		$newsordertype = 'ASC';
	} elseif ($newsorder == 0) {
		$newsordertype = 'DESC';
	}
	if ($newssort == 1) {
		$newssorting = 'ORDER BY s.time2 ' . $newsordertype . ', s.time  ' . $newsordertype;
	} elseif ($newssort == 0) {
		$newssorting = 'ORDER BY s.sid ' . $newsordertype;
	}
	$option = array (5, 20, 50, 100, 200);
	if ($archivedefault == '' || $archivedefault == '0') {
		$default = 20;		 
	} else {
		$default = $archivedefault; // default number of results per page
	}
	$query = 'SELECT s.`sid`, s.`aid`, s.`counter`, s.`title`, s.`time`, s.`time2`, s.`time3`, s.`slock`, s.`topic`, s.`informant`, s.`alanguage`, t.`topicname`, t.`topictext` FROM `' . $prefix . '_stories` s LEFT JOIN `' . $prefix . '_topics` t ON `topicid` = `topic` ' . $WHERE . ' ' . $newssorting;
	$opt_cnt = count($option);
	if (isset($_GET['go'])) {
		$go = $_GET['go'];
	} else {
		$go = '';
	}
	if ($go == '') { 
		$go = $default;
	} elseif (!in_array ($go, $option)) {
		$go = $default;
	} elseif (!is_numeric($go)) {
		$go = $default;
	}
	$nol = $go;
	$limit = '0, ' . $nol;
	$count = 1;
	$off_sql = $db->sql_query('' . $query . '');
	$off_pag = ceil ($db->sql_numrows($off_sql) / $nol);
	if (isset($_GET['offset'])) {
		$off = $_GET['offset'];
	} else {
		$off = '';
	}	
	if (get_magic_quotes_gpc() == 0) {
		$off = addslashes ($off);
	}
	if (!is_numeric($off)) {
		$off = 1;
	}
	if ($off > $off_pag) {
		$off = 1;
	}
	if ($off == '1') {
		$limit = '0, ' . $nol;
	} elseif ($off <> '') {
		for ($i = 0; $i <= ($off - 1) * $nol; $i ++) {
			$limit = $i . ', ' . $nol;
			$count = $i + 1;
		}
	}
	include_once 'header.php';
	GraphicAdmin();
	OpenTable();
	echo '<div align="center" class="archiveswitch">' , PHP_EOL
	   , '	<a href="' , $admin_file , '.php?op=' , $op , '"'
	   , ($slocknumeric == "" ? ' class="switchshadowactive"' : ' class="switchshadow"') , '>archive<br />(start)</a>' , PHP_EOL
	   , '	<a href="' , ($slocknum0 == 0 ? '#' : $admin_file . '.php?op=' . $op . '&amp;slocker=0' . $urlextension . '') , '"'
	   , ($slocknumeric != '' && $slocknumeric == 0 ? ' class="switchshadowactive"' : ' class="switchshadow"') , '>'
	   , _TONSTORYLOCKACTIVE , '<br />(' , ($slocknum0 > 0 ? $slocknum0 : '0') , ')</a>' , PHP_EOL
	   , '	<a href="' , ($slocknum1 == 0 ? '#' : $admin_file . '.php?op=' . $op . '&amp;slocker=1' . $urlextension . '') , '"'
	   , ($slocknumeric == 1 ? ' class="switchshadowactive"' : ' class="switchshadow"') , '>'
	   , _TONSTORYLOCKSUBMIT , '<br />(' , ($slocknum1 > 0 ? $slocknum1 : '0') , ')</a>' , PHP_EOL
	   , '	<a href="' , ($slocknum2 == 0 ? '#' : $admin_file . '.php?op=' . $op . '&amp;slocker=2' . $urlextension . '') , '"'
	   , ($slocknumeric == 2 ? ' class="switchshadowactive"' : ' class="switchshadow"') , '>'
	   , _TONSTORYLOCKTIMED , ' <br />(' , ($slocknum2 > 0 ? $slocknum2 : '0') , ')</a>' , PHP_EOL
	   , '	<a href="' , ($slocknum3 == 0 ? '#' : $admin_file . '.php?op=' . $op . '&amp;slocker=3' . $urlextension . '') , '"'
	   , ($slocknumeric == 3 ? ' class="switchshadowactive"' : ' class="switchshadow"') , '>'
	   , _TONSTORYLOCKFULL , '<br />(' , ($slocknum3 > 0 ? $slocknum3 : '0') , ')</a>' , PHP_EOL
	   , '</div>' , PHP_EOL;
	$qrytopic = $db->sql_query('SELECT t.`topicid`, t.`topicname`, t.`topictext` FROM `' . $prefix . '_topics` t, `' . $prefix . '_stories` s WHERE s.`topic` = t.`topicid` GROUP BY t.`topicid` ORDER BY t.`topictext` ASC');
	$topicnum = $db->sql_numrows($qrytopic);
	if ($topicnum != 0) {
		echo '<div align="center" class="archiveselect">' , PHP_EOL
		   , '<form id="gettopic" name="gettopic" method="get" action="' , $admin_file , '.php?op=' , $op , '">' , PHP_EOL
		   , '<input type="hidden" name="op" value="' , $op , '" />' , PHP_EOL;
		if ($slocknumeric != '') {
			echo '<input type="hidden" name="slocker" value="' , $slocknumeric , '" />' , PHP_EOL;
		}
		echo '<select size="1" name="topicsel" onchange="submit()">' , PHP_EOL
		   , '	<option value="0">' , _ALLTOPICS , '</option>' , PHP_EOL;
		while ($rowtopic = $db->sql_fetchrow($qrytopic)) {
			$topictext = htmlspecialchars($rowtopic['topictext'], ENT_QUOTES, _CHARSET);
			if ($topicsel != '') {
				echo '	<option value="' , $rowtopic['topicid'] , '"' , ($rowtopic['topicid'] == $topicnumeric ? ' selected="selected"' : '') , '>' , $topictext , '</option>';
			} else {
				echo '	<option value="' , $rowtopic['topicid'] , '">' , $topictext , '</option>' , PHP_EOL;
			}
		}
		echo '</select>' , PHP_EOL
		   //, '<input type="submit" value="' , _SEARCH , '" />' , PHP_EOL
		   , '</form>' , PHP_EOL
		   , '</div>' , PHP_EOL;
	}
	$next = 1;
	echo '<div align="center" class="archivenavi">' , PHP_EOL;
	if ($default == 20) {
		echo '	<a href="' , $path , '&amp;offset=' , $next , '&amp;go=' , $default , '"' , ($go == $default ? ' class="borderactive"' : '') , '>' , $default , '</a>' , PHP_EOL
		   , '	<a href="' , $path , '&amp;offset=' , $next , '&amp;go=50"' , ($go == 50 ? ' class="borderactive"' : '') , '>50</a>' , PHP_EOL
		   , '	<a href="' , $path , '&amp;offset=' , $next , '&amp;go=100"' , ($go == 100 ? ' class="borderactive"' : '') , '>100</a>' , PHP_EOL;
	} elseif ($default < 20) {
		echo '	<a href="' , $path , '&amp;offset=' , $next , '&amp;go=' , $default , '"' , ($go == $default ? ' class="borderactive"' : '') , '>' , $default , '</a>' , PHP_EOL
		   , '	<a href="' , $path , '&amp;offset=' , $next , '&amp;go=20"' , ($go == 20 ? ' class="borderactive"' : '') , '>20</a>' , PHP_EOL
		   , '	<a href="' , $path , '&amp;offset=' , $next , '&amp;go=50"' , ($go == 50 ? ' class="borderactive"' : '') , '>50</a>' , PHP_EOL
		   , '	<a href="' , $path , '&amp;offset=' , $next , '&amp;go=100"' , ($go == 100 ? ' class="borderactive"' : '') , '>100</a>' , PHP_EOL;
	} elseif ($default > 20 && $default < 50) {
		echo '	<a href="' , $path , '&amp;offset=' , $next , '&amp;go=20"' , ($go == 20 ? ' class="borderactive"' : '') , '>20</a>' , PHP_EOL
		   , '	<a href="' , $path , '&amp;offset=' , $next , '&amp;go=' , $default , '"' , ($go == $default ? ' class="borderactive"' : '') , '>' , $default , '</a>' , PHP_EOL
		   , '	<a href="' , $path , '&amp;offset=' , $next , '&amp;go=50"' , ($go == 50 ? ' class="borderactive"' : '') , '>50</a>' , PHP_EOL
		   , '	<a href="' , $path , '&amp;offset=' , $next , '&amp;go=100"' , ($go == 100 ? ' class="borderactive"' : '') , '>100</a>' , PHP_EOL;
	} elseif ($default == 50) {
		echo '	<a href="' , $path , '&amp;offset=' , $next , '&amp;go=20"' , ($go == 20 ? ' class="borderactive"' : '') , '>20</a>' , PHP_EOL
		   , '	<a href="' , $path , '&amp;offset=' , $next , '&amp;go=' , $default , '"' , ($go == $default ? ' class="borderactive"' : '') , '>' , $default , '</a>' , PHP_EOL
		   , '	<a href="' , $path , '&amp;offset=' , $next , '&amp;go=100"' , ($go == 100 ? ' class="borderactive"' : '') , '>100</a>' , PHP_EOL;
	} elseif ($default > 50 && $default < 100) {
		echo '	<a href="' , $path , '&amp;offset=' , $next , '&amp;go=20"' , ($go == 20 ? ' class="borderactive"' : '') , '>20</a>' , PHP_EOL
		   , '	<a href="' , $path , '&amp;offset=' , $next , '&amp;go=50"' , ($go == 50 ? ' class="borderactive"' : '') , '>50</a>' , PHP_EOL
		   , '	<a href="' , $path , '&amp;offset=' , $next , '&amp;go=' , $default , '"' , ($go == $default ? ' class="borderactive"' : '') , '>' , $default , '</a>' , PHP_EOL
		   , '	<a href="' , $path , '&amp;offset=' , $next , '&amp;go=100"' , ($go == 100 ? ' class="borderactive"' : '') , '>100</a>' , PHP_EOL;
	} elseif ($default == 100) {
		echo '	<a href="' , $path , '&amp;offset=' , $next , '&amp;go=20"' , ($go == 20 ? ' class="borderactive"' : '') , '>20</a>' , PHP_EOL
		   , '	<a href="' , $path , '&amp;offset=' , $next , '&amp;go=50"' , ($go == 50 ? ' class="borderactive"' : '') , '>50</a>' , PHP_EOL
		   , '	<a href="' , $path , '&amp;offset=' , $next , '&amp;go=' , $default , '"' , ($go == $default ? ' class="borderactive"' : '') , '>' , $default , '</a>' , PHP_EOL;
	} elseif ($default > 100) {
		echo '	<a href="' , $path , '&amp;offset=' , $next , '&amp;go=20"' , ($go == 20 ? ' class="borderactive"' : '') , '>20</a>' , PHP_EOL
		   , '	<a href="' , $path , '&amp;offset=' , $next , '&amp;go=50"' , ($go == 50 ? ' class="borderactive"' : '') , '>50</a>' , PHP_EOL
		   , '	<a href="' , $path , '&amp;offset=' , $next , '&amp;go=100"' , ($go == 100 ? ' class="borderactive"' : '') , '>100</a>' , PHP_EOL
		   , '	<a href="' , $path , '&amp;offset=' , $next , '&amp;go=' , $default , '"' , ($go == $default ? ' class="borderactive"' : '') , '>' , $default , '</a>' , PHP_EOL;
	}
	echo '</div>' , PHP_EOL;
	echo '<table border="0" cellpadding="0" cellspacing="0" class="archivelist centered">' , PHP_EOL;
	headfoot($newssort, $archivetopics);
	$sql = $db->sql_query('' . $query . ' LIMIT ' . $limit . '');
	while ($row = $db->sql_fetchrow($sql)) {
		$sid = $row['sid'];
		$said = htmlspecialchars($row['aid'], ENT_QUOTES, _CHARSET);
		$timestamp1 = new DateTime($row['time']);
		$timestamp2 = new DateTime($row['time2']);
		$timestamp3 = new DateTime($row['time3']);	
		$postingtime = $timestamp1->format('d.m.Y - H:i');
		$sortingtime = $timestamp2->format('d.m.Y - H:i');
		if ($row['time3'] != '0000-00-00 00:00:00') {
			$expiretime = $timestamp3->format('d.m.Y - H:i');
		} else {
			$expiretime = '&nbsp;';
		}
		if($archive_charlimit == 1 && strlen(trim($row['title'])) > ($counttitle != 0 ? $counttitle : '40')) {
			$row['title'] = substr(trim($row['title']),0, ($counttitle != 0 ? $counttitle : '40')) . '...';
		}		
		if($archive_charlimit == 1 && strlen(trim($row['topicname'])) >  ($counttopic != 0 ? $counttopic : '20')) {
			$row['topicname'] = substr(trim($row['topicname']),0, ($counttopic != 0 ? $counttopic : '20')) . '...';
		}		
		if($archive_charlimit == 1 && strlen(trim($row['topictext'])) >  ($counttopic != 0 ? $counttopic : '20')) {
			$row['topictext'] = substr(trim($row['topictext']),0, ($counttopic != 0 ? $counttopic : '20')) . '...';
		}
		$title = htmlspecialchars($row['title'], ENT_QUOTES, _CHARSET);
		$topicname = htmlspecialchars($row['topicname'], ENT_QUOTES, _CHARSET);	
		$topictext = htmlspecialchars($row['topictext'], ENT_QUOTES, _CHARSET);
		$informant = htmlspecialchars($row['informant'], ENT_QUOTES, _CHARSET);
		$topicid = $row['topic'];
		$counter = $row['counter'];
		$slock1 = $row['slock'];
		$alanguage = $row['alanguage'];
		if ($slock1 == 0) {$slockstatus = _TONSTORYLOCKACTIVE;}
		elseif ($slock1 == 1) {$slockstatus = _TONSTORYLOCKSUBMIT;}
		elseif ($slock1 == 2) {$slockstatus = _TONSTORYLOCKTIMED;} 
		elseif ($slock1 == 3) {$slockstatus = _TONSTORYLOCKFULL;}
		if ($aid == $said || is_mod_admin('admin')) {
			$editdel  = '<a href="' . $admin_file . '.php?op=EditStory&amp;sid=' . $sid . '">' . _EDIT . '</a>';
			$editdel .= '<a href="' . $admin_file . '.php?op=RemoveStory&amp;archive=1' . ($topicsel != '' ? '&amp;topicsel=' . $topicsel : '') . '&amp;sid=' . $sid . '">' . _DELETE . '</a>';
			$storystatus = '';
			if (($slock1 == 0 || $slock1 == 3) && $row['time3'] == '0000-00-00 00:00:00') {
				$storystatus  = '<a class="rn_csrf" href="' . $admin_file . '.php?op=StoryStatus' . ($topicsel != '' ? '&amp;topicsel=' . $topicsel : '') . ($off != 1 ? '&amp;offset=' . $off : '') . ($go != $default ? '&amp;go=' . $go : '') . '&amp;sid=' . $sid . '">' . $slockstatus . '</a>';
			}
		}
		echo '<tr class="archivehover">' , PHP_EOL
		   , '	<td class="text-center">' , $sid , '</td>' , PHP_EOL
		   , '	<td>' , PHP_EOL
		   , '		<div class="tooltip">';
		if ($topicid != '0' && $archivetopics == 0) {
			echo '<a href="modules.php?name=News&amp;new_topic=' , $topicid , '">' , $topictext , '</a> - ';
		}
			echo '<a href="modules.php?name=News&amp;file=article&amp;sid=' , $sid , '">' , ($title != '' ? $title : '&nbsp;') , '</a>' , PHP_EOL;
					hoveritems($editdel, $informant, $counter, $alanguage, $storystatus, $slockstatus);
		echo '		</div>' , PHP_EOL
		   , '	</td>' , PHP_EOL
		   , '	<td class="text-center">' , PHP_EOL
		   , '		<div class="tooltip">' , $postingtime , '</div>' , PHP_EOL
		   , '	</td>' , PHP_EOL;
		if ($newssort == 1) {
		echo '	<td class="text-center">' , PHP_EOL
		   , '		<div class="tooltip">' , $sortingtime , '</div>' , PHP_EOL
		   , '	</td>' , PHP_EOL;
		}
		echo '	<td class="text-center">' , PHP_EOL
		   , '		<div class="tooltip">' , $expiretime , '</div>' , PHP_EOL
		   , '	</td>' , PHP_EOL
		   , '</tr>' , PHP_EOL; 
		$count += 1;
	}
	headfoot($newssort, $archivetopics);
	echo '</table>' , PHP_EOL;
	echo '<div align="center" class="archivepager">' , PHP_EOL;
	if ($off <> 1) {
		$prev = $off - 1;
		echo '<a href="' , $path , '&amp;offset=' , $prev , '&amp;go=' , $go , '">&lt;</a>' , PHP_EOL;
	}
	if ($off_pag <= 9) {
		for ($i = 1; $i <= $off_pag; $i ++) {
			if ($i == $off) {
				echo '<span>' , $i , '</span>' , PHP_EOL;
			} else {
				echo '<a href="' , $path , '&amp;offset=' , $i , '&amp;go=' , $go , '">' , $i , '</a>' , PHP_EOL;
			}
		}
	} else {
		if ($off <=5) {
			for ($i = 1; $i <= 6; $i ++) {
				if ($i == $off) {
					echo '<span>' , $i , '</span>' , PHP_EOL;
				} else {
					echo '<a href="' , $path , '&amp;offset=' , $i , '&amp;go=' , $go , '">' , $i , '</a>' , PHP_EOL;
				}
		  	}
			echo ' ... ';
			for ($i = $off_pag -2; $i <= $off_pag; $i ++) {
				if ($i == $off) {
					echo '<span>' , $i , '</span>' , PHP_EOL;
				} else {
					echo '<a href="' , $path , '&amp;offset=' , $i , '&amp;go=' , $go , '">' , $i , '</a>' , PHP_EOL;
				} 
			}
		} else {
			if ($off >= $off_pag - 4) {
				for ($i = 1; $i <= 3; $i ++) {
					if ($i == $off) {
						echo '<span>' , $i , '</span>' , PHP_EOL;
					} else {
						echo '<a href="' , $path , '&amp;offset=' , $i , '&amp;go=' , $go , '">' , $i , '</a>' , PHP_EOL;
					}
				}
				echo ' ... ' , PHP_EOL;
				for ($i = $off_pag -5; $i <= $off_pag; $i ++) {
					if ($i == $off) {
						echo '<span>' , $i , '</span>' , PHP_EOL;
					} else {
						echo '<a href="' , $path , '&amp;offset=' , $i , '&amp;go=' , $go , '">' , $i , '</a>' , PHP_EOL;
					} 
				}
			} else {
				for ($i = 1; $i <= 3; $i ++) {
					if ($i == $off) {
						echo '<span>' , $i , '</span>' , PHP_EOL;
					} else {
						echo '<a href="' , $path , '&amp;offset=' , $i , '&amp;go=' , $go , '">' , $i , '</a>' , PHP_EOL;
					}
				}
				echo ' ... ' , PHP_EOL;
				$lastoff = $off -1;
				$nextoff = $off +1;
				echo '<a href="' , $path , '&amp;offset=' , $lastoff , '&amp;go=' , $go , '">' , $lastoff , '</a>' , PHP_EOL
				   , '<span>' , $off , '</span>' , PHP_EOL
				   , '<a href="' , $path , '&amp;offset=' , $nextoff , '&amp;go=' , $go , '">' , $nextoff , '</a>' , PHP_EOL
				   , ' ... ' , PHP_EOL;
			 	for ($i = $off_pag -2; $i <= $off_pag; $i ++) {
					if ($i == $off) {
						echo '<span>' , $i , '</span>' , PHP_EOL;
					} else {
						echo '<a href="' , $path , '&amp;offset=' , $i , '&amp;go=' , $go , '">' , $i , '</a>' , PHP_EOL;
					} 
			 	}
			 } 
		}
	}
	if ($off < $off_pag) {
	$next = $off + 1;
		echo '<a href="' , $path , '&amp;offset=' , $next , '&amp;go=' , $go , '">&gt;</a>' , PHP_EOL;
	}
	echo '<p align="center">' , _PAGINATOR_PAGE , ' ' , $off , ' ' , _OF , ' ' , $off_pag , '</p>' , PHP_EOL
	   , '</div>' , PHP_EOL
	   , '<br style="clear:both;" />' , PHP_EOL;		
	CloseTable();
	include_once 'footer.php';	
}