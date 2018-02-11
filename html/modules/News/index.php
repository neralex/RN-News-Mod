<?php
/**
 * @PHP-NUKE: Web Portal System
 * @package Tricked Out News
 * @version 2.6 (RN News-Mod)
 * @file: index.php
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
$index = 0;
if (!defined('INDEX_FILE')) define('INDEX_FILE', true); // Set to FALSE to hide right blocks
if (defined('INDEX_FILE') AND INDEX_FILE === true) {
	// auto set right blocks for pre patch 3.1 compatibility
	$index = 1;
}

$module_name = basename(dirname(__FILE__));
get_lang($module_name);

$PreferredStyle = 'news.css';
$ThemeSel = get_theme();
$tonCssFile = INCLUDE_PATH . 'themes/' . $ThemeSel . '/style/' . $PreferredStyle;
$DefaultStyle = 'modules/' . $module_name . '/css/' . $PreferredStyle;
if (file_exists($tonCssFile)) {
	define('RN_MODULE_CSS', $PreferredStyle);
} else {
	addCSSToHead($DefaultStyle, 'file');
}
		
if (!(isset($new_topic))) $new_topic = 0;
if (!(isset($score))) $score = 0;
if (!isset($op)) $op = '';
if (!isset($pagenum)) $pagenum = 0;

switch ($op) {
	default:
		theindex(intval($new_topic)); // Converting numerics to integers when passing precludes having to do it in every routine that calls it
		break;
	case 'rate_article':
		csrf_check();
		rate_article(intval($sid) , intval($score)); // Converting numerics to integers when passing precludes having to do it in every routine that calls it
		break;
	case 'rate_complete':
		if (!isset($rated)) {
			$rated = 0;
		}
		rate_complete(intval($sid) , intval($rated)); // Converting numerics to integers when passing precludes having to do it in every routine that calls it
		break;
}
die();

/*
 * Only functions below this line
 */
