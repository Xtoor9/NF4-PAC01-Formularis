<?php
    $numero1 = $_POST['num1'];
    $numero2 = $_POST['num2'];
    $numero3 = $_POST['num3'];

    $suma = $numero1 + $numero2 + $numero3;

    echo "<h1>La suma de ",$numero1," + ",$numero2," + ",$numero3," = ",$suma;
?>