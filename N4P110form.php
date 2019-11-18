<?php
//connect to MySQL
$db = mysqli_connect('localhost', 'root') or 
    die ('Unable to connect. Check your connection parameters.');

//create the main database if it doesn't already exist
$query = 'CREATE DATABASE IF NOT EXISTS serie';
mysqli_query($db,$query) or die(mysqli_error($db));

//make sure our recently created database is the active one
mysqli_select_db($db,'serie') or die(mysqli_error($db));
//Query para obtener los nombres de los series de la bd
$query = 'SELECT
        nombre_serie
    FROM
        serie';
$result = mysqli_query($db, $query) or die(mysqli_error($db));
extract($row);
?>
<html>
 <head>
  <title>Añadir comentario</title>
 </head>
 <body>
  <form action="N4P111formprocess.php" method="post">
    <p>Selecciona el serie al que va dirigido el comentario.</p>
    <select name="nombre_serie">
      <?php
      //bucle para añadir opciones al select para cada serie que tengamos en la bd
      while ($row = mysqli_fetch_assoc($result)) {
        extract($row);
        echo "<option value='$nombre_serie'>$nombre_serie</option>";
      }
      ?>
    </select>
    <p>Introduce tu nombre</p>
    <input type="text" name="name"/>
    <p>Introduce una valoración.</p>
    <input type="number" name="rating" min="1" max="5" />
    <p>Introduce un comentario.</p>
    <textarea name="comentario" rows="10" cols="40">Escribe aquí tu comentario</textarea>
    <input type="submit" name="submit" value="Submit" />
  </form>
 </body>
</html>