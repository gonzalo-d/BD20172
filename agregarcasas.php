
<?php
 ob_start();
 session_start();
     $servername = "localhost";
     $username = "postgres";
     $password = "marticito";
     $dbname = "dbtest";

     $conn =  pg_connect("host=localhost dbname=dbtest user=postgres password=marticito");
     if ($conn -> connect_error){
       die ("Fallo la conexión". $conn->connect_error);
     }
 // if session is not set this will redirect to login page
 if( !isset($_SESSION['username']) ) {
  header("Location: index.php");
  exit;
 }
 // select loggedin users detail

$res = pg_query($conn, "SELECT * FROM usuario WHERE username = '".$_SESSION['username']."'");
$userRow = pg_fetch_array($res);


?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Baladas de frío y calor</title>
    <link href="diseno.css" rel="stylesheet"/>
      <body>
        <div class ="menu">
          <ul id="menu">
            <li><a href="index.php">Logout</a></li>
            <li><a href="loged.php">Volver atrás</a></li>
          </ul>
        </div>

        <div class="contenido">
          <li>
	    <?php
            $tipousuario = "";

            if ($userRow['PERMISO']=='t'){
                $tipousuario = "el escritor, ser todopoderoso.";
            }
            else{
                $tipousuario = "un seguidor, tu existencia en este  mundo es insignificante.";
            }
           echo "Hola ".$userRow['username'].". En el sistema eres ".$tipousuario." Que quieres?";  ?></li>

           <?php

              $out =   ' 	<form action="agregarcasasDB.php" method="POST">
                        	<h3>Nombre Casa</h3>
                          <input type="text" name="nombre_casa"><br/>
                        	<h3>Cantidad de plata</h3>
                        	<input type="number" name="cantidad_plata"><br/>
                          <h3>Fecha Inicio contrato del lider:</h3>
                          <input type ="date" name="ini"><br/>
                          <h3>Fecha Termino contraro del lider:</h3>
                          <input type="date" name="fin"><br/>
                          Nombre del Lider<br>
                          <select name="id_lider">';

                          $personaje = pg_query($conn,'select * from personaje where id_casa IS NULL');
                          while ($row = pg_fetch_row($personaje) ) {
                          $out .= '<option value="'.$row[0].'">'.$row[4].'</option>';}
                          $out .= '</select><br>';
                          $out .= '<input type="submit" value="Agregar"> </form>';

                       echo $out;
               ?>



	<?php
	echo $_POST["nombre_casa"];
	echo $_POST["cantidad_plata"];
  echo $_POST["id_lider"];
  echo $_POST["fin"];
  echo $_POST["ini"];
	?>
        </div>
      </body>
</html>


<?php ob_end_flush(); ?>
