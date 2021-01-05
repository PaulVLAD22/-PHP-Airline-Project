<?php
require('fpdf.php');

class pdf extends FPDF {
    var $javascript;
    var $n_js;

    function IncludeJS($script) {
        $this->javascript=$script;
    }

    function _putjavascript() {
        $this->_newobj();
        $this->n_js=$this->n;
        $this->_out('<<');
        $this->_out('/Names [(EmbeddedJS) '.($this->n+1).' 0 R]');
        $this->_out('>>');
        $this->_out('endobj');
        $this->_newobj();
        $this->_out('<<');
        $this->_out('/S /JavaScript');
        $this->_out('/JS '.$this->_textstring($this->javascript));
        $this->_out('>>');
        $this->_out('endobj');
    }

    function _putresources() {
        parent::_putresources();
        if (!empty($this->javascript)) {
            $this->_putjavascript();
        }
    }

    function _putcatalog() {
        parent::_putcatalog();
        if (!empty($this->javascript)) {
            $this->_out('/Names <</JavaScript '.($this->n_js).' 0 R>>');
        }
    }
} 


// Instanciation of inherited class
$pdf = new PDF();
$pdf-> SetMargins(30,0,30);
$pdf->AddPage('L','A5');
// Logo
$x=$pdf->getX();
$y=$pdf->getY();
$pdf->SetFillColor(252,248,245);
$pdf->SetXY($x-30,$y-10);
//$pdf->Cell(220,160,'',0,1,'C','true');
$pdf->Rect(0,0,300,300,'F');
$pdf->SetXY($x,$y+10);
$pdf->Image('logo.png',$x,$y+10,60);

$link = $pdf->AddLink();
$pdf->SetLink($link);
if(count($_GET)>0)
$pdf->Image('print.png',240,$y+10,35,15,'','http://localhost/factura/factura.php?'.$pdf->IncludeJS("print('true');"));
else
$pdf->Image('print.png',240,$y+10,35,15,'','http://localhost/factura/factura.php?print=true');
//$pdf->Image('print.png',10,12,30,0,);
$pdf->ln(10);
$x=$pdf->getX();
$y=$pdf->getY();
$pdf->SetFillColor(255,255,255);
$pdf->Rect(30,$x+10,240,180,'F');
$pdf->SetXY($x,$y+20);
$pdf->SetDrawColor(237,236,234);
$pdf->SetLineWidth(0.7);
$pdf->Rect(30,$x+10,240,180,'D');
$pdf->SetXY($x,$y);
$pdf->ln(10);
$pdf->SetLineWidth(0.2);
$lungime=240;
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','B',16);
$pdf->ln(25);
$x=$pdf->GetX();
$pdf->SetX($x+10);
$pdf->Cell($lungime,10,'Factura fiscala NTC/11981//2013',0,1,'L',0);
$pdf->SetFont('Arial','B',12);
$pdf->SetX($x+10);
$pdf->Cell($lungime,10,'Data factura(azi): '.date('d-m-Y'),0,1,'L',0);
$pdf->ln(15);
$pdf->SetFont('Arial','B',11);
$pdf->SetDrawColor(237,236,234);
$pdf->SetX($x+10);
$pdf->Cell(($lungime-10)/2,10,'SC SKY NETCOM SRL','R',0,'L',0);
$pdf->Cell(5,10,' ',0,0,'L',0);
$pdf->Cell(($lungime-10)/2,8,'Chirvasa Alexandru',0,1,'L',0);
$pdf->SetFont('Arial','B',10);
$pdf->SetX($x+10);
$pdf->Cell(($lungime-10)/4-25,6,'ADRESA:',0,0,'L',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(($lungime-10)/4+25,6,'Calea Vitan nr. 117, bl.V21A, sc.1, ap.2, sect.3,','R',0,'L',0);
$pdf->Cell(5,10,' ',0,0,'R',0);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(($lungime-10)/4-30,6,'ADRESA:',0,0,'L',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(($lungime-10)/4+20,6,'Str. Papazoglu Nr. 84A, Sc. A, Ap. 187, Sector 3,',0,1,'L',0);

$pdf->SetFont('Arial','B',10);
$pdf->SetX($x+10);
$pdf->Cell(($lungime-10)/4-25,6,' ',0,0,'L',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(($lungime-10)/4+25,6,'Bucuresti','R',0,'L',0);
$pdf->Cell(5,10,' ',0,0,'R',0);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(($lungime-10)/4-30,6,' ',0,0,'L',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(($lungime-10)/4+20,6,'Bucuresti',0,1,'L',0);

$pdf->SetFont('Arial','B',10);
$pdf->SetX($x+10);
$pdf->Cell(($lungime-10)/4-25,6,'CUI:',0,0,'L',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(($lungime-10)/4+25,6,'-21476318','R',0,'L',0);
$pdf->Cell(5,10,' ',0,0,'R',0);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(($lungime-10)/4-30,6,'CUI/CNP:',0,0,'L',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(($lungime-10)/4+20,6,'VS 251266',0,1,'L',0);

$pdf->SetFont('Arial','B',10);
$pdf->SetX($x+10);
$pdf->Cell(($lungime-10)/4-25,6,'ONRC:',0,0,'L',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(($lungime-10)/4+25,6,'J40/6515/2007','R',0,'L',0);
$pdf->Cell(5,10,' ',0,0,'R',0);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(($lungime-10)/4-30,6,'ONRC/CI:',0,0,'L',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(($lungime-10)/4+20,6,'1910603375482',0,1,'L',0);

$pdf->SetFont('Arial','B',10);
$pdf->SetX($x+10);
$pdf->Cell(($lungime-10)/4-25,6,'CAPITAL SOCIAL:',0,0,'L',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(($lungime-10)/4+25,6,'200 RON','R',0,'L',0);
$pdf->Cell(5,10,' ',0,0,'R',0);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(($lungime-10)/4-30,6,'TELEFON:',0,0,'L',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(($lungime-10)/4+20,6,'0741015496',0,1,'L',0);

$pdf->SetFont('Arial','B',10);
$pdf->SetX($x+10);
$pdf->Cell(($lungime-10)/4-25,6,'',0,0,'L',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(($lungime-10)/4+25,6,'',0,0,'L',0);
$pdf->Cell(5,10,' ',0,0,'R',0);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(($lungime-10)/4-30,6,'MOBIL:',0,0,'L',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(($lungime-10)/4+20,6,'0741015496',0,1,'L',0);

$pdf->SetFont('Arial','B',10);
$pdf->SetX($x+10);
$pdf->Cell(($lungime-10)/4-25,6,'',0,0,'L',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(($lungime-10)/4+25,6,'',0,0,'L',0);
$pdf->Cell(5,10,' ',0,0,'R',0);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(($lungime-10)/4-30,6,'EMAIL:',0,0,'L',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(($lungime-10)/4+20,6,'xander91erep@gmail.com',0,1,'L',0);

$pdf->ln(30);
$pdf->SetFont('Arial','B',20);
$pdf->SetX($x+10);
$Date = date('d-m-Y');
$data_factura=date('d-m-Y', strtotime($Date. ' + 15 days'));
$pdf->Cell(115,12,'Total de plata pana la '.$data_factura.':',0,0,'L',0);
$pdf->SetFillColor(224,220,221);
$pdf->Cell(38,12,'10.95 RON ',0,1,'L',1);

//$pdf->IncludeJS("print('true');");
$pdf->Output('factura.pdf','I');  
?>
