<?php
$titulos = $_POST['titulo'];
$escritores = $_POST['productor'];
$generos = $_POST['genero'];
$sagas = $_POST['narrador'];
$dibujantes = $_POST['efecto'];
$narradores = $_POST['narrador'];

//Separamos las variables en arrays, por cada coma que haya cambia a la siguiente posicion
$array_titulos = explode(",", $titulos);
$array_escritores = explode(",", $escritores);
$array_generos = explode(",", $generos);
$array_sagas = explode(",", $sagas);
$array_dibujantes = explode(",", $dibujantes);
$array_narradores = explode(",", $narradores); 

//nos quedamos con la longitud de los arrays
$longitud_titulos = sizeof($array_titulos);
$longitud_escritores = sizeof($array_escritores);
$longitud_generos = sizeof($array_generos);
$longitud_sagas = sizeof($array_sagas);
$longitud_dibujantes = sizeof($array_dibujantes);
$longitud_narradores = sizeof($array_narradores);

?>
<html>
 <head>
  <title>Añadir comentario</title>
 </head>
 <body>
  <form action="N4P113formprocess.php" method="post">
    <p>Elije tu genero favorito:</p>
    <select name="genero">
      <?php
        for($cont=0;$cont<$longitud_generos;$cont++){
            echo "<option value='$array_generos[$cont]'>$array_generos[$cont]</option>";
        }      
      ?>
    </select>
    <p>Elije tu productor favorito:</p>
    <select name="autor">
      <?php
        for($cont=0;$cont<$longitud_escritores;$cont++){
            echo "<option value='$array_escritores[$cont]'>$array_escritores[$cont]</option>";
        }      
      ?>
    </select>
    <p>Elije tu serie favorito:</p>
    <select name="serie">
      <?php
        for($cont=0;$cont<$longitud_titulos;$cont++){
            echo "<option value='$array_titulos[$cont]'>$array_titulos[$cont]</option>";
        }      
      ?>
    </select>
    <p>Elije tu saga favorita:</p>
    <select name="saga">
      <?php
        for($cont=0;$cont<$longitud_sagas;$cont++){
            echo "<option value='$array_sagas[$cont]'>$array_sagas[$cont]</option>";
        }      
      ?>
    </select>
    <p>Elije tus efectos favorito:</p>
    <select name="dibujante">
      <?php
        for($cont=0;$cont<$longitud_dibujantes;$cont++){
            echo "<option value='$array_dibujantes[$cont]'>$array_dibujantes[$cont]</option>";
        }      
      ?>
    </select>
    <p>Elije tu tipo de narrador favorito:</p>
    <select name="narrador">
      <?php
        for($cont=0;$cont<$longitud_dibujantes;$cont++){
            echo "<option value='$array_dibujantes[$cont]'>$array_dibujantes[$cont]</option>";
        }      
      ?>
    </select>
    <input type="submit" name="submit" value="Submit" />
  </form>
 </body>
</html>