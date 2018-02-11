<?php
/**
 * @PHP-NUKE: Web Portal System
 * @package Tricked Out News
 * @version 2.6 (RN News-Mod)
 * @file: printpdf.php
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
$module_name = basename(dirname(__FILE__));
get_lang($module_name);

if (isset($id)) {
	if ($id == '' || !is_numeric($id)) {
		Header('Location: ./');	
		exit;
	} elseif (is_numeric($id)) {
		$idnum = $id;
	}
} else {
	$idnum = '';
}

if (is_admin($admin)) {
	$storylock = '';
} else {
	$storylock = '`slock` = 0 AND';
}

if ($idnum != '') {
require_once('classes/tcpdf/config/lang/eng.php');
require_once('classes/tcpdf/tcpdf.php');
global $db, $prefix, $nukeurl, $slogan, $sitename;
list($usenotes) = $db->sql_fetchrow($db->sql_query('SELECT `usenotes` FROM `' . $prefix . '_ton`'));
$result = $db->sql_query('SELECT `catid`, `sid`, `aid`, `time`, `title`, `hometext`, `bodytext`, `informant`, `notes` FROM `' . $prefix . '_stories` WHERE ' . $storylock . ' `sid` = \'' . $idnum . '\'');
$numrows = $db->sql_numrows($result);
if (intval($numrows)!=1) {
	Header('Location: modules.php?name=' . $module_name);
	exit();
}
$numrows = $db->sql_numrows($result);
$row = $db->sql_fetchrow($result);
$catid = intval($row['catid']);
$sid = $row['sid'];
$aaid = $row['aid'];
$time = $row['time'];
$title = htmlentities($row['title'], ENT_QUOTES, _CHARSET);
$hometext = stripslashes($row['hometext']);
$bodytext = stripslashes($row['bodytext']);
$informant = htmlspecialchars($row['informant'], ENT_QUOTES, _CHARSET);
if ($usenotes == 1) {
	$notes = $row['notes'];
} else {
	$notes = '';
}
$articleurl = $nukeurl . '/modules.php?name=News&file=article&sid=' . $sid;
if(empty($bodytext)) {
    $bodytext = $hometext.$notes;
} else {
    $bodytext = $hometext.$bodytext.$notes;
}

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor($informant);
//$pdf->SetTitle($title); // neralex: removed - pdf pagetitle
$pdf->SetTitle('article' . $sid);
$pdf->SetSubject($nukeurl);
$pdf->SetKeywords($sitename);

// set default header data
$pdf->SetHeaderData('','',$sitename,$nukeurl);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language dependent data:
$lg = Array();
$lg['a_meta_charset'] = 'UTF-8';
$lg['a_meta_dir'] = 'ltr';
$lg['a_meta_language'] = 'en';
$lg['w_page'] = 'page';

//set some language-dependent strings
$pdf->setLanguageArray($lg);
// add a page
$pdf->AddPage();
// ---------------------------------------------------------
// set font
$pdf->SetFont('helvetica', '', 16);
$htmlcontent4 = $title;
$pdf->WriteHTML($htmlcontent4, true, 0, true, 0);
// set font
$pdf->SetFont('helvetica', '', 8);
$htmlcontent3 = $time . ' by ' . $informant;
$pdf->WriteHTML($htmlcontent3, true, 0, true, 0);
// set font
$pdf->SetFont('helvetica', '', 12);
// print newline
$pdf->Ln();

// Arabic and English content
$htmlcontent2 = $bodytext;
$baseURL = getNukeURL();
$htmlcontent2 = reltoabs($bodytext, $baseURL);
$pdf->WriteHTML($htmlcontent2, true, 0, true, 0);


// print newline
$pdf->Ln();
// set LTR direction for english translation
// set font size
$pdf->SetFontSize(6);

$htmlcontent = $articleurl;
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);


//Close and output PDF document
$pdf->Output('article' . $sid . '.pdf', 'I');
}else{
echo 'There was an error';
}
//============================================================+
// END OF FILE                                                
//============================================================+