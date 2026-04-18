<?php 
$this->load->library('pdf');

ini_set('memory_limit','-1'); ini_set('max_execution_time','8000');

if(strlen($formato)>0){

    // initiate PDF
    $obpdf = new Pdf('L', 'mm', 'Letter', true, 'UTF-8', false); 
    
    $obpdf->SetTitle('TICKET WESTERN UNION');
    
    $obpdf->setSourceFile(UPLOAD."/pdf/".$formato);
    $tplIdx = $obpdf->importPage(1, 'TrimBox');
    $obpdf->AddPage();
    //$obpdf->cleanUp();
    $obpdf->useTemplate($tplIdx, 0, 0, 210, 279.5, true);

    $obpdf->SetFont('Helvetica', '', '7');
    $imgpath = dirname($_SERVER["SCRIPT_FILENAME"])."/assets/images/capa-espacio.jpg";
    $obpdf->SetFillColor(255, 255, 255);

    $obpdf->Image($imgpath, 1, 8, 205, 5, 'JPG', '', '', false, 300, '', false, false, 0, false, false, false);

    if($print){

        // 1RA PANTALLA
        if($mnt_total){
            $mnt_total_1 = number_format($mnt_total, 2, '.', ',');
            $pt2_pos1 = 48;
            $obpdf->Image($imgpath, 175, $pt2_pos1, 30, 3, 'JPG', '', '', false, 300, '', false, false, 0, false, false, false);
            $obpdf->writeHTMLCell(35.2, 3, 172, $pt2_pos1, $mnt_total_1, 0, 0, 1, true, 'R', false); 
        } // fin if mnt_total

        if($edt_sbt){
            $edt_sbt_1 = number_format($edt_sbt, 2, '.', ',');
            $pt2_pos2 = 56.2;
            $obpdf->Image($imgpath, 175, $pt2_pos2, 30, 3, 'JPG', '', '', false, 300, '', false, false, 0, false, false, false);
            $obpdf->writeHTMLCell(35.2, 3, 172, $pt2_pos2, $edt_sbt_1, 0, 0, 1, true, 'R', false); 

            $obpdf->SetFont('helveticaB', '', '6.7');
            $imgpath2 = dirname($_SERVER["SCRIPT_FILENAME"])."/assets/images/capa-espacio-gris.jpg";
            $pt2_pos3 = 59.4;
            $obpdf->Image($imgpath2, 175, $pt2_pos3, 30.2, 2.80, 'JPG', '', '', false, 300, '', false, false, 0, false, false, false);
            $obpdf->writeHTMLCell(35.2, 3, 172, $pt2_pos3, $edt_sbt_1, 0, 0, 1, true, 'R', false); 

        } // fin if edt_sbt 

        if($edt_appago){

            $edt_tc_1 = number_format($edt_tc, 8, '.', ',');
            $edt_appago_1 = number_format($edt_appago, 0, '.', ',').'.00';
            $obpdf->SetFont('Helvetica', '', '7');

            $pt1_pos4 = 68;
            $obpdf->Image($imgpath, 175, $pt1_pos4, 30, 2.8, 'JPG', '', '', false, 300, '', false, false, 0, false, false, false);
            $obpdf->writeHTMLCell(35.2, 3, 172, $pt1_pos4, $edt_tc_1, 0, 0, 1, true, 'R', false); 

            $pt1_pos5 = 73.6;
            $obpdf->Image($imgpath, 175, $pt1_pos5, 30, 4.2, 'JPG', '', '', false, 300, '', false, false, 0, false, false, false);
            $obpdf->writeHTMLCell(35.2, 3, 172, $pt1_pos5, $edt_appago_1, 0, 0, 1, true, 'R', false); 
        }

    } // fin if print


    // 2DA PANTALLA
    if($mnt_total){
        $mnt_total = number_format($mnt_total, 0, '.', ',');
        $pt2_pos1 = 176;
        $obpdf->Image($imgpath, 175, $pt2_pos1, 30, 3, 'JPG', '', '', false, 300, '', false, false, 0, false, false, false);
        $obpdf->writeHTMLCell(35.2, 3, 172, $pt2_pos1, $mnt_total, 0, 0, 1, true, 'R', false); 
    } // fin if mnt_total

    if($edt_sbt){
        $edt_sbt = number_format($edt_sbt, 0, '.', ',');
        $pt2_pos2 = 183.8;
        $obpdf->Image($imgpath, 175, $pt2_pos2, 30, 3, 'JPG', '', '', false, 300, '', false, false, 0, false, false, false);
        $obpdf->writeHTMLCell(35.2, 3, 172, $pt2_pos2, $edt_sbt, 0, 0, 1, true, 'R', false); 

        $obpdf->SetFont('helveticaB', '', '6.7');
        $imgpath2 = dirname($_SERVER["SCRIPT_FILENAME"])."/assets/images/capa-espacio-gris.jpg";
        $pt2_pos3 = 187.2;
        $obpdf->Image($imgpath2, 175, $pt2_pos3, 30.2, 2.70, 'JPG', '', '', false, 300, '', false, false, 0, false, false, false);
        $obpdf->writeHTMLCell(35.2, 3, 172, $pt2_pos3, $edt_sbt, 0, 0, 1, true, 'R', false); 

    } // fin if edt_sbt 

    if($edt_appago){
        $edt_tc = number_format($edt_tc, 8, '.', ',');
        $edt_appago = number_format($edt_appago, 0, '.', ',').'.00';
        $obpdf->SetFont('Helvetica', '', '7');
        $pt2_pos3 = 196;
        $obpdf->Image($imgpath, 175, $pt2_pos3, 30, 2.8, 'JPG', '', '', false, 300, '', false, false, 0, false, false, false);
        $obpdf->writeHTMLCell(35.2, 3, 172, $pt2_pos3, $edt_tc, 0, 0, 1, true, 'R', false); 

        $pt2_pos4 = 201;
        $obpdf->Image($imgpath, 175, $pt2_pos4, 30, 4.2, 'JPG', '', '', false, 300, '', false, false, 0, false, false, false);
        $obpdf->writeHTMLCell(35.2, 3, 172, $pt2_pos4, $edt_appago, 0, 0, 1, true, 'R', false); 
    }

    $obpdf->Output(); 

} // fin if strlen

