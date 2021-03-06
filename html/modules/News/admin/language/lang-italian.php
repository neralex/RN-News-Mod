<?php
/**
 * @PHP-NUKE: Web Portal System
 * @package Tricked Out News
 * @version 2.6 (RN News-Mod)
 * @file: lang-italian.php (admin)
 * @copyright (c) 2002 by Francisco Burzi
 * @Additional security & Abstraction layer conversion 2003 chatserv http://www.nukeresources.com
 * @nukeWYSIWYG Copyright (c) 2005 Kevin Guske http://nukeseo.com
 * @kses developed by Ulf Harnhammar http://kses.sf.net
 * @RavenNuke(tm) Support:
 * 2012 - Nuken http://www.trickedoutnews.com
 * 2013 - rework of all functions by neralex http://www.media.soefm.de
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
define('_ACTIVATECOMMENTS','Attivare i commenti per questo articolo?');
define('_ADDARTICLE','Aggiungi nuovo articolo');
define('_ALLSTORIES','TUTTI gli articoli sotto');
define('_ANDCOMMENTS','e tutti i suoi commenti?');
define('_ARESUREURL','(Se hai incluso un URL assicurati di convalidarlo e testarlo per controllare eventuali errori)');
if (!defined('_AREYOUSURE')) define('_AREYOUSURE','Are you sure you included a URL? Did you test them for typos?');
define('_ARTICLEADMIN','Amministrazione Articoli');
define('_ASELECTCATEGORY','Seleziona Categoria');
define('_ATTACHAPOLL','Allega un sondaggio a questo articolo');
define('_AUTOSTORYEDIT','Modifica articolo automatico');
define('_CATADDED','Nuova categoria aggiunta!');
define('_CATDELETED','Categoria cancellata!');
define('_CATEGORIESADMIN','Amministrazione categorie');
define('_CATEGORYADD','Aggiungi una nuova categoria');
define('_CATEGORYNAME','Nome categoria');
define('_CATEXISTS','Questa categoria esiste gi&agrave;!');
define('_CATNAME','Nome categoria');
define('_CATSAVED','Categoria salvata!');
define('_CHNGPROGRAMSTORY','Seleziona una nuova data per questo articolo:');
define('_DELCATWARNING1','Puoi cancellare questa categoria e TUTTI i suoi articoli e commenti');
define('_DELCATWARNING2','oppure puoi spostare TUTTI gli articoli in una nuova categoria.');
define('_DELCATWARNING3','Cosa vuoi fare?');
define('_DELETECATEGORY','Cancella categoria');
define('_DELETESTORY','Cancella articolo');
define('_EDITARTICLE','Modifica articolo');
define('_APPROVEARTICLE','Approvare articolo');
define('_EMAILUSER','Email Utente');
define('_EXTENDEDTEXT','Testo esteso');
define('_GOTOADMIN','Vai alla sezione amministrativa');
define('_HAS','ha');
define('_LEAVEBLANKTONOTATTACH','(Lasciare in bianco per postare l\'articolo senza allegare sondaggio)<br>(NOTA: le news automatiche o programmate non possono avere sondaggi allegati)');
define('_MOVEDONE','Congratulazioni! Spostamento completato!');
define('_MOVESTORIES','Sposta articoli in una nuova categoria');
define('_NEWSUBMISSIONS','Inserimenti di nuovi articoli');
define('_NOARTCATEDIT','Non puoi modificare la categoria <span class="italic">Articoli</span>');
define('_NOMOVE','No! Sposta sposta i miei articoli');
if (!defined('_NOSUBJECT')) define('_NOSUBJECT','Nessun oggetto');
define('_NOSUBMISSIONS','Nessuna nuova inserzione');
define('_NOTAUTHORIZED1','Non sei autorizzato a modificare questo articolo!');
define('_NOTAUTHORIZED2','Non puoi modificare o cancellare articoli non pubblicati da te');
define('_NOTES','Note');
define('_NOWIS','Adesso &egrave;');
define('_ONLYIFCATSELECTED','Funziona solo se la categoria <span class="italic">Articoli</span> non &egrave; selezionata');
if(!defined('_OPTION')) define('_OPTION','Opzione');
define('_POLLEACHFIELD','Inserisci ogni opzione disponibile in ogni singolo campo');
define('_POLLTITLE','Titolo Sondaggio');
define('_POSTSTORY','Invia articolo');
define('_PREVIEWSTORY','Anteprima articolo');
define('_PROGRAMSTORY','Vuoi programmare questo articolo?');
define('_PUBLISHINHOME','Pubblica in Homepage?');
define('_REMOVESTORY','Sei sicuro di voler rimuovere l\'Articolo ID #');
define('_SELECTCATDEL','Seleziona categoria da cancellare');
define('_SELECTNEWCAT','Seleziona la nuova categoria');
define('_SELECTTOPIC','Seleziona argomento');
define('_SENDPM','Manda un messaggio privato');
define('_STORIESINSIDE','articoli');
define('_STORYTEXT','Testo articolo');
define('_SUBMISSIONSADMIN','Amministrazione Inserzione Articoli');
define('_THECATEGORY','La categoria');
define('_USERPROFILE','Profilo utente');
define('_WILLBEMOVED','possono essere spostati.');
define('_YESDEL','Si! Cancella TUTTO!');
if (!defined('_CATEGORY')) {define('_CATEGORY','Categoria'); }
define('_TONCONFIG','Tricked Out News Control Panel');
define('_TONSETUP','Control the features of Tricked Out News');
define('_NEWSROWS','News columns display on index page');
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
define('_TONSORTDESCRIPTION10','News Sorting');
define('_TONSORTDESCRIPTION11','Here you can define the fields in the database with which you want to sort the stories. If you choose to select <strong>Time</strong>, will first be sorted by the <strong>Sorting Time</strong> and if this is already taken, then sorted by the <strong>Posting Time</strong>.');
define('_TONSORTDESCRIPTION20','News Order-Type');
define('_TONSORTDESCRIPTION21','Here can you set the <strong>ORDER BY</strong> type of the Mysql-Query. It is possible to determine your stories by descending (<strong>DESC</strong>) or ascending (<strong>ASC</strong>) sort.');
define('_TONSORTDESCRIPTION30','Counting Years (smallest value of Sorting-Time)');
define('_TONSORTDESCRIPTION31','Here you can set the minimum value in order to count the years of sorting time. If you are selecting <strong>min year in db</strong>, then the <strong>smallest value</strong> would be determined in the database.');
define('_TONSORTDESCRIPTION40','Counting Years (biggest value of Sorting-Time)');
define('_TONSORTDESCRIPTION41','Here you can set the maximum value in order to count the years of sorting time. If you are selecting <strong>max year in db</strong>, then the <strong>biggest value</strong> would be determined in the database.');
define('_TONSORTMINYEAR','min year in db');
define('_TONSORTMAXYEAR','max year in db');
if (!defined('_TONSORTTIME2')) define('_TONSORTTIME2','Tempo');
if (!defined('_TONSORTTIME')) define('_TONSORTTIME','Sorting-Time');
if (!defined('_TONPOSTTIME')) define('_TONPOSTTIME','Posting-Time');
define('_TONSUBMITTIME','Submit-Time');
define('_TONAUTOTIME','Autosave-Time');
if (!defined('_TONEXPTIME')) define('_TONEXPTIME','Expiration-Time');
define('_TONSORTID','Articolo-ID');
define('_TONSORTDESC','discendente');
define('_TONSORTASC','ascendente');
define('_TONSORTYEARS','anni');
define('_TONSORTYEAR','anno');
define('_TONSORTMIN','minuto');
define('_TONSORTSEC','secondo');
define('_TONGAPIINFO','<p style="text-align:left; color:#000;"><strong>You will need to get a goo.gl API Key to use this feature.</strong></p><p style="text-align:left; color:#000;"><strong>How to get a key?</strong></p><p style="text-align:left; color:#000;">Visit the <a style="text-decoration: underline; color:#000;" href="http://code.google.com/apis/console/" target="_blank">Google APIs Console</a>, and:</p><ul style="margin:0; list-style:decimal; text-align:left; color:#000;"><li><strong>Create a project.</strong> You can create as many or as few projects as you need. (See the <a style="text-decoration: underline; color:#000;" href="http://code.google.com/apis/console-help/#SeparateProjects" target="_blank">Google APIs Console FAQ</a> for details.) Google will generate exactly one key per project.</li><li><strong>Activate the URL Shortener API.</strong> After creating a project, you should see a list of APIs, each with an Activate button. Click the one for the url shortener.</li><li><strong>Nab the key.</strong> Click <strong>Keys</strong> on the left-hand side to findout about yours. The "Value" is the string you want.</li><li><strong>Copy &amp; Paste</strong> the Key in the&nbsp;Goo.gl API Key field and save the changes.</li></ul>');
define('_TONSNINFO','<p style="text-align:left; color:#000;"><strong>How to add Disqus to my site</strong></p><p style="text-align:left; color:#000;">You will need to go to <a style="text-decoration: underline; color:#000;" href="http://www.disqus.com" target="_blank">www.disqus.com</a> and create an account. Once your account is created, place your Disqus short name here and activate Disqus.</p>');
define('_TONADINFO','<p style="text-align:left; color:#000;"><strong>How to add an ad in Tricked Out News</strong></p><p style="text-align:left; color:#000;">You must create an ad in the Advertising module and activate it. The default position is 0 which is the same as the position in the theme header. You can create a new position in the Advertising module admin and use that position with the Tricked Out News ads. Simple create the new position, add an ad with that position and activate it. Enter the Ad Position Number here and save. The new ad will appear in your News article page.</p>');
// RN storylocker
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
define('_TONAUTHOR','Author');
define('_TONREADS','Reads');
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
define('_ACCOUNTSUSPEND','Account sospeso');
define('_ACCOUNTDELETE','Account disattivato');
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
define('_THANKSSUB','Grazie per il tuo Contributo!');
define('_SUBSENT','Il tuo Articolo &egrave; stato ricevuto...');
define('_SUBTEXT','Controlleremo la tua inserzione nelle prossime ore, se sar&agrave; considerata idonea e interessante verr&agrave; pubblicata presto.');
define('_WEHAVESUB','In questo momento abbiamo');
define('_WAITING','inserzioni in attesa di essere pubblicate.');
define('_YOURNAME','Il tuo nome');
if (!defined('_ERROR')) define('_ERROR','Error');
if (!defined('_DAY')) define('_DAY','Giorno');
define('_SUBMITNEWS','Scrivi articolo');
define('_SUBMITADVICE','Scrivi il tuo articolo compilando il seguente form in tutte le sue parti. Ricontrollalo accuratamente prima di inviarlo.<br>Tieni presente che non tutti gli articoli proposti saranno obbligatoriamente pubblicati.<br>Il nostro staff controller&agrave; l\'articolo prima della pubblicazione.');
define('_BEDESCRIPTIVE','Sii descrittivo, chiaro e semplice');
define('_BADTITLES','titoli simili a questi verranno rifiutati=\'Guarda Questo!\' o \'Un Articolo\'');
define('_HTMLISFINE','HTML va bene, ma controlla accuratamente la correttezza dei tags!');