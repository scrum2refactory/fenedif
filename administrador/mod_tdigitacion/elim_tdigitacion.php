<?php
require("../mod_configuracion/conexion.php");
require("../theme/header_inicio.php");
$ced = $_GET['cedula'];
$cedu = $_GET['ced'];
$id = $_GET['tdigitacion_id'];
echo "<br><br><br><br><br>";
$consulta_elimina = mysql_query("delete from tdigitacion where tdigitacion_id='$id'");
if($consulta_elimina)
		{
		echo $ced;	
		echo "<br><br><br><br><br>";
		echo "<font color=\"#FF0000\"><div align=\"center\">TIPO DIGITACIÓN ELIMINADO .... </div></font><br>"; 
		}
echo "<br><br><br><br><br>";
require("../theme/footer_inicio.php");
?>
