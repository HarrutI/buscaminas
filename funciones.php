<?php
require_once "minas.php";

function printMapa($mapa)
{
    $filas_t = sizeof($mapa);
    $colum_t = sizeof($mapa[0]);

    echo("<table align=\"center\" border = \"1\" width=". ($colum_t*50) ."px height=". ($filas_t*50) ."px");

    for($i = 0; $i<$filas_t;$i++)
    {
        echo("<tr>");

        for($j = 0; $j<$colum_t; $j++)
        {
            $casilla = $mapa[$i][$j]->getValue();
            $visible = $mapa[$i][$j]->getVisible();

            if($visible == 0)
            {
                echo("<td width=\"48px\" height=\"48px\" align=\"center\">
                <a href=index.php?operacion=revelar&la_fila=".$i."&la_columna=".$j.">
                <img src=\"square-48.png\"></img>
                </td>");
            }else
            {
                if($casilla == -1)
                {
                    echo("<td width=\"48px\" height=\"48px\" align=\"center\" bgcolor=\"tomato\">💣</td>");
                }
                else if($casilla > 0)
                {
                    echo("<td width=\"48px\" height=\"48px\" align=\"center\" bgcolor=\"cornflowerblue\">". $casilla ."</td>");

                }
                else
                {
                    echo("<td width=\"48px\" height=\"48px\" align=\"center\">". $casilla ."</td>");
                }
            }

        }
        echo("</tr>");
    }
    echo "</table>";
}

//funcion para leaderboard

function leer_leaderboard()
{
    $id_fichero = @fopen("leaderboard.txt","r") or die("<B>El fichero leaderboard.txt no se ha podido abrir.</B><P>");

    $leader = array();

    while(!feof($id_fichero))        
    {
        $leader_str = fgets($id_fichero);
        if($leader_str != "")
        {
            $fila = explode("_",$leader_str);
            array_push($leader,$fila);
        }
    }

    fclose($id_fichero);
    return $leader;
}

function add_leaderboard($nombre,$tiempo,$puntos,$leader)
{
    //compruebo si los puntos pasados entran en el marcador
    for($i = 0; $i<10; $i++)
    {
        if($puntos>$leader[$i][2])
        {
            $introducir = array($nombre,$tiempo,$puntos);
            array_splice($leader,$i,0,array($introducir));
            array_pop($leader);
            break;
        }
    }

    $id_fichero_temp = @fopen("basura.tmp","w") or die("<B>El fichero 'basura.tmp' no se ha podido abrir.</B><P>");

    for($j = 0; $j<sizeof($leader);$j++)
    {
        $leader_str = implode("_",$leader[$j]);

        if($i == $j)
        {
            $leader_str .= "\n";
        }
        fputs($id_fichero_temp,$leader_str);
    }
    

    fclose($id_fichero_temp);
    unlink('leaderboard.txt');
    rename("basura.tmp", 'leaderboard.txt');

    return $leader;
}


function printLeaderboard($leader)
{
    echo "<table border=\"|\">";
    echo "<tr> <th>Nombre</th> <th>Tiempo</th> <th>Puntuacion</th> </tr>";
    for($i = 0; $i<10; $i++)
    {
        echo "<tr> <td>".$leader[$i][0]."</td> <td>".gmdate("i:s", $leader[$i][1])."</td> <td>".$leader[$i][2]."</td> </tr>";
    }
    echo "</table>";
}

function calcPuntos($casillas,$tiempo,$minas)
{
    $p_cas = $casillas*10;
    $p_ti = 3000 - $tiempo*10;
    $p_mi = $minas * 100;

    $puntos = $p_cas + $p_ti + $p_mi;

    return $puntos;
}
?>