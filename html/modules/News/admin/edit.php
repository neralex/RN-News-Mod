<?php
/**
 * @PHP-NUKE: Web Portal System
 * @package Tricked Out News
 * @version 2.6 (RN News-Mod)
 * @file: edit.php (admin)
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

function editStory($sid, $status) {
	global $user, $bgcolor1, $bgcolor2, $aid, $prefix, $user_prefix, $db, $multilingual, $language, $admin_file, $anonymous, $ThemeSel, $advanced_editor, $module_name;
	if (!is_numeric($sid) || $sid == '') {
		Header('Location: ' . $admin_file . '.php?op=adminMain');
	}
	if (isset($status) && is_numeric($status)) {
		$statusnumeric = $status;
	} else {
		$statusnumeric = '';
	}	
	if (!isset($checked)) $checked = '';
	$sel = '';
	$result2 = $db->sql_query('SELECT `sid`, `aid` FROM `' . $prefix . '_stories` WHERE `sid` = \'' . $sid . '\'');
	list($ssid, $aaid) = $db->sql_fetchrow($result2);
	if ($ssid == '') {
		Header('Location: ' . $admin_file . '.php?op=adminMain');
	}
	if ($aaid == $aid || is_mod_admin('admin')) {
		$tonquery = $db->sql_query('SELECT `newsyearmin`, `newsyearmax`, `hideautotimes`, `previewstory`, `jqueryselect`, `TON_useCharLimit`, `TON_CharLimit`, `usenotes` FROM `' . $prefix . '_ton`');
		list($newsyearmin, $newsyearmax, $hideautotimes, $previewstory, $jqueryselect, $TON_useCharLimit, $TON_CharLimit, $usenotes) = $db->sql_fetchrow($tonquery);
		if ($jqueryselect == 1 && !file_exists('themes/' . $ThemeSel . '/style/NewsAdmin.css')) {
			addCSSToHead('modules/' . $module_name . '/css/jquery.multiselect.css', 'file');
		}	
		if ($jqueryselect == 1) {
			addJSToBody('includes/jquery/jquery-ui.min.js', 'file');
			addJSToBody('modules/' . $module_name . '/js/jquery.multiselect.min.js', 'file');
			addJSToBody('modules/' . $module_name . '/js/jquery.multiselect.filter.js', 'file');			
			$selector = '<script type="text/javascript">' . PHP_EOL
					  . '$(\'#selector\').multiselect({multiple: false, header: true, selectedList: 1});' . PHP_EOL
					  . '$(\'#selector\').multiselect().multiselectfilter();' . PHP_EOL
					  . '$(\'#selecttopic\').multiselect({multiple: false, header: true, selectedList: 1});' . PHP_EOL
					  . '$(\'#selecttopic\').multiselect().multiselectfilter();' . PHP_EOL
					  . '  </script>' . PHP_EOL;
			addJSToBody($selector,'inline');		
		}
		$assochecklist = '<script type="text/javascript">' . PHP_EOL
					   . '$(\'#selectall\').click(function() {$(\'input[type="checkbox"]\').attr(\'checked\', $(\'#selectall\').is(\'":checked\'));})' . PHP_EOL
					   . '  </script>' . PHP_EOL;
		addJSToBody($assochecklist,'inline');	
		include_once 'header.php';
		GraphicAdmin();
		OpenTable();
		echo '<div class="text-center title">' , _ARTICLEADMIN , '</div>' , PHP_EOL;
		CloseTable();
		$result = $db->sql_query('SELECT `catid`, `title`, `hometext`, `bodytext`, `topic`, `informant`, `notes`, `ihome`, `alanguage`, `acomm`, `time`, `time2`, `time3`, `counter`, `slock` FROM `' . $prefix . '_stories` WHERE `sid` = \'' . $sid . '\'');
		list($catid, $subject, $hometext, $bodytext, $topic, $informant, $notes, $ihome, $alanguage, $acomm, $time, $time2, $time3, $counter, $slock) = $db->sql_fetchrow($result);
		$result2 = $db->sql_query('SELECT `topicimage`, `topictext` FROM `' . $prefix . '_topics` WHERE `topicid` = \'' . $topic . '\'');
		list($topicimage, $topictext) = $db->sql_fetchrow($result2);
		$subject = htmlspecialchars($subject, ENT_QUOTES, _CHARSET);
		$topictext = htmlspecialchars($topictext, ENT_QUOTES, _CHARSET);
		OpenTable();
		echo '<div class="text-center option"><span class="thick">' , _EDITARTICLE , '</span></div>' , PHP_EOL
		   , ($previewstory == 1 ? '<a href="#ton_preview" class="tonpreview tonpressme">' . _PREVIEWSTORY . '</a>' . PHP_EOL : '')
		   , '<div' , ($previewstory == 1 ? ' class="display-none"' : '') , '>' , PHP_EOL
		   , '	<div id="ton_preview" class="themepreview" style="border-color:' , $bgcolor2 , '; background-color:' , $bgcolor1 , ';">' , PHP_EOL
		   , '		<img src="images/topics/' , $topicimage , '" border="0" align="right" class="themepreviewpic" title="' , $topictext , '" alt="" />' , PHP_EOL;
		themepreview($subject, $hometext, $bodytext, $notes);	
		echo '	</div>' , PHP_EOL
		   , '</div>' , PHP_EOL;	  	   
		if ($statusnumeric == 1) {
			echo '<div><span class="thick">' , _SAVESTATUS , '</span>: ' , _DONE , '!</div>' , PHP_EOL;
		} elseif ($statusnumeric == 2) {
			echo '<div><span class="thick">' , _SAVESTATUS , '</span>: ' , _APPROOVE , '!</div>' , PHP_EOL;
		} elseif ($statusnumeric == 3) {
			echo '<div><span class="thick">' , _SAVESTATUS , '</span>: ' , _FAIL , '!</div>' , PHP_EOL;		
		} elseif ($statusnumeric == 4) {
			echo '<div><span class="thick">' , _SAVESTATUS , '</span>: ' , _DONE , '!</div>' , PHP_EOL
			   , '<div><span class="thick">' , _TIMINGERROR , '</span>: ' , _TIMINGFAIL , '!</div>' , PHP_EOL;
		}
		echo '<form action="' , $admin_file , '.php" method="post">' , PHP_EOL;
		if ($slock == 1 && $aaid == '') {		   
			echo '<p><span class="thick">' , _TONPENDING , '</span></p>' , PHP_EOL
			   , '<p><span class="thick">' , _NAME , '</span>:</p>' , PHP_EOL
			   , '<select size="1" id="selector" name="uid">' , PHP_EOL;
			$usrquery = $db->sql_query('SELECT `user_id`, `user_level`, `user_email` FROM `' . $user_prefix . '_users` WHERE `username` = \'' . $db->sql_escape_string($informant) . '\'');
			list($userid, $userlevel, $user_email) = $db->sql_fetchrow($usrquery);
			$usrquery2 = $db->sql_query('SELECT `user_id`, `username`, `user_level` FROM `' . $user_prefix . '_users` ORDER BY `username` ASC, `user_id` ASC');
			while (list($user_id, $username, $user_level) = $db->sql_fetchrow($usrquery2)) {
				echo '<option value="' , $user_id , '"' , ($user_id == $userid ? ' selected="selected"' : '');
				if ($user_level == 0) {
					echo ' title="' , _ACCOUNTSUSPEND, '"';
				} elseif ($user_level == -1) {
					echo ' title="' , _ACCOUNTDELETE, '"';
				}
				echo '>' , htmlspecialchars($username, ENT_QUOTES, _CHARSET) , ($user_level < 1 ? ' (!)' : '') , '</option>' . PHP_EOL;
			}
			echo '</select>' , PHP_EOL;
			echo '&nbsp;&nbsp;' , PHP_EOL;
			if ($informant != 'Anonymous' && $informant != '') {
				if ($userlevel == '0') {
					echo '[ <span class="thick">' , _ACCOUNTSUSPEND , '</span> ]&nbsp;&nbsp;';
				} elseif ($userlevel == '-1') { 
					echo '[ <span class="thick">' , _ACCOUNTDELETE , '</span>  ]&nbsp;&nbsp;';
				} else {
					echo '[ <a href="mailto:' , $user_email , '?Subject=Re:%20' , urlencode($subject) , '"><span class="content">' , _EMAILUSER , '</span></a> | ' , PHP_EOL
					   , '<a href="modules.php?name=Your_Account&amp;op=userinfo&amp;username=' , htmlspecialchars($informant, ENT_QUOTES, _CHARSET) , '"><span class="content">' , _USERPROFILE , '</span></a> | ' , PHP_EOL
					   , '<a href="modules.php?name=Private_Messages&amp;mode=post&amp;u=' , $userid , '"><span class="content">' , _SENDPM , '</span></a> ]' , PHP_EOL;
				}
			}
			echo '<a href="#ton_submituser" class="toninfo"><img src="images/news/question.png" style="vertical-align:middle;" alt="Question" /></a>' , PHP_EOL
			   , '<div class="display-none">' , PHP_EOL
			   , '	<div id="ton_submituser" class="toncboxinline"><span class="thick">' , _TONSUBMIT , '</span><br /><br />' , _TONSUBMITFAQ , '</div>' , PHP_EOL
			   , '</div>' , PHP_EOL;
		}
		echo '<p class="larger"><span class="thick">Link</span>: <a href="modules.php?name=News&amp;file=article&amp;sid=' , $sid , '">' , $subject , '</a></p>' , PHP_EOL 
		   , '<p><span class="thick">' , _TITLE , '</span>:</p>' , PHP_EOL
		   , '<input class="larger" type="text" name="subject" size="50" value="' , $subject , '" /><br />' , PHP_EOL;

		echo '<div class="newssort">' , PHP_EOL;
		if ($time2 == "0000-00-00 00:00:00" || $time2 == '') {
			$time2 = $time;
		}
		preg_match('/(.*)?-(.*)?-(.*)? (.*)?:(.*)?:(.*)?/', $time, $matchposttime);
		$postingtime = $matchposttime[3] . '.' . $matchposttime[2] . '.' . $matchposttime[1] . ' - ' . $matchposttime[4] . ':' . $matchposttime[5] . ':' . $matchposttime[6];
		preg_match('/(.*)?-(.*)?-(.*)? (.*)?:(.*)?:(.*)?/', $time2, $matchtime);
		echo '<p><span class="thick">';
		if ($slock == 1) {
			echo _TONSUBMITTIME;
		} elseif ($slock == 2) {
			echo _TONAUTOTIME;
		} else {
			echo _TONPOSTTIME;
		}
		echo '</span>: ' , $postingtime , '</p>' , PHP_EOL
		   , '<p><span class="thick">' , _TONSORTTIME , '</span>:</p>' , PHP_EOL		   
		   , '<select title="' , _DAY , '" name="dayselect" size="1">' , PHP_EOL;
		for($i=1; $i<=31; $i++) {
			echo '	<option value="' , (strlen($i)>1 ? $i : '0' . $i) , '"' , ($matchtime[3] == $i ? ' selected="selected"' : '') , '>' , (strlen($i)>1 ? $i : '0' . $i) , '</option>' , PHP_EOL;
		}
		echo '</select>' , PHP_EOL
		   , '<span class="newssortfiller">.</span>' , PHP_EOL
		   , '<select title="' , _UMONTH , '" name="monthselect" size="1">' , PHP_EOL;
		for($i=1; $i<=12; $i++) {
			echo '	<option value="' , (strlen($i)>1 ? $i : '0' . $i) , '"' , ($matchtime[2] == $i ? ' selected="selected"' : '') , '>' , (strlen($i)>1 ? $i : '0' . $i) , '</option>' , PHP_EOL;
		}
		echo '</select>' , PHP_EOL
		   , '<span class="newssortfiller">.</span>' , PHP_EOL;
		$year_range_min = $newsyearmin;
		$year_range_max = $newsyearmax;
		$yearcheck = '';
		if ($year_range_min == '0' || $year_range_max == '0') {
			$timecheck = $db->sql_query('SELECT `time` FROM `' . $prefix . '_stories` WHERE `sid`');
			while ($time_check = $db->sql_fetchrow($timecheck)) {
				preg_match('/(.*)?-/', $time_check['time'], $match);
				$yearcheck[] = $match[1];
			}
		}
		if ($year_range_min == '0' && $yearcheck != '') {
			$result_minyear = intval(min($yearcheck));
			$year_min = $result_minyear;
		} elseif ($year_range_min == '0' && $yearcheck == '') {
			$year_min = date('Y');
		} else {
			$year_min = date('Y')-$year_range_min;
		}
		if ($year_range_max == '0' && $yearcheck != '') {
			$result_maxyear = intval(max($yearcheck));
			$year_max = $result_maxyear;
		} elseif ($year_range_max == '0' && $yearcheck == '') {
			$year_max = date('Y');
		} else {			
			$year_max = date('Y')+$year_range_max;
		}
		if ($year_max < date('Y')) {
			$year_max = date('Y');
		}
		echo '<select title="' , _TONSORTYEAR , '" name="yearselect" size="1">' , PHP_EOL;
		for($i=$year_min; $i<=$year_max; $i++) {
			echo '	<option value="' , $i , '"' , ($matchtime[1] == $i ? ' selected="selected"' : '') , '>' , $i , '</option>' , PHP_EOL;
		}
		echo '</select>' , PHP_EOL
		   , '<span class="newssortfiller">-</span>' , PHP_EOL
		   , '<select title="' , _HOUR , '" name="hourselect" size="1">' , PHP_EOL;
		for($i=0; $i<=23; $i++) {
			echo '	<option value="' , (strlen($i)>1 ? $i : '0' . $i) , '"' , ($matchtime[4] == $i ? ' selected="selected"' : '') , '>' , (strlen($i)>1 ? $i : '0' . $i) , '</option>' , PHP_EOL;
		}
		echo '</select>' , PHP_EOL
		   , '<span class="newssortfiller">:</span>' , PHP_EOL
		   , '<select title="' , _TONSORTMIN , '" name="minselect" size="1">' , PHP_EOL;
		for($i=0; $i<=59; $i++) {
			echo '	<option value="' , (strlen($i)>1 ? $i : '0' . $i) , '"' , ($matchtime[5] == $i ? ' selected="selected"' : '') , '>' , (strlen($i)>1 ? $i : '0' . $i) , '</option>' , PHP_EOL;
		}
		echo '</select>' , PHP_EOL
		   , '<span class="newssortfiller">:</span>' , PHP_EOL
		   , '<select title="' , _TONSORTSEC , '" name="secselect" size="1">' , PHP_EOL;
		for($i=0; $i<=59; $i++) {
			echo '	<option value="' , (strlen($i)>1 ? $i : '0' . $i) , '"' , ($matchtime[6] == $i ? ' selected="selected"' : '') , '>' , (strlen($i)>1 ? $i : '0' . $i) , '</option>' , PHP_EOL;
		}
		echo '</select>' , PHP_EOL
		   , '<a href="#ton_sorttime" class="toninfo"><img src="images/news/question.png" alt="Question" /></a>' , PHP_EOL
		   , '<div class="display-none">' , PHP_EOL
		   , '	<div id="ton_sorttime" class="toncboxinline"><span class="thick">' , _TONSORTTIME , '</span><br /><br />' , _TONSORTTIMEFAQ , '</div>' , PHP_EOL
		   , '</div>' , PHP_EOL;
		$date = date('d.m.Y - H:i:s');
		if ($slock != 0) {			
			$year = $matchposttime[1];
			$month = $matchposttime[2];
			$day = $matchposttime[3];
			$hour = $matchposttime[4];
			$min = $matchposttime[5];
			if ($slock == 2) { 
				echo '<p><span class="thick">' , _TONAUTOTIME , '</span>:</p>' , PHP_EOL
				   , '<input type="hidden" name="automated" value="1" />' , PHP_EOL;
			} elseif ($slock == 1 || $slock == 3) {
				if ($date >= $postingtime) {
					$autocheck1 = '';
					$autocheck0 = ' checked="checked"';
					$hideclass = ($hideautotimes == 1 ? 'display-none' : '');
				} else { 
					$autocheck1 = ' checked="checked"';
					$autocheck0 = '';
					$hideclass = '';
				}
				echo '<p>' , PHP_EOL
				   , '	<span class="thick">' , _TONPOSTTIME , '</span>: ' , PHP_EOL
				   , '	<input type="radio" name="automated" value="1"' , $autocheck1 , ' />' , _YES , ' &nbsp;&nbsp;' , PHP_EOL
				   , '	<input type="radio" name="automated" value="0"' , $autocheck0 , ' />' , _NO , PHP_EOL
				   , '</p>' , PHP_EOL
				   , '<p><span class="thick">' , _NOWIS , '</span>: ' , $date , '</p>' , PHP_EOL
				   , '<div id="autopost" class="' , $hideclass , '">' , PHP_EOL;
			}
			echo '<select title="' , _DAY , '" name="day">' , PHP_EOL;
			for($i=1; $i<=31; $i++) {
				echo '	<option value="' , (strlen($i)>1 ? $i : '0' . $i) , '"' , ($day == $i ? ' selected="selected"' : '') , '>' , (strlen($i)>1 ? $i : '0' . $i) , '</option>' , PHP_EOL;
			}
			echo '</select>' , PHP_EOL
			   , '<span class="newssortfiller">.</span>' , PHP_EOL
			   , '<select title="' , _UMONTH , '" name="month">' , PHP_EOL;
			for($i=1; $i<=12; $i++) {
				echo '	<option value="' , (strlen($i)>1 ? $i : '0' . $i) , '"' , ($month == $i ? ' selected="selected"' : '') , '>' , (strlen($i)>1 ? $i : '0' . $i) , '</option>' , PHP_EOL;
			}
			echo '</select>' , PHP_EOL
			   , '<span class="newssortfiller">.</span>' , PHP_EOL
			   , '<select title="' , _TONSORTYEAR , '" name="year" size="1">' , PHP_EOL;
			for($i=$year_min; $i<=$year_max; $i++) {
				echo '	<option value="' , $i , '"' , ($year == $i ? ' selected="selected"' : '') , '>' , $i , '</option>' , PHP_EOL;
			}
			echo '</select>' , PHP_EOL	
			   , '<span class="newssortfiller">-</span>' , PHP_EOL
			   , '<select title="' , _HOUR , '" name="hour">' , PHP_EOL;
			for($i=0; $i<=23; $i++) {
				echo '	<option value="' , (strlen($i)>1 ? $i : '0' . $i) , '"' , ($hour == $i ? ' selected="selected"' : '') , '>' , (strlen($i)>1 ? $i : '0' . $i) , '</option>' , PHP_EOL;
			}
			echo '</select>' , PHP_EOL
			   , '<span class="newssortfiller">:</span>' , PHP_EOL
			   , '<select title="' , _TONSORTMIN , '" name="min">' , PHP_EOL;
			for($i=0; $i<=59; $i++) {
				echo '	<option value="' , (strlen($i)>1 ? $i : '0' . $i) , '"' , ($min == $i ? ' selected="selected"' : '') , '>' , (strlen($i)>1 ? $i : '0' . $i) , '</option>' , PHP_EOL;
			}
			echo '</select>' , PHP_EOL
			   , '<a href="#ton_posttime" class="toninfo"><img src="images/news/question.png" alt="Question" /></a>' , PHP_EOL
			   , '	<div class="display-none">' , PHP_EOL
			   , '		<div id="ton_posttime" class="toncboxinline"><span class="thick">' , ($slock == 2 ? _TONAUTOTIME : _TONPOSTTIME) , '</span><br /><br />' , ($slock == 2 ? _TONAUTOPOSTTIMEFAQ : _TONPOSTTIMEFAQ) , '</div>' , PHP_EOL
			   , '	</div>' , PHP_EOL
			   , ($slock != 2 ? '</div>' . PHP_EOL : '');
		}
		if ($time3 == '0000-00-00 00:00:00' || $time3 == '') {
			$expiretime = $date;
			$dayexpire = date('j');
			$monthexpire = date('n');
			$yearexpire = date('Y');
			$hourexpire = date('H');
			$minexpire = date('i');
			$expirenone = 1;
		} else {
			preg_match('/(.*)?-(.*)?-(.*)? (.*)?:(.*)?:(.*)?/', $time3, $matchexpire);
			$expiretime = $matchexpire[3] . '.' . $matchexpire[2] . '.' . $matchexpire[1] . ' - ' . $matchexpire[4] . ':' . $matchexpire[5] . ':' . $matchexpire[6];			
			$yearexpire = $matchexpire[1];
			$monthexpire = $matchexpire[2];
			$dayexpire = $matchexpire[3];
			$hourexpire = $matchexpire[4];
			$minexpire = $matchexpire[5];
			$expirenone = 0;
		}	
		if ($date >= $expiretime && $expirenone == 1) {			
			$expirecheck1 = '';
			$expirecheck0 = ' checked="checked"';
			$hideclass2 = ($hideautotimes == 1 ? 'display-none' : '');
		} else { 
			$expirecheck1 = ' checked="checked"';
			$expirecheck0 = '';
			$hideclass2 = ($hideautotimes == 1 && $expirenone == 1 ? 'display-none' : '');
		}
		echo '<p><span class="thick">' , _TONEXPTIME , '</span>: ' , PHP_EOL
		   , '<input type="radio" name="automated2" value="1"' , $expirecheck1 , ' />' , _YES , ' &nbsp;&nbsp;' , PHP_EOL
		   , '<input type="radio" name="automated2" value="0"' , $expirecheck0 , ' />' , _NO , '</p>' , PHP_EOL
		   , ($date > $expiretime ? '<p>' . _TONEXPOLDTIME . '</p>' . PHP_EOL : '')
		   , '<div id="expire" class="' , $hideclass2 , '">' , PHP_EOL;
		echo '<select title="' , _DAY , '" name="dayexpire">' , PHP_EOL;
		for($i=1; $i<=31; $i++) {
			echo '	<option value="' , (strlen($i)>1 ? $i : '0' . $i) , '"' , ($dayexpire == $i ? ' selected="selected"' : '') , '>' , (strlen($i)>1 ? $i : '0' . $i) , '</option>' , PHP_EOL;
		}
		echo '</select>' , PHP_EOL
		   , '<span class="newssortfiller">.</span>' , PHP_EOL
		   , '<select title="' , _UMONTH , '" name="monthexpire">' , PHP_EOL;
		for($i=1; $i<=12; $i++) {
			echo '	<option value="' , (strlen($i)>1 ? $i : '0' . $i) , '"' , ($monthexpire == $i ? ' selected="selected"' : '') , '>' , (strlen($i)>1 ? $i : '0' . $i) , '</option>' , PHP_EOL;
		}
		echo '</select>' , PHP_EOL
		   , '<span class="newssortfiller">.</span>' , PHP_EOL
		   , '<select title="' , _TONSORTYEAR , '" name="yearexpire" size="1">' , PHP_EOL;
		for($i=$year_min; $i<=$year_max; $i++) {
			echo '	<option value="' , $i , '"' , ($yearexpire == $i ? ' selected="selected"' : '') , '>' , $i , '</option>' , PHP_EOL;
		}
		echo '</select>' , PHP_EOL	
		   , '<span class="newssortfiller">-</span>' , PHP_EOL
		   , '<select title="' , _HOUR , '" name="hourexpire">' , PHP_EOL;
		for($i=0; $i<=23; $i++) {
			echo '	<option value="' , (strlen($i)>1 ? $i : '0' . $i) , '"' , ($hourexpire == $i ? ' selected="selected"' : '') , '>' , (strlen($i)>1 ? $i : '0' . $i) , '</option>' , PHP_EOL;
		}
		echo '</select>' , PHP_EOL
		   , '<span class="newssortfiller">:</span>' , PHP_EOL
		   , '<select title="' , _TONSORTMIN , '" name="minexpire">' , PHP_EOL;
		for($i=0; $i<=59; $i++) {
			echo '	<option value="' , (strlen($i)>1 ? $i : '0' . $i) , '"' , ($minexpire == $i ? ' selected="selected"' : '') , '>' , (strlen($i)>1 ? $i : '0' . $i) , '</option>' , PHP_EOL;
		}
		echo '</select>' , PHP_EOL
		   , '<a href="#ton_expiretime" class="toninfo"><img src="images/news/question.png" alt="Question" /></a>' , PHP_EOL
		   , '	<div class="display-none">' , PHP_EOL
		   , '		<div id="ton_expiretime" class="toncboxinline"><span class="thick">' , _TONEXPTIME , '</span><br /><br />' , _TONEXPTIMEFAQ , '</div>' , PHP_EOL
		   , '	</div>' , PHP_EOL
		   , '</div>' , PHP_EOL		   
		   , '<p><span class="thick">' , _TONSTORYLOCK , '</span>:</p>' , PHP_EOL
		   , '<select name="slock" size="1">' , PHP_EOL;
		for($i=0; $i<=3; $i++) {
		  if ($slock!=1 && $i!=1) {
			echo '	<option value="' , $i , '"' , ($slock == $i ? ' selected="selected"' : '') , '>';
				if ($i==0) {
					echo _TONSTORYLOCKACTIVE;
				} elseif ($i==2) {
					echo _TONSTORYLOCKTIMED;
				} elseif ($i==3) {
					echo _TONSTORYLOCKFULL;
				}
			echo '</option>' , PHP_EOL;
		} elseif ($slock==1) { 			
			echo '	<option value="' , $i , '"' , ($slock == $i ? ' selected="selected"' : '') , '>';
				if ($i==0) {
					echo _TONSTORYLOCKACTIVE;
				} elseif ($i==1) {
					echo _TONSTORYLOCKSUBMIT;
				} elseif ($i==2) {
					echo _TONSTORYLOCKTIMED;
				} elseif ($i==3) {
					echo _TONSTORYLOCKFULL;
				}
			echo '</option>' , PHP_EOL;
		  }
		}
		echo '</select>' , PHP_EOL
		   , '<a href="#ton_storylock" class="toninfo"><img src="images/news/question.png" alt="Question" /></a>' , PHP_EOL
		   , '	<div class="display-none">' , PHP_EOL
		   , '		<div id="ton_storylock" class="toncboxinline"><span class="thick">' , _TONSTORYLOCK , '</span><br /><br />' , _TONSTORYLOCKFAQ , '</div>' , PHP_EOL
		   , '	</div>' , PHP_EOL
		   , '</div>' , PHP_EOL
		   , '<div class="topicmain">' , PHP_EOL
		   , '<span class="thick">' , _TOPIC , '</span>: ' , PHP_EOL
		   , '<select id="selecttopic" name="topic">' , PHP_EOL;
		$toplist = $db->sql_query('SELECT `topicid`, `topictext` FROM `' . $prefix . '_topics` ORDER BY `topictext`');
		echo '	<option value="">' , _ALLTOPICS , '</option>' , PHP_EOL;
		while(list($topicid, $topics) = $db->sql_fetchrow($toplist)) {
			echo '	<option value="' , $topicid , '"' , ($topicid == $topic ? ' selected="selected"' : '') , '>' , htmlspecialchars($topics, ENT_QUOTES, _CHARSET) , '</option>' , PHP_EOL;
		}
		echo '</select>' , PHP_EOL;
		$asql = 'SELECT `associated` FROM `' . $prefix . '_stories` WHERE `sid` = \'' . $sid . '\'';
		$aresult = $db->sql_query($asql);
		$arow = $db->sql_fetchrow($aresult);
		$asso_t = explode('-', $arow['associated']);
		$sql = 'SELECT `topicid`, `topictext` FROM `' . $prefix . '_topics` ORDER BY `topictext`';
		$result = $db->sql_query($sql);
		echo '<p><span class="thick">' , _ASSOTOPIC , '</span>: </p>' , PHP_EOL
		   , '<div class="assolistDIV assolist">' , PHP_EOL;
		while ($row = $db->sql_fetchrow($result)) {
			for ($i=0; $i<sizeof($asso_t); $i++) {
				if ($asso_t[$i] == $row['topicid']) {
					$checked = ' checked="checked"';
				break;
				}
			}		
			echo '	<label for="asso' , $row['topicid'] , '"><input id="asso' , $row['topicid'] , '" name="assotop[]" type="checkbox" value="' , $row['topicid'] , '"' , $checked , '/>' , htmlspecialchars($row['topictext'], ENT_QUOTES, _CHARSET) , '</label>' , PHP_EOL;
			$checked = '';
		}
		echo '</div>' , PHP_EOL
		   , '	<p class="assolistcheck"><input type="checkbox" id="selectall" />' , _TONSELECTALL , '</p>' , PHP_EOL
		   , '</div>' , PHP_EOL
		   , '<div class="clear-both newscounter">' , PHP_EOL
		   , '	<span class="thick">News-Counter</span>: <input type="text" name="counter" size="15" value="' , $counter , '" />' , PHP_EOL
		   , '</div>' , PHP_EOL;

		$cat = $catid;
		SelectCategory($cat);

		puthome($ihome, $acomm);
		if ($multilingual == 1) {
			echo '<p><span class="thick">' , _LANGUAGE , '</span><br />' , PHP_EOL;
			$lang_content = lang_select_list('alanguage', $alanguage);
			echo $lang_content , '</p>';
		} else {
			echo '<input type="hidden" name="alanguage" value="' , $language , '" />' , PHP_EOL;
		}
		if (!isset($advanced_editor) || $advanced_editor == 0) {
			$hometext = htmlspecialchars($hometext, ENT_QUOTES, _CHARSET);
			$bodytext = htmlspecialchars($bodytext, ENT_QUOTES, _CHARSET);
			if ($aaid != $informant && $usenotes == 1) {
				$notes = htmlspecialchars($notes, ENT_QUOTES, _CHARSET);
			}
		}
		$text = wysiwyg_textarea_html('hometext', $hometext, 'PHPNukeAdmin', '100%', '300px');
		$textext = wysiwyg_textarea_html('bodytext', $bodytext, 'PHPNukeAdmin', '100%', '300px');
		if ($aaid != $informant && $usenotes == 1) {
			$textnotes = wysiwyg_textarea_html('notes', $notes, 'PHPNukeAdmin', '100%', '100px');
		}
		if ((isset($advanced_editor) || $advanced_editor == 1) && $TON_useCharLimit == 1) {
			echo '<div id="ckcounter">' , PHP_EOL
  			   , '	<div class="ckbarcount ckbarmover">' , PHP_EOL
  			   , '		<div class="ckbar ckbluebar"></div>' , PHP_EOL
  			   , '	</div>' , PHP_EOL
  			   , '	<div id="ckcount"></div>' , PHP_EOL
  			   , '</div>' , PHP_EOL;
		}
		echo '<p class="thick clear-both">' , _STORYTEXT , '</p>' , PHP_EOL
		   , '<p class="clear-both">' , $text , '</p>' , PHP_EOL
		   , '<p class="thick">' , _EXTENDEDTEXT , '</p>' , PHP_EOL
		   , '<p>' , $textext , '<br /><span class="content">' , _ARESUREURL , '</span></p>' , PHP_EOL;
		if ($aaid != $informant && $usenotes == 1) {
			echo '<p class="thick">' , _NOTES , '</p>' , PHP_EOL
			   , '<p>' , $textnotes , '</p>' , PHP_EOL;
		}
		// tag cloud start
		if ($result = $db->sql_query('SELECT `tag` FROM `' . $prefix . '_tags` WHERE `whr` = 3 AND `cid` = \'' . $sid . '\'')) {
			$ntags = array();
			while ($row = mysqli_fetch_assoc($result)) {
				$ntags[] = htmlspecialchars($row['tag'], ENT_QUOTES, _CHARSET);
			}
			$ntags = implode(',',$ntags);
		} else {
			$ntags = '';
		}
		echo '<p>' , _TAGSCLOUD , ': <input type="text" name="tags" value="' , $ntags , '" size="40" maxlength="255" /> <span style="font-size:9px">(' , _SEPARATEDBYCOMMAS , ')</span></p>' , PHP_EOL;
		// tag cloud end	
		echo '<input type="hidden" name="sid" size="50" value="' , $sid , '" />' , PHP_EOL
		   , '<p><select name="op">' , PHP_EOL
		   , '	<option value="RemoveStory">' , _DELETESTORY , '</option>' , PHP_EOL
		   , '	<option value="ChangeStory" selected="selected">' , _SAVECHANGES , '</option>' , PHP_EOL
		   , '</select>' , PHP_EOL
		   , '<input type="submit" style="cursor:pointer;" value="' , _OK , '" /></p>' , PHP_EOL
		   , '</form>' , PHP_EOL;
		CloseTable();
		if ($hideautotimes == 1) {
			$radioswitsch = '<script type="text/javascript">' . PHP_EOL;
			if ($date >= $postingtime && ($slock == 1 || $slock == 3)) {
				$radioswitsch .= '	$(\'input[name="automated"]\').bind("change",function() {var showOrHide = ($(this).val() == 1) ? true : false; $("#autopost").removeClass("display-none").toggle(showOrHide);});' . PHP_EOL;
			} elseif ($date <= $postingtime && ($slock == 1 || $slock == 3)) {
				$radioswitsch .= '	$(\'input[name="automated"]\').bind("change",function() {var showOrHide = ($(this).val() == 1) ? true : false; $("#autopost").removeClass("display-none").toggle(showOrHide);});' . PHP_EOL;				
			}
			if ($date >= $expiretime && $expirenone == 1) {				
				$radioswitsch .= '	$(\'input[name="automated2"]\').bind("change",function() {var showOrHide = ($(this).val() == 1) ? true : false; $("#expire").toggle(showOrHide);});' . PHP_EOL;
			} elseif ($date <= $expiretime && $expirenone != 1) {
				$radioswitsch .= '	$(\'input[name="automated2"]\').bind("change",function() {var showOrHide = ($(this).val() == 1) ? true : false; $("#expire").removeClass("display-none").toggle(showOrHide);});' . PHP_EOL;
			}			
			$radioswitsch .= '  </script>' . PHP_EOL;
			addJSToBody($radioswitsch,'inline');
		}
		if ((isset($advanced_editor) || $advanced_editor == 1) && $TON_useCharLimit == 1) {
			$ckmaxchars = $TON_CharLimit;
			$ckinstance = 'hometext';
			$nohtmlcount = 0; // set to 1 for counting without html tags
			if ($nohtmlcount == 1) {
				$ckreplacer = 'replace(/(<([^>]+)>)/ig, \'\').';
			} else {
				$ckreplacer = '';
			}
			$ckcounter = '<script type="text/javascript">' . PHP_EOL
					   . 'jQuery(function() {' . PHP_EOL
					   . '	var editor = CKEDITOR.instances[\'' . $ckinstance . '\']' . PHP_EOL
					   . '	global = editor;' . PHP_EOL
					   . '	setInterval("updateCount()", 400);' . PHP_EOL
					   . '});' . PHP_EOL
					   . 'function updateCount() {' . PHP_EOL
					   . '	var almost = global.getData();' . PHP_EOL
					   . '	var main = almost.' . $ckreplacer . 'length *100;' . PHP_EOL
					   . '	var value = (main / ' . $ckmaxchars . ');' . PHP_EOL
					   . '	var count = ' . $ckmaxchars . ' - almost.' . $ckreplacer . 'length;' . PHP_EOL
					   . '	$(\'#ckcount\').html(almost.' . $ckreplacer . 'length);' . PHP_EOL
					   . '	if (almost.' . $ckreplacer . 'length <= ' . $ckmaxchars . ') {' . PHP_EOL
					   . '		jQuery(\'#ckcount\').html(count).removeClass("ckred");' . PHP_EOL
					   . '		jQuery(\'.ckbar\').animate({"width": value+\'%\'}, 1).removeClass(\'ckredbar\').addClass(\'ckbluebar\');' . PHP_EOL
					   . '	} else {' . PHP_EOL
					   . '		jQuery(\'#ckcount\').html(count).addClass("ckred");' . PHP_EOL
					   . '		jQuery(\'.ckbar\').animate({"width": \'100%\'}, 1).removeClass(\'ckbluebar\').addClass(\'ckredbar\');' . PHP_EOL
					   . '	}' . PHP_EOL
					   . '}' . PHP_EOL
					   . '</script>' . PHP_EOL;
			addJSToBody($ckcounter,'inline');
		}
		include_once 'footer.php';
	} else {
		include_once 'header.php';
		GraphicAdmin();
		OpenTable();
		echo '<div class="text-center title">' , _ARTICLEADMIN , '</div>' , PHP_EOL
		   , '<br />'
		   , '<div class="text-center title">' , _NOTAUTHORIZED1 , '<br />' , PHP_EOL
		   , _NOTAUTHORIZED2 , '<br /><br />' , PHP_EOL
		   , _GOBACK , '</div>' , PHP_EOL;
		CloseTable();	
		include_once 'footer.php';
	}
}

function changeStory($sid, $subject, $hometext, $bodytext, $tags, $topic, $uid, $notes, $catid, $ihome, $alanguage, $acomm, $assotop, $automated, $automated2, $year, $month, $day, $hour, $min, $yearselect, $monthselect, $dayselect, $hourselect, $minselect, $secselect, $yearexpire, $monthexpire, $dayexpire, $hourexpire, $minexpire, $counter, $slock) {
	global $aid, $prefix, $user_prefix, $db, $admin_file;
	if ($subject == '') {
		include_once 'header.php';
		OpenTable();
		echo '<div class="text-center">' , PHP_EOL
		   , ' <span class="thick">ERROR</span>' , PHP_EOL
		   , '<br />' , PHP_EOL
		   , _TONNOTTILE , PHP_EOL
		   , '<br /><br />' , PHP_EOL
		   , '[ <a href="javascript:history.go(-1)">' , _TONGOBACK , '</a> ]' , PHP_EOL
		   , '<br /><br />' , PHP_EOL
		   , '</div>' , PHP_EOL;
		CloseTable();
		include_once 'footer.php';
		exit;	
	}
	$associated = '';
	if ($assotop != '') {
		$j = sizeof($assotop);
		for ($i=0; $i<$j; ++$i) {
			$associated .= $assotop[$i] . '-';
		}
	}
	$today = date('Y-m-d H:i:00');
	if ($year != '' && $day != '' && $month != '' && $hour != '' && $min != '') {
		$postingtime = $year . '-' . $month . '-' . $day . ' ' . $hour . ':' . $min . ':00';
	} else {
		$postingtime = '';
	}
	if ($yearexpire != '' && $monthexpire != '' && $dayexpire != '' && $hourexpire != '' && $minexpire != '') {
		$expiretime = $yearexpire . '-' . $monthexpire . '-' . $dayexpire . ' ' . $hourexpire . ':' . $minexpire . ':00';		
	} else {
		$expiretime = '';
	}
	if ($postingtime != '' && $postingtime >= $today && $slock == 1 && $automated == 1) {
		$timecheck = 1;	
	} elseif ($postingtime != '' && $postingtime <= $today && ($slock == 1 || $slock == 2) && $automated == 1) {
		$timecheck = 0;
		$timealert = 1;
	} elseif ($postingtime != '' && $postingtime >= $today && $slock == 2 && $automated == 1) {
		$timecheck = 1;
	} elseif ($postingtime != '' && $postingtime >= $today && $slock == 3 && $automated == 1) {
		$timecheck = 1;
	} else {
		$timecheck = 0;
		$timealert = 0;
	}
	if ($automated2 == 1 && $expiretime != '' &&  $expiretime >= $today) {
		$expireheck = 1;
	} elseif ($automated2 == 1 && $expiretime != '' && $expiretime <= $today) {
		$expireheck = 0;
	} else {
		$expiretime = '';
		$expireheck = 1;
	}

	$result2 = $db->sql_query('SELECT `aid`, `informant` FROM `' . $prefix . '_stories` WHERE `sid` = \'' . $sid . '\'');
	list($aaid, $informant) = $db->sql_fetchrow($result2);
	if ($aaid == $aid || is_mod_admin('admin')) {
		$subject = $db->sql_escape_string(htmlspecialchars_decode(check_html($subject, 'nohtml'), ENT_QUOTES));
		$hometext = $db->sql_escape_string(check_html($hometext, ''));
		$bodytext = $db->sql_escape_string(check_html($bodytext, ''));
		$notes = $db->sql_escape_string(check_html($notes, ''));
		$time2 = $yearselect . '-' . $monthselect . '-' . $dayselect . ' ' . $hourselect . ':' . $minselect . ':' . $secselect;
		$time2 = $db->sql_escape_string($time2);
		if ($slock != 1 && $aaid == '') {
			$aid1 = '`aid` = \'' . $db->sql_escape_string($aid) . '\',';
		} else {
			$aid1 = '';
		}		
		if ($timecheck == 1) {
			$time = '`time` = \'' . $postingtime = $db->sql_escape_string($postingtime) . '\',';
		} else {
			$time = '';
		}
		if ($expireheck == 1) {
			$time3 = '`time3` = \'' . $expiretime = $db->sql_escape_string($expiretime) . '\',';
		} else {
			$time3 = '';
		}
		if (is_numeric($uid)) {
			$uidnumeric = $uid;
			$usrquery = $db->sql_query('SELECT `username` FROM `' . $user_prefix . '_users` WHERE `user_id` = \'' . $uidnumeric . '\'');
			list($username) = $db->sql_fetchrow($usrquery);
			if ($slock == 1 && $informant != $username) {
				$informant1 = 'informant=\'' . $username = $db->sql_escape_string(htmlspecialchars_decode(check_html($username, 'nohtml'), ENT_QUOTES)) . '\',';
			} else {
				$informant1 = '';
			}
		} else {
			$uidnumeric = '';
		}
		$changequery = $db->sql_query('UPDATE `' . $prefix . '_stories` SET '."`catid`='$catid', " . $aid1 . " `title`='$subject', " . $time . " `hometext`='$hometext', `bodytext`='$bodytext', `counter`='$counter', `topic`='$topic', " . $informant1 . " `notes`='$notes', `ihome`='$ihome', `alanguage`='$alanguage', `acomm`='$acomm', `associated`='$associated', `time2`='$time2', " . $time3 . " `slock`='$slock'".' WHERE `sid` = \'' . $sid . '\'');
		// tag cloud start
		if ($tags!="") {
			$db->sql_query('DELETE FROM `' . $prefix . '_tags` WHERE `whr` = 3 AND `cid` = \'' . $sid . '\'');
			$tags = explode(',',$tags);
			foreach ($tags as $tag) {
				$tag = $db->sql_escape_string(htmlspecialchars_decode(check_html($tag, 'nohtml'), ENT_QUOTES));
				$db->sql_query('INSERT INTO `' . $prefix . '_tags` (`tag`,`cid`,`whr`) VALUES '."('" . trim($tag) . "','$sid','3')".'');
			}
		}
		if ($slock != 1 && $aaid == '' && $uid > 1) {
			$db->sql_query('UPDATE `' . $user_prefix . '_users` SET `counter` = counter+1 WHERE `user_id` = \'' . $uid . '\'');
			$row = $db->sql_fetchrow($db->sql_query('SELECT `points` FROM `' . $prefix . '_groups_points` WHERE `id` = \'4\''));
			$db->sql_query('UPDATE `' . $user_prefix . '_users` SET `points` = points+' . $row['points'] . ' WHERE `user_id` = \'' . $uid . '\'');
			$aid2 = $db->sql_escape_string($aid);
			$db->sql_query('UPDATE `' . $prefix . '_authors` SET `counter` = counter+1 WHERE `aid` = \'' . $aid2 . '\'');
			$approovecount = 1; 
		} elseif ($slock != 1 && $aaid== '' && $uid == 1) {
			$db->sql_query('UPDATE `' . $prefix . '_authors` SET `counter` = counter+1 WHERE `aid` = \'' . $aid2 . '\'');
			$approovecount = 1;
		} else {
			$approovecount = '';
		}
		
		if ($changequery && $approovecount != 1 && $timealert == '') {
			$status = 1;
			Header('Location: ' . $admin_file . '.php?op=EditStory&sid=' . $sid . '&status=' . $status); exit;
		} elseif ($changequery && $approovecount != 1 && $timealert == 1) {
			$status = 4;
			Header('Location: ' . $admin_file . '.php?op=EditStory&sid=' . $sid . '&status=' . $status); exit;
		} elseif ($changequery && $approovecount == 1 && $timealert == '') {
			$status = 2;
			Header('Location: ' . $admin_file . '.php?op=EditStory&sid=' . $sid . '&status=' . $status); exit;		
		} elseif (!$changequery && $timealert == '') {	
			$status = 3;
			Header('Location: ' . $admin_file . '.php?op=EditStory&sid=' . $sid . '&status=' . $status); exit;	
		} else {	
			$status = 3;
			Header('Location: ' . $admin_file . '.php?op=EditStory&sid=' . $sid . '&status=' . $status); exit;
		}
	} else {
		$status = 3;	
		Header('Location: ' . $admin_file . '.php?op=EditStory&sid=' . $sid); exit;
	}
}