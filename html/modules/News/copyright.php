<?php
/**
 * @PHP-NUKE: Web Portal System
 * @package Tricked Out News
 * @version 2.6 (RN News-Mod)
 * @file: copyright.php
 * @copyright (c) 2002 by Francisco Burzi
 * @Additional security & Abstraction layer conversion 2003 chatserv http://www.nukeresources.com
 * @nukeWYSIWYG Copyright (c) 2005 Kevin Guske http://nukeseo.com
 * @kses developed by Ulf Harnhammar http://kses.sf.net
 * @RavenNuke(tm) Support:
 * 2012 - Nuken http://www.trickedoutnews.com
 * 2013 - rework of all functions by neralex http://www.media.soefm.de
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

$author_name = 'Nuken, neralex';
$author_user_email = '';
$author_homepage = 'http://www.media.soefm.de';
$license = 'GNU/GPL';
$download_location = 'http://www.media.soefm.de/download-file-1.html';
$module_version = '2.6 (RN News-Mod)';
$module_description = 'Mod of the Tricked Out News';

// DO NOT TOUCH THE FOLLOWING COPYRIGHT CODE. YOU'RE JUST ALLOWED TO CHANGE YOUR "OWN"
// MODULE'S DATA (SEE ABOVE) SO THE SYSTEM CAN BE ABLE TO SHOW THE COPYRIGHT NOTICE
// FOR YOUR MODULE/ADDON. PLAY FAIR WITH THE PEOPLE THAT WORKED CODING WHAT YOU USE!!
// YOU ARE NOT ALLOWED TO MODIFY ANYTHING ELSE THAN THE ABOVE REQUIRED INFORMATION.
// AND YOU ARE NOT ALLOWED TO DELETE THIS FILE NOR TO CHANGE ANYTHING FROM THIS FILE IF
// YOU'RE NOT THIS MODULE'S AUTHOR.

function show_copyright() {
	global $author_name, $author_email, $author_homepage, $license, $download_location, $module_version, $module_description;
	if ($author_name == '') {
		$author_name = 'N/A';
	}
	if ($author_email == '') {
		$author_email = 'N/A';
	}
	if ($author_homepage == '') {
		$author_homepage = 'N/A';
	}
	if ($license == '') {
		$license = 'N/A';
	}
	if ($download_location == '') {
		$download_location = 'N/A';
	}
	if ($module_version == '') {
		$module_version = 'N/A';
	}
	if ($module_description == '') {
		$module_description = 'N/A';
	}
	$module_name = 'Tricked Out News';

	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"'
	   , '"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'
	   , '<html xmlns="http://www.w3.org/1999/xhtml">'
	   , '<head><title>' , $module_name , ': Copyright Information</title></head>'
	   , '<body bgcolor="#F6F6EB" link="#363636" alink="#363636" vlink="#363636">'
	   , '<div style="text-align:center;"><span style="font-weight:bold;">Module Copyright &copy; Information</span><br />'
	   , '<span style="font-size:x-small; color:#363636; font-family:Verdana, Helvetica;">'
	   , '<span style="font-weight:bold;">Module Copyright &copy; Information</span><br />'
	   , $module_name , ' for <a href="http://ravenphpscripts.com" target="_blank">RavenNuke(tm)</a><br /><br />'
	   , '</span>'
	   , '</div>'
	   , '<img src="../../images/arrow.gif" border="0" alt="" />&nbsp;<span style="font-weight:bold;">Module\'s Name:</span> ' , $module_name , '<br />'
	   , '<img src="../../images/arrow.gif" border="0" alt="" />&nbsp;<span style="font-weight:bold;">Module\'s Version:</span> ' , $module_version , '<br />'
	   , '<img src="../../images/arrow.gif" border="0" alt="" />&nbsp;<span style="font-weight:bold;">Module\'s Description:</span> ' , $module_description , '<br />'
	   , '<img src="../../images/arrow.gif" border="0" alt="" />&nbsp;<span style="font-weight:bold;">License:</span> ' , $license , '<br />'
	   , '<img src="../../images/arrow.gif" border="0" alt="" />&nbsp;<span style="font-weight:bold;">Author\'s Name:</span> ' , $author_name , '<br />'
	   , '<img src="../../images/arrow.gif" border="0" alt="" />&nbsp;<span style="font-weight:bold;">Author\'s Email:</span> ' , $author_email , '<br /><br />'
	   , '<div style="text-align:center; font-size:x-small; color:#363636; font-family:Verdana, Helvetica;">'
	   , '[ <a href="' , $author_homepage , '" target="_blank">Author\'s HomePage</a> | '
	   , '<a href="' , $download_location , '" target="_blank">Module\'s Download</a> |'
	   , '<a href="javascript:void(0)" onclick="javascript:self.close()">Close</a> ]'
	   , '</div>'
	   , '</body>'
	   , '</html>';
}
show_copyright();