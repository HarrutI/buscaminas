<?php

    require_once "minas.php";
    require_once "funciones.php";

    session_start();

    if(!isset($_REQUEST['operacion']))
    {
        $op = '';
    }else
    {
        $op = $_REQUEST['operacion'];
    }

        switch($op)
        {
            case 'crear_mapa':

                $n_casillas = ($_REQUEST['fila_mapa']*$_REQUEST['columna_mapa']);
                $juego = new Mapa();

                //valido que el maximo de casillas es 900 y minimo debe tener 2 casillas, ademas numero de minas debe ser menor
                //al numero de casillas y mayor que 0, ademas el nombre no este vacio
                if($n_casillas <= 900 && $n_casillas>1 && $_REQUEST['minas_mapa']<$n_casillas && $_REQUEST['minas_mapa']>0 && $_REQUEST['nombre'] != "")
                {
                    $juego->crearMapa($_REQUEST['fila_mapa'],$_REQUEST['columna_mapa'],$_REQUEST['minas_mapa']);

                    //guardo el objeto mapa en la sesion y los datos introducidos para el leaderboard
                    $_SESSION['mapa'] = $juego;
                    $_SESSION['datos'] = array();
                    array_push($_SESSION['datos'],$_REQUEST['nombre']);
                    array_push($_SESSION['datos'],$n_casillas);
                    array_push($_SESSION['datos'],$_REQUEST['minas_mapa']);

                    //creo en sesion una variable con el tiempo actual al crear el mapa
                    $_SESSION['tInicio'] = time();
                }else
                {
                    $error = "Uno de los datos fue mal introducido";
                }

                break;
            
            case 'revelar':

                $f = $_REQUEST['la_fila'];
                $c = $_REQUEST['la_columna'];

                $continuar = $_SESSION['mapa']->revelar($f,$c);

                if($continuar == false)
                {
                    $_SESSION['mapa']->mostrarTodo();
                    echo "PERDISTE";
                }

                $victoria = $_SESSION['mapa']->checkVictoria();

                if($victoria)
                {
                    //creo la hora en la que ganaste y restarlo al inicial
                    $_SESSION['tFinal'] = time();
                    header("Location: leaderboard.php");
                    
                }

                break;
        }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscaminas</title>
</head>
<body align="center">
    <h1>BUSCAMINAS</h1>
    <form action="index.php" method="post">

        <label for="minas">Nombre:</label>
        <input type="text" name="nombre" id="nombre" required>

        <br>

        <label for="fila">Fila:</label>
        <input type="text" name="fila_mapa" id="fila" required>

        <br>

        <label for="columna">Columna:</label>
        <input type="text" name="columna_mapa" id="columna" required>

        <br>

        <label for="minas">Número de Minas:</label>
        <input type="text" name="minas_mapa" id="minas" required>

        <br>

        <!-- Campo oculto para enviar la operación -->
        <input type="hidden" name="operacion" value="crear_mapa">

        <br>

        <input type="submit" value="Enviar">
    </form>

    <?php
        
        if(isset($_SESSION['mapa']) && $_SESSION['mapa'] != "")
        {
            printMapa($_SESSION['mapa']->getMapa());
        }
        
        if(isset($error))
        {
            echo $error;
        }
    ?>
</body>
</html>