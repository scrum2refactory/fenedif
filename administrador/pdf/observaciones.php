<?php
session_start();
//incluimos funciones,configuración e idioma
include('../funciones.php');
require('../config.php');
require('../idioma/'.$idioma.'');
//si hay sesión cargamos código
if (isset($_SESSION['usuario_sesion']))
{
$docente = $_SESSION['usuario_sesion'];
$agrupamiento = $_GET['p1'];
$periodo = $_GET['p2'];
//conecto con MySQL
conecta();

//compruebo agrupamiento
$sel_agr = mysql_query("select agrupamiento from agrupamientos where agrupamiento = '$agrupamiento' and docente = '$docente'");
if(mysql_num_rows($sel_agr)>0)
{
require('html2fpdf.php');
$pdf=new HTML2FPDF('P','mm','A4');
$pdf->pgwidth = 180;
$pdf->SetMargins(20,5,20);
$pdf->AddPage();

$pdf->Image('logo_200.jpg',20,5); 
$pdf->Ln(5);		
$pdf->Cell(50,10,''.decode($nombre_centro).'',0,0,'L');
$pdf->Ln(5);
$pdf->Cell(50,10,''.decode($dir_centro).'',0,0,'L');
$pdf->Ln(5);
$pdf->Cell(80,10,'Tel.:'.$telefono_centro.' Fax: '.$fax_centro.'',0,0,'L');
$pdf->Ln(10);

$sel_det = mysql_query("select nombre from agrupamientos where agrupamiento = '$agrupamiento'");
$reg_det = mysql_fetch_array($sel_det);
$materia = $reg_det['nombre'];

$html_11='
	<td border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"1\" align=\"left\">
	
	'.decode($id_inf_nb).' '.decode($materia).'
	
	</td>';
	$pdf->WriteHTML($html_11);
$pdf->Ln(5);

//$pdf->Cell(80,10,''.decode($id_inf_nb).' ('.decode($materia).')',0,0,'L');
//$pdf->Ln(5);



if($periodo != $id_todo_curso)
	{
	$sel_fechas = mysql_query("select * from periodos where periodo = '$periodo'");
	$reg_fechas = mysql_fetch_array($sel_fechas);
	$f_ini = $reg_fechas['inicio'];
	$f_fin = $reg_fechas['fin'];
	$sel_obs = mysql_query("select agenda.fecha,agenda.cita from agenda,horario where agenda.tipo = 'o' and horario.sesion='$agrupamiento' and agenda.dia=horario.dia and agenda.franja=horario.franja and agenda.docente=horario.docente and agenda.docente = '$docente' and agenda.fecha between '$f_ini' and '$f_fin' order by agenda.fecha desc");
	$num_obs = mysql_num_rows($sel_obs);
	$pdf->Cell(80,10,''.decode($id_periodo).' '.decode($id_de).' '.decode($id_evaluacion).': '.decode($periodo).'',0,0,'L');
	$pdf->Ln();

	$html_1='
	<table border=\'1\'>
	<tr>
	<th>'.decode($id_fecha).'</th><th>'.decode($id_inf_nb).'</th>
	</tr>';
	$pdf->WriteHTML($html_1);

	for($o=0;$o<$num_obs;$o++)
		{
		$reg_obs = mysql_fetch_array($sel_obs);
		$fecha_obs = $reg_obs['fecha'];
		$fecha_obs_esp = cambia_fecha_a_esp($fecha_obs);
		$cita=$reg_obs['cita'];

		//la observación puede venir con <p> y esto dentro de la tabla no lo interpreta. Así que voy a sustituir
		//las etiquetas <p> por <br />
		$busqueda = '<p>';
		$reemplazo = '<br />';
		$cita_br = ereg_replace($busqueda,$reemplazo,$cita);
		$busqueda = '</p>';
		$reemplazo = '';
		$cita_br2 = ereg_replace($busqueda,$reemplazo,$cita_br);
		
		$html_2='
		<tr>
		<td align=\'center\' width=\'20%\'>'.$fecha_obs_esp.'</td>
		<td align=\'justify\' width=\'80%\'><div>'.decode($cita_br2).'</div></td>
		</tr>
		';
		$pdf->WriteHTML($html_2);			
		}
	$html_3='</table>';
	$pdf->WriteHTML($html_3);		
	}//fin un solo período
else
	{
	$pdf->Cell(80,10,''.decode($id_periodo).' '.decode($id_de).' '.decode($id_evaluacion).': '.decode($id_todo_curso).'',0,0,'L');
	$pdf->Ln();
	
	$html_1='
	<table border=\'1\'>
	<tr>
	<th>'.decode($id_fecha).'</th><th>'.decode($id_obs).'</th>
	</tr>';
	$pdf->WriteHTML($html_1);	

	$sel_obs = mysql_query("select agenda.fecha,agenda.cita from agenda,horario where agenda.tipo = 'o' and horario.sesion='$agrupamiento' and agenda.dia=horario.dia and agenda.franja=horario.franja and agenda.docente=horario.docente and agenda.docente = '$docente' order by agenda.fecha desc");
	$num_obs = mysql_num_rows($sel_obs);
	for($o=0;$o<$num_obs;$o++)
		{
		$reg_obs = mysql_fetch_array($sel_obs);
		$fecha_obs = $reg_obs['fecha'];
		$fecha_obs_esp = cambia_fecha_a_esp($fecha_obs);
		$cita=$reg_obs['cita'];
		
		//la observación puede venir con <p> y esto dentro de la tabla no lo interpreta. Así que voy a sustituir
		//las etiquetas <p> por <br />
		$busqueda = '<p>';
		$reemplazo = '<br />';
		$cita_br = ereg_replace($busqueda,$reemplazo,$cita);
		$busqueda = '</p>';
		$reemplazo = '';
		$cita_br2 = ereg_replace($busqueda,$reemplazo,$cita_br);
		
		$html_2='
		<tr>
		<td align=\'center\' width=\'20%\'>'.$fecha_obs_esp.'</td>
		<td align=\'justify\' width=\'80%\'><div>'.decode($cita_br2).'</div></td>
		</tr>
		';
		$pdf->WriteHTML($html_2);			
		}
	$html_3='</table>';
	$pdf->WriteHTML($html_3);
	}//fin todos los períodos

$pdf->Output();

}//fin compruebo agrupamiento
}//fin hay sesión

?>
