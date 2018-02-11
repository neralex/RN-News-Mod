<?php
/**
 * @PHP-NUKE: Web Portal System
 * @package Tricked Out News
 * @version 2.6 (RN News-Mod)
 * @file: lang-swedish.php (admin)
 * @copyright (c) 2002 by Francisco Burzi
 * @Additional security & Abstraction layer conversion 2003 chatserv http://www.nukeresources.com
 * @nukeWYSIWYG Copyright (c) 2005 Kevin Guske http://nukeseo.com
 * @kses developed by Ulf Harnhammar http://kses.sf.net
 * @RavenNuke(tm) Support:
 * 2012 - Nuken http://www.trickedoutnews.com
 * 2013 - rework of all functions by neralex http://www.media.soefm.de
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
define('_ACTIVATECOMMENTS','Aktivera kommentarer f�r den h�r artikeln?');
define('_ADDARTICLE','L�gg till ny artikel');
define('_ALLSTORIES','Alla artiklar under');
define('_ANDCOMMENTS','och alla kommentarer?');
define('_ARESUREURL','(Om du inkluderar webadresser var noga med att kolla s� att dom fungerar.)');
if (!defined('_AREYOUSURE')) define('_AREYOUSURE','Om du inkluderar webadresser var noga med att kolla s� att dom fungerar + att titta efter stavfel etc?');
define('_ARTICLEADMIN','Artikel/nyhets Administrationen');
define('_ASELECTCATEGORY','V�lj kategori');
define('_ATTACHAPOLL','L�gg till en omr�stning f�r den h�r artikeln');
define('_AUTOSTORYEDIT','Redigera programerade artiklar');
define('_CATADDED','Ny kategori tillagd!');
define('_CATDELETED','Kategori raderad!');
define('_CATEGORIESADMIN','Kategorier Administration');
define('_CATEGORYADD','L�gg till ny kategori');
define('_CATEGORYNAME','Kategori namn');
define('_CATEXISTS','Den h�r kategorien finns redan!');
define('_CATNAME','Kategori Namn');
define('_CATSAVED','Kategori sparad!');
define('_CHNGPROGRAMSTORY','V�lj nytt datum f�r den h�r artikeln:');
define('_DELCATWARNING1','Du kan ta bort denna kategori och alla dess artiklar och kommentarer');
define('_DELCATWARNING2','eller s� kan du flytta alla artiklar till en ny kategori.');
define('_DELCATWARNING3','Vad vill du g�ra?');
define('_DELETECATEGORY','Radera kategori');
define('_DELETESTORY','Radera artikel');
define('_EDITARTICLE','Redigera artikel');
define('_APPROVEARTICLE','Godk�nna artikel');
define('_EMAILUSER','Email Anv�ndare');
define('_EXTENDEDTEXT','Ut�kad text');
define('_GOTOADMIN','G� till admin sektionen')
;define('_HAS','har');
define('_LEAVEBLANKTONOTATTACH','(L�mnas blank f�r att posta artikel utan omr�stning)<br />(OBS: Programerade artiklar kan inte ha omr�stning)');
define('_MOVEDONE','Gratulationer! Flytten har avslutats!');
define('_MOVESTORIES','Flytta artiklar till en ny kategori');
define('_NEWSUBMISSIONS','Nytt nyhetstips');
define('_NOARTCATEDIT','Du kan redigera <span class="italic">Artiklar</span> Kategori');
define('_NOMOVE','Nej! Flytta mina artiklar');
if (!defined('_NOSUBJECT')) define('_NOSUBJECT','Inget �mne');
define('_NOSUBMISSIONS','Inga nya artiklar');
define('_NOTAUTHORIZED1','Du tar inte tillst�nd att r�ra denna artikel!');
define('_NOTAUTHORIZED2','Du kan inte redigera eller ta bort artiklar som du inte offentliggjord');
define('_NOTES','Notera');
define('_NOWIS','Nu');
define('_ONLYIFCATSELECTED','Fungerar bara om <span class="italic">Artiklar</span> kategori �r inte vald');
if(!defined('_OPTION')) define('_OPTION','Val');
define('_POLLEACHFIELD','Ange varje valm�jlighet till ett enda f�lt');
define('_POLLTITLE','Unders�kningstitel');
define('_POSTSTORY','Posta artikel');
define('_PREVIEWSTORY','F�rhandsvisa artikel');
define('_PROGRAMSTORY','Vill du programmera in denna artikel?');
define('_PUBLISHINHOME','Publicera p� f�rsta sidan?');
define('_REMOVESTORY','�r du s�ker p� att du vill ta bort artikel ID #');
define('_SELECTCATDEL','V�lj en kategori att ta bort');
define('_SELECTNEWCAT','V�lj den nya kategorin');
define('_SELECTTOPIC','V�lj �mne');
define('_SENDPM','Skicka priv mess');
define('_STORIESINSIDE','ber�ttelser inuti');
define('_STORYTEXT','Artikel Text');
define('_SUBMISSIONSADMIN','Nyhetstips Administrationen');
efine('_THECATEGORY','Kategori');
define('_USERPROFILE','Anv�ndar profil');
define('_WILLBEMOVED','Flyttas.');
define('_YESDEL','Ja! Radera alla!');
if (!defined('_CATEGORY')) {define('_CATEGORY','Kategori'); }
define('_TONCONFIG','Tricked Out News Control Panel');
define('_TONSETUP','Control the features of Tricked Out News');
efine('_NEWSROWS','News columns display on index page');
define('_BOOKMARK','Display Bookmarks on index?');
define('_RBLOCKS','Display right block for articles?');
define('_LINKLOCATION','Index Link locations');
define('_ARTICLELINK','Display Readmore in a colorbox?');
define('_ARTVIEW','View articles old style or new?');
define('_TONUTL','Link title to article?');
define('_TONPDF','Display PDF?');
define('_TONUR','Display User Rating?');
define('_TONSTF','Display Send to Friend?');
define('_TONUCL','Use character count on index?');
define('_TONCL','If so, how many characters do you want displayed?');
define('_TONTAACT','Activate Top Ads?');
define('_TONBAACT','Activate Bottom Ads?');
define('_TONDIS','Use Disqus?');
define('_TONSN','Disqus Short Name');
define('_TONTA','To insert an ad above the article, enter the ads position number here');
define('_TONBA','To insert an ad below the article, enter the ads position number here');
define('_TONGAPI','Goo.gl API Key');
define('_TONGSB','Use Goo.gl short url for social bookmarks?');
define('_TONGA','Display Goo.gl short url at bottom of article?');
define('_TONPREVIEW','Preview Ad:');
define('_TONSHOWTAGS','Show tags on article and index?');
define('_TAGSCLOUD','Tag Cloud');
define('_SEPARATEDBYCOMMAS','Separate by commas');
define('_TONMAIN','Admin Main');
define('_TONAUTOLINKWARNING','You need to set $tnsl_bAutoTapLinks to true in rnconfig');
// RN NEWS-Sort Mod
define('_TONSORTDESCRIPTION10','Artikeln Sortering');
define('_TONSORTDESCRIPTION11','Here you can define the fields in the database with which you want to sort the stories. If you choose to select <strong>Time</strong>, will first be sorted by the <strong>Sorting Time</strong> and if this is already taken, then sorted by the <strong>Posting Time</strong>.');
define('_TONSORTDESCRIPTION20','Artikeln Sortera efter typ');
define('_TONSORTDESCRIPTION21','Here can you set the <strong>ORDER BY</strong> type of the Mysql-Query. It is possible to determine your stories by descending (<strong>DESC</strong>) or ascending (<strong>ASC</strong>) sort.');
define('_TONSORTDESCRIPTION30','Counting Years (smallest value of Sorting-Time)');
define('_TONSORTDESCRIPTION31','Here you can set the minimum value in order to count the years of sorting time. If you are selecting <strong>min year in db</strong>, then the <strong>smallest value</strong> would be determined in the database.');
define('_TONSORTDESCRIPTION40','Counting Years (biggest value of Sorting-Time)');
define('_TONSORTDESCRIPTION41','Here you can set the maximum value in order to count the years of sorting time. If you are selecting <strong>max year in db</strong>, then the <strong>biggest value</strong> would be determined in the database.');
define('_TONSORTMINYEAR','min year in db');
define('_TONSORTMAXYEAR','max year in db');
if (!defined('_TONSORTTIME2')) define('_TONSORTTIME2','Tid');
if (!defined('_TONSORTTIME')) define('_TONSORTTIME','Sorting-Time');
if (!defined('_TONPOSTTIME')) define('_TONPOSTTIME','Posting-Time');
if (!defined('_TONSUBMITTIME')) define('_TONSUBMITTIME','Submit-Time');
define('_TONAUTOTIME','Autosave-Time');
if (!defined('_TONEXPTIME')) define('_TONEXPTIME','Expiration-Time');
define('_TONSORTID','Artikeln-ID');
define('_TONSORTDESC','omv&auml;nd');
define('_TONSORTASC','stigande');
define('_TONSORTYEARS','&aring;r');
define('_TONSORTYEAR','&aring;r');
define('_TONSORTMIN','minut');
define('_TONSORTSEC','andra');
define('_TONGAPIINFO','<p style="text-align:left; color:#000;"><strong>You will need to get a goo.gl API Key to use this feature.</strong></p><p style="text-align:left; color:#000;"><strong>How to get a key?</strong></p><p style="text-align:left; color:#000;">Visit the <a style="text-decoration: underline; color:#000;" href="http://code.google.com/apis/console/" target="_blank">Google APIs Console</a>, and:</p><ul style="margin:0; list-style:decimal; text-align:left; color:#000;"><li><strong>Create a project.</strong> You can create as many or as few projects as you need. (See the <a style="text-decoration: underline; color:#000;" href="http://code.google.com/apis/console-help/#SeparateProjects" target="_blank">Google APIs Console FAQ</a> for details.) Google will generate exactly one key per project.</li><li><strong>Activate the URL Shortener API.</strong> After creating a project, you should see a list of APIs, each with an Activate button. Click the one for the url shortener.</li><li><strong>Nab the key.</strong> Click <strong>Keys</strong> on the left-hand side to findout about yours. The "Value" is the string you want.</li><li><strong>Copy &amp; Paste</strong> the Key in the&nbsp;Goo.gl API Key field and save the changes.</li></ul>');
define('_TONSNINFO','<p style="text-align:left; color:#000;"><strong>How to add Disqus to my site</strong></p><p style="text-align:left; color:#000;">You will need to go to <a style="text-decoration: underline; color:#000;" href="http://www.disqus.com" target="_blank">www.disqus.com</a> and create an account. Once your account is created, place your Disqus short name here and activate Disqus.</p>');
define('_TONADINFO','<p style="text-align:left; color:#000;"><strong>How to add an ad in Tricked Out News</strong></p><p style="text-align:left; color:#000;">You must create an ad in the Advertising module and activate it. The default position is 0 which is the same as the position in the theme header. You can create a new position in the Advertising module admin and use that position with the Tricked Out News ads. Simple create the new position, add an ad with that position and activate it. Enter the Ad Position Number here and save. The new ad will appear in your News article page.</p>');
if (!defined('_TONSTORYLOCK')) define('_TONSTORYLOCK','Status');
if (!defined('_TONSTORYLOCKACTIVE')) define('_TONSTORYLOCKACTIVE','active');
if (!defined('_TONSTORYLOCKSUBMIT')) define('_TONSTORYLOCKSUBMIT','submitted');
if (!defined('_TONSTORYLOCKTIMED')) define('_TONSTORYLOCKTIMED','timed');
if (!defined('_TONSTORYLOCKFULL')) define('_TONSTORYLOCKFULL','disabled');
if (!defined('_TONSTORYLOCKEXP')) define('_TONSTORYLOCKEXP','expired');
define('_TONHIDEAUTOTIMES','Hide the autopost and/or expiration (smaller than current date/time)');
define('_TONHIDEAUTOTIMESFAQ','If the input fields of autopost and/or expiration are stored smaller than the current date/time, then they are hided with a little jQuery Script.');
define('_TONEXPOLDTIME','You have stored a time, smaller as the current.<br />Enter a new date/time or its would be reseted.');
define('_TONSELECTALL','select all');
if (!defined('_TONAUTHOR')) define('_TONAUTHOR','Author');
if (!defined('_TONREADS')) define('_TONREADS','Reads');
define('_TONHIDEAUTOSUBMIT','Hide the autopost and expiration fields (Submit News)');
define('_TONHIDEAUTOSUBMITFAQ','You can <strong>turn off</strong> the fields of <strong>Autopost-Time</strong> and <strong>Expiration-Time</strong> in the <strong>Submit News</strong>.');
define('_TONHIDEPREVIEW','Hide the preview and show it in a colorbox (Edit &amp; Submit)');
define('_TONHIDEPREVIEWFAQ','<strong>Hide</strong> the <strong>preview</strong> of a <strong>posted</strong> or <strong>submitted</strong> story in the formular and show it in a <strong>colorbox</strong>. This option <strong>contributes</strong> to the <strong>clarity</strong> of the form.');
define('_TONARCHIVDEFAULT','Set a news archive default value of results per page');
define('_TONARCHIVDEFAULTFAQ','Here you can set a <strong>default value</strong> of <strong>results per page</strong> for the <strong>news archive</strong>. If you leave it <strong>blank</strong>, then a <strong>value</strong> is used <strong>by 20 articles</strong> per page.');
define('_TONARCHIVETOPICS','Hide the topicnames in the news archive');
define('_TONARCHIVETOPICSFAQ','Here you can <strong>hide</strong> the <strong>topicnames</strong> in the <strong>news archive</strong>. This is for <strong>themes</strong> with a <strong>small width</strong>.');
define('_TONSORTTIMEFAQ','Here you can set a <strong>time</strong>, to <strong>sort</strong> your <strong>stories</strong> besides your <strong>posting time</strong>. If you have <strong>change</strong> the <strong>News-Sorting</strong> option, from <strong>Story-ID</strong> to <strong>Sorting-Time</strong>, then it this <strong>timestamp</strong>, that control your sorting.<br /><br />If <strong>Sorting-Time</strong> and <strong>Posting-Time</strong> have the <strong>same value</strong> or the if the <strong>Sorting-Time</strong> is empty, then is the <strong>Posting-Time</strong> the <strong>main value</strong> of sorting.<br /><br />After add a new story, the <strong>Sorting-Time</strong> is smaller then the <strong>Posting-Time</strong>. <strong>This is intentional</strong>. So you can specify when creating an article, a <strong>Sorting-Time</strong> in the past, <strong>without editing</strong> the article.');
define('_TONPOSTTIMEFAQ','Here you can set the <strong>Posting-Time</strong> of the article. This is <strong>only allowed</strong>, if you <strong>do not</strong> set the <strong>status</strong> to <strong>timed</strong> or <strong>active</strong> with a time in the past.');
define('_TONAUTOPOSTTIMEFAQ','Here you can <strong>set a time</strong> to <strong>post</strong> an a time <strong>into the future</strong>. If the time has come, then <strong>goes</strong> the article <strong>automaticly online</strong>. This is an <strong>adaption</strong> of the old <strong>autonews</strong>. If you set the <strong>Posting-Time</strong> smaller then the <strong>current date</strong>, then the entered <strong>time</strong> would be <strong>not stored</strong> and it must set a new <strong>Autopost-Time</strong> in the future.');
define('_TONEXPTIMEFAQ','Here you can set a time, to <strong>expire</strong> your <strong>article</strong>. If you set a <strong>time in the future</strong>, bigger as the current date/time, then goes the article <strong>automaticly</strong> to the status <strong>disabled</strong>. I you set the <strong>Expiration-Time</strong> smaller as the current date/time, then would be the <strong>Expiration-Time</strong> reseted and you must set a new time to expire.');
define('_TONSTORYLOCKFAQ','Here you can choose the status of your article.<br /><br />If you choose <strong>disabled</strong>, so can <strong>no one of a users</strong> see or <strong>use the article</strong> on the page. <strong>only admins</strong> can use it. As <strong>admin</strong> you <strong>can use</strong> the article, how you knows it. the <strong>disabled-status</strong> allowed to use a article, but <strong>for all other visitors</strong> is the article <strong>blocked</strong>. this status <strong>works in</strong> all other <strong>modules</strong> or <strong>blocks</strong> with news-functions.<br /><br />the <strong>submit-option</strong> works as the <strong>disabled-status</strong>. this option is for locating the <strong>submit news</strong>. only if you set a <strong>Posting-Time in the past</strong>, then would be set the status to <strong>disabled</strong>.<br /><br />Only if you set a <strong>Posting-Time</strong> in the <strong>future</strong>, then you can set the <strong>status</strong> on <strong>timed</strong>. Remember here again: If you set a <strong>Expiration-Time</strong> smaller as the current date/time, then would be the <strong>Expiration-Time</strong> reseted.');
define('_ACCOUNTSUSPEND','Account Suspended');
define('_ACCOUNTDELETE','Account Deactivated');
define('_TONJQUERYSELECT','Use jQuery Selectboxes (Submit-User, Topics)');
define('_TONJQUERYSELECTFAQ','With this option you can use the select boxes to choose the submit-user and the topics with a the powerfull jQuery-UI. You can also search in the select boxes.');
define('_TONSUBMIT','Change the submit user');
define('_TONSUBMITFAQ','Here you can <strong>change</strong> the <strong>submit user</strong> of the article. You can use this option <strong>until</strong> you have the article <strong>stored</strong> under a <strong>different status</strong> as submitted. Only then is the <strong>contribution</strong> to the <strong>user</strong> or the <strong>admin</strong> assigned.');
define('_TONPENDING','The article is pending!');
define('_SAVESTATUS','Save Status');
if (!defined('_DONE')) define('_DONE','done');
if (!defined('_FAIL')) define('_FAIL','failed');
if (!defined('_APPROOVE')) define('_APPROOVE','approved');
define('_TIMINGERROR','Timing-Error');
define('_TIMINGFAIL','Your Posting-Time was not stored! Please enter a time in the future');
define('_ARCHIVECHARLIMIT','Activate a character counter for the names of the topics and articles in the archive');
define('_ARCHIVECHARLIMITFAQ','If you have activated the character counter, you can determine the values for the length of the names of topics and articles in the archive. This is especially helpful for small-width themes.');
define('_ARCHIVECOUNTTOPICS','Determine a value for the length of the topic-names in the archive');
define('_ARCHIVECOUNTTOPICSFAQ','The default value for the length of the topic-names in the archive is 20 characters if you do not specify a value.');
define('_ARCHIVECOUNTTITLES','Determine a value for the length of the article-titles in the archive');
define('_ARCHIVECOUNTTITLESFAQ','The default value for the length of the article-titles in the archive is 40 characters if you do not specify a value.');
define('_ACTIVATEADMINNOTES','Activate Admin-Notes');
if (!defined('_TONNOTTILE')) define('_TONNOTTILE','You don\'t have entered a title!');
if (!defined('_TONGOBACK')) define('_TONGOBACK','Go Back');
// submit news
define('_THANKSSUB','Thanks for your submission!');
define('_SUBSENT','Your Article has been received...');
define('_SUBTEXT','We will check your submission in the next few hours, if it is interesting and relevant we will publish it soon.');
define('_WEHAVESUB','At this moment we have');
define('_WAITING','submissions waiting to be published.');
if (!defined('_DAY')) define('_DAY','Day');
define('_YOURNAME','Your Name');
if (!defined('_ERROR')) define('_ERROR','Error');
define('_SUBMITNEWS','Submit News');
define('_SUBMITADVICE','Please write your article/story filling the following form and double check your submission.<br />You\'re advised that not all submissions will be posted.<br />Your submission will be checked for proper grammar and maybe edited by our staff.');
define('_BEDESCRIPTIVE','Be Descriptive, Clear and Simple');
define('_BADTITLES','bad titles=\'Check This Out!\' or \'An Article\'');
define('_HTMLISFINE','HTML is fine, but double check those URLs and HTML tags!');