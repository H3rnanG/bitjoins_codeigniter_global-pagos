<?php 
$this->load->library('pdf');

ini_set('memory_limit','-1'); ini_set('max_execution_time','8000');

//var_dump($formato);die();
/*
var_dump($print);
echo 'mnt_total:'.$mnt_total.'<br>';
echo 'edt_sbt:'.$edt_sbt.'<br>';
echo 'edt_appago:'.$edt_appago.'<br>';
die();
*/


function coverWithLabelTCPDF(TCPDF $pdf, float $x, float $y, float $w, float $h, string $label='Envíos',string $align='C',string $bold='B',float $txtY=8): void {
    // Rectángulo de tapa (blanco) sin borde
    //$pdf->Rect($x, $y, $w, $h, 'F', [], [100,150,255]);
    $pdf->Rect($x, $y, $w, $h, 'F', [], [255,255,255]);

    // Texto centrado
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('helvetica', $bold, 12);
    $pdf->SetXY($x, $y+$txtY);
    $pdf->setCellHeightRatio(1.0);
    $pdf->Cell($w, $h, $label, 0, 0, $align, false, '', 0, false, 'M', 'M');
}

if(strlen($formato)>0){

    // initiate PDF (P o L)
    $obpdf = new Pdf('P', 'mm', 'Letter', true, 'UTF-8', false); 
    
    $obpdf->SetTitle('TICKET BILLETERA');
    
    $obpdf->setSourceFile(UPLOAD."/pdf/".$formato);
    $tplIdx = $obpdf->importPage(1, 'MediaBox'); //TrimBox - MediaBox - CropBox
    $size = $obpdf->getTemplateSize($tplIdx);
    $orientation = ($size['w'] > $size['h']) ? 'L' : 'P';
    $obpdf->AddPage($orientation, [$size['w'], $size['h']]);
    //$obpdf->cleanUp();
    //$obpdf->useTemplate($tplIdx, 0, 0, 208, 280, true);
    $obpdf->useTemplate($tplIdx);

    //$obpdf->SetFont('Helvetica', '', '7');
    $imgpath = dirname($_SERVER["SCRIPT_FILENAME"])."/assets/images/capa-espacio.jpg";
    $obpdf->SetFillColor(255, 255, 255);
    $obpdf->Rect(0, 0, $size['w'], 10, 'F'); 
    //$obpdf->Rect(0, $size['h'] - 0.6, $size['w'], 0.6, 'F');
    //$obpdf->Image($imgpath, 1, 8, 100, 5, 'JPG', '', '', false, 300, '', false, false, 0, false, false, false);

    coverWithLabelTCPDF($obpdf, 14, 11.5, 48, 16, 'Envíos');
    coverWithLabelTCPDF($obpdf, 14, 175, 48, 16, 'Envíos');

    // 1ERA PANTALLA
    if($print){
        if($mnt_total){
            $mnt_total_1 = number_format($mnt_total, 2, '.', ',');
            coverWithLabelTCPDF($obpdf, 90.5, 46.5, 25, 6.5, $mnt_total_1,'R','',3);
        } // fin if mnt_total

        if($edt_crg){
            $edt_crg_1 = number_format($edt_crg, 2, '.', ',');
            coverWithLabelTCPDF($obpdf, 90.5, 53, 25, 6.5, $edt_crg_1,'R','',3);
        }

        if($edt_sbt){
            $edt_sbt_1 = number_format($edt_sbt, 2, '.', ',');
            coverWithLabelTCPDF($obpdf, 90.5, 66, 25, 6.5, $edt_sbt_1,'R','',3);
        }

    }//fin if print

    // 2DA PANTALLA
    if($mnt_total){
        $mnt_total_2 = number_format($mnt_total, 2, '.', ',');
        coverWithLabelTCPDF($obpdf, 90.5, 212, 25, 6.5, $mnt_total_2,'R','',3);
    } // fin if mnt_total

    if($edt_crg){
        $edt_crg_2 = number_format($edt_crg, 2, '.', ',');
        coverWithLabelTCPDF($obpdf, 90.5, 218, 25, 6.5, $edt_crg_2,'R','',3);
    }

    if($edt_sbt){
        $edt_sbt_2 = number_format($edt_sbt, 2, '.', ',');
        coverWithLabelTCPDF($obpdf, 90.5, 230, 25, 6.5, $edt_sbt_2,'R','',3);
    }

    $obpdf->Output(); 

} // fin if strlen

