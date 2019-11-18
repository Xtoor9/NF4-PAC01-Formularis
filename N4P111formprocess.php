<?php
//connect to MySQL
$db = mysqli_connect('localhost', 'root') or 
    die ('Unable to connect. Check your connection parameters.');

//create the main database if it doesn't already exist
$query = 'CREATE DATABASE IF NOT EXISTS serie';
mysqli_query($db,$query) or die(mysqli_error($db));

//make sure our recently created database is the active one
mysqli_select_db($db,'serie') or die(mysqli_error($db));
//Cojemos las variables del formulario anterior
$nombreserie = $_POST['nombre_serie'];
$valoracion = $_POST['rating'];
$comentarios = $_POST['comentario'];
$nombre = $_POST['name'];

//query para obtener el id del serie que previamente hemos seleccionado en el otro formulario
$query = "SELECT
        id_serie
    FROM
        serie
    WHERE nombre_serie = '$nombreserie'";
$result = mysqli_query($db, $query) or die(mysqli_error($db));
$row = mysqli_fetch_assoc($result);
extract($row);
//obtenemos un array con todos los datos de la fecha de hoy
$date = getdate();
//accedemos al año guardado en el array
$fecha .= $date['year'];
$fecha .= "-";
//accedemos al mes guardado en el array
$fecha .= $date['mon'];
$fecha .= "-";
//accedemos al dia del mes guardado en el array
$fecha .= $date['mday'];

//Hacemos el insert con todos los datos
$insert = "INSERT INTO reviews (review_serie_id,review_date,reviewer_name,review_comment,review_rating) VALUES('$id_serie','$fecha','$nombre','$comentarios','$valoracion')";
mysqli_query($db, $insert) or die(mysqli_error($db));

//Añadimos un enlace a la pagina de detalles del serie seleccionado
$enlace .= <<<ENDHTML
    <p>El comentario se ha insertado correctamente, haz click <a href="NP4111reviewcomments.php?idserie2=$id_serie&orden=review_date">aqui</a> para ver los comentarios del serie seleccionado'</p>
ENDHTML;
echo $enlace;
?>