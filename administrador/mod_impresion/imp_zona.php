<?php 
?>
<?php
require_once("classpdf/fpdf.php");
header("Content-type: application/pdf; charset=utf-8");
/*********** Create PDF ***********************/
    $pdf = new fpdf('P','mm','A4');
	$pdf->AddPage();
    $pdf->SetFont('Arial','B',14);
/***************  Header ***************************/
	$universidad=utf8_decode('Gestion de Procesos');
    $header_uno  = $pdf->Text(10, 15, "$universidad");
	//$header_uno .= 	$pdf->text(10, 25, "Ciudad");
	//$header_uno .= $pdf->text(10, 30, "Tels");
	$header_uno .= $pdf->Image("../theme/images/logo_tixi.jpg", 150, 5);
	$pdf->Cell(190, 20,$header_uno);
	$pdf->Ln();
    $pdf->Cell(190, 10,"");
    $pdf->Ln();
/*************** Cuerpo del documento **************/
    $beg_bod = utf8_decode('TIPO DE ZONA');
    $pdf->Cell(190, 10,$beg_bod,0, 0, 'C');
    $pdf->Ln();
	
	  
/**************** Campo cedula ****************/	
    $pdf->SetFont('Arial','B',10);
	$camp_ced = "CODIGO:";
	$camp_ced_value = $_POST["zona_id"];
	$pdf->Cell(50, 8,$camp_ced,1);
	$pdf->SetFont("Times");
	$pdf->Cell(140, 8,$camp_ced_value,1);
	$pdf->Ln();
/**************** Campo apellido paterno ****************/	
    $pdf->SetFont('Arial','B',10);
	$camp_apellidop = "ZONA NOMBRE:";
	$camp_apellidop_value = $_POST["zona_nombre"];
	$pdf->Cell(50, 8,$camp_apellidop,1);
	$pdf->SetFont("Times");
	$pdf->Cell(140, 8,$camp_apellidop_value,1);
	$pdf->Ln();

/************* Footer ************************/	
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(50, 30,"JEFE DEPARTAMENTO.",0,0,'C');
	$med=utf8_decode('FUNCIONARIO');
    $pdf->Cell(190, 30,"$med",0,0, 'C');
    $pdf->Ln();


    $pdf->Output();
	
	
	
	?>