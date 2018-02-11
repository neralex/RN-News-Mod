<?php
/**
 * @PHP-NUKE: Web Portal System
 * @package Tricked Out News
 * @version 2.6 (RN News-Mod)
 * @file: post.php (admin)
 * @copyright (c) 2002 by Francisco Burzi
 * @Additional security & Abstraction layer conversion 2003 chatserv http://www.nukeresources.com
 * @nukeWYSIWYG Copyright (c) 2005 Kevin Guske http://nukeseo.com
 * @kses developed by Ulf Harnhammar http://kses.sf.net
 * @RavenNuke(tm) Support:
 * 2012 - Nuken http://www.trickedoutnews.com
 * 2013 - rework of all functions by neralex http://www.media.soefm.de
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

if (!defined('MODULE_FILE') && !defined('ADMIN_FILE')) {die('You can\'t access this file directly...');}
if (!defined('PHP_EOL')) define ('PHP_EOL', strtoupper(substr(PHP_OS,0,3) == 'WIN') ? "\r\n" : "\n");

function adminStory() {
	global $prefix, $db, $language, $multilingual, $admin_file, $bgcolor1, $bgcolor2, $ThemeSel, $advanced_editor, $module_name, $AllowableHTML, $user, $anonymous;
	$tonquery = $db->sql_query('SELECT `newsyearmin`, `newsyearmax`, `hideautotimes`, `hideautosubmit`, `jqueryselect`, `TON_useCharLimit`, `TON_CharLimit` FROM `' . $prefix . '_ton`');
	list($newsyearmin, $newsyearmax, $hideautotimes, $hideautosubmit, $jqueryselect, $TON_useCharLimit, $TON_CharLimit) = $db->sql_fetchrow($tonquery);
	if ($jqueryselect == 1 && !file_exists('themes/' . $ThemeSel . '/style/NewsAdmin.css')) {
		addCSSToHead('modules/' . $module_name . '/css/jquery.multiselect.css', 'file');
	}
	if ($hideautotimes == 1) {
		$radioswitsch = '<script type="text/javascript">' . PHP_EOL
					  . '$(\'input[name="automated"]\').bind("change",function() {var showOrHide = ($(this).val() == 1) ? true : false; $(\'#autopost\').toggle(showOrHide);});' . PHP_EOL
					  . '$(\'input[name="automated2"]\').bind("change",function() {var showOrHide = ($(this).val() == 1) ? true : false; $(\'#expire\').toggle(showOrHide);});' . PHP_EOL
					  . '</script>' . PHP_EOL;
		addJSToBody($radioswitsch,'inline');
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
				  . '</script>' . PHP_EOL;
		addJSToBody($selector,'inline');
	}
	$assochecklist = '<script type="text/javascript">$(\'#selectall\').click(function() {$("input[type=\'checkbox\']").prop(\'checked\', $(\'#selectall\').is(\':checked\'));})</script>' . PHP_EOL;
	addJSToBody($assochecklist,'inline');
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
				   . '		jQuery(\'#ckcount\').html(count).removeClass(\'ckred\');' . PHP_EOL
				   . '		jQuery(\'.ckbar\').animate({"width": value+\'%\'}, 1).removeClass(\'ckredbar\').addClass(\'ckbluebar\');' . PHP_EOL
				   . '	} else {' . PHP_EOL
				   . '		jQuery(\'#ckcount\').html(count).addClass("ckred");' . PHP_EOL
				   . '		jQuery(\'.ckbar\').animate({"width": \'100%\'}, 1).removeClass(\'ckbluebar\').addClass(\'ckredbar\');' . PHP_EOL
				   . '	}' . PHP_EOL
				   . '}' . PHP_EOL
				   . '</script>' . PHP_EOL;
		addJSToBody($ckcounter,'inline');
	}
	$sel = '';
	include_once 'header.php';
	if (defined('ADMIN_FILE')) {
		GraphicAdmin();
	} else {
		OpenTable();
		echo '<div class="text-center"><span class="title thick">' , _SUBMITNEWS , '</span><br /><br />' , _SUBMITADVICE , '</div>' . PHP_EOL;
		CloseTable();
	}
	OpenTable();
	if (defined('ADMIN_FILE')) {
		echo '<div class="text-center title">' , _ARTICLEADMIN , '</div>' , PHP_EOL
		   , '<br />' , PHP_EOL
		   , '<form action="' , $admin_file , '.php" method="post">' , PHP_EOL
		   , '<div class="text-center option">' , _ADDARTICLE , '</div>' , PHP_EOL;
	} else {
		if (is_user($user)) {
			$userinfo = getusrinfo($user);
		} else {
			$userinfo = array();
		}
		echo '<form action="modules.php?name=Submit_News" method="post">' , PHP_EOL
		   , '<p><span class="thick">' , _YOURNAME , ':</span> ';
		if ($userinfo) {
			echo '<a href="modules.php?name=Your_Account">' , htmlspecialchars($userinfo['username'],ENT_QUOTES, _CHARSET) , '</a> [ <a href="modules.php?name=Your_Account&amp;op=logout">' , _LOGOUT , '</a> ]';
		} else {
			echo $anonymous , ' [ <a href="modules.php?name=Your_Account">' , _NEWUSER , '</a> ]';
		}
		echo '</p>' , PHP_EOL;
	}
	echo '<p><span class="thick">' , _TITLE , '</span>:' , (!defined('ADMIN_FILE') ? ' (' . _BADTITLES . ' - ' . _BEDESCRIPTIVE . '.)' : '') , '</p>' , PHP_EOL
	   , '<input type="text" name="subject" size="50" /><br />' , PHP_EOL;
	if ($hideautosubmit == 0 || defined('ADMIN_FILE')) {
		$year_range_min = $newsyearmin;
		$year_range_max = $newsyearmax;
		$yearcheck = array();
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
		echo '<div class="newssort">' , PHP_EOL;
	}
	if (defined('ADMIN_FILE')) {
		echo '<p><span class="thick">' , _TONSORTTIME , '</span>:</p>' , PHP_EOL
		   , '<select title="' , _DAY , '" name="dayselect" size="1">' , PHP_EOL;
		for($i=1; $i<=31; $i++) {
			echo '	<option value="' , (strlen($i)>1 ? $i : '0' . $i) , '"' , (date('d') == $i ? ' selected="selected"' : '') , '>' , (strlen($i)>1 ? $i : '0' . $i) , '</option>' , PHP_EOL;
		}
		echo '</select>' , PHP_EOL
		   , '<span class="newssortfiller">.</span>' , PHP_EOL
		   , '<select title="' , _UMONTH , '" name="monthselect" size="1">' , PHP_EOL;
		for($i=1; $i<=12; $i++) {
			echo '	<option value="' , (strlen($i)>1 ? $i : '0' . $i) , '"' , (date('m') == $i ? ' selected="selected"' : '') , '>' , (strlen($i)>1 ? $i : '0' . $i) , '</option>' , PHP_EOL;
		}
		echo '</select>' , PHP_EOL
		   , '<span class="newssortfiller">.</span>' , PHP_EOL;
		echo '<select title="' , _TONSORTYEAR , '" name="yearselect" size="1">' , PHP_EOL;
		for($i=$year_min; $i<=$year_max; $i++) {
			echo '	<option value="' , $i , '"' , (date('Y') == $i ? ' selected="selected"' : '') , '>' , $i , '</option>' , PHP_EOL;
		}
		echo '</select>' , PHP_EOL
		   , '<span class="newssortfiller">-</span>' , PHP_EOL
		   , '<select title="' , _HOUR , '" name="hourselect" size="1">' , PHP_EOL;
		for($i=0; $i<=23; $i++) {
			echo '	<option value="' , (strlen($i)>1 ? $i : '0' . $i) , '"' , (date('H') == $i ? ' selected="selected"' : '') , '>' , (strlen($i)>1 ? $i : '0' . $i) , '</option>' , PHP_EOL;
		}
		echo '</select>' , PHP_EOL
		   , '<span class="newssortfiller">:</span>' , PHP_EOL
		   , '<select title="' , _TONSORTMIN , '" name="minselect" size="1">' , PHP_EOL;
		for($i=0; $i<=59; $i++) {
			echo '	<option value="' , (strlen($i)>1 ? $i : '0' . $i) , '"' , (date('i') == $i ? ' selected="selected"' : '') , '>' , (strlen($i)>1 ? $i : '0' . $i) , '</option>' , PHP_EOL;
		}
		echo '</select>' , PHP_EOL
		   , '<span class="newssortfiller">:</span>' , PHP_EOL
		   , '<select title="' , _TONSORTSEC , '" name="secselect" size="1">' , PHP_EOL;
		for($i=0; $i<=59; $i++) {
			echo '	<option value="' , (strlen($i)>1 ? $i : '0' . $i) , '"' , (date('s') == $i ? ' selected="selected"' : '') , '>' , (strlen($i)>1 ? $i : '0' . $i) , '</option>' , PHP_EOL;
		}
		echo '</select>' , PHP_EOL
		   , '<a href="#ton_sorttime" class="toninfo"><img src="images/news/question.png" alt="Question" /></a>' , PHP_EOL
		   , '<div class="display-none">' , PHP_EOL
		   , '	<div id="ton_sorttime" class="toncboxinline"><span class="thick">' , _TONSORTTIME , '</span><br /><br />' , _TONSORTTIMEFAQ , '</div>' , PHP_EOL
		   , '</div>' , PHP_EOL;
	}
	if ($hideautosubmit == 0 || defined('ADMIN_FILE')) {
		echo '<p>' , PHP_EOL
		   , '	<span class="thick">' , _TONAUTOTIME , '</span>: ' , PHP_EOL
		   , '	<input type="radio" name="automated" value="1" />' , _YES , ' &nbsp;&nbsp;' , PHP_EOL
		   , '	<input type="radio" name="automated" value="0" checked="checked" />' , _NO , PHP_EOL
		   , '</p>' , PHP_EOL
		   , '<p><span class="thick">' , _NOWIS , '</span>: ' , date('d.m.Y H:i:s') , '</p>' , PHP_EOL
		   , '<div id="autopost"' , ($hideautotimes == 1 ? ' class="display-none"' : '') , '>' , PHP_EOL
		   , '<select title="' , _DAY , '" name="day">' , PHP_EOL;
		for($i=1; $i<=31; $i++) {
			echo '	<option value="' , (strlen($i)>1 ? $i : '0' . $i) , '"' , (date('d') == $i ? ' selected="selected"' : '') , '>' , (strlen($i)>1 ? $i : '0' . $i) , '</option>' , PHP_EOL;
		}
		echo '</select>' , PHP_EOL
		   , '<span class="newssortfiller">.</span>' , PHP_EOL
		   , '<select title="' , _UMONTH , '" name="month">' , PHP_EOL;
		for($i=1; $i<=12; $i++) {
			echo '	<option value="' , (strlen($i)>1 ? $i : '0' . $i) , '"' , (date('m') == $i ? ' selected="selected"' : '') , '>' , (strlen($i)>1 ? $i : '0' . $i) , '</option>' , PHP_EOL;
		}
		echo '</select>' , PHP_EOL
		   , '<span class="newssortfiller">.</span>' , PHP_EOL
		   , '<select title="' , _TONSORTYEAR , '" name="year" size="1">' , PHP_EOL;
		for($i=$year_min; $i<=$year_max; $i++) {
			echo '	<option value="' , (strlen($i)>1 ? $i : '0' . $i) , '"' , (date('Y') == $i ? ' selected="selected"' : '') , '>' , (strlen($i)>1 ? $i : '0' . $i) , '</option>' , PHP_EOL;
		}
		echo '</select>' , PHP_EOL
		   , '<span class="newssortfiller">-</span>' , PHP_EOL
		   , '<select title="' , _HOUR , '" name="hour">' , PHP_EOL;
		for($i=0; $i<=23; $i++) {
			echo '	<option value="' , (strlen($i)>1 ? $i : '0' . $i) , '"' , (date('H') == $i ? ' selected="selected"' : '') , '>' , (strlen($i)>1 ? $i : '0' . $i) , '</option>' , PHP_EOL;
		}
		echo '</select>' , PHP_EOL
		   , '<span class="newssortfiller">:</span>' , PHP_EOL
		   , '<select title="' , _TONSORTMIN , '" name="min">' , PHP_EOL;
		for($i=0; $i<=59; $i++) {
			echo '	<option value="' , (strlen($i)>1 ? $i : '0' . $i) , '"' , (date('i') == $i ? ' selected="selected"' : '') , '>' , (strlen($i)>1 ? $i : '0' . $i) , '</option>' , PHP_EOL;
		}
		echo '</select>' , PHP_EOL
		   , '<a href="#ton_posttime" class="toninfo"><img src="images/news/question.png" alt="Question" /></a>' , PHP_EOL
		   , '<div class="display-none">' , PHP_EOL
		   , '	<div id="ton_posttime" class="toncboxinline"><span class="thick">' , _TONAUTOTIME , '</span><br /><br />' , _TONAUTOPOSTTIMEFAQ , '</div>' , PHP_EOL
		   , '</div>' , PHP_EOL
		   , '</div>' , PHP_EOL
		   , '<p><span class="thick">' , _TONEXPTIME , '</span>: ' , PHP_EOL
		   , '<input type="radio" name="automated2" value="1" />' , _YES , ' &nbsp;&nbsp;' , PHP_EOL
		   , '<input type="radio" name="automated2" value="0" checked="checked" />' , _NO , '</p>' , PHP_EOL
		   , '<div id="expire"' , ($hideautotimes == 1 ? ' class="display-none"' : '') , '>' , PHP_EOL
		   , '<select title="' , _DAY , '" name="dayexpire">' , PHP_EOL;
		for($i=1; $i<=31; $i++) {
			echo '	<option value="' , (strlen($i)>1 ? $i : '0' . $i) , '"' , (date('d') == $i ? ' selected="selected"' : '') , '>' , (strlen($i)>1 ? $i : '0' . $i) , '</option>' , PHP_EOL;
		}
		echo '</select>' , PHP_EOL
		   , '<span class="newssortfiller">.</span>' , PHP_EOL
		   , '<select title="' , _UMONTH , '" name="monthexpire">' , PHP_EOL;
		for($i=1; $i<=12; $i++) {
			echo '	<option value="' , (strlen($i)>1 ? $i : '0' . $i) , '"' , (date('m') == $i ? ' selected="selected"' : '') , '>' , (strlen($i)>1 ? $i : '0' . $i) , '</option>' , PHP_EOL;
		}
		echo '</select>' , PHP_EOL
		   , '<span class="newssortfiller">.</span>' , PHP_EOL
		   , '<select title="' , _TONSORTYEAR , '" name="yearexpire" size="1">' , PHP_EOL;
		for($i=$year_min; $i<=$year_max; $i++) {
			echo '	<option value="' , $i , '"' , (date('Y') == $i ? ' selected="selected"' : '') , '>' , $i , '</option>' , PHP_EOL;
		}
		echo '</select>' , PHP_EOL
		   , '<span class="newssortfiller">-</span>' , PHP_EOL
		   , '<select title="' , _HOUR , '" name="hourexpire">' , PHP_EOL;
		for($i=0; $i<=23; $i++) {
			echo '	<option value="' , (strlen($i)>1 ? $i : '0' . $i) , '"' , (date('H') == $i ? ' selected="selected"' : '') , '>' , (strlen($i)>1 ? $i : '0' . $i) , '</option>' , PHP_EOL;
		}
		echo '</select>' , PHP_EOL
		   , '<span class="newssortfiller">:</span>' , PHP_EOL
		   , '<select title="' , _TONSORTMIN , '" name="minexpire">' , PHP_EOL;
		for($i=0; $i<=59; $i++) {
			echo '	<option value="' , (strlen($i)>1 ? $i : '0' . $i) , '"' , (date('i') == $i ? ' selected="selected"' : '') , '>' , (strlen($i)>1 ? $i : '0' . $i) , '</option>' , PHP_EOL;
		}
		echo '</select>' , PHP_EOL 
		   , '<a href="#ton_expiretime" class="toninfo"><img src="images/news/question.png" alt="Question" /></a>' , PHP_EOL
		   , '	<div class="display-none">' , PHP_EOL
		   , '		<div id="ton_expiretime" class="toncboxinline"><span class="thick">' , _TONEXPTIME , '</span><br /><br />' , _TONEXPTIMEFAQ , '</div>' , PHP_EOL
		   , '	</div>' , PHP_EOL
		   , '</div>' , PHP_EOL;
	}
	if (defined('ADMIN_FILE')) {
	echo '<p><span class="thick">' , _TONSTORYLOCK , '</span>:</p>' , PHP_EOL
	   , '<select name="slock" size="1">' , PHP_EOL;
	for($i=0; $i<=3; $i++) {
	  if ($i!=1) {
		echo '	<option value="' , $i , '">';
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
	   , '<div class="display-none">' , PHP_EOL
	   , '	<div id="ton_storylock" class="toncboxinline"><span class="thick">' , _TONSTORYLOCK , '</span><br /><br />' , _TONSTORYLOCKFAQ , '</div>' , PHP_EOL
	   , '</div>' , PHP_EOL;
	}
	if ($hideautosubmit == 0 || defined('ADMIN_FILE')) {
		echo '</div>' , PHP_EOL;
	}
	if (!defined('ADMIN_FILE')) {
		echo '<input type="hidden" name="slock" value="1" />' , PHP_EOL;
	}	
	echo '<div class="topicmain' , (!defined('ADMIN_FILE') ? ' clear-both' : '') , '">' , PHP_EOL
	   , '<span class="thick">' , _TOPIC , '</span> ' , PHP_EOL;
	$toplist = $db->sql_query('SELECT `topicid`, `topictext` FROM `' . $prefix . '_topics` ORDER BY `topictext`');
	if (!isset($topic)) $topic = '';
	echo '<select id="selecttopic" name="topic">' , PHP_EOL
	   , '	<option value="">' , _SELECTTOPIC , '</option>' , PHP_EOL;
	$topic = (int) $topic;
	while(list($topicid, $topics) = $db->sql_fetchrow($toplist)) {		
		echo '	<option value="' , $topicid , '"' , ($topicid == $topic ? ' selected="selected"' : '') , '>' , htmlspecialchars($topics, ENT_QUOTES, _CHARSET) , '</option>' , PHP_EOL;
	}
	echo '</select>' , PHP_EOL;
	if (defined('ADMIN_FILE')) {
		$asql = 'SELECT `associated` FROM `' . $prefix . '_stories`';
		$aresult = $db->sql_query($asql);
		$arow = $db->sql_fetchrow($aresult);
		$asso_t = explode('-', $arow['associated']);
		$sql = 'SELECT `topicid`, `topictext` FROM `' . $prefix . '_topics` ORDER BY `topictext`';
		$result = $db->sql_query($sql);
		echo '<p><span class="thick">' , _ASSOTOPIC , '</span>: </p>' , PHP_EOL
		   , '<div class="assolistDIV assolist">' , PHP_EOL;
		while ($row = $db->sql_fetchrow($result)) {
			echo '	<label for="asso' , $row['topicid'] , '"><input id="asso' , $row['topicid'] , '" name="assotop[]" type="checkbox" value="' , $row['topicid'] , '"/>' , htmlspecialchars($row['topictext'], ENT_QUOTES, _CHARSET) , '</label>' , PHP_EOL;
		}
		echo '</div>' , PHP_EOL
		   , '	<p class="assolistcheck"><input type="checkbox" id="selectall" />' , _TONSELECTALL , '</p>' , PHP_EOL
		   , '</div>' , PHP_EOL;
		$cat = 0;
		SelectCategory($cat);
		puthome('', '');
	} else {
		echo '</div>' , PHP_EOL;
	}	
	if ($multilingual == 1) {
		echo '<p><span class="thick">' , _LANGUAGE , '</span><br />' , PHP_EOL;
		$lang_content = lang_select_list('alanguage', $language);
		echo $lang_content , '</p>';
	} else {
		echo '<input type="hidden" name="alanguage" value="' , $language , '" />' , PHP_EOL;
	}
	$text = wysiwyg_textarea_html('hometext', '', 'PHPNukeAdmin', '100%', '300px');
	$textext = wysiwyg_textarea_html('bodytext', '', 'PHPNukeAdmin', '100%', '300px');
	if ((isset($advanced_editor) || $advanced_editor == 1) && $TON_useCharLimit == 1) {
		echo '<div' , (!defined('ADMIN_FILE') ? ' class="clear-both"' : '') , ' id="ckcounter">' , PHP_EOL
		   , '	<div class="ckbarcount ckbarmover">' , PHP_EOL
		   , '		<div class="ckbar ckbluebar"></div>' , PHP_EOL
		   , '	</div>' , PHP_EOL
		   , '	<div id="ckcount"></div>' , PHP_EOL
		   , '</div>' , PHP_EOL;
	}
	echo '<p class="thick clear-both">' , _STORYTEXT , '</p>' , PHP_EOL
	   , '<p>' , $text , '</p>' , PHP_EOL
	   , '<p class="thick">' , _EXTENDEDTEXT , '</p>' , PHP_EOL
	   , '<p>' , $textext , '<br /><span class="content">' , _ARESUREURL , '</span></p>' , PHP_EOL
	   , '<p><span class="thick">' ,_TAGSCLOUD, '</span>: ' , PHP_EOL
	   , '<input type="text" name="tags" size="40" maxlength="255" /> <span style="font-size:9px"> (' , _SEPARATEDBYCOMMAS , ')</span></p>' , PHP_EOL;
	if (!defined('ADMIN_FILE') && (!isset($advanced_editor) || $advanced_editor == 0)) {
		echo '<p><span class="thick">' , _ALLOWEDHTML , '</span><br />';
		while (list($key) = each($AllowableHTML)) {
			echo ' &lt;' , $key , '&gt;' , PHP_EOL;
		}
		echo '</p>' , PHP_EOL;
	}
	if (defined('ADMIN_FILE')) {
		echo '<p><select name="op">' , PHP_EOL
		   , '	<option value="PreviewAdminStory" selected="selected">' , _PREVIEWSTORY , '</option>' , PHP_EOL
		   , '	<option value="PostAdminStory">' , _POSTSTORY , '</option>' , PHP_EOL
		   , '</select>' , PHP_EOL
		   , '<input type="submit" style="cursor:pointer;" value="' , _OK , '" /></p>' , PHP_EOL;
		if (!isset($pollTitle) OR !isset($optionText)) {
			putpoll('', array_fill(1, 12, ''));
		} else {
			putpoll($pollTitle, $optionText);
		}
	} else {
		echo '<input type="hidden" name="op" value="PreviewAdminStory" />' , PHP_EOL
		   , '<input type="submit" style="cursor:pointer;" value="' , _PREVIEWSTORY , '" />' , PHP_EOL;		
	}
   echo '</form>' , PHP_EOL;
   CloseTable();
	include_once 'footer.php';
}

function previewAdminStory($automated, $automated2, $year, $day, $month, $hour, $min, $subject, $hometext, $bodytext, $tags, $topic, $catid, $ihome, $alanguage, $acomm, $pollTitle, $optionText, $assotop, $yearselect, $monthselect, $dayselect, $hourselect, $minselect, $secselect, $yearexpire, $monthexpire, $dayexpire, $hourexpire, $minexpire, $slock) {
	global $user, $bgcolor1, $bgcolor2, $prefix, $db, $alanguage, $multilingual, $admin_file, $language, $ThemeSel, $advanced_editor, $module_name, $modGFXChk;
	if ($subject == '') {
		include_once 'header.php';
		OpenTable();
		echo '<div class="text-center">' , PHP_EOL
		   , ' <span class="thick">ERROR</span>' , PHP_EOL
		   , '<br />' , PHP_EOL
		   , _TONNOTTILE , PHP_EOL
		   , '<br /><br />' , PHP_EOL
		   , '[ <a href="javascript:history.go(-2)">' , _TONGOBACK , '</a> ]' , PHP_EOL
		   , '<br /><br />' , PHP_EOL
		   , '</div>' , PHP_EOL;
		CloseTable();
		include_once 'footer.php';
		exit;	
	}
	$tonquery = $db->sql_query('SELECT `newsyearmin`, `newsyearmax`, `hideautotimes`, `hideautosubmit`, `jqueryselect`, `previewstory`, `TON_useCharLimit`, `TON_CharLimit` FROM `' . $prefix . '_ton`');
	list($newsyearmin, $newsyearmax, $hideautotimes, $hideautosubmit, $jqueryselect, $previewstory, $TON_useCharLimit, $TON_CharLimit) = $db->sql_fetchrow($tonquery);
	if ($jqueryselect == 1 && !file_exists('themes/' . $ThemeSel . '/style/NewsAdmin.css')) {
		addCSSToHead('modules/' . $module_name . '/css/jquery.multiselect.css', 'file');
	}
	if ($jqueryselect == 1) {
		addJSToBody('includes/jquery/jquery-ui.min.js', 'file');
		addJSToBody('modules/' . $module_name . '/js/jquery.multiselect.min.js', 'file');
		addJSToBody('modules/' . $module_name . '/js/jquery.multiselect.filter.js', 'file');
		$selector = '<script type="text/javascript">' . PHP_EOL
				  . '$("#selecttopic").multiselect({multiple: false, header: true, selectedList: 1});' . PHP_EOL
				  . '$("#selecttopic").multiselect().multiselectfilter();' . PHP_EOL
				  . '  </script>' . PHP_EOL;
		addJSToBody($selector,'inline');
	}
	$assochecklist = '<script type="text/javascript">$(\'#selectall\').click(function() {$(\'input[type="checkbox"]\').attr(\'checked\', $(\'#selectall\').is(\'":checked\'));})</script>' . PHP_EOL;
	addJSToBody($assochecklist,'inline');
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
				   . '		jQuery(\'#ckcount\').html(count).removeClass(\'ckred\');' . PHP_EOL
				   . '		jQuery(\'.ckbar\').animate({"width": value+\'%\'}, 1).removeClass(\'ckredbar\').addClass(\'ckbluebar\');' . PHP_EOL
				   . '	} else {' . PHP_EOL
				   . '		jQuery(\'#ckcount\').html(count).addClass(\'ckred\');' . PHP_EOL
				   . '		jQuery(\'.ckbar\').animate({"width": \'100%\'}, 1).removeClass(\'ckbluebar\').addClass(\'ckredbar\');' . PHP_EOL
				   . '	}' . PHP_EOL
				   . '}' . PHP_EOL
				   . '</script>' . PHP_EOL;
		addJSToBody($ckcounter,'inline');
	}
	include_once 'header.php';
	if ($topic<1) {
		$topic = 0;
	}
	$sel = '';
	if (defined('ADMIN_FILE')) {
		GraphicAdmin();
	}
	OpenTable();
	if (defined('ADMIN_FILE')) {
		echo '<div class="text-center title">' , _ARTICLEADMIN , '</div>' , PHP_EOL
		   , '<br />' , PHP_EOL
		   , '<form action="' , $admin_file , '.php" method="post">' , PHP_EOL
		   , '<div class="text-center option">' , _PREVIEWSTORY , '</div>' , PHP_EOL;
	} else {
		echo '<form action="modules.php?name=Submit_News" method="post">' , PHP_EOL;
	}
	echo '<input type="hidden" name="catid" value="' , $catid , '" />' , PHP_EOL;
	$subject = htmlspecialchars(htmlspecialchars_decode(check_html($subject, 'nohtml'), ENT_QUOTES), ENT_QUOTES, _CHARSET);
	$hometext = check_html($hometext, '');
	$bodytext = check_html($bodytext, '');
	$topic = (int) $topic;
	$result=$db->sql_query('SELECT `topicimage` FROM `' . $prefix . '_topics` WHERE `topicid` = \'' . $topic . '\'');
	list($topicimage) = $db->sql_fetchrow($result);
	echo ($previewstory == 1 ? '<a href="#ton_preview" class="tonpreview tonpressme">' . _PREVIEWSTORY . '</a>' . PHP_EOL : '')
	   , '<div' , ($previewstory == 1 ? ' class="display-none"' : '') , '>' , PHP_EOL
	   , '	<div id="ton_preview" class="themepreview" style="border-color:' , $bgcolor2 , '; background-color:' , $bgcolor1 , ';">' , PHP_EOL
	   , '		<img src="images/topics/' , $topicimage , '" border="0" align="right" class="themepreviewpic" alt="" />' , PHP_EOL;
	themepreview($subject, $hometext, $bodytext);
	echo '	</div>' , PHP_EOL
	   , '</div>' , PHP_EOL
	   , '<p><span class="thick">' , _TITLE , ' </span></p>' , PHP_EOL
	   , '<input type="text" name="subject" size="50" value="' , $subject , '" /><br />' , PHP_EOL;
	if ($hideautosubmit == 0 || defined('ADMIN_FILE')) {
		$now = date('d.m.Y H:i:s');
		$date = date('Y-m-d H:i:s');
		if ($automated == 0 || $automated2 == 0) {	
			preg_match('/(.*)?-(.*)?-(.*)? (.*)?:(.*)?:(.*)?/', $date, $matchtdate);
		}
		if ($automated == 0) {
			$year = $matchtdate[1];
			$month = $matchtdate[2];
			$day = $matchtdate[3];
			$hour = '00';
			$min = '00';
			$sec = '00';
		}
		if ($automated2 == 0) {
			$yearexpire = $matchtdate[1];
			$monthexpire = $matchtdate[2];
			$dayexpire = $matchtdate[3];
			$hourexpire = '00';
			$minexpire = '00';	
			$secexpire = '00';
		}
		$year_range_min = $newsyearmin;
		$year_range_max = $newsyearmax;
		$yearcheck = array();
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
		$expiretime = $yearexpire . '-' . $monthexpire . '-' . $dayexpire . ' ' . $hourexpire . ':' . $minexpire . ':00';	
		if ($date >= $expiretime) {
			$expirecheck1 = '';
			$expirecheck0 = ' checked="checked"';
			$hideclass2 = ($hideautotimes == 1 ? 'display-none' : '');
		} else {  
			$expirecheck1 = ' checked="checked"';
			$expirecheck0 = '';
			$hideclass2 = ($hideautotimes == 1 && $date >= $expiretime ? 'display-none' : '');
		}
		echo '<div class="newssort">' , PHP_EOL;
	}
	if (defined('ADMIN_FILE')) {
		echo '<p><span class="thick">' , _TONSORTTIME , '</span>:</p>' , PHP_EOL
		   , '<select title="' , _DAY , '" name="dayselect" size="1">' , PHP_EOL;
		for($i=1; $i<=31; $i++) {
			echo '	<option value="' , (strlen($i)>1 ? $i : '0' . $i) , '"' , ($dayselect == $i ? ' selected="selected"' : '') , '>' , (strlen($i)>1 ? $i : '0' . $i) , '</option>' , PHP_EOL;
		}
		echo '</select>' , PHP_EOL
		   , '<span class="newssortfiller">.</span>' , PHP_EOL
		   , '<select title="' , _UMONTH , '" name="monthselect" size="1">' , PHP_EOL;
		for($i=1; $i<=12; $i++) {
			echo '	<option value="' , (strlen($i)>1 ? $i : '0' . $i) , '"' , ($monthselect == $i ? ' selected="selected"' : '') , '>' , (strlen($i)>1 ? $i : '0' . $i) , '</option>' , PHP_EOL;
		}
		echo '</select>' , PHP_EOL
		   , '<span class="newssortfiller">.</span>' , PHP_EOL;
		echo '<select title="' , _TONSORTYEAR , '" name="yearselect" size="1">' , PHP_EOL;
		for($i=$year_min; $i<=$year_max; $i++) {
			echo '	<option value="' , $i , '"' , ($yearselect == $i ? ' selected="selected"' : '') , '>' , $i , '</option>' , PHP_EOL;
		}
		echo '</select>' , PHP_EOL
		   , '<span class="newssortfiller">-</span>' , PHP_EOL
		   , '<select title="' , _HOUR , '" name="hourselect" size="1">' , PHP_EOL;
		for($i=0; $i<=23; $i++) {
			echo '	<option value="' , (strlen($i)>1 ? $i : '0' . $i) , '"' , ($hourselect == $i ? ' selected="selected"' : '') , '>' , (strlen($i)>1 ? $i : '0' . $i) , '</option>' , PHP_EOL;
		}
		echo '</select>' , PHP_EOL
		   , '<span class="newssortfiller">:</span>' , PHP_EOL
		   , '<select title="' , _TONSORTMIN , '" name="minselect" size="1">' , PHP_EOL;
		for($i=0; $i<=59; $i++) {
			echo '	<option value="' , (strlen($i)>1 ? $i : '0' . $i) , '"' , ($minselect == $i ? ' selected="selected"' : '') , '>' , (strlen($i)>1 ? $i : '0' . $i) , '</option>' , PHP_EOL;
		}
		echo '</select>' , PHP_EOL
		   , '<span class="newssortfiller">:</span>' , PHP_EOL
		   , '<select title="' , _TONSORTSEC , '" name="secselect" size="1">' , PHP_EOL;
		for($i=0; $i<=59; $i++) {
			echo '	<option value="' , (strlen($i)>1 ? $i : '0' . $i) , '"' , ($secselect == $i ? ' selected="selected"' : '') , '>' , (strlen($i)>1 ? $i : '0' . $i) , '</option>' , PHP_EOL;
		}
		echo '</select>' , PHP_EOL
		   , '<a href="#ton_sorttime" class="toninfo"><img src="images/news/question.png" alt="Question" /></a>' , PHP_EOL
		   , '<div class="display-none">' , PHP_EOL
		   , '	<div id="ton_sorttime" class="toncboxinline"><span class="thick">' , _TONSORTTIME , '</span><br /><br />' , _TONSORTTIMEFAQ , '</div>' , PHP_EOL
		   , '</div>' , PHP_EOL;
	}
	if ($hideautosubmit == 0 || defined('ADMIN_FILE')) {
		$postingtime = $year . '-' . $month . '-' . $day . ' ' . $hour . ':' . $min . ':00';
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
		   , '	<span class="thick">' , _TONAUTOTIME , '</span>: ' , PHP_EOL
		   , '	<input type="radio" name="automated" value="1"' , $autocheck1 , ' />' , _YES , ' &nbsp;&nbsp;' , PHP_EOL
		   , '	<input type="radio" name="automated" value="0"' , $autocheck0 , ' />' , _NO , PHP_EOL
		   , '</p>' , PHP_EOL
		   , '<p><span class="thick">' , _NOWIS , '</span>: ' , $now , '</p>' , PHP_EOL	 
		   , ($date >= $postingtime && $automated == 1 ? '<p>' . _TONEXPOLDTIME . '</p>' . PHP_EOL : '')
		   , '<div id="autopost" class="' , $hideclass , '">' , PHP_EOL
		   , '<select title="' , _DAY , '" name="day">' , PHP_EOL;
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
			echo '	<option value="' , $i , '"' , ($yearselect == $i ? ' selected="selected"' : '') , '>' , $i , '</option>' , PHP_EOL;
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
		   , '<div class="display-none">' , PHP_EOL
		   , '	<div id="ton_posttime" class="toncboxinline"><span class="thick">' , _TONAUTOTIME , '</span><br /><br />' , _TONAUTOPOSTTIMEFAQ , '</div>' , PHP_EOL
		   , '</div>' , PHP_EOL
		   , '</div>' , PHP_EOL;
	
		echo '<p><span class="thick">' , _TONEXPTIME , '</span>: ' , PHP_EOL
		   , '<input type="radio" name="automated2" value="1"' , $expirecheck1 , ' />' , _YES , ' &nbsp;&nbsp;' , PHP_EOL
		   , '<input type="radio" name="automated2" value="0"' , $expirecheck0 , ' />' , _NO , PHP_EOL
		   , '</p>' , PHP_EOL
		   , ($date >= $expiretime && $automated2 == 1 ? '<p>' . _TONEXPOLDTIME . '</p>' . PHP_EOL : '')
		   , '<div id="expire" class="' , $hideclass2 , '">' , PHP_EOL
		   , '<select title="' , _DAY , '" name="dayexpire">' , PHP_EOL;
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
		   , '</div>' , PHP_EOL;	
		if (defined('ADMIN_FILE')) {
			echo '<p><span class="thick">' , _TONSTORYLOCK , '</span>:</p>' , PHP_EOL
			   , '<select name="slock" size="1">' , PHP_EOL;
			for($i=0; $i<=3; $i++) {
				if ($i!=1) {
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
			   , '<div class="display-none">' , PHP_EOL
			   , '	<div id="ton_storylock" class="toncboxinline"><span class="thick">' , _TONSTORYLOCK , '</span><br /><br />' , _TONSTORYLOCKFAQ , '</div>' , PHP_EOL
			   , '</div>' , PHP_EOL;
		}
	}
	if ($hideautosubmit == 0 || defined('ADMIN_FILE')) {
		echo '</div>' , PHP_EOL;
	}
	if (!defined('ADMIN_FILE')) {
		echo '<input type="hidden" name="slock" value="1" />' , PHP_EOL;
	}
	echo '<div class="topicmain' , (!defined('ADMIN_FILE') ? ' clear-both' : '') , '">' , PHP_EOL
	   , '<span class="thick">' , _TOPIC , '</span> ' , PHP_EOL;
	$toplist = $db->sql_query('SELECT `topicid`, `topictext` FROM `' . $prefix . '_topics` ORDER BY `topictext`');
	if (!isset($topic)) $topic='';
	echo '<select id="selecttopic" name="topic">' , PHP_EOL
	   , '	<option value="">' , _ALLTOPICS , '</option>' , PHP_EOL;
	while(list($topicid, $topics) = $db->sql_fetchrow($toplist)) {
		echo '	<option value="' , $topicid , '"' , ($topicid == $topic ? ' selected="selected"' : '') , '>' , htmlspecialchars($topics, ENT_QUOTES, _CHARSET) , '</option>' , PHP_EOL;
	}
	echo '</select>' , PHP_EOL;	
	if (defined('ADMIN_FILE')) {	
		$associated = '';
		if (!empty($assotop)) {
			$j = sizeof($assotop);
			for ($i=0; $i<$j; ++$i) {
				$associated .= $assotop[$i] . '-';
			}
		}
		$asso_t = explode('-', $associated);
		echo '<p><span class="thick">' , _ASSOTOPIC , '</span>: </p>' , PHP_EOL
		   , '<div class="assolistDIV assolist">' , PHP_EOL;
		$result = $db->sql_query('SELECT `topicid`, `topictext` FROM `' . $prefix . '_topics` ORDER BY `topictext`');	
		while ($row = $db->sql_fetchrow($result)) {
			$checked = '';
			for ($i=0; $i<sizeof($asso_t); $i++) {
				if ($asso_t[$i] == $row['topicid']) {
					$checked = ' checked="checked"';
					break;
				}
			}
			echo '	<label for="asso' , $row['topicid'] , '"><input id="asso' , $row['topicid'] , '" name="assotop[]" type="checkbox" value="' , $row['topicid'] , '"' , $checked , '/>' , htmlspecialchars($row['topictext'], ENT_QUOTES, _CHARSET) , '</label>' , PHP_EOL;
		}
		echo '</div>' , PHP_EOL
		   , '	<p class="assolistcheck"><input type="checkbox" id="selectall" />' , _TONSELECTALL , '</p>' , PHP_EOL
		   , '</div>' , PHP_EOL;
		$cat = $catid;
		SelectCategory($cat);
		puthome($ihome, $acomm);
	} else {
		echo '</div>' , PHP_EOL;
	}
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
	}
	$text = wysiwyg_textarea_html('hometext', $hometext, 'PHPNukeAdmin', '100%', '300px');
	$textext = wysiwyg_textarea_html('bodytext', $bodytext, 'PHPNukeAdmin', '100%', '300px');
	if (isset($advanced_editor) || $advanced_editor == 1 && $TON_useCharLimit == 1) {
		echo '<div' , (!defined('ADMIN_FILE') ? ' class="clear-both"' : '') , ' id="ckcounter">' , PHP_EOL
		   , '	<div class="ckbarcount ckbarmover">' , PHP_EOL
		   , '		<div class="ckbar ckbluebar"></div>' , PHP_EOL
		   , '	</div>' , PHP_EOL
		   , '	<div id="ckcount"></div>' , PHP_EOL
		   , '</div>' , PHP_EOL;
	}
	echo '<p class="thick clear-both">' , _STORYTEXT , '</p>' , PHP_EOL
	   , '<p>' , $text , '</p>' , PHP_EOL
	   , '<p class="thick">' , _EXTENDEDTEXT , '</p>' , PHP_EOL
	   , '<p>' , $textext , '<br /><span class="content">' , _ARESUREURL , '</span></p>' , PHP_EOL
	   , '<p>' ,_TAGSCLOUD, ': <input type="text" name="tags" value="' , htmlspecialchars($tags, ENT_QUOTES, _CHARSET) , '" size="40" maxlength="255" /> <span style="font-size:9px">(' , _SEPARATEDBYCOMMAS , ')</span></p>' , PHP_EOL;
    if (defined('ADMIN_FILE')) {
		echo '<p><select name="op">' , PHP_EOL
		   , '	<option value="PreviewAdminStory" selected="selected">' , _PREVIEWSTORY , '</option>' , PHP_EOL
		   , '	<option value="PostAdminStory">' , _POSTSTORY , '</option>' , PHP_EOL
		   , '</select>' , PHP_EOL
		   , '<input type="submit" style="cursor:pointer;" value="' , _OK , '" /></p>' , PHP_EOL
		   , '<br />' , PHP_EOL;
		   putpoll($pollTitle, $optionText);
	} else {
		echo security_code($modGFXChk[$module_name], 'stacked')
		   , '<input type="hidden" name="op" value="PostAdminStory" />' , PHP_EOL
		   , '<input type="submit" style="cursor:pointer;" value="' , _POSTSTORY , '" />' , PHP_EOL;		
	} 
    echo '</form>' , PHP_EOL;
CloseTable();
	if (($hideautotimes == 1 &&  $hideautosubmit == 0) || ($hideautotimes == 1 && defined('ADMIN_FILE'))) {
		$radioswitsch  = '<script type="text/javascript">' . PHP_EOL;
		if ($date >= $postingtime) {
			$radioswitsch .= '	$(\'input[name="automated"]\').bind("change",function() {var showOrHide = ($(this).val() == 1) ? true : false; $(\'#autopost\').removeClass(\'display-none\').toggle(showOrHide);});' . PHP_EOL;
		} elseif ($date <= $postingtime) {
			$radioswitsch .= '	$(\'input[name="automated"]\').bind("change",function() {var showOrHide = ($(this).val() == 1) ? true : false; $(\'#autopost\').removeClass(\'display-none\').toggle(showOrHide);});' . PHP_EOL;
		}
		if ($date >= $expiretime) {
			$radioswitsch .= '	$(\'input[name="automated2"]\').bind("change",function() {var showOrHide = ($(this).val() == 1) ? true : false; $(\'#expire\').toggle(showOrHide);});' . PHP_EOL;
		} elseif ($date <= $expiretime) {
			$radioswitsch .= '	$(\'input[name="automated2"]\').bind("change",function() {var showOrHide = ($(this).val() == 1) ? true : false; $(\'#expire\').removeClass(\'display-none\').toggle(showOrHide);});' . PHP_EOL;
		}
		$radioswitsch .= '</script>' . PHP_EOL;
		addJSToBody($radioswitsch,'inline');
	}
    include_once 'footer.php';
}

function postAdminStory($automated, $automated2, $year, $day, $month, $hour, $min, $subject, $hometext, $bodytext, $tags, $topic, $catid, $ihome, $alanguage, $acomm, $pollTitle, $optionText, $assotop, $yearselect, $monthselect, $dayselect, $hourselect, $minselect, $secselect, $yearexpire, $monthexpire, $dayexpire, $hourexpire, $minexpire, $slock) {
	global $aid, $db, $prefix, $admin_file, $nuke_config, $user, $anonymous, $modGFXChk, $AllowableHTML, $module_name;
	# php7 fix
	if ($topic == '' || !is_numeric($topic)) {
		$topic = 1;
	}
	if ($subject == '') {
		include_once 'header.php';
		OpenTable();
		echo '<div class="text-center">' , PHP_EOL
		   , ' <span class="thick">ERROR</span>' , PHP_EOL
		   , '<br />' , PHP_EOL
		   , _TONNOTTILE , PHP_EOL
		   , '<br /><br />' , PHP_EOL
		   , '[ <a href="javascript:history.go(-2)">' , _TONGOBACK , '</a> ]' , PHP_EOL
		   , '<br /><br />' , PHP_EOL
		   , '</div>' , PHP_EOL;
		CloseTable();
		include_once 'footer.php';
		exit;	
	}
	if (!defined('ADMIN_FILE')) {
		include_once 'header.php';
		OpenTable();
		$gfx_check = isset($_POST['gfx_check']) ? $_POST['gfx_check'] : '';
		if (!security_code_check($gfx_check, $modGFXChk[$module_name])) {
			echo '<div class="text-center"><span class="option thick italic">' , _SECCODEINCOR , '</span><br /><br />'
			   , '[ <a href="javascript:history.go(-2)">' , _GOBACK2 , '</a> ]</div>';
			CloseTable();
			include_once 'footer.php';
			die();
		}	
		if (is_user($user)) {
			$userinfo = getusrinfo($user);
			$uid = $userinfo['user_id'];
			$informant = $db->sql_escape_string($userinfo['username']);
		} else {
			$uid = 1;
			$informant = $db->sql_escape_string($anonymous);
		}
	}
	$associated = '';
	if (!empty($assotop)) {
		$j = sizeof($assotop);
		for ($i=0; $i<$j; ++$i) {
			$associated .= $assotop[$i] . '-';
		}
	}
	if ($slock != 1 && defined('ADMIN_FILE')) {
		$aid = $db->sql_escape_string($aid);
		$informant = $aid;
	} elseif ($slock == 1 && !defined('ADMIN_FILE')) {
		$aid = '';
	}
	$subject = $db->sql_escape_string(htmlspecialchars_decode(check_html($subject, 'nohtml'), ENT_QUOTES));
	$hometext = $db->sql_escape_string(check_html($hometext, ''));
	$bodytext = $db->sql_escape_string(check_html($bodytext, ''));
	$now = date('Y-m-d H:i:s');
	$today = date('Y-m-d H:i:00');
	$postingtime = $year . '-' . $month . '-' . $day . ' ' . $hour . ':' . $min . ':00';
	$expiretime = $yearexpire . '-' . $monthexpire . '-' . $dayexpire . ' ' . $hourexpire . ':' . $minexpire . ':00';
	$time2 = $yearselect . '-' . $monthselect . '-' . $dayselect . ' ' . $hourselect . ':' . $minselect . ':' . $secselect;
	if ($postingtime >= $today && $slock == 1 && $automated == 1) {
		$timecheck = 1;	
	} elseif ($postingtime <= $today && $slock == 2 && $automated == 1) {
		$slock = 3;
		$timecheck = 0;
	} elseif ($postingtime >= $today && $slock == 2 && $automated == 1) {
		$timecheck = 1;	
	} elseif (($postingtime <= $today || $postingtime >= $today) && $slock == 3 && $automated == 1) {
		$timecheck = 1;
	} else {
		$timecheck = 0;
	}
	if ($automated2 == 1 && $expiretime >= $now) {
		$expireheck = 1;
	} elseif ($automated2 == 1 && $expiretime <= $now) {
		$expireheck = 0;
	} else {
		$expiretime = '';
		$expireheck = 1;
	}
	if ($timecheck == 1) {
		$time = $db->sql_escape_string($postingtime);
	} else {
		$time = $now;
	}
	if ($time2 != $now) {
		$time2 = $db->sql_escape_string($time2);
	} else {
		$time2 = $now;
	}
	if ($expireheck == 1) {
		$time3 = $db->sql_escape_string($expiretime);
	} else {
		$time3 = '';
	}

	if (($pollTitle != '') AND ($optionText[1] != '') AND ($optionText[2] != '')) {
		$haspoll = 1;
		$timeStamp = time();
		$pollTitle = $db->sql_escape_string(htmlspecialchars_decode(check_html($pollTitle, 'nohtml'),ENT_QUOTES));
		if (!$db->sql_query('INSERT INTO `' . $prefix . '_poll_desc` '."VALUES (NULL, '$pollTitle', '$timeStamp', 0, '$alanguage', 0)")) {
			return;
		}
		$object = $db->sql_fetchrow($db->sql_query('SELECT `pollID` FROM `' . $prefix . '_poll_desc` WHERE `pollTitle` = \'' . $pollTitle . '\''));
		$id = $object['pollID'];
		$id = intval($id);
		for($i = 1; $i <= sizeof($optionText); $i++) {
			if (!empty($optionText[$i])) {
				$optionText[$i] = $db->sql_escape_string(htmlspecialchars_decode(check_html($optionText[$i], 'nohtml'),ENT_QUOTES));
			}
			if (!$db->sql_query('INSERT INTO `' . $prefix . '_poll_data` (`pollID`, `optionText`, `optionCount`, `voteID`) '."VALUES ('$id', '$optionText[$i]', 0, '$i')")) {
				return;
			}
		}
	} else {
		$haspoll = 0;
		$id = 0;
	}
	$sql = 'INSERT INTO `' . $prefix . '_stories` VALUES(NULL, \'' . $catid . '\', \'' . $aid . '\', \'' . $subject . '\', \'' . $time . '\', \'' . $hometext . '\', \'' . $bodytext . '\', 0, 0, \'' . $topic . '\', \'' . $informant . '\', \'\', \'' . $ihome . '\', \'' . $alanguage . '\',
	\'' . $acomm . '\', \'' . $haspoll . '\', \'' . $id . '\', 0, 0, \'' . $associated . '\', \'' . $time2 . '\', ';
	# php7 fix
	if ($time3 != '') {
		$sql .= '\'' . $time3  . '\'';
	} else {
		$sql .= 'NULL';
	}
	$sql .= ', \'' . $slock . '\')';
	$result = $db->sql_query($sql);
	if ($tags!='') { // tag cloud start
		$row = $db->sql_fetchrow($db->sql_query('SELECT `sid` FROM `' . $prefix . '_stories` ORDER BY `sid` DESC LIMIT 1'));
		$lastid = intval($row['sid']);
		$tags = explode(',',$tags);
		foreach ($tags as $tag) {
			$tag = $db->sql_escape_string(htmlspecialchars_decode(check_html($tag, 'nohtml'), ENT_QUOTES));
			$db->sql_query('INSERT INTO `' . $prefix . '_tags` (`tag`,`cid`,`whr`) VALUES '."('".trim($tag)."','$lastid','3')".'');
		}
	} // tag cloud end
	if (defined('ADMIN_FILE')) {
		$result = $db->sql_query('SELECT `sid` FROM `' . $prefix . '_stories` WHERE `title` = \'' . $subject . '\' ORDER BY `time` DESC LIMIT 0,1');
		list($artid) = $db->sql_fetchrow($result);
		if ($id > 0) {
			$db->sql_query('UPDATE `' . $prefix . '_poll_desc` SET `artid` = ' . $artid . ' WHERE `pollID` = \'' . $id . '\'');
		}
		if (!$result) {
			exit();
		}
		
		$result = $db->sql_query('UPDATE `' . $prefix . '_authors` SET `counter` = `counter` + 1 WHERE `aid` = \'' . $aid . '\'');
		Header('Location: ' . $admin_file . '.php?op=newsarchive' . ($topic > 0 ? '&topicsel=' . $topic : '')); exit;
	} else {
		if($nuke_config['notify']) {
			$notify_message =  "\n\n\n" . '========================================================' . "\n\n" . $subject . "\n\n\n" . $hometext . "\n\n" . $bodytext . "\n\n" . $informant;
			$mailsuccess = false;
			if (defined('TNML_IS_ACTIVE') and validate_mail($nuke_config['notify_from']) !== false) {
				$mailsuccess = tnml_fMailer($nuke_config['notify_email'], $nuke_config['notify_subject'], $notify_message, $nuke_config['notify_from'], $nuke_config['sitename']);
			} else {
				$mailsuccess = mail($nuke_config['notify_email'], $nuke_config['notify_subject'], $notify_message, 'From: ' . $nuke_config['sitename'] . ' <' . $nuke_config['notify_from'] . '>' . "\n\n" . 'X-Mailer: PHP/' . phpversion());
			}
		}
		$waiting = $db->sql_numrows($db->sql_query('SELECT * FROM `' . $prefix . '_stories` WHERE `slock` = 1'));
		echo '<div class="text-center"><p class="title">' , _SUBSENT , '</p></div>' , PHP_EOL
			, '<div class="content text-center"><p class="thick">' , _THANKSSUB , '</p>' . PHP_EOL
			, '<p>' , _SUBTEXT , '</p>' , PHP_EOL
			, '<p>' , _WEHAVESUB , ' ' , $waiting , ' ' , _WAITING , '</p>' , PHP_EOL
			, '<p>[ <a href="modules.php?name=Submit_News">' , _GOBACK2 , '</a> ]</p>' , PHP_EOL
			, '</div>' , PHP_EOL;
		CloseTable();	
		include_once 'footer.php';
	}
}