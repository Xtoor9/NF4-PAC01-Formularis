<?php
$table="";
$cont=0;
$media=NULL;
//connect to MySQL
$db = mysqli_connect('localhost', 'root') or 
    die ('Unable to connect. Check your connection parameters.');
mysqli_select_db($db , 'serie') or die(mysqli_error($db));
$serie_rating=0;
$idserie =  $_GET['idserie2'];
$ordenar = $_GET['orden'];

// function to generate ratings
function generate_ratings($rating) {
    $serie_rating="";
    for ($i = 0; $i < $rating; $i++) {
        $serie_rating .= '<img src="full_star.png" alt="star"/>';
    }
    return $serie_rating;
}


// take in the id of a director and return his/her full name
function get_autor1($id_autor1) {

    global $db;

    $query = 'SELECT 
            cliente_fullname 
       FROM
           cliente
       WHERE
           cliente_id = ' . $id_autor1;
    $result = mysqli_query($db, $query) or die(mysqli_error($db));

    $row = mysqli_fetch_assoc($result);
    extract($row);

    return $cliente_fullname;
}

// take in the id of a lead actor and return his/her full name
function get_autor2($id_autor2) {

    global $db;

    $query = 'SELECT
            cliente_fullname
        FROM
            cliente
        WHERE
            cliente_id = ' . $id_autor2;
    $result = mysqli_query($db,$query) or die(mysqli_error($db));

    $row = mysqli_fetch_assoc($result);
    extract($row);

    return $cliente_fullname;
}

// take in the id of a movie type and return the meaningful textual
// description
function get_tiposerie($tiposerie_id) {

    global $db;

    $query = 'SELECT 
            tiposerie_label
       FROM
           tiposerie
       WHERE
           tiposerie_id = ' . $tiposerie_id;
    $result = mysqli_query($db,$query) or die(mysqli_error($db));

    $row = mysqli_fetch_assoc($result);
    extract($row);

    return $tiposerie_label;
}

// function to calculate if a movie made a profit, loss or just broke even
function calculate_differences($ventas, $coste) {

    $difference = $ventas - $coste;

    if ($difference < 0) {     
        $color = 'red';
        $difference = '$' . abs($difference) . ' million';
    } elseif ($difference > 0) {
        $color ='green';
        $difference = '$' . $difference . ' million';
    } else {
        $color = 'blue';
        $difference = 'broke even';
    }

    return '<span style="color:' . $color . ';">' . $difference . '</span>';
}





// retrieve information
$query = 'SELECT
        nombre_serie, ano_serie, autor1_serie, autor2_serie, tipo_serie, episodios_serie, coste_serie, ventas_serie
    FROM
        serie
    WHERE
        id_serie = '. $idserie;
       
$result = mysqli_query($db, $query) or die(mysqli_error($db));


$row = mysqli_fetch_assoc($result);
extract($row);

$nombreserie          = $nombre_serie;
$autor1serie          = get_autor1($autor1_serie);
$autor2serie          = get_autor2($autor2_serie);
$anoserie             = $ano_serie;
$paginasserie         = $paginas_serie . ' pags';
$ventasserie          = $ventas_serie . ' million';
$costeserie          = $coste_serie . ' million';
$beneficiosserie      = calculate_differences($ventas_serie,$coste_serie);

// display the information

$table.= <<<ENDHTML
<html>
 <head>
  <title>Detalles y Reviews de: $nombre_serie</title>
 </head>
 <body>
  <div style="text-align: center;">
   <h2>$nombre_serie</h2>
   <h3><em>Detalles</em></h3>
   <table cellpadding="2" cellspacing="2"
    style="width: 70%; margin-left: auto; margin-right: auto; text-align: center;">
    <tr>
     <td><strong>Título</strong></strong></td>
     <td>$nombreserie</td>
     <td><strong>Año</strong></strong></td>
     <td>$anoserie</td>
    </tr><tr>
     <td><strong>Autor 1</strong></td>
     <td>$autor1serie</td>
     <td><strong>Coste</strong></td>
     <td>$costeserie</td>
    </tr><tr>
     <td><strong>Autor 2</strong></td>
     <td>$autor2serie</td>
     <td><strong>Ventas</strong></td>
     <td>$ventasserie</td>
    </tr><tr>
     <td><strong>Páginas</strong></td>
     <td>$paginasserie</td>
     <td><strong>Beneficios</strong></td>
     <td>$beneficiosserie</td>
    </tr>
   </table>
ENDHTML;



// retrieve reviews for this movie
$query = 'SELECT
        review_serie_id, review_date, reviewer_name, review_comment, review_rating
    FROM
        reviews
    WHERE
        review_serie_id =' . $idserie . ' 
        
    ORDER BY ' . $ordenar .' DESC';


$result = mysqli_query($db, $query) or die(mysqli_error($db));




// display the reviews
$table.= <<<ENDHTML
   <h3><em>Reviews</em></h3>
   <table cellpadding='2' cellspacing='2'
    style="width: 90%; margin-left: auto; margin-right: auto; text-align: center;">
    <tr>
     <th style="width: 7em;"><a href="NP4111reviewcomments.php?idserie2=$idserie&orden=review_date">Fecha</a></th>
     <th style="width: 10em;"><a href="NP4111reviewcomments.php?idserie2=$idserie&orden=reviewer_name">Reviewer</th>
     <th><a href="NP4111reviewcomments.php?idserie2=$idserie&orden=review_comment">Comentarios</th>
     <th style="width: 5em;"><a href="NP4111reviewcomments.php?idserie2=$idserie&orden=review_rating">Rating</th>
    </tr>
ENDHTML;

while ($row = mysqli_fetch_assoc($result)) {
    $date = $row['review_date'];
    $name = $row['reviewer_name'];
    $comment = $row['review_comment'];
    $rating = generate_ratings($row['review_rating']);
    $suma = $row['review_rating'];
    $cont++;
    $media += $suma;
    $resto = $cont%2;
    if($resto==0):
        $color= "#DAF7A6";
    else:
        $color= "#FFC300";
    endif;
    
    $table.= <<<ENDHTML
    <tr style="background-color:$color">
      <td style="vertical-align:top; text-align: center">$date</td>
      <td style="vertical-align:top">$name</td>
      <td style="vertical-align:top">$comment</td>
      <td style="vertical-align:top">$rating</td>
    </tr>
ENDHTML;
}



$media = ($media)/$cont;
$entero = intval($media);
$decimal = $media - $entero;
$rating = generate_ratings($entero);
$porcentaje = 0;

if($decimal>0){
    $porcentaje = $decimal*100;
    $porcentaje = intval(100-$porcentaje);
    $rating .= '<img src="full_star.png" alt="estrella" style="clip-path:inset(0%' . $porcentaje . '% 0% 0%);"/>';
}

$table .= <<<ENDHTML
<tr style="border: 2px solid black;">
   <td colspan= "3" style="vertical-align:top; text-align: center;">Media</td>
   <td style="vertical-align:top; text-align: center;">$rating</td>
</tr>
ENDHTML;

$table.=<<<ENDHTML
  </div>
 </body>
</html>
ENDHTML;

echo $table;
?>