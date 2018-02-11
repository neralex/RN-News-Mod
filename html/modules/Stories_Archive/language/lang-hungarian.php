<?php

/**************************************************************************/
/* PHP-NUKE: Advanced Content Management System                           */
/* ============================================                           */
/*                                                                        */
/* This is the language module with all the system messages               */
/*                                                                        */
/* If you made a translation, please go to the site and send to me        */
/* the translated file. Please keep the original text order by modules,   */
/* and just one message per line, also double check your translation!     */
/*                                                                        */
/* You need to change the second quoted phrase, not the capital one!      */
/*                                                                        */
/* If you need to use double quotes (') remember to add a backslash (\),  */
/* so your entry will look like: This is \'double quoted\' text.          */
/* And, if you use HTML code, please double check it.                     */
/**************************************************************************/

define("_PRINTER","Nyomtathat&oacute; v&aacute;ltozat");
define("_FRIEND","K&uuml;ldje el lev&eacute;lben!");
define("_YOURNAME","Neve");
define("_OK","Rendben!");
if(!defined('_ALLOWEDHTML')) define('_ALLOWEDHTML','Allowed HTML:');
define("_EXTRANS","HTML k&oacute;dok elt&aacute;vol&iacute;t&aacute;sa");
define("_HTMLFORMATED","HTML k&oacute;dokat tartalmaz&oacute; sz&ouml;veg");
define("_PLAINTEXT","Egyszer&ucirc; sz&ouml;veg");
define("_ARTICLES","Cikkek");
define("_SUBMITNEWS","H&iacute;rk&uuml;ld&eacute;s");
define("_SUBMITADVICE","Az al&aacute;bbi mez&otilde;ket kit&ouml;ltve k&uuml;ldheti el a cikket. Elk&uuml;ld&eacute;s el&otilde;tt ellen&otilde;rizze az adatokat.<br />A cikk nem felt&eacute;tlen&uuml;l ker&uuml;l k&ouml;zl&eacute;sre, &eacute;s nem minden esetben jelenik meg a f&otilde;oldalon.<br />A cikket helyes&iacute;r&aacute;silag &eacute;s nyelvhelyess&eacute;gileg is ellen&otilde;rizz&uuml;k, &eacute;s lehet, hogy v&aacute;ltoztatunk is rajta.");
define("_SUBTITLE","C&iacute;m");
define("_BEDESCRIPTIVE","Legyen egy&eacute;rtelm&ucirc;, &eacute;rthet&otilde; &eacute;s vil&aacute;gos");
define("_BADTITLES","Rossz c&iacute;mek: pl. \"N&eacute;zze meg ezt!\", \"&Uacute;j weboldal\" stb.");
define("_HTMLISFINE","HTML k&oacute;dokat &eacute;s linkeket is &iacute;rhat, de legyen szabv&aacute;nyos!");
if(!defined('_AREYOUSURE')) define('_AREYOUSURE','(If you included any URLs, be sure to validate and test them for typos.)');
define("_SUBPREVIEW","Meg kell n&eacute;znie a cikket, miel&otilde;tt elk&uuml;lden&eacute;.");
define("_SELECTTOPIC","V&aacute;lasszon rovatot");
define("_NEWSUBPREVIEW","El&otilde;n&eacute;zet");
define("_STORYLOOK","A cikke valahogy &iacute;gy fog kin&eacute;zni:");
define("_CHECKSTORY","M&eacute;gegyszer ellen&otilde;rizze a sz&ouml;veget, a HTML k&oacute;dokat &eacute;s a linkeket is, miel&otilde;tt elk&uuml;ldi a cikket!");
define("_THANKSSUB","K&ouml;sz&ouml;nj&uuml;k az &iacute;r&aacute;st!");
define("_SUBSENT","Megkaptuk a cikk&eacute;t...");
define("_SUBTEXT","Hamarosan megn&eacute;zz&uuml;k a cikket, &eacute;s ha &eacute;rdekes &eacute;s t&eacute;m&aacute;ba ill&otilde;, k&ouml;zz&eacute;tessz&uuml;k.");
define("_WEHAVESUB","Jelenleg");
define("_WAITING","cikk v&aacute;rakozik a k&ouml;zz&eacute;t&eacute;telre.");
//define("_PREVIEW","El&otilde;n&eacute;zet");
define("_NEWUSER","Regisztr&aacute;ci&oacute;");
define("_USCORE","Oszt&aacute;lyzatok");
if (!defined('_DATE')) { define('_DATE','D&aacute;tum'); }
define("_STORYTEXT","Bevezet&otilde; sz&ouml;veg");
define("_EXTENDEDTEXT","B&otilde;v&iacute;tett sz&ouml;veg");
if (!defined('_LANGUAGE')) define('_LANGUAGE', 'Nyelv');
define("_SELECTMONTH2VIEW","K&eacute;rem, v&aacute;lassza ki a h&oacute;napot, amelynek a cikkeit meg szeretn&eacute; tekinteni:");
define("_SHOWALLSTORIES","Minden cikk");
define("_STORIESARCHIVE","R&eacute;gebbi cikkek");
define("_ACTIONS","M&ucirc;veletek");
define("_ARCHIVESINDEX","R&eacute;gebbi cikkek");
define("_ALLSTORIESARCH","Minden cikk");
define("_NEXTPAGE","K&ouml;vetkez&otilde; oldal");
define("_PREVIOUSPAGE","El&otilde;z&otilde; oldal");
define('_TAGSCLOUD','Tag Cloud');
define('_SEPARATEDBYCOMMAS','Separate by commas');
define('_ERROR','There is an error occurred while saving.');
// sorting - locking
define('_NOWIS','Now is');
define('_TONSORTYEAR','Year');
define('_TONSORTMIN','Minute');
define('_TONSORTSEC','Second');
define('_TONAUTOTIME','Autopost-Time');
define('_TONEXPTIME','Expiration-Time');
define('_TONSTORYLOCK','Story-Status');
define('_TONSTORYLOCKACTIVE','active');
define('_TONSTORYLOCKSUBMIT','submitted');
define('_TONSTORYLOCKTIMED','timed');
define('_TONSTORYLOCKFULL','disabled');
define('_TONSTORYLOCKEXP','expired');
define('_TONEXPOLDTIME','You have stored a time, smaller as the current.<br />Enter a new date/time or its would be reseted.');
define('_TONAUTOPOSTTIMEFAQ','Here you can <strong>set a time</strong> to <strong>post</strong> an a time <strong>into the future</strong>. If the time has come, then <strong>goes</strong> the article <strong>automaticly online</strong>. Please set the <strong>Autopost-Time</strong> bigger then the <strong>current date/time</strong>.');
define('_TONEXPTIMEFAQ','Here you can set a time, to <strong>expire</strong> your <strong>article</strong>. If you set a <strong>time in the future</strong>, bigger as the <strong>current date/time</strong>, then would be the article <strong>automaticly disabled</strong>. If you set the <strong>Expiration-Time</strong> smaller as the <strong>current date/time</strong>, then would be the <strong>Expiration-Time</strong> reseted.');
define('_DAY','Day');
?>