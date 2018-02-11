<?php
/**
 * @PHP-NUKE: Web Portal System
 * @package Tricked Out News
 * @version 2.6 (RN News-Mod)
 * @file: article.php
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

if (!isset($op)) $op = '';
if (!isset($gfx_check)) $gfx_check = '';
$module_name = basename(dirname(__FILE__));
get_lang($module_name);
// theme specific styling: located @ themes/ANY_ACTIVE_THEME/style/news.css
$PreferredStyle = 'news.css';
$ThemeSel = get_theme();
$tonCssFile = INCLUDE_PATH . 'themes/' . $ThemeSel . '/style/' . $PreferredStyle;
$DefaultStyle = 'modules/' . $module_name . '/css/' . $PreferredStyle;
if (file_exists($tonCssFile)) {
	define('RN_MODULE_CSS', $PreferredStyle);
} else {
	addCSSToHead($DefaultStyle, 'file');
}
	// TON SETTINGS
	$sql = 'SELECT * FROM `' . $prefix . '_ton`';
	$result = $db->sql_query($sql);
	$row = $db->sql_fetchrow($result);
	$rblocks =  $row['rblocks'];
	$artview =  $row['artview'];
	$TON_usePDF =  $row['TON_usePDF'];
	$TON_useRating =  $row['TON_useRating'];
	$TON_useSendToFriend =  $row['TON_useSendToFriend'];
	$showtags = $row['showtags'];
	$topadact =  $row['topadact'];
	$topad =  $row['topad'];
	$bottomadact =  $row['bottomadact'];
	$bottomad =  $row['bottomad'];
	$usedisqus = $row['usedisqus'];
	$shortname = $row['shortname'];
	$googlapi = $row['googlapi'];
	$usegooglsb = $row['usegooglsb'];
	$usegooglart = $row['usegooglart'];
	$usenotes = $row['usenotes'];
	if ($rblocks == '1') {
	define('INDEX_FILE', TRUE);
	}
	if ($artview == 'new') {
		addJSToBody('modules/' . $module_name . '/js/jquery.rating.js', 'file');
		addJSToBody('modules/' . $module_name . '/js/slidingDiv.js', 'file');
	}
	if (isset($sid)) {$sid = intval($sid);} else {$sid = '';}
	if (stristr($_SERVER['REQUEST_URI'],'mainfile')) {
		Header('Location: modules.php?name=' . $module_name . '&file=article&sid=' . $sid);
		} elseif (empty($sid) && !isset($tid)) {
		Header('Location: ./'); exit;
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
		$topicname = htmlspecialchars($row['topicname'], ENT_QUOTES, _CHARSET);
		$topicimage = htmlspecialchars($row['topicimage'], ENT_QUOTES, _CHARSET);
		$topictext = htmlspecialchars($row['topictext'], ENT_QUOTES, _CHARSET);
	}
	if (is_admin($admin)) {
		$storylock = '';
	} else {
		$storylock = '`slock` = 0 AND';
	}
	$result = $db->sql_query('SELECT `catid`, `aid`, `time`, `title`, `hometext`, `bodytext`, `topic`, `informant`, `notes`, `acomm`, `haspoll`, `pollID`, `score`, `ratings`, `associated` FROM `' . $prefix . '_stories` WHERE ' . $storylock . ' `sid` = \'' . $sid . '\'');

	$numrows = $db->sql_numrows($result);
	if (intval($numrows)!=1) {
		Header('Location: ./');
		die();
	}
	$row = $db->sql_fetchrow($result);
	$catid =$row['catid'];
	$aaid = htmlspecialchars($row['aid'], ENT_QUOTES, _CHARSET);
	$time = $row['time'];
	$title = htmlspecialchars($row['title'], ENT_QUOTES, _CHARSET);
	$hometext = $row['hometext'];
	$bodytext = $row['bodytext'];
	$topic = $row['topic'];
	$informant = htmlspecialchars($row['informant'], ENT_QUOTES, _CHARSET);
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
	$associated = $row['associated'];
	Topics($sid);
	if (isset($googlapi) AND ($usegooglsb) OR ($usegooglart)) {
		$gooarticleurl = $nukeurl.'/modules.php?name=' . $module_name . '&file=article&sid=' . $sid;
		$longUrl = $gooarticleurl;
		$apiKey = $googlapi;
		$postData = array('longUrl' => $longUrl, 'key' => $apiKey);
		$jsonData = json_encode($postData);
		$curlObj = curl_init();
		curl_setopt($curlObj, CURLOPT_URL, 'https://www.googleapis.com/urlshortener/v1/url');
		curl_setopt($curlObj, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curlObj, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($curlObj, CURLOPT_HEADER, 0);
		curl_setopt($curlObj, CURLOPT_HTTPHEADER, array('Content-type:application/json'));
		curl_setopt($curlObj, CURLOPT_POST, 1);
		curl_setopt($curlObj, CURLOPT_POSTFIELDS, $jsonData);
		$response = curl_exec($curlObj);
		$json = json_decode($response);
		curl_close($curlObj);
		$goourl = $json->id;
		$endshort = '<div>Short URL: <input value="' . $goourl . '" id="goourl" name="' . $goourl . '" type="text" /></div>'; //Google short url
	}
	# nukeSEO Social Bookmarking added Tricked Out News
	require_once("includes/nukeSEO_SB.php");
	global $nukeurl, $subject;
	//determine what links to use for SB
	if (isset($googlapi) AND ($usegooglsb)) {
		$articleurl = $goourl;
		}elseif (defined('TNSL_USE_SHORTLINKS')){
		$articleurl = $nukeurl.'/article' . $sid . '.html';
		}else{
		$articleurl = $nukeurl.'/modules.php?name=' . $module_name . '&amp;file=article&amp;sid=' . $sid;
	}
	$articletitle = $title; // pass the raw title to nukeSEO SB
	$socialbookmarkHTML = getBookmarkHTML( $articleurl, $articletitle, '&nbsp;', 'small');
	# nukeSEO Social Bookmarking
	if (!is_admin($admin)) {	
		$db->sql_query('UPDATE `' . $prefix . '_stories` SET `counter` = counter+1 WHERE `sid` = \'' . $sid . '\'');
	}
	$artpage = 1;
	$pagetitle = '- '.$title;
	include_once('header.php');

	$artpage = 0;
	formatTimestamp($time);
	if(empty($bodytext)) {
		$bodytext = $hometext;
	} else {
		$bodytext = $hometext . $bodytext;
	}
	if (!empty($notes)) {
		$bodytext = $bodytext . '<span class="thick">' . _NOTE . '</span><br />' . $notes;
	}
	if (isset($googlapi) AND ($usegooglart)) {  //display Google Short Url under article
		$bodytext = $bodytext . '<br />' . $endshort;
	}
	/* Determine if the article has attached a poll */
	if ($haspoll == 1) {
		$url = sprintf('modules.php?name=Surveys&amp;op=results&amp;pollID=%d', $pollID);
		$tonpoll  = '<br />' . PHP_EOL;
		$tonpoll .= '<div class="text-center">' . PHP_EOL;
		$tonpoll .= '	<form action="modules.php?name=Surveys" method="post">';
		$tonpoll .= '		<input type="hidden" name="pollID" value="' . $pollID . '" />';
		$tonpoll .= '		<input type="hidden" name="forwarder" value="' . $url . '" />';
		$row3 = $db->sql_fetchrow($db->sql_query('SELECT `pollTitle`, `voters` FROM `' . $prefix . '_poll_desc` WHERE `pollID` = \'' . $pollID . '\''));
		$pollTitle = htmlspecialchars($row3['pollTitle'], ENT_QUOTES, _CHARSET);
		$voters = $row3['voters'];
		$tonpoll .= '	' . _ARTICLEPOLL;
		$tonpoll .= '		<p class="thick">' . $pollTitle . '</p>' . PHP_EOL;
		$tonpoll .= '		<div class="poll">' . PHP_EOL;	
		for($i = 1; $i <= 12; $i++) {
			$result4 = $db->sql_query('SELECT `pollID`, `optionText`, `optionCount`, `voteID` FROM `' . $prefix . '_poll_data` WHERE `pollID` = \'' . $pollID . '\' AND `voteID` = \'' . $i . '\'');
			$row4 = $db->sql_fetchrow($result4);
			$numrows = $db->sql_numrows($result4);
			if($numrows != 0) {
				$optionText = htmlspecialchars($row4['optionText'], ENT_QUOTES, _CHARSET);
				if(!empty($optionText)) {
				$tonpoll .= '		<div class="text-right"><input type="radio" name="voteID" value="' . $i . '" /></div>' . PHP_EOL;
				$tonpoll .= '		<div class="text-left">' . $optionText . '</div>' . PHP_EOL;
				}
			}
		}
		$tonpoll .= '	</div>' . PHP_EOL;
		$tonpoll .= '	<div class="toncentertxt content">' . PHP_EOL;
		$tonpoll .= '		<input type="submit" class="pointer" value="' . _VOTE . '" />' . PHP_EOL;
		$tonpoll .= '	</div>' . PHP_EOL;
		if (is_user($user)) {
			cookiedecode($user);
		}
		if (!isset($sum)) $sum = 0;
		for($i = 0; $i < 12; $i++) {
			$row5 = $db->sql_fetchrow($db->sql_query('SELECT `optionCount` FROM `' . $prefix . '_poll_data` WHERE `pollID` = \'' . $pollID . '\' AND `voteID` = \'' . $i . '\''));
			$optionCount = $row5['optionCount'];
			$sum = (int)$sum+$optionCount;
		}
		$tonpoll .= '<br />' . PHP_EOL;
		$tonpoll .= '<div class="content">' . PHP_EOL;
		$tonpoll .= '	[ <a href="modules.php?name=Surveys&amp;op=results&amp;pollID=' . $pollID . '&amp;mode=' . $userinfo['umode'] . '&amp;order=' . $userinfo['uorder'] . '&amp;thold=' . $userinfo['thold'] . '"><span class="thick">' . _RESULTS . '</span></a> | <a href="modules.php?name=Surveys"><span class="thick">' . _POLLS . '</span></a> ]' . PHP_EOL;
	
		if ($pollcomm) {
			$result6 = $db->sql_query('SELECT * FROM `' . $prefix . '_pollcomments` WHERE `pollID` = \'' . $pollID . '\'');
			$numcom = $db->sql_numrows($result6);
			$tonpoll .= '	<br />' . PHP_EOL;
			$tonpoll .= '	' . _VOTES . ': <span class="thick">' . $sum . '</span><br />' . PHP_EOL;
			$tonpoll .= '	' . _PCOMMENTS . ' <span class="thick">' . $numcom . '</span>' . PHP_EOL;
		} else {
			$tonpoll .= '	<br />' . PHP_EOL;
			$tonpoll .= '	' . _VOTES . ' <span class="thick">' . $sum . '</span>' . PHP_EOL;
		}
		$tonpoll .= '</div>' . PHP_EOL;
		$tonpoll .= '</form>' . PHP_EOL;
		$tonpoll .= '</div>' . PHP_EOL;
		$bodytext = $bodytext . $tonpoll;  //Places poll under article
	}
	/* End Determine if the article has attached a poll */
	if(empty($informant)) {
		$informant = $anonymous;
	}
	/* Start Ads in article mod */
	if (isset($banners) AND ($topadact)){
		$bodytext = ads($topad) . '<br />' . $bodytext;
	}
	if (isset($banners) AND ($bottomadact)){
		$bodytext= $bodytext . '<br />' . ads($bottomad);
	}
	/* End Ads in article mod */
	if ($catid != 0) {
		$row2 = $db->sql_fetchrow($db->sql_query('SELECT `title` FROM `' . $prefix . '_stories_cat` WHERE `catid` = \'' . $catid . '\''));
		$title1 = htmlspecialchars($row2['title'], ENT_QUOTES, _CHARSET);
		$title = '<a href="modules.php?name=' . $module_name . '&amp;file=categories&amp;op=newindex&amp;catid=' . $catid . '"><span class="storycat">' . $title1 . '</span></a>: ' . $title;
	}
	echo '<div class="onehundred" style="vertical-align:top;">' . PHP_EOL; // neralex: div vs table fix
	/* Show admin links */
	if (is_admin($admin)) {
		Opentable();
		echo '<div class="text-center">' , PHP_EOL
		   , '<span class="thick">' , _ADMIN , '</span><br />' , PHP_EOL
		   , '[ <a href="' , $admin_file , '.php?op=adminStory">' , _ADD , '</a> | <a href="' , $admin_file , '.php?op=EditStory&amp;sid=' , $sid , '">' , _EDIT , '</a> | <a href="' , $admin_file , '.php?op=RemoveStory&amp;sid=' , $sid , '">' , _DELETE , '</a> ]</div>' , PHP_EOL
		   , '<br />' , PHP_EOL;
		Closetable();
	}
	themearticle($aaid, $informant, $datetime, $title, $bodytext, $topic, $topicname, $topicimage, $topictext, $subject, $notes);
	/* Start show tags mod */
	if ($showtags){
		$result = $db->sql_query('SELECT `tag` FROM `' . $prefix . '_tags` WHERE `cid` = \'' . $sid . '\'');
		$istag=$db->sql_numrows($result);
		if($istag>0){
		Opentable();
		echo '<div><img src="images/news/tag.png" alt="Tags" align="left" />&nbsp;';
			while ($row = $db->sql_fetchrow($result)) {
				$tag = $row['tag'];
				$num = $db->sql_numrows($db->sql_query('SELECT `tag` FROM `' . $prefix . '_tags` WHERE `tag` = \'' . $tag . '\''));
				if ($num<=1) {$dim = 'class1';}
				else if ($num<=5) {$dim = 'class2';}
				else if ($num<=20) {$dim = 'class3';}
				else if ($num<=50) {$dim = 'class4';}
				else { $dim = 'class5'; }
				echo '<span class="' , $dim , '"><a href="modules.php?name=Tags&amp;op=list&amp;tag=' , urlencode($tag) , '" title="' , htmlspecialchars($row['tag'], ENT_QUOTES, _CHARSET) , '">' , htmlspecialchars($row['tag'], ENT_QUOTES, _CHARSET) , '</a></span> ' , PHP_EOL;
			}
		echo '</div>' , PHP_EOL;
		Closetable();
		}
	}
	/* End show tags mod */
	/* Start generating content for Related, Rate This and Share links */
	$linkopacity ='opacity:0.4;filter:alpha(opacity=40)" onmouseover="this.style.opacity=1;this.filters.alpha.opacity=100" onmouseout="this.style.opacity=0.4;this.filters.alpha.opacity=40';
	$bminfo = '<a href="modules.php?name=' . $module_name . '&amp;file=print&amp;sid=' . $sid . '" class="normal-text topbottomlinks"><img style="' . $linkopacity . '" src="images/news/print.gif" alt="' . _PRINTER . '" title="cssheader=[tonheaderclass] cssbody=[tonbodyclass] header=[' . _PRINTER . ']body=[]" /> </a>';
	# Tricked Out News Pdf link and images added to match Social Bookmarking
	if ($TON_usePDF) {
		$bminfo .= '<a target="_blank" href="modules.php?name=' . $module_name . '&amp;file=printpdf&amp;id=' . $sid . '" class="normal-text topbottomlinks"><img style="' . $linkopacity . '" src="images/news/pdf.png" alt="' . _PDF . '" title="cssheader=[tonheaderclass] cssbody=[tonbodyclass] header=[' . _PDF . ']body=[]" /></a>&nbsp;';
	}
	if (is_user($user) and $TON_useSendToFriend) {
		$bminfo .= '<a href="modules.php?name=' . $module_name . '&amp;file=friend&amp;op=FriendSend&amp;sid=' . $sid . '" class="normal-text topbottomlinks"><img style="' . $linkopacity . '" src="images/news/friend.gif" alt="' . _FRIEND . '" title="cssheader=[tonheaderclass] cssbody=[tonbodyclass] header=[' . _FRIEND . ']body=[]" /></a>&nbsp;';
	}
		$bminfo .= '<a href="backend.php" class="normal-text topbottomlinks"><img style="' . $linkopacity . '" src="images/news/rss.png" alt="' . _RSS . '" title="cssheader=[tonheaderclass] cssbody=[tonbodyclass] header=[' . _RSS . ']body=[]" /> </a>';
		# nukeSEO Social Bookmarking added Tricked Out News
		$bminfo .=  $socialbookmarkHTML;
		# nukeSEO Social Bookmarking
		$topictext = htmlspecialchars(htmlspecialchars_decode(check_html($topictext, 'nohtml'), ENT_QUOTES), ENT_QUOTES, _CHARSET);
		$moreinfo  = '	&bull;&nbsp;<a href="modules.php?name=Stories_Archive">' . _ARCHIVE . '</a><br />' . PHP_EOL;
		$moreinfo .= '	&bull;&nbsp;<a href="modules.php?name=Search&amp;topic=' . $topic . '">' . _MOREABOUT . ' ' . $topictext . '</a><br />' . PHP_EOL;
		$moreinfo .= '	&bull;&nbsp;<a href="modules.php?name=Search&amp;author=' . $aaid . '">' . _NEWSBY . ' ' . $aaid . '</a><br />' . PHP_EOL;
		$moreinfo .= '	&bull;&nbsp;' . _MOSTREAD . ' ';
	
	global $multilingual, $currentlang, $admin_file, $user;
	if ($multilingual == 1) {
		/* the OR is needed to display stories who are posted to ALL languages */
		$querylang = 'AND (`alanguage` = \'' . $currentlang . '\' OR `alanguage` = \'\')';
	} else {
		$querylang = '';
	}
		$row9 = $db->sql_fetchrow($db->sql_query('SELECT `sid`, `title` FROM `' . $prefix . '_stories` WHERE `slock` = 0 AND `topic` = \'' . $topic . '\' ' . $querylang . ' ORDER BY `counter` DESC LIMIT 0,1'));
		$topstory = $row9['sid'];
		$ttitle = htmlspecialchars($row9['title'], ENT_QUOTES, _CHARSET);
		$moreinfo .= '<a href="modules.php?name=' . $module_name . '&amp;file=article&amp;sid=' . $topstory . '">' . $topictext . '</a>' . PHP_EOL;
	if ($multilingual == 1) {
		$querylang = 'AND (`blanguage` = \'' . $currentlang . '\' OR `blanguage` = \'\')';
	} else {
		$querylang = '';
	}
	/* Start Rating */
	if ($TON_useRating) {
		function rate_title($i) {
			if ($i == 1) {
				$rate_title = _BAD;
			} elseif ($i == 2) {
				$rate_title = _REGULAR;
			} elseif ($i == 3) {
				$rate_title = _GOOD;
			} elseif ($i == 4) {
				$rate_title = _VERYGOOD;
			} elseif ($i == 5) {
				$rate_title = _EXCELLENT;
			}
			return $rate_title;
		}
		if ((strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 6.0') !== FALSE) || $artview == 'old') {
			if ($ratings != 0) {
				$rate = substr($score / $ratings, 0, 4);
				$r_image = round($rate);
				if ($r_image > 0 && $r_image < 6) {
					$the_image = '<br />' . PHP_EOL
							   . '<img src="images/articles/stars-' . $r_image . '.gif" border="1" alt="" title="' . rate_title($r_image) . '" />' . PHP_EOL
							   . '</div>' . PHP_EOL
							   . '<br />' . PHP_EOL;
				}
			} else {
				$rate = 0;
				$the_image = '</div><br />' . PHP_EOL;
			}
			OpenTable();
			echo '<br />' , PHP_EOL
			   , '<div class="text-center">' , _RATEARTICLE , '</div>' , PHP_EOL
			   , '<br />' , PHP_EOL
			   , '<div class="text-center">' , _AVERAGESCORE , ': <span class="thick">' , $rate , '</span>&nbsp;&nbsp;' , _VOTES , ': <span class="thick">' , $ratings , '</span>&nbsp;</div>' , PHP_EOL
			   , '<div class="text-center centered">' , PHP_EOL
			   , $the_image
			   , '<div class="text-center centered">' , PHP_EOL
			   , '	<form action="modules.php?name=' , $module_name , '" method="post">' , PHP_EOL 
			   , '	' , _RATETHISARTICLE , PHP_EOL
			   , '	<br /><br />' , PHP_EOL;
			for ($i=5; $i>=1; $i--) {
				echo '	<input type="radio" name="score" value="' , $i , '" /> <img src="images/articles/stars-' , $i , '.gif" alt="' , rate_title($i) , '" title="' , rate_title($i) , '" />' . ($i > 1 ? '&nbsp;' : '') , PHP_EOL;
			}
			echo '	<br class="clear-both" />' , PHP_EOL
			   , '	<input type="hidden" name="sid" value="' , $sid , '" />' , PHP_EOL
			   , '	<input type="hidden" name="op" value="rate_article" />' , PHP_EOL
			   , '	<p><input type="submit" class="pointer" value="' , _CASTMYVOTE , '" /></p>' , PHP_EOL
			   , '	</form>' , PHP_EOL
			   , '</div>' , PHP_EOL;
		} else {
			if ($ratings != 0) {
				$rate = substr($score/$ratings, 0, 4);
				$r_image = round($rate);
				$the_image = '<div class="centerstar">' . PHP_EOL;
				for ($i=1; $i<=5; $i++) {
					$the_image .= '	<input name="star3" type="radio" class="star" title="' . rate_title($i) . '" disabled="disabled"' . ($i == $r_image ? ' checked="checked"' : '') . ' />' . PHP_EOL;
				}
				$the_image .= '</div><br />' . PHP_EOL;
			} else {
				$rate = 0;
				$the_image = '';
			}
			$rateinfo = '<div class="text-center">' . PHP_EOL
					  . '	' . _RATEARTICLE . '<br />' . PHP_EOL
					  . '	' . _RATETHISARTICLE . '<br />' . PHP_EOL
					  . '	' . _AVERAGESCORE . ': <span class="thick">' . $rate . '</span>&nbsp;&nbsp;' . _VOTES . ': <span class="thick">' . $ratings . '</span><br />' . PHP_EOL
					  . '	' . $the_image
					  . '	<form action="modules.php?name=' . $module_name . '" method="post">' . PHP_EOL
					  . '	<br />' . PHP_EOL
					  . '	<div class="centerstars">' . PHP_EOL;
			for ($i=1; $i<=5; $i++) {
				$rateinfo .= '		<input type="radio" name="score" value="' . $i . '" class="star" title="' . rate_title($i) . '" />' . PHP_EOL;
			}
			$rateinfo .= '	</div>' . PHP_EOL
					   . '	<br class="clear-both" />' . PHP_EOL
					   . '	<input type="hidden" name="sid" value="' . $sid . '" />' . PHP_EOL
					   . '	<input type="hidden" name="op" value="rate_article" />' . PHP_EOL
					   . '	<p><input type="submit" class="pointer" value="' . _CASTMYVOTE . '" /></p>' . PHP_EOL
					   . '	</form>' . PHP_EOL
					   . '</div>' . PHP_EOL;
		}
	} else {
		$rateinfo = '';
	}
	if ((strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 6.0') !== FALSE) || $artview=='old') {
		//echo '<div class="toncenterdiv toncentertxt">' . $moreinfo . '<br /><br />' . ($artview == 'old' ? '' : '<br />' .$rateinfo . '<br />') . '<br /><br />' . $bminfo . '</div>';
		echo '<div class="toncenterdiv toncentertxt">' , $moreinfo , '<br /><br />' , $bminfo , '</div>'; // neralex: removed rateinfo
		CloseTable();
	} else {
		Opentable();
		//Redisigned for 2.6 to work with all themes
		echo '<div class="toncenterdiv toncentertxt click">' , PHP_EOL
		   , '	<a class="rightspace" onclick="Moreinfo(); return false;" href="#"><img class="img" src="images/news/click.png" alt="click" />&nbsp;' , _TONRELATED , '</a>' , PHP_EOL
		   , '	<div id="slidingDiv1" style="padding: 4px; display:none;">' , $moreinfo , '</div>' , PHP_EOL;
		if ($TON_useRating) 
		echo '	<a class="rightspace" onclick="Rateinfo(); return false;" href="#"><img class="img" src="images/news/click.png" alt="click" />&nbsp;' , _TONRATETHIS , '</a>' , PHP_EOL
		   , '	<div id="slidingDiv2" style="padding: 4px; display:none;"><br />' , $rateinfo , '</div>' , PHP_EOL
		   , '	<a onclick="Bminfo(); return false;" href="#"><img class="img" src="images/news/click.png" alt="click" />&nbsp;' , _TONSHARE , '</a>' , PHP_EOL
		   , '	<div id="slidingDiv3" style="padding: 4px; display:none;">' , $bminfo , '</div>' , PHP_EOL
		   , '</div>' , PHP_EOL;
		Closetable();
	}
	/* End generating content for Related, Rate This and Share links */
	cookiedecode($user);
	if (!empty($associated)) {
		OpenTable();
		echo '<div class="toncenterdiv toncentertxt">' , PHP_EOL
		   , '	<p class="thick">' , _ASSOTOPIC , '</p>' , PHP_EOL;
		$asso_t = explode('-',$associated);
		for ($i=0; $i<sizeof($asso_t); $i++) {
			if (!empty($asso_t[$i])) {
				$query = $db->sql_query('SELECT `topicimage`, `topictext` FROM `' . $prefix . '_topics` WHERE `topicid` = \'' . (int)$asso_t[$i] . '\'');
				list($topicimage, $topictext) = $db->sql_fetchrow($query);
				$topicimage = htmlspecialchars($topicimage, ENT_QUOTES, _CHARSET);
				$topictext = htmlspecialchars($topictext, ENT_QUOTES, _CHARSET);
				echo '	<a href="modules.php?name=' , $module_name , '&amp;new_topic=', (int)$asso_t[$i] , '"><img src="' , $tipath , $topicimage , '" hspace="10" alt="' , $topictext , '" title="' , $topictext , '" /></a>' , PHP_EOL
				   , '	<br /><br />' , PHP_EOL;
			}
		}
		echo '</div>' , PHP_EOL;
		CloseTable();
	}
	if ($usedisqus) {
		//Start Disqus
		Opentable();
		$ds = $shortname;
		$did = $module_name . '-' . $sid;
		// $pageurl is used inside of javascript - do not use &amp; unless output as html
		// To properly tap $pageurl shortlink users must set $tnsl_bAutoTapLinks = true in rnconfig.php
		$pageurl = $nukeurl.'/modules.php?name=' . $module_name . '&file=article&sid=' . $sid;
		include_once('includes/jquery/disqus.php');
		echo disqus($ds, $did, $pageurl);
		Closetable();
		// End Disqus
		echo '</div>' . PHP_EOL; // neralex: div vs table fix
	// End Disqus
	} else {
		// Start Regular Comment Code
		if (empty($mode) OR $mode != 'nocomments' OR $acomm == 0 OR $articlecomm == 1) {
			include_once('modules/News/comments.php');
		}
	}
include_once ('footer.php');