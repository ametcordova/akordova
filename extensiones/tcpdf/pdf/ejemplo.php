<?php
//============================================================+
// File name   : example_numlines.php
// Begin       : 2008-03-04
// Last Update : 2009-09-30
// 
// Description : Example for TCPDF class
// 
// Author: Nicola Asuni
// 
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com s.r.l.
//               Via Della Pace, 11
//               09044 Quartucciu (CA)
//               ITALY
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example
 * @author Nicola Asuni
 * @copyright 2004-2009 Nicola Asuni - Tecnick.com S.r.l (www.tecnick.com) Via Della Pace, 11 - 09044 - Quartucciu (CA) - ITALY - www.tecnick.com - info@tecnick.com
 * @link http://tcpdf.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 * @since 2010-01-21
 */
//REQUERIMOS LA CLASE TCPDF
//require_once('tcpdf_include.php');

require_once('lang/eng.php');
require_once('../tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false); 

// set document information
//$pdf->SetCreator(PDF_CREATOR);
//$pdf->SetAuthor('Nicola Asuni');
//$pdf->SetTitle('TCPDF Example 001');
//$pdf->SetSubject('TCPDF Tutorial');
//$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetMargins(0,0,0, true);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO); 

//set some language-dependent strings
$pdf->setLanguageArray($l); 

// ---------------------------------------------------------

// set font
$pdf->SetFont('times', 'BI', 16);

// add a page
//$pdf->AddPage();
$pdf->AddPage('P', 'A7');

$pdf->SetFont('times', 'BI', 8);
$w = 100; //mm

$s = "CYBER INDIA ";
// there is no new line char for the above string
$n = $pdf->getNumLines($s, $w);
$pdf->MultiCell($w,'',$s,0,'L',0,1);

$s = "SOFTWARE PROFESSIONALS(Opt-In Newsletter Subscribers in India)";
// there is no new line char for the above string
$n = $pdf->getNumLines($s, $w);
$pdf->MultiCell($w,'',$s,0,'L',0,1);


$s = "Opt-In Newsletter Subscribers in India";
// there is no new line char for the above string
$n = $pdf->getNumLines($s, $w);
$pdf->MultiCell($w,'',$s,0,'L',0,1);

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('example_numlines.pdf', 'I');

//============================================================+
// END OF FILE                                                 
//============================================================+
?>
