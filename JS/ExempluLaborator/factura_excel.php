<?php
/**
 * PHPExcel
 *
 * Copyright (c) 2006 - 2015 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2015 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    ##VERSION##, ##DATE##
 */

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once 'PHPExcel/Classes/PHPExcel.php';


// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Optional PHP")
							 ->setLastModifiedBy("Optional PHP")
							 ->setTitle("Factura")
							 ->setSubject("Factura")
							 ->setDescription("Factura scrisa in xls")
							 ->setKeywords("factura xls phpexcel")
							 ->setCategory("factura");


// adauga datele facturii
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Furnizor:')
            ->setCellValue('B1', 'Firma Test')
            ->setCellValue('A2', 'Reg. com.:')
            ->setCellValue('B2', 'J32/1111/2222')
            ->setCellValue('A3','CIF')
            ->setCellValue('B3','RO12345678')
            ->setCellValue('A4','Adresa: ')
            ->setCellValue('B4','str. Aciliu nr.22, Sibiu, Jud. Sibiu')
            ->setCellValue('A5','IBAN:')
            ->setCellValue('B5',' RO12345678910111213141516')
            ->setCellValue('A6','Banca:')
            ->setCellValue('B6','BCR SIBIU')
            ->setCellValue('A7','Capital social:')
            ->setCellValue('B7','1000 RON')
            ->setCellValue('C1','FACTURA')
            ->setCellValue('F1','Client:')
            ->setCellValue('G1','Dynamic Soft Service')
            ->setCellValue('F2','Reg. com.:')
            ->setCellValue('G2','J35/105/1994')
            ->setCellValue('F3','CIF:')
            ->setCellValue('G3','RO55667788')
            ->setCellValue('F4','Adresa:')
            ->setCellValue('G4',' str.Client 5, nr.5, Satu Mare')
            ->setCellValue('F5','Judet:')
            ->setCellValue('G5',' Satu Mare')
            ->setCellValue('F6',' IBAN:')
            ->setCellValue('G6',' RO06BTRL5765069XXX006484')
            ->setCellValue('F7',' Banca:')
            ->setCellValue('G7',' BT')
            ->setCellValue('C2', "Seria FCT nr. 0021\nData (zi/luna/an): 27/03/2008\nNr aviz: 12345\nCota TVA: 19%");

//redimensionare coloane
  $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
   $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
   $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
   $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
   $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
   $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
   $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);

//schimbare text coloana D1
   $objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
   $objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setSize(20);

//aliniere centrata a textului
$objPHPExcel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

