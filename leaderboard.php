<?php

require_once "minas.php";
require_once "funciones.php";

session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body align="center">
    <h1>VICTORIA</h1>
    <table align="center">
        <tr>
            <td>
            <?php
                //en esta vatiable de sesion guardo el objeto mapa generado en index.php
                if(isset($_SESSION['mapa']) && $_SESSION['mapa'] != "")
                {
                    //cambio todas las casillas para que sean visibles
                    $_SESSION['mapa']->mostrarTodo();
                    //getMapa() obtiene como un array el mapa entero y ejecuto al funcion para imprimir
                    //el mapa entero.
                    printMapa($_SESSION['mapa']->getMapa());
                }
            ?>
            </td>
            <td>
            <?php

                //compruebo si las 3 variables en sesiones existen
                if(isset($_SESSION['datos']) && isset($_SESSION['tInicio']) && isset($_SESSION['tFinal']))
                {
                    $leader = leer_leaderboard();
                    $nombre = $_SESSION['datos'][0];
                    $casillas = $_SESSION['datos'][1];
                    $minas = $_SESSION['datos'][2];
                    $tiempo = $_SESSION['tFinal'] - $_SESSION['tInicio'];
    
                    $puntos = calcPuntos($casillas,$tiempo,$minas);
                    $leader = add_leaderboard($nombre,$tiempo,$puntos,$leader);
                    printLeaderboard($leader);
                }
                
            ?>
            </td>
        </tr>
    </table>
    
</body>
</html>