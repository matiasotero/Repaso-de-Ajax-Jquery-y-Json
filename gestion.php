<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
	<title>Gestion de vehiculos</title>
	<!--<link rel="stylesheet" type="text/css" href="estilo.css">
  	<link rel="stylesheet" type="text/css" media="all" href="style.css">-->
  	<link rel="stylesheet" type="text/css" href="estiloGestion.css">
</head>
<body>
<br>
<a href="index.php" class="btn">Volver</a>
<?php

/*	1- si es un ingreso lo guardo en ticket.txt
 	2- si es salida leo el archivo:
 	leer del archivo todos los datos, guardarlos en un array
	si la patente existe en el archivo .
	 sobreescribo el archivo con todas las patentes
	 y su horario si la patente solicitada
	... calculo el costo de estacionamiento a 
	20$ el segundo y lo muestro.
	si la patente no existe mostrar mensaje y 
	el boton que me redirija al index  
	3- guardar todo lo facturado en facturado.txt*/

//var_dump($_POST["estacionar"]);
//var_dump($_FILES["fotoAutito"]["name"]);
//var_dump($extAnterior[1]);
if(isset($_POST["patente"]) && $_POST["patente"]!="")
{
	$accion = $_POST["estacionar"];
	$patente = $_POST["patente"];
	if ($accion == "ingreso") 
	{	
		//if($_POST["fotoAutito"]!="")
		//{
		$extAnterior=explode(".", $_FILES["fotoAutito"]["name"]);
		//$archivoDestino="Fotitos/".$_FILES["fotoAutito"]["name"];	
		$archivoDestino="Fotitos/".$_POST["patente"].".".$extAnterior[1];
		//echo "<br>".var_dump($extAnterior);
		//die();
		//echo "<br>";
		//var_dump($archivoDestino);
		move_uploaded_file($_FILES["fotoAutito"]["tmp_name"], $archivoDestino);//tmp_name te devuelve el lugar donde se guarda en el directorio de archivo temporales del servidor
		//die();
		//}
	/*else
	{
		$archivoDestino=1;
		$extAnterior=1;	
	}*/
	$ahora=date("y-m-d h:i:s");
		echo "<br><h2>Se guardo la patente ".$patente."</h2><br>";
		$archivo=fopen("ticket.txt", "a");
		fwrite($archivo, $patente."[".$ahora."[".$archivoDestino."\n");//el corchete es separador//si el escape "\n" no funciona, probar PHP_EOL
		//echo "<br>";
		//echo var_dump($archivoDestino[1]);
		//echo "<br>";
		fclose($archivo);
	}
	else
	{
		$archivo=fopen("ticket.txt", "r");
		while (!feof($archivo))//La función feof devuelve true si es el final de la fila del archivo
		{
			$renglon=fgets($archivo);
			$auto=explode("[", $renglon);
			if($auto[0] != "")//esto sirve para que no se guarde un elemento vacio
				$listaDeAutos[]=$auto;
		}
		//var_dump($listaDeAutos);
		//die();
		$cont=0;
		foreach ($listaDeAutos as $item) 
		{
			if($item[0] == $patente)
			{
				$actual=new DateTime(date("y-m-d h:i:s"));
				var_dump($actual);
				$horaIngreso=new DateTime($item[1]);
				//var_dump($horaIngreso);
				$tiempoEstadia=$horaIngreso->diff($actual);
				//$actual=date("y-m-d h:i:s");
				//var_dump($actual);
				//die();
				//$horaIngreso=strtotime($item[1]);
				//$tiempoEstadia=round((abs($horaIngreso-$actual))/60/60/60/60/60);
				//$tiempoEstadia=round($tiempoEstadia);
				MostrarTiempoDeEstadia($item,$tiempoEstadia);
				//die();
				unset($listaDeAutos[$cont]);
				break;
			}
			$cont++;
		}
		$archivo=fopen("ticket.txt", "w");
		foreach ($listaDeAutos as $item) 
		{
			fwrite($archivo, $item[0]."[".$item[1]."[".$item[2]);
		}
		fclose($archivo);
		//GrabarTiempoDeEstadia($_POST["patente"]);
	}
	MostrarListado();
}

else
{
	echo "<h1>No se ingreso ningún auto!</h1>";
	echo "<br><br>";
	MostrarListado();
}
function MostrarListado()
{
	$archivo=fopen("ticket.txt", "r");

	//echo "<div='CajaUno animated bounceInLeft'>";
	echo "<table border=3>";
	echo "<th>Patente</th><th>Fecha</th><th>Foto</th>";

	while (!feof($archivo)) 
	{	
		echo "<tr>";	
		$renglon=fgets($archivo);
		$auto=explode("[", $renglon);
		//if(trim($reglon))//trim() saca todos los espacios
		//{
		if($auto[0]!="")
		{
			echo "<td>".$auto[0]."</td>"."<td>".$auto[1]."</td>"."<td>"."<img src= $auto[2] width=200px>"."</td>" ;
			echo "</tr>";
		}
		//}
	}
	echo "</table>";

}

function MostrarTiempoDeEstadia($auto,$tiempoEstacionado)
{
	$tiempo=$tiempoEstacionado->h;
	$total=20;
	echo "<br><br><br>";
	echo "<div class='CajaEnunciado'>";
	echo "El auto con patente: ".$auto[0]." estuvo estacionado ".$tiempo." horas."."<br>";
	if($tiempo < 1)
		echo "Debe abonar ".$total;
	else
	{
		$total=$tiempo*20;
		echo "Debe abonar ".$total.".";
	}
	echo "</div>";
}


function GrabarTiempoDeEstadia($patente)
{
	$archivo=fopen("ticket.txt", "r");
	$listaDeAutos=array();
	$listaAuxiliar=array();
	while (!feof($archivo)) 
	{
		$renglon=fgets($archivo);
		$auto=explode("[", $renglon);
		array_push($listaDeAutos,$auto);
	}
	//var_dump($listaDeAutos);
	foreach ($listaDeAutos as $auto)  
	{ 
		$esta=false; 
		if($auto[0]==$patente) 
		{
			$esta=true;
			$fechaInicio=$auto[1];
			$fechaDiferencia=strtotime($ahora)-strtotime($fechaInicio);//strtotime() tranforma de string a dato tipo date o fecha echo "El tiempo transcurrido es: ".$fechaDiferencia; echo "<h2>".var_dump($fechaDiferencia)."</h2>"; 
		}
		else 
		{ 
			if($auto[0]!="") 
				$listaAuxiliar[]=$auto; 
		} 
		//echo $auto[0]."<br>";// el indice cero es la patente, el indice uno es la fecha if($esta) 
		if($esta) 
		{ 
			//echo "<br>"."El auto esta"."<br>";
			$archivoDos=fopen("ticket.txt", "w"); 
			foreach ($listaAuxiliar as $auto)  
			{
				fwrite($archivoDos, $auto[0]."[".$auto[1]."$"."\n"); 
			} 
			fclose($archivoDos); 
		}
		else 
			echo "No esta el auto"; 
	}
}

?>
</body>
</html>