//adaugare bordura de culoare negru
$styleArray = array(
	'borders' => array(
		'outline' => array(
			'style' => PHPExcel_Style_Border::BORDER_THICK,
			'color' => array('argb' => 'FF000000'),
		),
	),
);
$objPHPExcel->getActiveSheet()->getStyle('C2:E5')->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle('A1:G13')->applyFromArray($styleArray);
//unire casute C2:E5
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('C2:E5');
$objPHPExcel->getActiveSheet()->getStyle('C2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('C2')->getAlignment()->setWrapText(true);

//adaugare imagine
$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('Thumb');
$objDrawing->setDescription('Thumbnail Image');
$objDrawing->setPath('logo.png');
$objDrawing->setHeight(80);
$objDrawing->setCoordinates('C9');
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

//adaugare tabel
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A15', 'Nr. crt:')
            ->setCellValue('B15', 'Denumirea produselor sau a serviciilor')
            ->setCellValue('C15', 'U.M.')
            ->setCellValue('D15', 'Cant.')
            ->setCellValue('E15', "Pret unitar\n(fara TVA)\n-RON")
            ->setCellValue('F15', "Valoarea\n-RON")
            ->setCellValue('G15', "Valoarea TVA\n-RON-")
            ->setCellValue('A16', "0")
            ->setCellValue('B16', "1")
            ->setCellValue('C16', "2")
            ->setCellValue('D16', "3")
            ->setCellValue('E16', "4")
            ->setCellValue('F16', "5(3x4)")
            ->setCellValue('G16', "6")
            ->setCellValue('A17', "1")
            ->setCellValue('B17', "Prestari servicii conform contract nr 21/14.01.2008")
            ->setCellValue('C17', "buc")
            ->setCellValue('D17', "1")
            ->setCellValue('E17', "1000.00")
            ->setCellValue('F17', "1000.00")
            ->setCellValue('G17', "190.00")
            ->setCellValue('A18', "2")
            ->setCellValue('B18', "Dezvoltare Aplicatie Web ")
            ->setCellValue('C18', "buc")
            ->setCellValue('D18', "1")
            ->setCellValue('E18', "300.00")
            ->setCellValue('F18', "300.00")
            ->setCellValue('G18', "57.00")
            ->setCellValue('A19', "3")
            ->setCellValue('B19', "Discount 10%")
            ->setCellValue('C19', "buc")
            ->setCellValue('D19', "1")
            ->setCellValue('E19', "-130.00")
            ->setCellValue('F19', "-130.00")
            ->setCellValue('G19', "-24.70")
            ->setCellValue('A20', "Mentionam ca plata trebuie facuta fara numerar")
            ->setCellValue('A21', "Semnatura si\nstampila\nfurnizorului")
            ->setCellValue('B21', "Intocmit de: Vlaicu POP\nCNP: 1821220190456\nNumele delegatului: Maria VODA\nB.I/C.I: SB288887\nMijloc transport: B43634\nExpedierea s-a efectuat in prezenta noastra la data de\n....................ora.........\nSemnaturile:")
            ->setCellValue('E21', "Total")
            ->setCellValue('F21', "1170.00")
            ->setCellValue('G21', "223.30")
            ->setCellValue('E23',"Total plata ")
            ->setCellValue('F23',"1392.30")
            ->setCellValue('E25',"Semnatura de primire:")
            ->setCellValue('A27',"Termen Plata: 15 zile")
            ->setCellValue('A28',"-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------");

  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C1:E1');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C8:E12');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A21:A26');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B21:D26');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E21:E22');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E23:E24');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F21:F22');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('G21:G22');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F23:G24');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E25:G26');
  $objPHPExcel->getActiveSheet()->getStyle('A15:G15')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  $objPHPExcel->getActiveSheet()->getStyle('A16:G16')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  $objPHPExcel->getActiveSheet()->getStyle('A16:A19')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  $objPHPExcel->getActiveSheet()->getStyle('A15:G15')->getAlignment()->setWrapText(true);
  $objPHPExcel->getActiveSheet()->getStyle('A16:G16')->getAlignment()->setWrapText(true);
  $objPHPExcel->getActiveSheet()->getStyle('A21:B21')->getAlignment()->setWrapText(true);
  $objPHPExcel->getActiveSheet()->getStyle('A15:G15')->getFont()->setBold(true);
  $objPHPExcel->getActiveSheet()->getStyle('A16:G16')->getFont()->setBold(true);

for($c='A';$c<='G';$c++)
 for($i=15;$i<=26;$i++)
  $objPHPExcel->getActiveSheet()->getStyle($c.$i)->applyFromArray($styleArray);


//ultima parte a facturii
$objPHPExcel->getActiveSheet()->getStyle('A30:G50')->applyFromArray($styleArray);
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A30:B37');
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A30',"Seria CHT nr. 0007\nFurnizor: Firma Test\nReg. com.: J32/1111/2222\nCIF:RO12345678\nCont: RO12345678910111213141516\nBanca:BCR SIBIU\nAdresa: str. Aciliu nr.22, Sibiu, Jud. Sibiu\nCapital social: 1000 RON")
            ->setCellValue('F39',"Seria CHT nr. 0007\nData (zi/luna/an): 27/03/2008")
            ->setCellValue('A43',"Am primit de la: Dynamic Soft Servicen\nAdresa: str.Client 5, nr.5, Satu Mare, Judet Satu Mare\nSuma de 1392.30 RON, adica unamietreisutenouazecisidoua, 3 RON\nreprezentand contravaloarea facturii seria FCT nr 0021 din data de 27/03/2008")
            ->setCellValue('E49','Casier,');
$objPHPExcel->getActiveSheet()->getStyle('A30:B50')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('F39')->getAlignment()->setWrapText(true);

$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('Thumb');
$objDrawing->setDescription('Thumbnail Image');
$objDrawing->setPath('logo.png');
$objDrawing->setHeight(80);
$objDrawing->setCoordinates('F33');
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F38', 'CHITANTA');
$objPHPExcel->getActiveSheet()->getStyle('F38')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('F38')->getFont()->setSize(20);
$objPHPExcel->getActiveSheet()->getStyle('F38')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('F38:G38');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('F33:G33');

$objPHPExcel->setActiveSheetIndex(0)->mergeCells('F39:G40');
$objPHPExcel->getActiveSheet()->getStyle('F39')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('F39:G40')->applyFromArray($styleArray);

$objPHPExcel->getActiveSheet()->getStyle('C9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A43:D46');
$objPHPExcel->getActiveSheet()->getStyle('A43')->getAlignment()->setWrapText(true);



// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Factura');


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="factura.xls"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
