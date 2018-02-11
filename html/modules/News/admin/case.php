<?php
/**
 * @PHP-NUKE: Web Portal System
 * @package Tricked Out News
 * @version 2.6 (RN News-Mod)
 * @file: case.php (admin)
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
$module_name = basename(substr(__FILE__, 0, -15));
include_once('modules/' . $module_name . '/admin/language/lang-' . $currentlang . '.php');
switch($op) {

    case 'RemoveStory':
    case 'adminStory':
    case 'PreviewAdminStory':
    case 'PostAdminStory':
    case 'EditStory':
    case 'ChangeStory':
    case 'newsedit':
    case 'tonSave':
    case 'newsarchive':
  	case 'YesDelCategory':
    case 'DelCategory':
    case 'NoMoveCategory':
    case 'EditCategory':	
    case 'SaveEditCategory':
    case 'AddCategory':
    case 'SaveCategory':
	case 'StoryStatus':
    include_once('modules/' . $module_name . '/admin/index.php');
    break;

}