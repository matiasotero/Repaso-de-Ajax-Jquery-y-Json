
<!doctype html>
<html lang="en-US">
<head>

  <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
  <title> Alumnos </title>

  <link rel="stylesheet" type="text/css" href="estilo.css">
  <link rel="stylesheet" type="text/css" href="animacion.css">
  <link rel="stylesheet" type="text/css" media="all" href="style.css">

  <script type="text/javascript">
    function startTime()
    {
      today=new Date();
      year=today.getFullYear();
      month=today.getMonth();
      day=("0"+(today.getDay()+1)).slice(-2);
      h=today.getHours();
      m=today.getMinutes();
      s=today.getSeconds();
      m=checkTime(m);
      s=checkTime(s);
      document.getElementById('reloj').innerHTML=day+"/0"+month+"/"+year+" "+h+":"+m+":"+s;
      t=setTimeout('startTime()',500);}
      function checkTime(i)
      {
        if(i<10) 
          {
            i="0" + i;
          }
      return i;
    }
    window.onload=function(){startTime();}
  </script> 
<style type="text/css">
  #relojete 
  {
     font-size: 2000px;
  }
</style>


  <!--script type="text/javascript" src="js/currency-autocomplete.js"></script-->
</head>
	<body>
    <div class="CajaUno animated bounceInDown">

            <form action="gestion.php" method="post" enctype="multipart/form-data"><!--Pasa el archivo la propiedad enctype="multipart/form-data" en foto, no el nombre -->
            <input type="text" name="patente"  id="autocomplete" required title="Debe ingresar una patente!"/>
            <br>
            <input type="submit" class="MiBotonUTN" value="ingreso"  name="estacionar" />
            <br/>
            <input type="submit" class="MiBotonUTN" value="egreso" name="estacionar" />
            <br>
            <!--<input type="file" class="MiBotonUTN" name="fotoAutito" accept="image/x-png, image/gif, image/jpeg" />-->
            <input type="file" class="MiBotonUTN" name="fotoAutito" value="fotoAutito" accept="image/*" /><!--la propiedad del control input file accept-->
          </form>



    </div>
      <div class="CajaEnunciado animated bounceInLeft">
      <h2>autos:</h2>

      <?php
      echo "<br>";
      MostrarListadosAutosIngresados();

      function MostrarListadosAutosIngresados()
      {
        $archivo=fopen("ticket.txt", "r");
        while (!feof($archivo)) 
        {
          $renglon=fgets($archivo);
          $auto=explode("[", $renglon);
          if($auto[0]!="")
          {
            echo "Patente: ".$auto[0]." /Hora ingreso: ".$auto[1]."<br>";
          }
        }
        fclose($archivo);
      } 
      ?>     
      
    </div>
    <br><br><br><br><br><br><br>
      		<div id="reloj" class="relojete">
          </div>
	</body>
</html>