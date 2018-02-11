<?php
/**
 * @PHP-NUKE: Web Portal System
 * @package Tricked Out News
 * @version 2.6 (RN News-Mod)
 * @file: config.php (admin)
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

function newsedit() {
	global $prefix, $db, $admin_file, $tnsl_bAutoTapLinks, $tnsl_bUseShortLinks;
	include_once 'header.php';
	GraphicAdmin();
	$result = $db->sql_query('SELECT `newsrows`, `bookmark`, `rblocks`, `linklocation`, `articlelink`, `artview`, `TON_useTitleLink`, `TON_usePDF`, `TON_useRating`, `TON_useSendToFriend`, `showtags`, `TON_useCharLimit`, `TON_CharLimit`, `topadact`, `topad`, `bottomadact`, `bottomad`, `usedisqus`, `shortname`, `googlapi`, `usegooglsb`, `usegooglart`, `newssort`, `newsorder`, `newsyearmin`, `newsyearmax`, `hideautotimes`, `previewstory`, `hideautosubmit`, `archivedefault`, `archivetopics`, `jqueryselect`, `archive_charlimit`, `counttopic`, `counttitle`, `usenotes` FROM `' . $prefix . '_ton`');
	list($newsrows, $bookmark, $rblocks, $linklocation, $articlelink, $artview, $TON_useTitleLink, $TON_usePDF, $TON_useRating, $TON_useSendToFriend, $showtags, $TON_useCharLimit, $TON_CharLimit, $topadact, $topad, $bottomadact, $bottomad, $usedisqus, $shortname, $googlapi, $usegooglsb, $usegooglart, $newssort, $newsorder, $newsyearmin, $newsyearmax, $hideautotimes, $previewstory, $hideautosubmit,  $archivedefault, $archivetopics, $jqueryselect, $archive_charlimit, $counttopic, $counttitle, $usenotes) = $db->sql_fetchrow($result);
	OpenTable();
		echo '<div class="text-center title thick">' , _TONCONFIG , '</div>' , PHP_EOL
		   , '<div class="text-center option thick">' , _TONSETUP , '</div>' , PHP_EOL
		   , '<br /><br />' , PHP_EOL
		   , '<form action="' , $admin_file , '.php" method="post">' , PHP_EOL
		   , '<table border="0" class="centered">' , PHP_EOL
		   , '<tr>' , PHP_EOL
		   , '	<td>' , _NEWSROWS , ':</td>' , PHP_EOL
		   , '	<td>' , PHP_EOL
		   , '		<select name="newsrows">' , PHP_EOL;
	for($i=1; $i<=2; $i++) {
		echo '			<option value="' , $i , '"' , ($newsrows == $i ? ' selected="selected"' : '') , '>' , ($i == 2 ? _YES : _NO) , '</option>' , PHP_EOL;
	}
		echo '		</select>' , PHP_EOL
		   , '	</td>' , PHP_EOL
		   , '</tr>' , PHP_EOL
		   , '<tr>' , PHP_EOL
		   , '	<td>' , _BOOKMARK , ':</td>' , PHP_EOL
		   , '	<td>' , PHP_EOL
		   , '		<select name="bookmark">' , PHP_EOL;
	for($i=0; $i<=1; $i++) {
		echo '			<option value="' , $i , '"' , ($bookmark == $i ? ' selected="selected"' : '') , '>' , ($i == 1 ? _YES : _NO) , '</option>' , PHP_EOL;
	}
		echo '		</select>' , PHP_EOL
		   , '	</td>' , PHP_EOL
		   , '</tr>' , PHP_EOL
		   , '<tr>' , PHP_EOL
		   , '	<td>' , _RBLOCKS , ':</td>' , PHP_EOL
		   , '	<td>' , PHP_EOL
		   , '		<select name="rblocks">' , PHP_EOL;
	for($i=0; $i<=1; $i++) {
		echo '			<option value="' , $i , '"' , ($rblocks == $i ? ' selected="selected"' : '') , '>' , ($i == 1 ? _YES : _NO) , '</option>' , PHP_EOL;
	}
		echo '		</select>' , PHP_EOL
		   , '	</td>' , PHP_EOL
		   , '</tr>' , PHP_EOL
		   , '<tr>' , PHP_EOL
		   , '	<td>' , _LINKLOCATION , ':</td>' , PHP_EOL
		   , '	<td>' , PHP_EOL
		   , '		<select name="linklocation">' , PHP_EOL
		   , '			<option>' , $linklocation , '</option>' , PHP_EOL;
	if ($linklocation == 'bottom') {
		echo '			<option>top</option>' , PHP_EOL;
	}else{
		echo '			<option>bottom</option>' , PHP_EOL;
	}
		echo '		</select>' , PHP_EOL
		   , '	</td>' , PHP_EOL
		   , '</tr>' , PHP_EOL
		   , '<tr>' , PHP_EOL
		   , '	<td>' , _ARTICLELINK , ':</td>' , PHP_EOL
		   , '	<td>' , PHP_EOL
		   , '		<select name="articlelink">' , PHP_EOL;
	for($i=0; $i<=1; $i++) {
		echo '			<option value="' , $i , '"' , ($articlelink == $i ? ' selected="selected"' : '') , '>' , ($i == 1 ? _YES : _NO) , '</option>' , PHP_EOL;
	}
		echo '	</select>' , PHP_EOL
		   , '	</td>' , PHP_EOL
		   , '</tr>' , PHP_EOL
		   , '<tr>' , PHP_EOL
		   , '	<td>' , _ARTVIEW , ':</td>' , PHP_EOL
		   , '	<td>' , PHP_EOL
		   , '		<select name="artview">' , PHP_EOL
		   , '			<option>' , $artview , '</option>' , PHP_EOL;
	if ($artview == 'old') {
		echo '			<option>new</option>' , PHP_EOL;
	}else{
		echo '			<option>old</option>' , PHP_EOL;
	}
		echo '	</select>' , PHP_EOL
		   , '	</td>' , PHP_EOL
		   , '</tr>' , PHP_EOL
		   , '<tr>' , PHP_EOL
		   , '	<td>' , _TONUTL , ':</td>' , PHP_EOL
		   , '	<td>' , PHP_EOL
		   , '		<select name="TON_useTitleLink">' , PHP_EOL;
	for($i=0; $i<=1; $i++) {
		echo '			<option value="' , $i , '"' , ($TON_useTitleLink == $i ? ' selected="selected"' : '') , '>' , ($i == 1 ? _YES : _NO) , '</option>' , PHP_EOL;
	}
		echo '	</select>' , PHP_EOL
		   , '	</td>' , PHP_EOL
		   , '</tr>' , PHP_EOL
		   , '<tr>' , PHP_EOL
		   , '	<td>' , _TONPDF , ':</td>' , PHP_EOL
		   , '	<td>' , PHP_EOL
		   , '		<select name="TON_usePDF">' , PHP_EOL;
	for($i=0; $i<=1; $i++) {
		echo '			<option value="' , $i , '"' , ($TON_usePDF == $i ? ' selected="selected"' : '') , '>' , ($i == 1 ? _YES : _NO) , '</option>' , PHP_EOL;
	}
		echo '	</select>' , PHP_EOL
		   , '	</td>' , PHP_EOL
		   , '</tr>' , PHP_EOL
		   , '<tr>' , PHP_EOL
		   , '	<td>' , _TONUR , ':</td>' , PHP_EOL
		   , '	<td>' , PHP_EOL
		   , '		<select name="TON_useRating">' , PHP_EOL;
	for($i=0; $i<=1; $i++) {
		echo '			<option value="' , $i , '"' , ($TON_useRating == $i ? ' selected="selected"' : '') , '>' , ($i == 1 ? _YES : _NO) , '</option>' , PHP_EOL;
	}
		echo '	</select>' , PHP_EOL
		   , '	</td>' , PHP_EOL
		   , '</tr>' , PHP_EOL
		   , '<tr>' , PHP_EOL
		   , '	<td>' , _TONSTF , ':</td>' , PHP_EOL
		   , '	<td>' , PHP_EOL
		   , '		<select name="TON_useSendToFriend">' , PHP_EOL;
	for($i=0; $i<=1; $i++) {
		echo '			<option value="' , $i , '"' , ($TON_useSendToFriend == $i ? ' selected="selected"' : '') , '>' , ($i == 1 ? _YES : _NO) , '</option>' , PHP_EOL;
	}
		echo '	</select>' , PHP_EOL
		   , '	</td>' , PHP_EOL
		   , '</tr>' , PHP_EOL
		   , '<tr>' , PHP_EOL
		   , '	<td>' , _TONSHOWTAGS , ':</td>' , PHP_EOL
		   , '	<td>' , PHP_EOL
		   , '		<select name="showtags">' , PHP_EOL;
	for($i=0; $i<=1; $i++) {
		echo '			<option value="' , $i , '"' , ($showtags == $i ? ' selected="selected"' : '') , '>' , ($i == 1 ? _YES : _NO) , '</option>' , PHP_EOL;
	}
		echo '	</select>' , PHP_EOL
		   , '	</td>' , PHP_EOL
		   , '</tr>' , PHP_EOL
		   , '<tr>' , PHP_EOL
		   , '	<td>' , _TONUCL , ':</td>' , PHP_EOL
		   , '	<td>' , PHP_EOL
		   , '		<select name="TON_useCharLimit">' , PHP_EOL;
	for($i=0; $i<=1; $i++) {
		echo '			<option value="' , $i , '"' , ($TON_useCharLimit == $i ? ' selected="selected"' : '') , '>' , ($i == 1 ? _YES : _NO) , '</option>' , PHP_EOL;
	}
		echo '	</select>' , PHP_EOL
		   , '	</td>' , PHP_EOL
		   , '</tr>' , PHP_EOL
		   , '<tr>' , PHP_EOL
		   , '	<td>' , _TONCL , ':</td>' , PHP_EOL
		   , '	<td>' , PHP_EOL
		   , '		<input type="text" name="TON_CharLimit" value="' , $TON_CharLimit , '" size="4" maxlength="7" />' , PHP_EOL
		   , '	</td>' , PHP_EOL
		   , '</tr>' , PHP_EOL
		   , '<tr>' , PHP_EOL
		   , '	<td>' , _TONTAACT , ':</td>' , PHP_EOL
		   , '	<td>' , PHP_EOL
		   , '		<select name="topadact">' , PHP_EOL;
	for($i=0; $i<=1; $i++) {
		echo '			<option value="' , $i , '"' , ($topadact == $i ? ' selected="selected"' : '') , '>' , ($i == 1 ? _YES : _NO) , '</option>' , PHP_EOL;
	}
		echo '	</select>' , PHP_EOL
		   , '	</td>' , PHP_EOL
		   , '</tr>' , PHP_EOL
		   , '<tr>' , PHP_EOL
		   , '	<td>' , PHP_EOL
		   , '		' , _TONTA , ': <a href="#ton_ta" class="toninfo"><img src="images/news/question.png" style="vertical-align:middle" alt="Question" /></a>' , PHP_EOL
		   , '		<div class="display-none">' , PHP_EOL
		   , '			<div id="ton_ta" class="toncboxinline"><span class="thick">' , _TONTA , '</span><br /><br />' , _TONADINFO , '</div>' , PHP_EOL
		   , '		</div>' , PHP_EOL
		   , '	</td>' , PHP_EOL
		   , '	<td>' , PHP_EOL
		   , '		<input type="text" name="topad" value="' , $topad , '" size="2" maxlength="3" />' , PHP_EOL
		   , '	</td>' , PHP_EOL
		   , '</tr>' , PHP_EOL;
	if ($topadact) {
		echo '<tr>' , PHP_EOL
		   , '	<td>' , PHP_EOL
		   , '		<br />' , _TONPREVIEW , '<br />' , ads($topad) , '<br />' , PHP_EOL
		   , '	</td>' , PHP_EOL
		   , '</tr>' , PHP_EOL;
	}
		echo '<tr>' , PHP_EOL
		   , '	<td>' , _TONBAACT , ':</td>' , PHP_EOL
		   , '	<td>' , PHP_EOL
		   , '		<select name="bottomadact">' , PHP_EOL;
	for($i=0; $i<=1; $i++) {
		echo '			<option value="' , $i , '"' , ($bottomadact == $i ? ' selected="selected"' : '') , '>' , ($i == 1 ? _YES : _NO) , '</option>' , PHP_EOL;
	}
		echo '	</select>' , PHP_EOL
		   , '	</td>' , PHP_EOL
		   , '</tr>' , PHP_EOL
		   , '<tr>' , PHP_EOL
		   , '	<td>' , PHP_EOL
		   , '		' , _TONBA , ': <a href="#ton_ba" class="toninfo"><img src="images/news/question.png" style="vertical-align:middle" alt="Question" /></a>' , PHP_EOL
		   , '		<div class="display-none">' , PHP_EOL
		   , '			<div id="ton_ba" class="toncboxinline"><span class="thick">' , _TONBA , '</span><br /><br />' , _TONADINFO , '</div>' , PHP_EOL
		   , '		</div>' , PHP_EOL
		   , '	</td>' , PHP_EOL
		   , '	<td>' , PHP_EOL
		   , '		<input type="text" name="bottomad" value="' , $bottomad , '" size="2" maxlength="3" />' , PHP_EOL
		   , '	</td>' , PHP_EOL
		   , '</tr>' , PHP_EOL;
	if ($bottomadact) {
		echo '<tr>' , PHP_EOL
		   , '	<td>' , PHP_EOL
		   , '		<br />' , _TONPREVIEW , '<br />' , ads($bottomad) , '<br />' , PHP_EOL
		   , '	</td>' , PHP_EOL
		   , '</tr>' , PHP_EOL;
	}
		echo '<tr>' , PHP_EOL
		   , '	<td>' , _TONDIS , ':</td>' , PHP_EOL
		   , '	<td>' , PHP_EOL
		   , '		<select name="usedisqus">' , PHP_EOL;
	for($i=0; $i<=1; $i++) {
		echo '			<option value="' , $i , '"' , ($usedisqus == $i ? ' selected="selected"' : '') , '>' , ($i == 1 ? _YES : _NO) , '</option>' , PHP_EOL;
	}
		echo '</select>' , PHP_EOL;
	if ($usedisqus == 1 && $tnsl_bAutoTapLinks == false && $tnsl_bUseShortLinks == true) {
		echo '<span class="thick" style="color:darkred"> ' , _TONAUTOLINKWARNING , '</span>';
	}
		echo '	</td>' , PHP_EOL
		   , '</tr>' , PHP_EOL;
	if ($usedisqus==1) {		   
		echo '<tr>' , PHP_EOL
		   , '	<td>' , PHP_EOL
		   , '		' , _TONSN , ': <a href="#ton_disqus" class="toninfo"><img src="images/news/question.png" style="vertical-align:middle" alt="Question" /></a>' , PHP_EOL
		   , '		<div class="display-none">' , PHP_EOL
		   , '			<div id="ton_disqus" class="toncboxinline"><span class="thick">' , _TONSN , '</span><br /><br />' , _TONSNINFO , '</div>' , PHP_EOL
		   , '		</div>' , PHP_EOL
		   , '	</td>' , PHP_EOL	   
		   , '	<td>' , PHP_EOL
		   , '		<input type="text" name="shortname" id="disqus_placeholder" value="' , $shortname , '" size="15" maxlength="25" />' , PHP_EOL
		   , '	</td>' , PHP_EOL
		   , '</tr>' , PHP_EOL;	   
	}
		echo '<tr>' , PHP_EOL
		   , '	<td>' , PHP_EOL
		   , '		' , _TONGAPI , ': <a href="#ton_googlkey" class="toninfo"><img src="images/news/question.png" style="vertical-align:middle" alt="Question" /></a>' , PHP_EOL
		   , '		<div class="display-none">' , PHP_EOL
		   , '			<div id="ton_googlkey" class="toncboxinline"><span class="thick">' , _TONGAPI , '</span><br /><br />' , _TONGAPIINFO , '</div>' , PHP_EOL
		   , '		</div>' , PHP_EOL
		   , '	</td>' , PHP_EOL
		   , '	<td>' , PHP_EOL
		   , '		<input type="text" name="googlapi" id="googlapi_placeholder" value="' , $googlapi , '" size="42" maxlength="44" />' , PHP_EOL
		   , '	</td>' , PHP_EOL
		   , '</tr>' , PHP_EOL
		   , '<tr>' , PHP_EOL
		   , '	<td>' , _TONGSB , ':</td>' , PHP_EOL
		   , '	<td>' , PHP_EOL
		   , '		<select name="usegooglsb">' , PHP_EOL;
	for($i=0; $i<=1; $i++) {
		echo '			<option value="' , $i , '"' , ($usegooglsb == $i ? ' selected="selected"' : '') , '>' , ($i == 1 ? _YES : _NO) , '</option>' , PHP_EOL;
	}
		echo '	</select>' , PHP_EOL
		   , '	</td>' , PHP_EOL
		   , '</tr>' , PHP_EOL
		   , '<tr>' , PHP_EOL
		   , '	<td>' , _TONGA , ':</td>' , PHP_EOL
		   , '	<td>' , PHP_EOL
		   , '		<select name="usegooglart">' , PHP_EOL;
	for($i=0; $i<=1; $i++) {
		echo '			<option value="' , $i , '"' , ($usegooglart == $i ? ' selected="selected"' : '') , '>' , ($i == 1 ? _YES : _NO) , '</option>' , PHP_EOL;
	}
		echo '	</select>' , PHP_EOL
		   , '	</td>' , PHP_EOL
		   , '</tr>' , PHP_EOL
		   , '<tr>' , PHP_EOL
		   , '	<td>' , PHP_EOL
		   , '		' , _TONSORTDESCRIPTION10 , ': <a href="#ton_sortcont1" class="toninfo"><img src="images/news/question.png" style="vertical-align:middle" alt="Question" /></a>' , PHP_EOL	
		   , '		<div class="display-none">' , PHP_EOL
		   , '			<div id="ton_sortcont1" class="toncboxinline"><span class="thick">' , _TONSORTDESCRIPTION10 , '</span><br /><br />' , _TONSORTDESCRIPTION11 , '</div>' , PHP_EOL
		   , '		</div>' , PHP_EOL
		   , '	</td>' , PHP_EOL
		   , '	<td>' , PHP_EOL
		   , '		<select name="newssort">' , PHP_EOL;
	for($i=0; $i<=1; $i++) {
		echo '			<option value="' , $i , '"' , ($newssort == $i ? ' selected="selected"' : '') , '>' , ($i == 1 ? _TONSORTTIME : _TONSORTID) , '</option>' , PHP_EOL;
	}
		echo '	</select>' , PHP_EOL
		   , '	</td>' , PHP_EOL
		   , '</tr>' , PHP_EOL
		   , '<tr>' , PHP_EOL
		   , '	<td>' , PHP_EOL
		   , '		' , _TONSORTDESCRIPTION20 , ': <a href="#ton_sortcont2" class="toninfo"><img src="images/news/question.png" style="vertical-align:middle" alt="Question" /></a>' , PHP_EOL
		   , '		<div class="display-none">' , PHP_EOL
		   , '			<div id="ton_sortcont2" class="toncboxinline"><span class="thick">' , _TONSORTDESCRIPTION20 , '</span><br /><br />' , _TONSORTDESCRIPTION21 , '</div>' , PHP_EOL
		   , '		</div>' , PHP_EOL
		   , '	</td>' , PHP_EOL
		   , '	<td>' , PHP_EOL
		   , '		<select name="newsorder">' , PHP_EOL;
	for($i=0; $i<=1; $i++) {
		echo '		<option value="' , $i , '"' , ($newsorder == $i ? ' selected="selected"' : '') , '>' , ($i == 1 ? _TONSORTASC : _TONSORTDESC) , '</option>' , PHP_EOL;
	}	
		echo '	</select>' , PHP_EOL
		   , '	</td>' , PHP_EOL
		   , '</tr>' , PHP_EOL
		   , '<tr>' , PHP_EOL
		   , '	<td>' , PHP_EOL
		   , '		' , _TONSORTDESCRIPTION30 , ': <a href="#ton_sortcont3" class="toninfo"><img src="images/news/question.png" style="vertical-align:middle" alt="Question" /></a>' , PHP_EOL
		   , '		<div class="display-none">' , PHP_EOL
		   , '			<div id="ton_sortcont3" class="toncboxinline"><span class="thick">' , _TONSORTDESCRIPTION30 , '</span><br /><br />' , _TONSORTDESCRIPTION31 , '</div>' , PHP_EOL
		   , '		</div>' , PHP_EOL
		   , '	</td>' , PHP_EOL
		   , '	<td>' , PHP_EOL
		   , '		<select name="newsyearmin">' , PHP_EOL
		   , '			<option value="0">' , _TONSORTMINYEAR , '</option>' , PHP_EOL;
	for($i=1; $i<=5; $i++) {
		echo '			<option value="' , $i , '"' , ($newsyearmin == $i ? ' selected="selected"' : '') , '>- ' , ($i<2 ? $i . ' ' . _TONSORTYEAR : $i . ' ' . _TONSORTYEARS) , '</option>' , PHP_EOL;
	}
		echo '	</select>' , PHP_EOL
		   , '	</td>' , PHP_EOL
		   , '</tr>' , PHP_EOL
		   , '<tr>' , PHP_EOL
		   , '	<td>' , PHP_EOL
		   , '		' , _TONSORTDESCRIPTION40 , ': <a href="#ton_sortcont4" class="toninfo"><img src="images/news/question.png" style="vertical-align:middle" alt="Question" /></a>' , PHP_EOL
		   , '		<div class="display-none">' , PHP_EOL
		   , '			<div id="ton_sortcont4" class="toncboxinline"><span class="thick">' , _TONSORTDESCRIPTION40 , '</span><br /><br />' , _TONSORTDESCRIPTION41 , '</div>' , PHP_EOL
		   , '		</div>' , PHP_EOL
		   , '	</td>' , PHP_EOL
		   , '	<td>' , PHP_EOL
		   , '		<select name="newsyearmax">' , PHP_EOL
		   , '			<option value="0">' , _TONSORTMAXYEAR , '</option>' , PHP_EOL;
	for($i=1; $i<=5; $i++) {
		echo '			<option value="' , $i , '"' , ($newsyearmax == $i ? ' selected="selected"' : '') , '>+ ' , ($i<2 ? $i . ' ' . _TONSORTYEAR : $i . ' ' . _TONSORTYEARS) , '</option>' , PHP_EOL;
	}
		echo '		</select>' , PHP_EOL
		   , '	</td>' , PHP_EOL
		   , '</tr>' , PHP_EOL
		   , '<tr>' , PHP_EOL
		   , '	<td>' , PHP_EOL
		   , '		' , _TONHIDEAUTOTIMES , ': <a href="#ton_hideautotimes" class="toninfo"><img src="images/news/question.png" style="vertical-align:middle" alt="Question" /></a>' , PHP_EOL
		   , '		<div class="display-none">' , PHP_EOL
		   , '			<div id="ton_hideautotimes" class="toncboxinline"><span class="thick">' , _TONHIDEAUTOTIMES , '</span><br /><br />' , _TONHIDEAUTOTIMESFAQ , '</div>' , PHP_EOL
		   , '		</div>' , PHP_EOL
		   , '	</td>' , PHP_EOL
		   , '	<td>' , PHP_EOL
		   , '		<select name="hideautotimes">' , PHP_EOL;
	for($i=0; $i<=1; $i++) {
		echo '		<option value="' , $i , '"' , ($hideautotimes == $i ? ' selected="selected"' : '') , '>' , ($i == 1 ? _YES : _NO) , '</option>' , PHP_EOL;
	}
		echo '		</select>' , PHP_EOL
		   , '	</td>' , PHP_EOL
		   , '</tr>' , PHP_EOL
		   , '<tr>' , PHP_EOL
		   , '	<td>' , PHP_EOL
		   , '		' , _TONHIDEAUTOSUBMIT , ': <a href="#ton_hideautosubmit" class="toninfo"><img src="images/news/question.png" style="vertical-align:middle" alt="Question" /></a>' , PHP_EOL
		   , '		<div class="display-none">' , PHP_EOL
		   , '			<div id="ton_hideautosubmit" class="toncboxinline"><span class="thick">' , _TONHIDEAUTOSUBMIT , '</span><br /><br />' , _TONHIDEAUTOSUBMITFAQ , '</div>' , PHP_EOL
		   , '		</div>' , PHP_EOL
		   , '	</td>' , PHP_EOL
		   , '	<td>' , PHP_EOL
		   , '		<select name="hideautosubmit">' , PHP_EOL;
	for($i=0; $i<=1; $i++) {
		echo '		<option value="' , $i , '"' , ($hideautosubmit == $i ? ' selected="selected"' : '') , '>' , ($i == 1 ? _YES : _NO) , '</option>' , PHP_EOL;
	}
		echo '		</select>' , PHP_EOL
		   , '	</td>' , PHP_EOL
		   , '</tr>' , PHP_EOL
		   , '<tr>' , PHP_EOL
		   , '	<td>' , PHP_EOL
		   , '		' , _TONHIDEPREVIEW , ': <a href="#ton_hidepreview" class="toninfo"><img src="images/news/question.png" style="vertical-align:middle" alt="Question" /></a>' , PHP_EOL
		   , '		<div class="display-none">' , PHP_EOL
		   , '			<div id="ton_hidepreview" class="toncboxinline"><span class="thick">' , _TONHIDEPREVIEW , '</span><br /><br />' , _TONHIDEPREVIEWFAQ , '</div>' , PHP_EOL
		   , '		</div>' , PHP_EOL
		   , '	</td>' , PHP_EOL
		   , '	<td>' , PHP_EOL
		   , '		<select name="previewstory">' , PHP_EOL;
	for($i=0; $i<=1; $i++) {
		echo '		<option value="' , $i , '"' , ($previewstory == $i ? ' selected="selected"' : '') , '>' , ($i == 1 ? _YES : _NO) , '</option>' , PHP_EOL;
	}
		echo '		</select>' , PHP_EOL
		   , '	</td>' , PHP_EOL
		   , '</tr>' , PHP_EOL
		   , '<tr>' , PHP_EOL
		   , '	<td>' , PHP_EOL
		   , '		' , _TONJQUERYSELECT , ': <a href="#ton_jqueryselect" class="toninfo"><img src="images/news/question.png" style="vertical-align:middle" alt="Question" /></a>' , PHP_EOL
		   , '		<div class="display-none">' , PHP_EOL
		   , '			<div id="ton_jqueryselect" class="toncboxinline"><span class="thick">' , _TONJQUERYSELECT , '</span><br /><br />' , _TONJQUERYSELECTFAQ , '</div>' , PHP_EOL
		   , '		</div>' , PHP_EOL
		   , '	</td>' , PHP_EOL
		   , '	<td>' , PHP_EOL
		   , '		<select name="jqueryselect">' , PHP_EOL;
	for($i=0; $i<=1; $i++) {
		echo '		<option value="' , $i , '"' , ($jqueryselect == $i ? ' selected="selected"' : '') , '>' , ($i == 1 ? _YES : _NO) , '</option>' , PHP_EOL;
	}
		echo '		</select>' , PHP_EOL
		   , '	</td>' , PHP_EOL
		   , '</tr>' , PHP_EOL
		   , '<tr>' , PHP_EOL
		   , '	<td>' , PHP_EOL
		   , '		' , _TONARCHIVDEFAULT , ': <a href="#ton_archivedefault" class="toninfo"><img src="images/news/question.png" style="vertical-align:middle" alt="Question" /></a>' , PHP_EOL
		   , '		<div class="display-none">' , PHP_EOL
		   , '			<div id="ton_archivedefault" class="toncboxinline"><span class="thick">' , _TONARCHIVDEFAULT , '</span><br /><br />' , _TONARCHIVDEFAULTFAQ , '</div>' , PHP_EOL
		   , '		</div>' , PHP_EOL
		   , '	</td>' , PHP_EOL
		   , '	<td>' , PHP_EOL
		   , '		<input type="text" name="archivedefault" value="' , ($archivedefault == 0 ? '' : $archivedefault) , '" size="4" maxlength="3" />' , PHP_EOL
		   , '	</td>' , PHP_EOL
		   , '</tr>' , PHP_EOL
		   , '<tr>' , PHP_EOL
		   , '	<td>' , PHP_EOL
		   , '		' , _TONARCHIVETOPICS , ': <a href="#ton_archivetopics" class="toninfo"><img src="images/news/question.png" style="vertical-align:middle" alt="Question" /></a>' , PHP_EOL
		   , '		<div class="display-none">' , PHP_EOL
		   , '			<div id="ton_archivetopics" class="toncboxinline">' , PHP_EOL
		   , '				<span class="thick">' , _TONARCHIVETOPICS , '</span><br /><br />' , _TONARCHIVETOPICSFAQ , PHP_EOL
		   , '			</div>' , PHP_EOL
		   , '		</div>' , PHP_EOL
		   , '	</td>' , PHP_EOL
		   , '	<td>' , PHP_EOL
		   , '		<select name="archivetopics">' , PHP_EOL;
	for($i=0; $i<=1; $i++) {
		echo '		<option value="' , $i , '"' , ($archivetopics == $i ? ' selected="selected"' : '') , '>' , ($i==1 ? _YES : _NO) , '</option>' , PHP_EOL;
	}
		echo '		</select>' , PHP_EOL
		   , '	</td>' , PHP_EOL
		   , '</tr>' , PHP_EOL
		   , '<tr>' , PHP_EOL
		   , '	<td>' , PHP_EOL
		   , '		' , _ARCHIVECHARLIMIT , ': <a href="#archive_charlimit" class="toninfo"><img src="images/news/question.png" style="vertical-align:middle" alt="Question" /></a>' , PHP_EOL
		   , '		<div class="display-none">' , PHP_EOL
		   , '			<div id="archive_charlimit" class="toncboxinline"><span class="thick">' , _ARCHIVECHARLIMIT , '</span><br /><br />' , _ARCHIVECHARLIMITFAQ , '</div>' , PHP_EOL
		   , '		</div>' , PHP_EOL
		   , '	</td>' , PHP_EOL
		   , '	<td>' , PHP_EOL
		   , '		<select name="archive_charlimit">' , PHP_EOL;
	for($i=0; $i<=1; $i++) {
		echo '		<option value="' , $i , '"' , ($archive_charlimit == $i ? ' selected="selected"' : '') , '>' , ($i==1 ? _YES : _NO) , '</option>' , PHP_EOL;
	}
		echo '		</select>' , PHP_EOL
		   , '	</td>' , PHP_EOL
		   , '</tr>' , PHP_EOL;
	if ($archive_charlimit == 1) {
		echo '<tr>' , PHP_EOL
		   , '	<td>' , PHP_EOL
		   , '		' , _ARCHIVECOUNTTOPICS , ': <a href="#archive_counttopic" class="toninfo"><img src="images/news/question.png" style="vertical-align:middle" alt="Question" /></a>' , PHP_EOL
		   , '		<div class="display-none">' , PHP_EOL
		   , '			<div id="archive_counttopic" class="toncboxinline"><span class="thick">' , _ARCHIVECOUNTTOPICS , '</span><br /><br />' , _ARCHIVECOUNTTOPICSFAQ , '</div>' , PHP_EOL
		   , '		</div>' , PHP_EOL
		   , '	</td>' , PHP_EOL
		   , '	<td>' , PHP_EOL
		   , '		<input type="text" name="counttopic" value="' , ($counttopic == 0 ? '' : $counttopic) , '" size="3" maxlength="3" />' , PHP_EOL
		   , '	</td>' , PHP_EOL
		   , '</tr>' , PHP_EOL
		   , '<tr>' , PHP_EOL
		   , '	<td>' , PHP_EOL
		   , '		' , _ARCHIVECOUNTTITLES , ': <a href="#archive_counttitle" class="toninfo"><img src="images/news/question.png" style="vertical-align:middle" alt="Question" /></a>' , PHP_EOL
		   , '		<div class="display-none">' , PHP_EOL
		   , '			<div id="archive_counttitle" class="toncboxinline"><span class="thick">' , _ARCHIVECOUNTTITLES , '</span><br /><br />' , _ARCHIVECOUNTTITLESFAQ , '</div>' , PHP_EOL
		   , '		</div>' , PHP_EOL
		   , '	</td>' , PHP_EOL
		   , '	<td>' , PHP_EOL
		   , '		<input type="text" name="counttitle" value="' , ($counttitle == 0 ? '' : $counttitle) , '" size="3" maxlength="3" />' , PHP_EOL
		   , '	</td>' , PHP_EOL
		   , '</tr>' , PHP_EOL;
	}
		echo '<tr>' , PHP_EOL
		   , '	<td>' , _ACTIVATEADMINNOTES , ':</td>' , PHP_EOL
		   , '	<td>' , PHP_EOL
		   , '		<select name="usenotes">' , PHP_EOL;
	for($i=0; $i<=1; $i++) {
		echo '		<option value="' , $i , '"' , ($usenotes == $i ? ' selected="selected"' : '') , '>' , ($i==1 ? _YES : _NO) , '</option>' , PHP_EOL;
	}
		echo '		</select>' , PHP_EOL
		   , '	</td>' , PHP_EOL
		   , '</tr>' , PHP_EOL
		   , '<tr>' , PHP_EOL
		   , '	<td class="text-center" colspan="2">' , PHP_EOL
		   , '		<input type="hidden" name="op" value="tonSave" />' , PHP_EOL
		   , '		<br /><input type="submit" style="cursor:pointer;" value="' , _SAVECHANGES , '" />' , PHP_EOL
		   , '	</td>' , PHP_EOL
		   , '</tr>' , PHP_EOL
		   , '</table>' , PHP_EOL
		   , '</form>' , PHP_EOL;
	CloseTable();
	// start jQuery placeholders
	if ($shortname == '') {
		$disqus_placeholder = '<script type="text/javascript">' . PHP_EOL
							. '$(document).ready(function() {' . PHP_EOL
							. '	var Element = \'#disqus_placeholder\';' . PHP_EOL
							. '	var disqus = \'Short Name...\';' . PHP_EOL
							. '	$(Element).val(disqus);' . PHP_EOL
							. '	$(Element).bind(\'focus\',function() {' . PHP_EOL
							. '		$(this).addClass(\'focus\');' . PHP_EOL
							. '		if ($(this).val()==disqus) {' . PHP_EOL
							. '			$(this).val(\'\');' . PHP_EOL
							. '		}' . PHP_EOL
							. '	}).bind("blur",function() {' . PHP_EOL
							. '		if ($(this).val()==\'\') {' . PHP_EOL
							. '			$(this).val(disqus);' . PHP_EOL
							. '			$(this).removeClass(\'focus\');' . PHP_EOL
							. '		}' . PHP_EOL
							. '	});' . PHP_EOL
							. '});' . PHP_EOL
							. '</script>' . PHP_EOL;
		addJSToBody($disqus_placeholder,'inline');
	}
	if ($googlapi == '') {
		$googlapi_placeholder = '<script type="text/javascript">' . PHP_EOL
							  . '$(document).ready(function() {' . PHP_EOL
							  . '	var Element = \'#googlapi_placeholder\';' . PHP_EOL
							  . '	var googlapi = \'Goo.gl API Key...\';' . PHP_EOL
							  . '		$(Element).val(googlapi);' . PHP_EOL
							  . '		$(Element).bind(\'focus\',function() {' . PHP_EOL
							  . '		$(this).addClass(\'focus\');' . PHP_EOL
							  . '		if ($(this).val()==googlapi) {' . PHP_EOL
							  . '			$(this).val(\'\');' . PHP_EOL
							  . '		}' . PHP_EOL
							  . '	}).bind("blur",function() {' . PHP_EOL
							  . '		if ($(this).val()==\'\') {' . PHP_EOL
							  . '			$(this).val(googlapi);' . PHP_EOL
							  . '			$(this).removeClass(\'focus\');' . PHP_EOL
							  . '		}' . PHP_EOL
							  . '	});' . PHP_EOL
							  . '});' . PHP_EOL
							  . '</script>' . PHP_EOL;
		addJSToBody($googlapi_placeholder,'inline');
	}
	include_once 'footer.php';
}

function tonSave($newsrows, $bookmark, $rblocks, $linklocation, $articlelink, $artview, $TON_useTitleLink, $TON_usePDF, $TON_useRating, $TON_useSendToFriend, $showtags, $TON_useCharLimit, $TON_CharLimit, $topadact, $topad, $bottomadact, $bottomad, $usedisqus, $shortname, $googlapi, $usegooglsb, $usegooglart, $newssort, $newsorder, $newsyearmin, $newsyearmax, $hideautotimes, $previewstory, $hideautosubmit, $archivedefault, $archivetopics, $jqueryselect, $archive_charlimit, $counttopic, $counttitle, $usenotes) {
	global $prefix, $db, $admin_file;
	if (!is_numeric($TON_CharLimit) || $TON_CharLimit <= 0) {
		 $cTON_CharLimit = '';
	} else {
		$cTON_CharLimit = $TON_CharLimit;
	}
	if (!is_numeric($topad) || $topad <= 0) {
		 $ctopad = 0;
	} else {
		$ctopad = $topad;
	}
	if (!is_numeric($bottomad) || $bottomad <= 0) {
		 $cbottomad = 0;
	} else {
		$cbottomad = $bottomad;
	}	
	if ($shortname == 'Short Name...') {
		$shortname = '';
	} else {
		$shortname = $db->sql_escape_string(htmlspecialchars_decode(check_html($shortname, 'nohtml'), ENT_QUOTES));
	}
	if ($googlapi == 'Goo.gl API Key...') {
		$googlapi = '';
	} else {
		$googlapi = $db->sql_escape_string(htmlspecialchars_decode(check_html($googlapi, 'nohtml'), ENT_QUOTES));
	}
	if (!is_numeric($archivedefault) || $archivedefault <= 0) {
		$carchivedefault = 0;
	} else {
		$carchivedefault = $archivedefault;
	}
	if (!is_numeric($counttopic) || $counttopic <= 0) {
		 $counttopic = 0;
	}
	if (!is_numeric($counttitle) || $counttitle <= 0) {
		 $counttitle = 0;
	}
	if (!is_numeric($usenotes) || $usenotes <= 0) {
		 $usenotes = 0;
	}
	$db->sql_query('UPDATE `' . $prefix . '_ton` SET '."`newsrows`='$newsrows', `bookmark`='$bookmark', `rblocks`='$rblocks', `linklocation`='$linklocation', `articlelink`='$articlelink', `artview`='$artview', `TON_useTitleLink`='$TON_useTitleLink', `TON_usePDF`='$TON_usePDF', `TON_useRating`='$TON_useRating', `TON_useSendToFriend`='$TON_useSendToFriend', `showtags`='$showtags', `TON_useCharLimit`='$TON_useCharLimit', `TON_CharLimit`='$cTON_CharLimit', `topadact`='$topadact', `topad`='$ctopad', `bottomadact`='$bottomadact', `bottomad`='$cbottomad', `usedisqus`='$usedisqus', `shortname`='$shortname', `googlapi`='$googlapi', `usegooglsb`='$usegooglsb', `usegooglart`='$usegooglart', `newssort`='$newssort', `newsorder`='$newsorder', `newsyearmin`='$newsyearmin', `newsyearmax`='$newsyearmax', `hideautotimes`='$hideautotimes', `previewstory`='$previewstory', `hideautosubmit`='$hideautosubmit', `archivedefault`='$carchivedefault', `archivetopics`='$archivetopics', `jqueryselect`='$jqueryselect', `archive_charlimit`='$archive_charlimit', `counttopic`='$counttopic', `counttitle`='$counttitle', `usenotes`='$usenotes'".'');
	 Header('Location: ' . $admin_file . '.php?op=newsedit');
}