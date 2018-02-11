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

define('_PRINTER','Format imprimable');
define('_FRIEND','Envoyer cet article &agrave; un(e) ami(e)');
define('_YOURNAME','Votre Nom');
define('_OK','Ok !');
if(!defined('_ALLOWEDHTML')) define('_ALLOWEDHTML','HTML autoris&eacute;:');
define('_EXTRANS','Extrans (html tags en texte)');
define('_HTMLFORMATED','Format HTML');
define('_PLAINTEXT','Texte seulement');
define('_ARTICLES','Articles');
define('_SUBMITNEWS','Proposer un article');
define('_SUBMITADVICE','Veuillez &eacute;crire votre article/nouvelle en compl&egrave;tant le formulaire suivant, et v&eacute;rifier une seconde fois votre texte.<br />Les propositions ne sont pas toutes publi&eacute;es.<br />Votre proposition sera v&eacute;rifi&eacute;e au niveau de la grammaire et pourrait &ecirc;tre &eacute;dit&eacute;e par notre &eacute;quipe.');
define('_SUBTITLE','Titre');
define('_BEDESCRIPTIVE','Soyez descriptif, simple et clair');
define('_BADTITLES','Ex. de mauvais titres: \'Lisez ceci !\' ou \'Un article\'');
define('_HTMLISFINE','le HTML c\'est bien, mais contr&ocirc;lez vos URLs et tags HTML!');
if(!defined('_AREYOUSURE')) define('_AREYOUSURE','Etes-vous s&ucirc;r d\'inclure un URL ? Avez-vous verifi&eacute; la typo. ?');
define('_SUBPREVIEW','Vous devez visualiser avant de pouvoir soumettre');
define('_SELECTTOPIC','S&eacute;lectionnez un Sujet');
define('_NEWSUBPREVIEW','Pr&eacute;visualisation de la proposition');
define('_STORYLOOK','Votre article/nouvelle ressemblera &agrave; ceci:');
define('_CHECKSTORY','Veuillez re-v&eacute;rifier votre texte, les liens, etc, avant d\'envoyer votre article !');
define('_THANKSSUB','Merci pour votre proposition!');
define('_SUBSENT','Nous avons re&ccedil;u votre article...');
define('_SUBTEXT','Nous examinerons votre proposition dans quelques heures; si elle est int&eacute;ressante et \'&agrave; propos\', nous la publierons prochainement.');
define('_WEHAVESUB','En ce moment, nous avons');
define('_WAITING','proposition(s) en attente de publication.');
//define('_PREVIEW','Prévisualisation');
define('_NEWUSER','Nouvel Utilisateur');
define('_USCORE','Score');
if (!defined('_DATE')) { define('_DATE','Date'); }
define('_STORYTEXT','Texte de l\'article');
define('_EXTENDEDTEXT','Suite du Texte');
if (!defined('_LANGUAGE')) define('_LANGUAGE','Langue');
define('_SELECTMONTH2VIEW','Merci de séléctionner le mois que vous voulez voir :');
define('_SHOWALLSTORIES','Voir TOUS les articles');
define('_STORIESARCHIVE','Archives des articles');
define('_ACTIONS','Actions');
define('_ARCHIVESINDEX','Index des Archives des articles');
define('_ALLSTORIESARCH','TOUS les articles');
define('_NEXTPAGE','Page suivante');
define('_PREVIOUSPAGE','Page précédente');
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
