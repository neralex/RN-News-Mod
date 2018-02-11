<?php
/**
* @category RavenNuke 3.0
* @package Core
* @subpackage elFinder
* @version $Id$
* @copyright (c) 2012 Raven Web Services, LLC
* @link http://www.ravennuke.com
* @license http://www.gnu.org/licenses/gpl.html GNU/GPL 3
*/

$module = !empty($_GET['module']) ? $_GET['module'] : 'ckeditor';
$module = 'ckeditor';
$dir = 'php/modules';
$dirHandler = opendir($dir);
$plugins = array();
while ($file = readdir($dirHandler)) {
	if ($file != '.' && $file != '..') {
		$plugins[] = $file;
	}
}
closedir($dirHandler);

if (!in_array($module . '.php', $plugins)) die('ERROR: The ' . htmlspecialchars($module, ENT_QUOTES) . ' module was not found!');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">

<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>File Manager</title>

	<link rel="stylesheet" href="../jquery/css/smoothness/jquery-ui.css" type="text/css" media="screen" title="no title" charset="utf-8">
	<script src="../jquery/jquery.js" type="text/javascript" charset="utf-8"></script>
	<script src="../jquery/jquery-ui.min.js" type="text/javascript" charset="utf-8"></script>

	<link rel="stylesheet" href="css/common.css"      type="text/css" media="screen" charset="utf-8">
	<link rel="stylesheet" href="css/dialog.css"      type="text/css" media="screen" charset="utf-8">
	<link rel="stylesheet" href="css/toolbar.css"     type="text/css" media="screen" charset="utf-8">
	<link rel="stylesheet" href="css/navbar.css"      type="text/css" media="screen" charset="utf-8">
	<link rel="stylesheet" href="css/statusbar.css"   type="text/css" media="screen" charset="utf-8">
	<link rel="stylesheet" href="css/contextmenu.css" type="text/css" media="screen" charset="utf-8">
	<link rel="stylesheet" href="css/cwd.css"         type="text/css" media="screen" charset="utf-8">
	<link rel="stylesheet" href="css/quicklook.css"   type="text/css" media="screen" charset="utf-8">
	<link rel="stylesheet" href="css/commands.css"    type="text/css" media="screen" charset="utf-8">

	<link rel="stylesheet" href="css/theme.css"       type="text/css" media="screen" charset="utf-8">

	<!-- elfinder core -->
	<script src="js/elFinder.js"           type="text/javascript" charset="utf-8"></script>
	<script src="js/elFinder.version.js"   type="text/javascript" charset="utf-8"></script>
	<script src="js/jquery.elfinder.js"    type="text/javascript" charset="utf-8"></script>
	<script src="js/elFinder.resources.js" type="text/javascript" charset="utf-8"></script>
	<script src="js/elFinder.options.js"   type="text/javascript" charset="utf-8"></script>
	<script src="js/elFinder.history.js"   type="text/javascript" charset="utf-8"></script>
	<script src="js/elFinder.command.js"   type="text/javascript" charset="utf-8"></script>

	<!-- elfinder ui -->
	<script src="js/ui/overlay.js"       type="text/javascript" charset="utf-8"></script>
	<script src="js/ui/workzone.js"      type="text/javascript" charset="utf-8"></script>
	<script src="js/ui/navbar.js"        type="text/javascript" charset="utf-8"></script>
	<script src="js/ui/dialog.js"        type="text/javascript" charset="utf-8"></script>
	<script src="js/ui/tree.js"          type="text/javascript" charset="utf-8"></script>
	<script src="js/ui/cwd.js"           type="text/javascript" charset="utf-8"></script>
	<script src="js/ui/toolbar.js"       type="text/javascript" charset="utf-8"></script>
	<script src="js/ui/button.js"        type="text/javascript" charset="utf-8"></script>
	<script src="js/ui/uploadButton.js"  type="text/javascript" charset="utf-8"></script>
	<script src="js/ui/viewbutton.js"    type="text/javascript" charset="utf-8"></script>
	<script src="js/ui/searchbutton.js"  type="text/javascript" charset="utf-8"></script>
	<script src="js/ui/sortbutton.js"    type="text/javascript" charset="utf-8"></script>
	<script src="js/ui/panel.js"         type="text/javascript" charset="utf-8"></script>
	<script src="js/ui/contextmenu.js"   type="text/javascript" charset="utf-8"></script>
	<script src="js/ui/path.js"          type="text/javascript" charset="utf-8"></script>
	<script src="js/ui/stat.js"          type="text/javascript" charset="utf-8"></script>
	<script src="js/ui/places.js"        type="text/javascript" charset="utf-8"></script>

	<!-- elfinder commands -->
	<script src="js/commands/back.js"      type="text/javascript" charset="utf-8"></script>
	<script src="js/commands/forward.js"   type="text/javascript" charset="utf-8"></script>
	<script src="js/commands/reload.js"    type="text/javascript" charset="utf-8"></script>
	<script src="js/commands/up.js"        type="text/javascript" charset="utf-8"></script>
	<script src="js/commands/home.js"      type="text/javascript" charset="utf-8"></script>
	<script src="js/commands/copy.js"      type="text/javascript" charset="utf-8"></script>
	<script src="js/commands/cut.js"       type="text/javascript" charset="utf-8"></script>
	<script src="js/commands/paste.js"     type="text/javascript" charset="utf-8"></script>
	<script src="js/commands/open.js"      type="text/javascript" charset="utf-8"></script>
	<script src="js/commands/rm.js"        type="text/javascript" charset="utf-8"></script>
	<script src="js/commands/info.js"      type="text/javascript" charset="utf-8"></script>
	<script src="js/commands/duplicate.js" type="text/javascript" charset="utf-8"></script>
	<script src="js/commands/rename.js"    type="text/javascript" charset="utf-8"></script>
	<script src="js/commands/help.js"      type="text/javascript" charset="utf-8"></script>
	<script src="js/commands/getfile.js"   type="text/javascript" charset="utf-8"></script>
	<script src="js/commands/mkdir.js"     type="text/javascript" charset="utf-8"></script>
	<script src="js/commands/mkfile.js"    type="text/javascript" charset="utf-8"></script>
	<script src="js/commands/upload.js"    type="text/javascript" charset="utf-8"></script>
	<script src="js/commands/download.js"  type="text/javascript" charset="utf-8"></script>
	<script src="js/commands/edit.js"      type="text/javascript" charset="utf-8"></script>
	<script src="js/commands/quicklook.js" type="text/javascript" charset="utf-8"></script>
	<script src="js/commands/quicklook.plugins.js" type="text/javascript" charset="utf-8"></script>
	<script src="js/commands/extract.js"   type="text/javascript" charset="utf-8"></script>
	<script src="js/commands/archive.js"   type="text/javascript" charset="utf-8"></script>
	<script src="js/commands/search.js"    type="text/javascript" charset="utf-8"></script>
	<script src="js/commands/view.js"      type="text/javascript" charset="utf-8"></script>
	<script src="js/commands/resize.js"    type="text/javascript" charset="utf-8"></script>
	<script src="js/commands/sort.js"      type="text/javascript" charset="utf-8"></script>

	<!-- elfinder languages -->
	<script src="js/i18n/elfinder.ar.js"    type="text/javascript" charset="utf-8"></script>
	<script src="js/i18n/elfinder.ca.js"    type="text/javascript" charset="utf-8"></script>
	<script src="js/i18n/elfinder.cs.js"    type="text/javascript" charset="utf-8"></script>
	<script src="js/i18n/elfinder.de.js"    type="text/javascript" charset="utf-8"></script>
	<script src="js/i18n/elfinder.en.js"    type="text/javascript" charset="utf-8"></script>
	<script src="js/i18n/elfinder.es.js"    type="text/javascript" charset="utf-8"></script>
	<script src="js/i18n/elfinder.fr.js"    type="text/javascript" charset="utf-8"></script>
	<script src="js/i18n/elfinder.hu.js"    type="text/javascript" charset="utf-8"></script>
	<script src="js/i18n/elfinder.jp.js"    type="text/javascript" charset="utf-8"></script>
	<script src="js/i18n/elfinder.nl.js"    type="text/javascript" charset="utf-8"></script>
	<script src="js/i18n/elfinder.pl.js"    type="text/javascript" charset="utf-8"></script>
	<script src="js/i18n/elfinder.pt_BR.js" type="text/javascript" charset="utf-8"></script>
	<script src="js/i18n/elfinder.ru.js"    type="text/javascript" charset="utf-8"></script>
	<script src="js/i18n/elfinder.zh_CN.js" type="text/javascript" charset="utf-8"></script>

	<!-- elfinder dialog -->
	<script src="js/jquery.dialogelfinder.js"     type="text/javascript" charset="utf-8"></script>

	<style type="text/css">
		body { font-family:arial, verdana, sans-serif;}
		.button {
			width: 100px;
			position:relative;
			display: -moz-inline-stack;
			display: inline-block;
			vertical-align: top;
			zoom: 1;
			*display: inline;
			margin:0 3px 3px 0;
			padding:1px 0;
			text-align:center;
			border:1px solid #ccc;
			background-color:#eee;
			margin:1em .5em;
			padding:.3em .7em;
			border-radius:5px;
			-moz-border-radius:5px;
			-webkit-border-radius:5px;
			cursor:pointer;
		}
	</style>

	<script type="text/javascript" charset="utf-8">
		$().ready(function() {

			var funcNum = window.location.search.replace(/^.*CKEditorFuncNum=(\d+).*$/, "$1");
			var langCode = window.location.search.replace(/^.*langCode=([a-z]{2}).*$/, "$1");

			$('#finder').elfinder({
				url : 'php/modules/<?PHP echo $_GET['module']; ?>.php',
				lang : langCode,
				getFileCallback : function(url) {
					url = url.replace('../../', '');
					window.opener.CKEDITOR.tools.callFunction(funcNum, url);
					window.close();
				},
				uiOptions : {
					toolbar : [
						['back', 'forward'],
						['reload'],
						['home', 'up'],
						['mkdir', 'mkfile', 'upload'],
						['open', 'download', 'getfile'],
						['info'],
						['quicklook'],
						['copy', 'cut', 'paste'],
						['rm'],
						['duplicate', 'rename', 'edit', 'resize'],
						['search'],
						['view', 'sort'],
						['help']
					]
				},
				contextmenu : {
					files : ['getfile', '|','open', 'quicklook', '|', 'download', '|', 'copy', 'cut', 'paste', 'duplicate', '|', 'rm', '|', 'edit', 'rename', 'resize', 'info']
				},
				commands : ['open', 'reload', 'home', 'up', 'back', 'forward', 'getfile', 'quicklook', 'download', 'rm', 'duplicate', 'rename', 'mkdir', 'mkfile', 'upload', 'copy', 'cut', 'paste', 'edit', 'search', 'info', 'view', 'help', 'resize', 'sort'],
			})
		})
	</script>

</head>
<body>
	<div id="finder">finder <span>here</span></div>
</body>
</html>