function theindex($new_topic = 0) {
	global $db, $storyhome, $topicname, $topicimage, $topictext, $datetime, $user, $cookie, $nukeurl, $prefix, $multilingual, $currentlang, $articlecomm, $sitename, $user_news, $userinfo;
	// Query TON addons
	$sql_ton = 'SELECT `newsrows`, `bookmark`, `linklocation`, `articlelink`, `TON_useTitleLink`, `TON_usePDF`, `TON_useRating`, `TON_useSendToFriend`, `showtags`, `TON_useCharLimit`, `TON_CharLimit`, `usedisqus`, `shortname`, `googlapi`, `usegooglsb`, `newssort`, `newsorder`, `usenotes` FROM `' . $prefix . '_ton`';
	$result_ton = $db->sql_query($sql_ton);
	$row = $db->sql_fetchrow($result_ton);
	$newsrows = $row['newsrows'];
	$bookmark = $row['bookmark'];
	$linklocation = $row['linklocation'];
	$articlelink = $row['articlelink'];
	$TON_useTitleLink = $row['TON_useTitleLink'];
	$TON_usePDF = $row['TON_usePDF'];
	$TON_useRating = $row['TON_useRating'];
	$TON_useSendToFriend = $row['TON_useSendToFriend'];
	$showtags = $row['showtags'];
	$TON_useCharLimit = $row['TON_useCharLimit'];
	$TON_CharLimit = $row['TON_CharLimit'];
	$usedisqus = $row['usedisqus'];
	$shortname = $row['shortname'];
	$googlapi = $row['googlapi'];
	$usegooglsb = $row['usegooglsb'];
	$usenotes = $row['usenotes'];
	// neralex: change newssort
	$newsorder = $row['newsorder'];
	if ($newsorder == 1) {
		$newsordertype = 'ASC';
	} elseif ($newsorder == 0) {
		$newsordertype = 'DESC';
	}	
	$newssort = $row['newssort'];
	if ($newssort == 1) {
		$newssorting = 'ORDER BY s.`time2` ' . $newsordertype . ', s.`time` ' . $newsordertype;
	} elseif ($newssort == 0) {
		$newssorting = 'ORDER BY s.`sid` ' . $newsordertype;
	}			
	//determine percentage for news row mod
	if ($newsrows == 1) {
		$newspercent ='onehundred';
	} elseif ($newsrows == 2) {
		$newspercent ='nothundred'; // neralex: div vs table fix
	}
	// if "columns display" is active and its shows only one id in news or catagories, then has the container the full width
	$fullwidth = 0; // neralex: set to 0, if you don't want the first container in full width
	if (is_user($user)) {
		getusrinfo($user);
	}
	if ($multilingual == 1) {
		$querylang = 'AND (`alanguage` = \'' . $currentlang . '\' OR `alanguage` = \'\') AND s.`slock` = 0';
	} else {
		$querylang = 'AND s.`slock` = 0';
	}
	if ($articlelink == 1) {
		$inlineJS  = '<script type="text/javascript">$(document).ready(function() {$(\'.colorbox3\').colorbox({opacity:0.50, width:"600"});});</script>' . PHP_EOL;
		addJSToBody($inlineJS,'inline');
	}
	include_once 'header.php';
	automated_news();
	if (isset($userinfo['storynum']) AND $user_news == 1) {
		$storynum = $userinfo['storynum'];
	} else {
		$storynum = $storyhome;
	}
	if ($new_topic == 0) {
		$qdb = 'WHERE (`ihome` = 0 OR s.`catid` = 0)';
		$home_msg = '';
	} else {
		$qdb = 'WHERE topic=' . $new_topic;
		$result_a = $db->sql_query('SELECT `topictext` FROM `' . $prefix . '_topics` WHERE `topicid` = \'' . $new_topic . '\'');
		$row_a = $db->sql_fetchrow($result_a);
		$numrows_a = $db->sql_numrows($result_a);
		$topic_title = htmlspecialchars($row_a['topictext'], ENT_QUOTES, _CHARSET);
		OpenTable();
		if ($numrows_a == 0) {
			echo '<div class="text-center centered">' , PHP_EOL
			   , '	<p class="title">' , $sitename , '</p>' , PHP_EOL
			   , '	<br /><br />' , _NOINFO4TOPIC , '<br /><br />' , PHP_EOL
			   , '	[ <a href="modules.php?name=News">' , _GOTONEWSINDEX , '</a> | <a href="modules.php?name=Topics">' , _SELECTNEWTOPIC , '</a> ]' , PHP_EOL
			   , '</div>';
		} else {
			echo '<div class="text-center centered">' , PHP_EOL
			   , '	<p class="title">' , $sitename , ': ' , $topic_title , '</p>' , PHP_EOL
			   , '	<br /><br />' , PHP_EOL
			   , '	<form action="modules.php?name=Search" method="post">' , PHP_EOL
			   , '	<input type="hidden" name="topic" value="' , $new_topic , '" />' , PHP_EOL
			   , '	' , _SEARCHONTOPIC , ': <input type="text" name="query" size="30" />&nbsp;&nbsp;' , PHP_EOL
			   , '	<input type="submit" class="pointer" value="' , _SEARCH , '" />' , PHP_EOL
			   , '</form>' , PHP_EOL
			   , '[ <a href="index.php">' , _GOTOHOME , '</a> | <a href="modules.php?name=Topics">' , _SELECTNEWTOPIC , '</a> ]' , PHP_EOL
			   , '</div>' , PHP_EOL;
		}
		CloseTable();
		echo '<br />' , PHP_EOL;
	} // END THAT THERE IS A NEW TOPIC

	global $pagenum, $usePaginatorControl, $cfgPaginatorControl; // If you use setQSPage() to change from 'pagenum' to something else, you must change $pagenum here to whatever you used
	$iNumRowsPerPg = $storyhome+1;
	$sql = 'SELECT `sid` FROM `' . $prefix . '_stories` WHERE (`ihome` = 0 OR `catid` = 0) AND `slock` = 0 LIMIT 0,' . $iNumRowsPerPg; //Modified to detect only visible articles
	$iTotNewsCount = $db->sql_numrows($db->sql_query($sql));
	if ($iTotNewsCount < $iNumRowsPerPg) $usePaginatorControl = false;
	if (isset($usePaginatorControl) and $usePaginatorControl) {
		$pagenum = intval($pagenum);
		list($iNewsCount) = $db->sql_fetchrow($db->sql_query('SELECT COUNT(`sid`) AS `iNewsCount` FROM `' . $prefix . '_stories` s ' . $qdb . ' ' . $querylang));
		include_once NUKE_CLASSES_DIR . 'class.paginator.php';
		include_once NUKE_CLASSES_DIR . 'class.paginator_html.php';
		$oPaginator = new Paginator_html($pagenum, $iNewsCount, $storynum);
		$oPaginator->setDefaults($cfgPaginatorControl);
		$oPaginator->set_Links($cfgPaginatorControl['iMaxPages']); // Sets number of links before and after current page to show
		$oPaginator->setLink('modules.php?name=News&amp;new_topic=' . $new_topic);
		$oPaginator->setTotalItems(_PAGINATOR_TOTALSTORIES);
		$sPaginatorHTML = $oPaginator->getPagerHTML() . '<br />' . PHP_EOL;
		if ($cfgPaginatorControl['iPosition'] == 0 or $cfgPaginatorControl['iPosition'] == 2) {
			echo $sPaginatorHTML;
		}
		$limit = $oPaginator->getStartRow() . ',' . $storynum;
	} else {
		$limit = $storynum;
	}
	//Control column mod Tricked Out News
	echo '<div id="ncolumn">' . PHP_EOL; // neralex: div vs table fix
	$count = 0;
	//end Control column mod Tricked Out News
	$result = $db->sql_query('SELECT t.`topicname`, t.`topicimage`, t.`topictext`, t.`topicid`, s.`sid` as `ssid`, s.`catid`, s.`aid`, s.`title`, s.`time`, s.`time2`, s.`hometext`, s.`bodytext`, s.`comments`, s.`counter`, s.`topic`, s.`informant`,'
		    . ' s.`notes`, s.`acomm`, s.`score`, s.`ratings`, s.`ihome`, c.`title` as `ctitle`'
		    . ' FROM `' . $prefix . '_stories` s LEFT JOIN `' . $prefix . '_topics` t ON t.`topicid` = s.`topic` LEFT JOIN `' . $prefix . '_stories_cat` c ON c.`catid` = s.`catid` '
		    . $qdb . ' ' . $querylang . ' ' . $newssorting . ' LIMIT ' . $limit);

	 //Control column mod Tricked Out News
	if ($fullwidth == 1 && $newsrows == 2) { 
		$numrows = $db->sql_numrows($result);
		if ($numrows > 1) { // neralex: check if more as 1 id
			$numcheck = 2;
		} else {
			$numcheck = 1;
		}
	} else {
		$numcheck = '';
	}
	//end Control column mod Tricked Out News
	
	while ($row = $db->sql_fetchrow($result)) {
		$topicname = htmlspecialchars($row['topicname'], ENT_QUOTES, _CHARSET);
		$topicimage = htmlspecialchars($row['topicimage'], ENT_QUOTES, _CHARSET);
		$topictext = htmlspecialchars($row['topictext'], ENT_QUOTES, _CHARSET);
		$sid = $row['ssid'];
		$catid = $row['catid'];
		$aid = htmlspecialchars($row['aid'], ENT_QUOTES, _CHARSET);
		$title = htmlspecialchars($row['title'], ENT_QUOTES, _CHARSET);
		$time = $row['time'];
		$hometext = $row['hometext'];
		$bodytext = $row['bodytext'];
		$comments = $row['comments'];
		$counter = $row['counter'];
		$topic = $row['topic'];
		$informant = htmlspecialchars($row['informant'], ENT_QUOTES, _CHARSET);
		if ($usenotes == 1) {
			$notes = $row['notes'];
		} else {
			$notes = '';
		}
		$acomm = $row['acomm'];
		$score = $row['score'];
		$ratings = $row['ratings'];
		if ($catid > 0) {
			$cattitle = htmlspecialchars($row['ctitle'], ENT_QUOTES, _CHARSET);
		}
		formatTimestamp($time);
		$introcount = strlen($hometext);
		$fullcount = strlen($bodytext);
		$totalcount = $introcount+$fullcount;
		$c_count = $comments;
		$story_link = '<a href="modules.php?name=News&amp;file=article&amp;sid=' . $sid . '">';
		// Start Character Count Mod
		if ($TON_useCharLimit) {
			if (strlen($hometext) <= $TON_CharLimit) {
				$hometext = $hometext;
			} else {
				$hometext = substr($hometext, 0, strrpos(substr($hometext, 0, $TON_CharLimit), ' ')).'' . $story_link . '&nbsp;&nbsp;' . _READMORE . '</a></p><br />';
				//$hometext = substr($hometext, 0, strrpos(substr($hometext, 0, $TON_CharLimit), ' ')).'' . $story_link . '&nbsp;&nbsp;' . _READMORE . '</a><br />';
			}
		}
		// End Character Count Mod
		// Start Readmore link on index
		if (($TON_useCharLimit == 0) && (!empty($bodytext))) {
		        $hometext = $hometext . $story_link .'&nbsp;' . _READMORE . '</a>' . PHP_EOL;
				}
		//End Readmore link on index
		// Start Tags Mod
		if ($showtags) {
			$db_tags_cloud = $db->sql_query('SELECT `tag` FROM `' . $prefix . '_tags` WHERE `whr` = 3 AND `cid` = \'' . $sid. '\'');
			$verifytags = $db->sql_numrows($db_tags_cloud);
			if(!empty($verifytags)) {
				$taglink = '<div class="tagindex"><img src="images/news/tag.png" alt="Tags" align="left" />&nbsp;';
				while ($row = $db->sql_fetchrow($db_tags_cloud)) {
					$tag = $row['tag'];
					$taglink .= '<a href="modules.php?name=Tags&amp;op=list&amp;tag=' . urlencode($tag) . '" title="' . htmlspecialchars($tag, ENT_QUOTES, _CHARSET) . '">' . htmlspecialchars($tag, ENT_QUOTES, _CHARSET) . '</a> ';
				}
				$taglink .= '</div>' . PHP_EOL;
			} else {
				$taglink = '';
			}
			$hometext = '<br />' . $taglink . $hometext;
		}
		// End Tags Mod
		// Start Disqus Comment Count
		if ($usedisqus) {
			global $module_name;
			$ds = $shortname;
			include_once('includes/jquery/disqus.php');
			disqusCounter($ds);
			$hometext = $hometext . '<br />' . PHP_EOL
					  . '<a href="modules.php?name=News&amp;file=article&amp;sid=' . $sid . '"><img src="images/news/comment.png" style="opacity:0.4;" '
					  . 'onmouseover="this.style.opacity=1;" onmouseout="this.style.opacity=0.4;" alt="Comments" title="Comments" /></a>'
					  . '&nbsp;'
					  . '<a class="commentlink thick" href="' . $nukeurl . '/modules.php?name=News&amp;file=article&amp;sid=' . $sid . '#disqus_thread" rel="' . $module_name . '-' . $sid . '">' . _COMMENTS . '</a>' . PHP_EOL;
		}
		// End Disqus Comment Count
		if ($articlecomm == 1 AND $acomm == 0) {
			if ($c_count == 0) {
				$commentnum =  _COMMENTSQ;
			} elseif ($c_count == 1) {
				$commentnum = $c_count . ' ' . _COMMENT;
			} elseif ($c_count > 1) {
				$commentnum = $c_count . ' ' . _COMMENTS;
			}
		}
		$rated = 0;
		if ($score != 0) {
			$rated = substr($score/$ratings, 0, 4);
		}
		$ratetext = '' . _SCORE . ' ' . $rated;
		//Start TON Links
		$linkopacity ='opacity:0.4;" onmouseover="this.style.opacity=1;" onmouseout="this.style.opacity=0.4;';
		$bottomlink = $pdfLinkBottom = $pdfLinkTop = $stfLinkBottom = $stfLinkTop = $rateLinkBottom = $rateLinkTop = '';
		if ($TON_usePDF) {
			$pdfLinkBottom = '<a target="_blank" href="modules.php?name=News&amp;file=printpdf&amp;id=' . $sid . '" class="normal-text topbottomlinks"><img style="' . $linkopacity . '" class="newsicon pdf" src="modules/News/css/images/transparent.gif" alt="' . _PDF . '" title="cssheader=[tonheaderclass] cssbody=[tonbodyclass] header=[' . _PDF . ']body=[]" /></a>' . PHP_EOL;
			$pdfLinkTop = '<a target="_blank" href="modules.php?name=News&amp;file=printpdf&amp;id=' . $sid . '" class="normal-text topbottomlinks"><img style="' . $linkopacity . '" class="newsposition newsicon pdf" src="modules/News/css/images/transparent.gif" alt="' . _PDF . '" title="cssheader=[tonheaderclass] cssbody=[tonbodyclass] header=[' . _PDF . ']body=[]" /></a>' . PHP_EOL;
		}
		if ($TON_useSendToFriend) {
			$stfLinkBottom = '<a href="modules.php?name=News&amp;file=friend&amp;op=FriendSend&amp;sid=' . $sid . '" class="normal-text topbottomlinks"><img style="' . $linkopacity . '" class="newsicon mail" src="modules/News/css/images/transparent.gif" alt="' . _FRIEND . '" title="cssheader=[tonheaderclass] cssbody=[tonbodyclass] header=[' . _FRIEND . ']body=[]" /></a>' . PHP_EOL;
			$stfLinkTop = '<a href="modules.php?name=News&amp;file=friend&amp;op=FriendSend&amp;sid=' . $sid . '" class="normal-text"><img style="' . $linkopacity . '" class="newsposition newsicon mail" src="modules/News/css/images/transparent.gif"  alt="' . _FRIEND . '" title="cssheader=[tonheaderclass] cssbody=[tonbodyclass] header=[' . _FRIEND . ']body=[]" /></a>' . PHP_EOL;
		}
		if ($TON_useRating) {
			$rateLinkBottom = '<img style="' . $linkopacity . '" class="newsicon rated" src="modules/News/css/images/transparent.gif" alt="' . _SCORE . '" title="cssheader=[tonheaderclass] cssbody=[tonbodyclass] header=['.$ratetext.']body=[]" />' . PHP_EOL;
			$rateLinkTop = '&nbsp;<img style="' . $linkopacity . '" class="newsposition newsicon rated" src="modules/News/css/images/transparent.gif" alt="' . _SCORE . '" title="cssheader=[tonheaderclass] cssbody=[tonbodyclass] header=['.$ratetext.']body=[]" />' . PHP_EOL;
		}
		if ($articlelink=='1') {
			if ($fullcount > 0) {
				$bottomlink = '<a class="colorbox3 cboxelement normal-text topbottomlinks" href="modules.php?name=News&amp;file=articlebox&amp;sid=' . $sid . '"><img style="' . $linkopacity . '" class="newsicon readmore" src="modules/News/css/images/transparent.gif" alt="' . _READMORE . '" title="cssheader=[tonheaderclass] cssbody=[tonbodyclass] header=[' . _READMORE . ']body=[]" /></a>' . PHP_EOL;
			}
		} elseif ($articlelink=='0') {
			if ($fullcount > 0) {
				$bottomlink = '<a href="modules.php?name=News&amp;file=article&amp;sid=' . $sid . '" class="normal-text topbottomlinks"><img style="' . $linkopacity . '" class="newsicon readmore" src="modules/News/css/images/transparent.gif" alt="' . _READMORE . '" title="cssheader=[tonheaderclass] cssbody=[tonbodyclass] header=[' . _READMORE . ']body=[]" /></a>' . PHP_EOL;
			}
		}
		$bottomlink .= '<a href="modules.php?name=News&amp;file=print&amp;sid=' . $sid . '" class="normal-text topbottomlinks"><img style="' . $linkopacity . '" class="newsicon print" src="modules/News/css/images/transparent.gif" alt="' . _PRINTER . '" title="cssheader=[tonheaderclass] cssbody=[tonbodyclass] header=[' . _PRINTER . ']body=[]" /></a>'.$stfLinkBottom.$pdfLinkBottom;
		if ($articlecomm == 1 AND $acomm == 0 AND $usedisqus == 0) {
			$bottomlink .= '<a href="modules.php?name=News&amp;file=article&amp;sid=' . $sid . '" class="normal-text topbottomlinks"><img style="' . $linkopacity . '" class="newsicon comment" src="modules/News/css/images/transparent.gif" alt="' . _UCOMMENT . '" title="cssheader=[tonheaderclass] cssbody=[tonbodyclass] header=[' . $commentnum . ']body=[]" /></a>&nbsp;';
			}else{
			$bottomlink .= '<a href="modules.php?name=News&amp;file=article&amp;sid=' . $sid . '" class="normal-text topbottomlinks"><img style="' . $linkopacity . '" class="newsicon more" src="modules/News/css/images/transparent.gif" alt="' . _MOREABOUT . '" title="cssheader=[tonheaderclass] cssbody=[tonbodyclass] header=[' . _MOREABOUT . ']body=[]" /></a>&nbsp;';
		}
		$bottomlink .= $rateLinkBottom;
		$toplink = $rateLinkTop;
		if ($articlecomm == 1 AND $acomm == 0 AND $usedisqus == 0) {
			$toplink .= '<a href="modules.php?name=News&amp;file=article&amp;sid=' . $sid . '" class="normal-text topbottomlinks"><img style="' . $linkopacity . '" class="newsposition newsicon comment" src="modules/News/css/images/transparent.gif" alt="' . _UCOMMENT . '" title="cssheader=[tonheaderclass] cssbody=[tonbodyclass] header=[' . $commentnum . ']body=[]" /></a>';
		}else{
			$toplink .= '<a href="modules.php?name=News&amp;file=article&amp;sid=' . $sid . '" class="normal-text topbottomlinks"><img style="' . $linkopacity . '" class="newsposition newsicon more" src="modules/News/css/images/transparent.gif" alt="' . _MOREABOUT . '" title="cssheader=[tonheaderclass] cssbody=[tonbodyclass] header=[' . _MOREABOUT . ']body=[]" /></a>';
		}
		$toplink .= '<a href="modules.php?name=News&amp;file=print&amp;sid=' . $sid . '" class="normal-text"><img style="' . $linkopacity . '" class="newsposition newsicon print" src="modules/News/css/images/transparent.gif" alt="' . _PRINTER . '" title="cssheader=[tonheaderclass] cssbody=[tonbodyclass] header=[' . _PRINTER . ']body=[]" /></a>'.$stfLinkTop.$pdfLinkTop;
		if ($articlelink=="1") {
			if ($fullcount > 0) {
				$toplink .= '<a class="colorbox3 cboxelement normal-text" href="modules.php?name=News&amp;file=articlebox&amp;sid=' . $sid . '"><img style="' . $linkopacity . '" class="newsposition newsicon readmore" src="modules/News/css/images/transparent.gif" alt="' . _READMORE . '" title="cssheader=[tonheaderclass] cssbody=[tonbodyclass] header=[' . _READMORE . ']body=[]" /></a>';
			}
		} elseif ($articlelink == '0') {
			if ($fullcount > 0) {
				$toplink .= '<a href="modules.php?name=News&amp;file=article&amp;sid=' . $sid . '" class="normal-text topbottomlinks"><img style="' . $linkopacity . '" class="newsposition newsicon readmore" src="modules/News/css/images/transparent.gif" alt="' . _READMORE . '" title="cssheader=[tonheaderclass] cssbody=[tonbodyclass] header=[' . _READMORE . ']body=[]" /></a>';
			}
		}
		$articletitle = $title; // pass the raw title to nukeSEO SB
		if ($TON_useTitleLink) $title = $story_link . $title . '</a>'; // Make the title a link to the story
		if ($linklocation == 'top') {
			$title .= $toplink;
		}
		// Tricked Out News
		if ($linklocation == 'bottom') {
			$morelink = $bottomlink .'<br />';
		} else {
			$morelink = '<br />';
		}
		// Tricked Out News
		// Google short url
		if (isset($googlapi) AND ($usegooglsb)) {
			$gooarticleurl = $nukeurl . '/modules.php?name=News&file=article&sid=' . $sid;
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
			}
		if ($bookmark == '1') {
			// nukeSEO Social Bookmarking Tricked Out News
			require_once('includes/nukeSEO_SB.php');
			global $nukeurl;
			if (isset($googlapi) AND ($usegooglsb)) {
				$articleurl = $goourl;
			} elseif (defined('TNSL_USE_SHORTLINKS')) {
				$articleurl = $nukeurl . '/article' . $sid . '.html';
			} else {
				$articleurl = $nukeurl . '/modules.php?name=News&file=article&sid=' . $sid;
			}
			$socialbookmarkHTML = getBookmarkHTML($articleurl, $articletitle, '&nbsp;', 'small');
			$morelink .= $socialbookmarkHTML;
			// nukeSEO Social Bookmarking
		}
		// Control column mod Tricked Out News
		if ($count % $newsrows == 0) echo '<div class="getzero">' , PHP_EOL; // neralex: added class getzero
		$count++;
		echo '<div class="'; // neralex: div vs talbe fix
		if ($numcheck == 1 &&  $newspercent == 'nothundred') { // neralex: check if not more as 1 id
			echo 'onehundred';
		} elseif ($newspercent == 'nothundred') { // neralex: check if more as 1 id
			echo 'nothundred';
			if ($count % 2 != 0) {
				echo ' nright';
			} else {
				echo ' nleft';
			}
		} else {
			echo 'onehundred';
		}
		echo '">' , PHP_EOL;
		//end Control column mod Tricked Out News
		themeindex($aid, $informant, $datetime, $title, $counter, $topic, $hometext, $notes, $morelink, $topicname, $topicimage, $topictext);
		//Control column mod Tricked Out News
		echo '</div>'; // neralex: div vs talbe fix
		if ($count % $newsrows == 0) echo '</div>' , PHP_EOL; // neralex: div vs talbe fix
		//end Control column mod Tricked Out News
	} // end of the while loop
	//Control column mod Tricked Out News
	if ($count > 0 && $count % $newsrows != 0) { // neralex devision by zero fix
		echo '</div>' , PHP_EOL; // neralex div vs talbe fix
	}
	// if ($count < 1) echo '<tr><td></td></tr>';  //added for compliance if no articles are in index.  // neralex: div vs talbe fix
	echo '</div>' , PHP_EOL; // neralex: div vs talbe fix
	//end Control column mod Tricked Out News
	if ((isset($usePaginatorControl) && $usePaginatorControl) && ($cfgPaginatorControl['iPosition'] == 1 || $cfgPaginatorControl['iPosition'] == 2)) {
		echo $sPaginatorHTML;
	}
	include_once 'footer.php';
}
function rate_article($sid, $score) {
	global $prefix, $db, $ratecookie, $sitename;
	if (!isset($a)) $a = '';
	if (!isset($r_cookie)) $r_cookie = '';
	if (!isset($rcookie)) $rcookie = '';
	if ($score) {
		if ($score > 5) {
			$score = 5;
		}
		if ($score < 1) {
			$score = 1;
		}
		if ($score != 1 AND $score != 2 AND $score != 3 AND $score != 4 AND $score != 5) {
			Header('Location: index.php');
			die();
		}
		if (isset($ratecookie)) {
			$rcookie = base64_decode($ratecookie);
			$rcookie = addslashes($rcookie);
			$r_cookie = explode(':', $rcookie);
		}
		for ($i = 0;$i < sizeof($r_cookie);$i++) {
			if ($r_cookie[$i] == $sid) {
				$a = 1;
			}
		}
		if ($a == 1) {
			Header('Location: modules.php?name=News&op=rate_complete&sid=' . $sid . '&rated=1');
		} else {
			$result = $db->sql_query('UPDATE `' . $prefix . '_stories` SET `score` = `score`+' . $score . ', `ratings` = `ratings`+1 WHERE `sid` = \'' . $sid . '\'');
			$info = base64_encode($rcookie . $sid . ':');
			setcookie('ratecookie', $info, time() +3600);
			update_points(7);
			Header('Location: modules.php?name=News&op=rate_complete&sid=' . $sid);
		}
	} else {
		include_once 'header.php';
		title($sitename . ': ' . _ARTICLERATING);
		OpenTable();
		echo '<div class="text-center">' , _DIDNTRATE , '<br /><br />' , _GOBACK , '</div>' , PHP_EOL;
		CloseTable();
		include_once 'footer.php';
	}
}

function rate_complete($sid, $rated = 0) {
	global $sitename, $user, $cookie, $userinfo;

	include_once 'header.php';
	title($sitename . ': ' . _ARTICLERATING);
	OpenTable();
	if ($rated == 0) {
		echo '<div class="text-center">' , _THANKSVOTEARTICLE , '<br /><br />'
		   , '[ <a href="modules.php?name=News&amp;file=article&amp;sid=' , $sid , '">' , _BACKTOARTICLEPAGE , '</a> ]</div>' , PHP_EOL;
	} elseif ($rated == 1) {
		echo '<div class="text-center">' , _ALREADYVOTEDARTICLE , '<br /><br />'
		   , '[ <a href="modules.php?name=News&amp;file=article&amp;sid=' , $sid , '">' , _BACKTOARTICLEPAGE , '</a> ]</div>' , PHP_EOL;
	}
	CloseTable();
	include_once 'footer.php';
}