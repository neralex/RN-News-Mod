<?php
/**
 *
 * @package RavenNuke 2.5
 * @subpackage Core
 * @version $Id$
 * @copyright (c) 2011 Raven Web Services, LLC
 * @link http://www.ravennuke.com
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * This is the language module with all the system messages
 * If you make a translation, please go to: http://www.ravenphpscripts.com and post your translation in our forums
 *
 * You need to change the second quoted phrase, not the capitalised one!
 *
 * If you need to use double quotes (") remember to add a backslash (\),
 * so your entry will look like: This is \"double quoted\" text.
 * And, if you use HTML code, please double check it.
*/

global $sitename, $nukeurl;
define('_ACTBANNERS','Activer les banni&egrave;res sur votre site?');
define('_ACTIVATE','Activer');
define('_ACTIVATE2','Activer ?');
define('_ACTIVATEHTTPREF','Activer le tra&ccedil;age des r&eacute;f&eacute;rants HTTP?');
define('_ACTIVE','Actif');
define('_ACTIVEBANNERS','Banni&egrave;res Actives');
define('_ACTIVEBANNERS2','Bannieres Actives');
define('_ACTMULTILINGUAL','Activate Multilingual features? ');
define('_ACTUSEFLAGS','Display flags instead of a dropdown box? ');
define('_ADDAUTHOR','Ajouter un nouvel administrateur');
define('_ADDAUTHOR2','Ajouter un Auteur ');
define('_ADDBANNER','Ajouter une banni&egrave;re');
define('_ADDCLIENT','Ajouter un nouveau client');
define('_ADDCLIENT2','Ajouter un client');
define('_ADDHEADLINE','Ajouter une Manchette');
define('_ADDIMPRESSIONS','Ajouter plus d\'impressions');
define('_ADDMSG','Add message');
define('_ADDNEWBANNER','Ajouter une nouvelle banni&egrave;re');
define('_ADDNEWBLOCK','Ajouter un nouveau bloc');
define('_ADDNEWGROUP','Add New Users Group');
define('_ADMINEMAIL','Email de l\'administrateur');
define('_ADMINGRAPHIC','Utiliser des images dans le menu Administration?');
define('_ADMINID','ID Admin');
define('_ADMINISTRATION','Administration');
define('_ADMINLOGIN','Administration Syst&egrave;me: Login');
define('_ADMINLOGOUT','Sortie');
define('_ADMINMENU','Menu Administration');
define('_ADMPOLLS','Survey / Polls');
define('_ADVERTISINGCLIENTS','Annonceurs');
define('_AFTEREXPIRATION','After Expiration');
if (!defined('_ALL')) define('_ALL','Tous');
define('_ALLMESSAGES','Overview messages');
define('_ALLOWANONPOST','Accepter les envois anonymes?');
define('_ALREADYOPTIMIZED','D�j� optimis�');
define('_ALTTEXT','Alternate Text');
//define('_ANEWSLETTER','Une Newsletter � tous ceux inscrit seulement');
define('_ANONYMOUSNAME','Nom par d&eacute;faut pour les anonymes');
define('_ARESUREDELBLOCK','Etes-vous s&ucirc;r de vouloir enlever ce bloc ?');
define('_ARTICLES','Articles');
define('_AUTHOR','Auteur');
define('_AUTHORDEL','Enlever un auteur');
define('_AUTHORDELSURE','Etes-vous s&ucirc;r de vouloir supprimer');
define('_AUTHORSADMIN','Adminitration des auteurs');
define('_AUTOMATEDARTICLES','Articles programm&eacute;s');
define('_A_GETOUT','GET OUT !!!');
define('_A_INTRUDER_MSG','INTRUDER ALERT!!!');
define('_BACKENDCONF','Configuration syndication');
define('_BACKENDLANG','Syndication - Langue');
define('_BACKENDTITLE','Syndication - Titre');
define('_BACKUPINFO', '<p>Previous versions of PHP-Nuke and RavenNuke(tm) provided a backup routine that could be accessed from the Administrative Control Panel (ACP).  In testing for the RavenNuke(tm) 2.20 release we found that (a) the program had serious bugs that produced invalid backup data and (b) in most server conditions, due to the expansion in the number and size of the MySQL tables, the backup process could not be run successfully.</p>
<p>As a consequence, we have decided to at least temporarily remove the backup program from the ACP.</p>
<p>There are two alternatives that are preferable to using an ACP based backup process.  The first is to check with your host to see if it provides an automated and regularly scheduled MySQL dump process. Usually these are located on your cPanel or vDeck or other host management panel. Since there are many varieties of hosts involved, it is up to you to talk to your host and make arrangements for this.  The second alternative is to use phpMyAdmin and dump your files with that tool.  Again, while most hosts provide access to phpMyAdmin, it is up to you to make those arrangements.</p>
<p>In arranging to dump your data, you should also take a look at options for restoring it.  As we stated above, many hosts place resource limits that will make restoring a typical NUKE database impossible without additional tools.  The one we highly recommend is BigDump which can be found at:</p>
<p><a href="http://www.ozerov.de/bigdump.php"><em>http://www.ozerov.de/bigdump.php</em></a></p><p>We strongly recommend that you download, install and test BigDump in conjunction with your chosen backup method <em>before</em> you reach a crisis situation where the restore needs to be run immediately.</p>');
define('_BANDATE','Ban Date');
define('_ADVERTISING','Advertising');
//define('_BANNERS','Banners');
define('_ADVERTISINGADMIN','Advertising Administration');
//define('_BANNERS',,'Administration des Banni&egrave;res');
define('_BANNERSOPT','Options pour les banni&egrave;res');
define('_BANNEWIP','Ban a new IP Address');
define('_BLOCK','Bloc');
define('_BLOCKACTIVATION','Activation du bloc');
define('_BLOCKDOWN','Descendre le bloc');
define('_BLOCKFILE','(Fichier Block)');
define('_BLOCKFILE2','FICHIER');
define('_BLOCKPREVIEW','Pr&eacute;visualisation du bloc');
define('_BLOCKS','Blocs');
define('_BLOCKSADMIN','Administration des blocs');
define('_BLOCKSYSTEM','SYSTEM');
define('_BLOCKUP','Remonter le bloc');
define('_BROADCASTMSG','Activate Broadcast Messages?');
if (!defined('_CATEGORY')) define('_CATEGORY','Cat&eacute;gorie');
define('_CENSORMODE','Censor Mode');
define('_CENSOROPTIONS','Censure Options');
define('_CENSORREPLACE','Replace Censored Words with:');
define('_CENTERBLOCK','Center Block');
define('_CENTERDOWN','Center Down');
define('_CENTERUP','Center Up');
define('_CENTERTOP','Center Top (above msg)');
define('_CHANGE','Change');
define('_CHANGEDATE','Changer la date de d&eacute;but &agrave; aujourd\'hui ?');
define('_CHANGEMODNAME','Changer le nom du module');
define('_CLICKS','Clicks');
define('_CLICKSPERCENT','% Clicks');
define('_CLICKURL','URL du clic');
define('_CLIENTLOGIN','Login du client');
define('_CLIENTNAME','Nom du client');
define('_CLIENTPASSWD','Mot de passe du client');
define('_CLIENTWITHOUTBANNERS','Ce client n\'a pas de banni&egrave;re active pour le moment.');
define('_COLLAPSEBLOCKS', 'Collapsable Blocks');
define('_COMMENTSARTICLES','Activer les commentaires pour les Articles?');
define('_COMMENTSLIMIT','Limite en octets pour les commentaires');
define('_COMMENTSMOD','Mod&eacute;ration des commentaires');
define('_COMMENTSOPT','Options pour les commentaires');
define('_COMMENTSPOLLS','Activer les commentaires pour les Sondages?');
define('_COMPLETEFIELDS','Vous devez remplir tous les Champs');
define('_CONTACTEMAIL','E-mail');
define('_CONTACTNAME','Nom du contact');
define('_CONTENT','Contenu');
define('_CREATEBLOCK','Cr&eacute;er un bloc');
define('_CREATEGROUP','Create This Group');
define('_CREATEUSERDATA','Do you want to create a normal user with the same data?');
define('_CREATIONERROR','Erreur dans la cr&eacute;ation d\'un compte auteur');
define('_CURRENTPOLL','Sondage en cours');
define('_CUSTOM','Autre');
define('_CUSTOMMODNAME','Nom du module choisi:');
define('_CUSTOMTITLE','Titre choisi');
define('_DAY','Jour');
define('_DAYS','jours');
define('_DBOPTIMIZATION','Optimisation de la base de donn�es');
define('_DEACTIVATE','D&eacute;sactiver');
define('_DEFAULTTHEME','Th&egrave;me par d&eacute;faut pour votre site');
define('_DEFHOMEMODULE','Default Homepage Module');
define('_DELAUTHOR','Enlever un auteur');
define('_DELCLIENTHASBANNERS','Ce client a les BANNI&Egrave;RES suivantes activ&eacute;es et en fonction.');
define('_DELETEBANNER','D&eacute;truire la banni&egrave;re');
define('_DELETECLIENT','Supprimer Client Publicitaire');
define('_DELETEREFERERS','Effacer les r&eacute;f&eacute;rants');
define('_DESC01','Personal user\'s Journal entry. Valid for public and private entries');
define('_DESC02','Each comment posted in a public user\'s Journal');
define('_DESC03','Each time a user send the link to our site to a friend via Recommend Us Module');
define('_DESC04','News that the user sends from Submit News module and then published by the administrator');
define('_DESC05','Comment published for any article and/or news');
define('_DESC06','Each article\'s or news has an option to send it to a friend. Points valid for each time the user sends the article to a friend');
define('_DESC07','Each time a user votes for any article');
define('_DESC08','Each vote registered for any survey, actual or old ones are valid');
define('_DESC09','Comment published for any actual or old survey');
define('_DESC10','Each time the user opens a new thread in the Forums');
define('_DESC11','Forums threads answered or replied');
define('_DESC12','Comment published for any review in the Reviews module');
define('_DESC13','Get points for each page view generated by the user. Valid for any page of the site');
define('_DESC14','Each time a user clicks to visit any resource on WebLinks module');
define('_DESC15','Each time a user votes for a resource in WebLinks module');
define('_DESC16','Comments posted on any resource in the WebLink module');
define('_DESC17','Each time a user clicks to download any file or resource on Downloads module');
define('_DESC18','Each time a user votes for a resource in Downloads module');
define('_DESC19','Comments posted on any resource in the Downloads module');
define('_DESC20','Each time a user publish a public message using the Broadcast message system');
define('_DESC21','The best way to give back a user something is to give him some points for banner clicks on your site');
define('_DESCRIPTION','Description');
define('_DOWNLOAD','Downloads');
define('_EDITADMINS','Editer l\'auteur');
define('_EDITBANNER','Edition de la banni&egrave;re');
define('_EDITBLOCK','Editer un bloc');
define('_EDITCLIENT','Edition du client annonceur');
define('_EDITGROUP','Edit Users Group');
define('_EDITHEADLINE','Editer les manchettes');
define('_EDITMSG','Edit message');
define('_EMAIL','E-mail');
define('_EMAIL2SENDMSG','Adresse Email o&ugrave; envoyer le message');
define('_EMAILFROM','Compte Email (From)');
define('_EMAILMSG','Message');
define('_EMAILSUBJECT','Objet du message');
define('_ENCYCLOPEDIA','Encyclopedia');
define('_ERROR','ERROR:');
define('_EXACTMATCH','Exact match');
define('_EXPIRATION','Expiration');
define('_EXTRAINFO','Autres...');
define('_FAQ','F.A.Q.');
define('_FILEINCLUDE','(Choisissez un block � inclure. Tous les autres champs seront ignor�s)');
define('_FILENAME','Nom de fichier');
define('_FIXBLOCKS','R�gler les conflits de longueurs avec les blocks');
define('_FOOTERLINE1','Ligne de pied 1');
define('_FOOTERLINE2','Ligne de pied 2');
define('_FOOTERLINE3','Ligne de pied 3');
define('_FOOTERMSG','Messages de bas de page');
define('_FORCHANGES','(Pour les changements seulement)');
//define('_FROM','De');
define('_FUNCTIONS','Fonctions');
define('_GENSITEINFO','Infos G&eacute;n&eacute;rales sur le Site');
define('_GO','Ok');
define('_GODNOTDEL','*(Le compte DIEU ne peut pas &ecirc;tre effac&eacute;)');
define('_GRAPHICOPT','Options graphiques');
define('_GROUP','Group');
define('_GROUPADDERROR','Group Creation Error!');
define('_GROUPDELETE','Delete Users Group');
define('_GROUPSADMIN','Users Group Administration');
define('_GTITLE','Group Name');
define('_HASBEENBANNED','has been banned from this site');
define('_HEADLINESADMIN','Administration des manchettes');
define('_HOMECONFIG','Configuration de la page d\'accueil');
define('_HOMEPAGE','Page d\'accueil');
define('_ID','ID');
define('_IFRSSWARNING','If you complete the fields RSS/RDF file URL: or Filename: the above Content field will not be displayed.');
define('_IFYOUACTIVE','(Si vous activez ce message maintenant, la date de d&eacute;but sera aujourd\'hui)');
define('_IMAGEURL','URL vers l\'image');
define('_IMPLEFT','Imp. Restantes');
define('_IMPRESSIONS','Impressions');
define('_INACTIVE','Inactif');
define('_INACTIVEBANNERS','Inactive Banners');
define('_INHOME','In Home');
define('_IPBAN', 'IP Ban');
define('_IPBANNED','Banned IP Addresses');
define('_IPBANSYSTEM','IP Ban System');
define('_IPENTERED','IP address entered:');
define('_IPLOCALHOST','You can\'t ban the localhost IP address');
define('_IPNUMERIC','And IP address should be numeric');
define('_IPOUTRANGE','IP address is out of range');
define('_IPSTARTZERO','And IP address can\'t start with 0');
define('_IPYOURS','You can\'t ban your own IP address!');
define('_ITEMSTOP','Nombre d\'&eacute;l&eacute;ments sur la page Top');
define('_KBSAVED','Kb sauv�s depuis sa premi�re �x�cution!');
if (!defined('_LANGUAGE')) define('_LANGUAGE','Langue');
define('_LAST','Derniers');
define('_LEFT','Gauche');
define('_LEFTBLOCK','Bloc de gauche');
define('_LOCALEFORMAT','Format local pour la date et l\'heure');
define('_MADE','Accomplies');
define('_MAIL2ADMIN','Envoyer les nouveaux articles par e-mail &agrave; l\'administrateur');
define('_MAINACCOUNT','Admin Dieu*');
//define('_MANYUSERSNOTE','Attention! Plusieurs utilisateurs vont recevoir cet email. Merci d\'attendre jusqu\'� ce que le script ai finit l\'op�ration. Ceci peut prendre plusieurs minutes!');
//define('_MAREYOUSURE2SEND','Etes vous sure de vouloir envoyer maintenant ce Massive Email ?');
//define('_MASSEMAIL','Massive Email');
//define('_MASSEMAILMSG',"=========================================================\nVous recevez cette Newsletter parceque vous �tes inscrit au site $sitename.");
//define('_MASSEMAILSENT','Massive Email a �t� envoy�.');
//define('_MASSMAIL','Une Massive e-mail pour tous les utilisateurs');
define('_MATCHANY','Match anywhere in the text');
define('_MATCHBEG','Match word at the beginning');
define('_MAXREF','Combien de r&eacute;f&eacute;rants voulez-vous garder au maximum?');
define('_MAXRSS','Maximum RSS items');
define('_MESSAGECONTENT','Contenu');
define('_MESSAGES','Messages');
define('_MESSAGESADMIN','Administration des messages');
define('_MESSAGETITLE','Titre');
define('_MISCOPT','Options diverses');
define('_MODADMIN','Mod&eacute;ration par l\'administrateur');
define('_MODIFYINFO','Modifier l\'Information');
define('_MODTYPE','Type de mod&eacute;ration');
define('_MODULEEDIT','Editer le modules');
define('_MODULEHOMENOTE','<span class="thick">-= WARNING =-</span><br />Bold module\'s title represents the module you have in the Homepage.<br />You can\'t Deactivate or Restrict this module while it\'s the default one!<br />If you delete the module\'s directory you\'ll see and error in the Homepage.<br />Also, this module has been replaced with <span class="italic">Home</span> link in the modules block.');
define('_MODULEINHOME','Module Loaded in the Homepage:');
define('_MODULES','Modules');
define('_MODULESACTIVATION','Allez voir dans Modules/Addons et changez son statut.<br />Les nouveau modules copi�s dans le dossier <span class="italic">/modules/</span> seront automatiquement ajout�s avec pour statut <span class="italic">Inactif</span> � la base de donn�es quand vous rechargerez cette page.<br />Si vous voulez supprimer un module, supprimez le seulement du r�pertoire <span class="italic">/modules/</span>, le system mettra � jour automatiquement la base de donn�es.');
define('_MODULESADDONS','Modules et Addons');
define('_MODULESADMIN','Modules Administration');
define('_MODUSERS','Mod&eacute;ration par les utilisateurs');
define('_MOVEBLOCKS', 'Moveable Blocks');
define('_MULTILINGUALOPT','Multilingual Options');
//define('_MUSERWILLRECEIVE','Les utilisateur vont recevoir cette Newsletter.');
define('_MUSTBEINIMG','must be in /images/ directory. Valid only for AvantGo module');
define('_MVADMIN','Les administrateurs seulement');
define('_MVALL','Tous les visiteurs');
define('_MVANON','Les utilisateurs anonymes seulement');
define('_MVUSERS','Les utilisateurs enregistr&eacute;s seulement');
define('_MYHEADLINES','Activate Headlines Reader?');
//define('_MYOUAREABOUTTOSEND','Vous �tes sur le point d\'envoyer un Massive e-mail � TOUS les utilisateurs inscrit.');
define('_NAME','Nom');
//define('_NAREYOUSURE2SEND','Etes vous sure de vouloir envoyer maitenant cette Newsletter ?');
define('_NEWS','News');
//define('_NEWSLETTER','Newsletter');
//define('_NEWSLETTERSENT','La Newsletter a �t� envoy�.');
//define('_NLUNSUBSCRIBE',"=========================================================\nVous recevez cette Newsletter parceque vous la recevez de $sitename.\nVous pouvez vous d�sinscrire en allant sur URL:\n\n$nukeurl/modules.php?name=Your_Account&op=edituser\n\n puis choisissez \"Non\" � la question Recevoir la Newsletter par Email puis sauvegardez.");
define('_NEWWEIGHT','New Weight');
define('_NOADMINYET','There are no Administrators Accounts yet, proceeed to create the Super User:');
define('_NOAUTOARTICLES','Il n\'y a pas d\'articles programm&eacute;s.');
define('_NOFILTERING','No filtering');
define('_NOFUNCTIONS','---------');
define('_NOGROUPS','There aren\'t any Users Group created at this time');
define('_NOMOD','Pas de Mod&eacute;ration');
define('_NONUMVALUE','The value of the Points isn\'t numeric. Go back and fix it.');
define('_NORMAL','Normal');
define('_NOTIFYSUBMISSION','Notifier les suggestions par e-mail?');
define('_NOTINMENU','[ <span class="larger"><strong>&middot;</strong></span> ] means a module which name and link will not be visible in Modules Block');
//define('_NUSERWILLRECEIVE','Les utilisateur vont recevoir cette Newsletter.');
//define('_NYOUAREABOUTTOSEND','Vous �tes sur le point d\'envoyer une Newsletter � tous les utilisateurs inscrit.');
define('_OK','Ok !');
define('_OLDSTORIES','Nombre d\'articles dans la bo&icirc;te des Articles Pr&eacute;c&eacute;dents');
define('_ONLYHEADLINES','(Seulement pour les manchettes)');
define('_ONLYNUMVAL','Use numeric values only');
define('_OPTIMIZATIONRESULTS','R�sultat de l\'optimisation');
define('_OPTIMIZED','Optimiz�!');
define('_OPTIMIZINGDB','Optimisation de la base de donn�es:');
define('_OPTIMIZE_DB', 'Optimize DB');
define('_ORDMSG','Weight values must be between 1 and 999');
define('_ORDMSG2','Duplicate Weight values not permitted');
define('_ORDMSGSIDEL','in left blocks');
define('_ORDMSGSIDEC','in center up blocks');
define('_ORDMSGSIDED','in center down blocks');
define('_ORDMSGSIDER','in right blocks');
define('_ORDMSGSIDET','in top center blocks');
define('_PASSWDLEN','Taille minimale pour le mot de passe des utilisateurs');
define('_PASSWDNOMATCH','D&eacute;sol&eacute;, les mots de passe ne correspondent pas.  Retournez &agrave; la page pr&eacute;c&eacute;dente et essayez &agrave; nouveau.');
define('_PERMISSIONS','Permissions');
define('_POINTS','Points');
define('_POINTS01','Journal Entry');
define('_POINTS02','Journal Comment');
define('_POINTS03','Recommendation to a Friend');
define('_POINTS04','News Submission Published');
define('_POINTS05','News Comment');
define('_POINTS06','News Sent to a Friend');
define('_POINTS07','News Article Rating');
define('_POINTS08','Vote in Surveys');
define('_POINTS09','Comment in Surveys');
define('_POINTS10','Forum New Post');
define('_POINTS11','Forum Answer Post');
define('_POINTS12','Review Comment');
define('_POINTS13','Page View');
define('_POINTS14','Visit to a WebLink');
define('_POINTS15','Rate to any WebLink');
define('_POINTS16','Comment to any WebLink');
define('_POINTS17','Download of a File');
define('_POINTS18','Rate to any Download');
define('_POINTS19','Comment to any Download');
define('_POINTS20','Broadcast Message');
define('_POINTS21','Click on any Banner');
define('_POINTSNEEDED','Points Needed');
define('_POINTSSYSTEM','Points System');
define('_POSITION','Position');
//define('_POSSIBLESPAM','Merci de noter que certains utilisateur vont se sentir abus�s par cette email peut �tre non d�sir� et peuvent consid�rer ceci comme du Spam!');
define('_PREFERENCES','Pr&eacute;f&eacute;rences');
define('_PUBLISHEDSTORIES','Cet administrateur a publi&eacute; des articles');
define('_PURCHASED','Achet&eacute;es');
define('_PURCHASEDIMPRESSIONS','Impressions achet&eacute;es');
define('_PUTINHOME','Put in Home');
define('_REASON','Reason');
define('_REFRESHTIME','D&eacute;lai de rafra&icirc;chissement');
define('_REMOVECOMMENTS','Effacer les commentaires');
define('_REMOVEMSG','Are you sure you want to remove this message ? ');
define('_REQUIRED','(requis)');
define('_REQUIREDNOCHANGE','(requis, ne peut pas &ecirc;tre chang&eacute; plus tard)');
define('_RETYPEPASSWD','Retapez votre mot de Passe');
define('_REVIEWS','Reviews');
//define('_REVIEWTEXT','Merci de v�rifier votre texte:');
define('_RIGHT','Droite');
define('_RIGHTBLOCK','Bloc de droite');
define('_RSSCONTENT','(Contenu RSS/RDF)');
define('_RSSFAIL','Il y a un probl&egrave;me avec l\'URL du fichier RSS');
define('_RSSFILE','URL du fichier RSS/RDF');
define('_RSSTRYAGAIN','Veuillez v&eacute;rifier l\'URL et le nom du fichier RSS, et essayez &agrave; nouveau.');
define('_SAVE','Sauver');
define('_SAVEBLOCK','Sauvegarder le bloc');
define('_SAVECHANGES','Sauvez les modifications');
define('_SAVEDATABASE','Sauvegarde de la Base de Donn�es');
define('_SAVEGROUP','Save Group');
define('_SELECTNEWADMIN','Choisissez un nouvel administrateur &agrave; qui les assigner');
define('_SELLANGUAGE','Selectionnez la langue de votre site');
//define('_SEND','Envoyer');
define('_SETUPHEADLINES','(Pour obtenir de nouvelles manchettes, s&eacute;lectionnez un site dans la liste ou choisissez Autre et entrez l\'URL)');
define('_SHOW','Montrer');
define('_SHOWINMENU','Visible in Modules Block?');
define('_SITECONFIG','Configuration du site Web');
define('_SITELOGO','Logo du site');
define('_SITENAME','Nom du Site');
define('_SITESLOGAN','Slogan du site');
define('_SITEURL','URL du site');
define('_SIZE','Taille');
define('_SPACESAVED','Espace sauv�');
//define('_STAFF','Equipe');
define('_STARTDATE','Date de mise en ligne du site');
define('_STATUS','Status');
define('_STORIESHOME','Nombre d\'articles sur la page d\'accueil');
define('_STORYID','ID article');
//define('_SUBJECT','Sujet');
define('_SUBMIT','Soumettre');
//define('_SUBSCRIBEDUSERS','Utilisateurs inscrit');
define('_SUBUSERS','Subscribed Users');
define('_SUBVISIBLE','Visible to Subscribers?');
define('_SUCCESS','Success!!');
define('_SUPERUSER','Super Utilisateur');
define('_SUPERWARNING','ATTENTION: Si Super Utilisateur est coch&eacute;, l\'utilisateur aura tous les acc&egrave;s ouverts !');
define('_SURE2DELHEADLINE','ATTENTION: Etes-vous s&ucirc;r de vouloir enlever cette manchette?');
define('_SUREGRPDEL1','Are you sure you want to remove/delete the group?:');
define('_SURETOBANIP','Are you sure you want to UNBAN the following IP address:');
define('_SURETOCHANGEMOD','Are you sure you want to change your Homepage from');
define('_SURETODELBANNER','Etes-vous s&ucirc;r de vouloir d&eacute;truire cette Banni&egrave;re ?');
define('_SURETODELCLIENT','Vous &ecirc;tes sur le point d\'enlever un client et toutes ses banni&egrave;res !!!');
define('_SURETODELCOMMENTS','Etes-vous s&ucirc;r de vouloir supprimer le commentaire s&eacute;lectionn&eacute; et toutes les r&eacute;ponses ?');
define('_TABLE','Tableau');
define('_THEIP','The IP address');
define('_THEME', 'Theme');
define('_THEMES', 'Themes');
define('_THEMENAME', 'Theme Name');
define('_THEMECONFIG', 'Theme Configuration');
define('_THEMEUPDATEGOOD', 'Themes Updated Successfully');
define('_THEMEUPDATEFAIL', 'Themes Update Failed');
define('_TIMES','fois');
define('_TITLE','Titre');
define('_TO','&agrave;');
if(!defined('_TOPICS')) define('_TOPICS','Topics');
define('_TOTALSPACESAVED','Espace total sauv�:');
define('_TYPE','Type');
define('_UGROUP','Users Group');
define('_UGROUPS','Users Group/Points');
define('_UNBAN','UnBan');
define('_UPDATE','Update');
define('_UPDATEGOOD', 'Updated Successfully');
define('_URL','URL');
define('_USERSCOUNT','Users Count');
define('_USERSHOMENUM','Let users change News number in Home?');
define('_USERSOPTIONS','Users Options');
define('_VALIDATE', 'Validate');
define('_VALIDIFREG','Valid only if Registered Users are selected above');
define('_VIEW','Visible to');
define('_VIEWPRIV','Qui peut le voir ?');
define('_WANT2ACTIVATE','Voulez-vous activer ce bloc ?');
define('_WARNING','Attention');
define('_WEBLINKS','Web Links');
define('_WEIGHT','Poid');
//define('_WHATTODO','Que veux tu envoyer?');
define('_WHOLINKS','Qui place des liens vers notre site ?');
define('_WHOSONLINE','Qui est en ligne ?');
define('_YOUARELOGGEDOUT','Vous &ecirc;tes maintenant d&eacute;connect&eacute; !');
define('_YOUHAVERUNSCRIPT','Vous avez �x�cut� ce script:');
define('_TONSTORYLOCK','Status');
define('_TONSTORYLOCKACTIVE','active');
define('_TONSTORYLOCKSUBMIT','submitted');
define('_TONSTORYLOCKTIMED','timed');
define('_TONSTORYLOCKFULL','disabled');
define('_TONSTORYLOCKEXP','expired');
define('_TONAUTHOR','Author');
define('_TONREADS','Reads');
define('_TONSORTTIME','Sorting-Time');
define('_TONPOSTTIME','Posting-Time');
define('_TONEXPTIME','Expiration-Time');
?>