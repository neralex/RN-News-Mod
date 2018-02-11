<?php
/**
 * @PHP-NUKE: Web Portal System
 * @package Tricked Out News
 * @version 2.6 (RN News-Mod)
 * @file: links.php (admin)
 * @copyright (c) 2002 by Francisco Burzi
 * @Additional security & Abstraction layer conversion 2003 chatserv http://www.nukeresources.com
 * @nukeWYSIWYG Copyright (c) 2005 Kevin Guske http://nukeseo.com
 * @kses developed by Ulf Harnhammar http://kses.sf.net
 * @RavenNuke(tm) Support:
 * 2012 - Nuken http://www.trickedoutnews.com
 * 2013 - rework of all functions by neralex http://www.media.soefm.de
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
if (!defined('ADMIN_FILE')) {
	die ('Access Denied');
}
global $admin_file;
adminmenu($admin_file.'.php?op=adminStory', _NEWS, 'stories.gif');
adminmenu($admin_file.'.php?op=newsedit', _NEWS .' Config', 'newsconfig.gif');
adminmenu($admin_file.'.php?op=newsarchive', _NEWS.' Archive', 'stories.gif');