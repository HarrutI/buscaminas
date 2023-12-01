<?php

class Casilla
{
    private $valor = 0;
    private $visible = 0;

    function __construct($valor)
    {
        $this->valor = $valor;
    }

    function changeVisible()
    {
        $this->visible = 1;
    }

    function setValue($v)
    {
        $this->valor = $v;
    }

    function getValue()
    {
        return $this->valor;
    }

    function getVisible()
    {
        return $this->visible;
    }

};


class Mapa
{

    private $mapa = array();
    private $minas_totales = 0;
    private $noMinas_totales = 0;
    private $noMinas_rev = 0;

    function __construct()
    {
        
    }

    function crearMapa($filas_t,$colum_t,$minas)
    {
        $mapa = array();
        //tengo un mapa con todos los valores igual a 0
        for($i = 0; $i<$filas_t; $i++)
        {
            $fi = array();

            for($j = 0; $j<$colum_t; $j++)
            {
                $casilla = new Casilla(0);

                array_push($fi,$casilla);
            }

            array_push($mapa,$fi);
        }

        //contador que hará de filtro para salir de bucle, porque en cada iteracion que se haga,
        //no tiene por que haberse puesto una mina
        $m = 0;

        while($m<$minas)
        {
            //el rand incluye los numeros de los extremos, el ultimo digito de fila y de columna sale
            //fuera del limite por lo que le resto 1
            $fi_m = rand(0,$filas_t-1);
            $co_m = rand(0,$colum_t-1);

            //Una mina se identifica por tener el valor de -1
            //si la casilla aleatoria no tiene ese valor, se le modificara a -1
            if($mapa[$fi_m][$co_m]->getValue() != -1){
                //esa posicion la pongo como mina
                $mapa[$fi_m][$co_m]->setValue(-1);
                $m++;

                //bucle que recorre alrededor de la mina para aumentar en 1 los numeros alrededores
                for ($i = $fi_m-1; $i<=$fi_m+1; $i++)
                {
                    //compruebo que no se salga del limite por la izquierda y derecha  del mapa
                    if ($i>=0 && $i<$filas_t)
                    {
                        for($j = $co_m-1; $j<=$co_m+1; $j++)
                        {
                            //compruebo que no se salga del limite por arriba y por abajo, ademas compruebo que esa posicion 
                            //tenga una mina, y si la tiene no aumente en 1 su valor
                            if ($j>=0 && $j<$colum_t)
                            {
                                $valor_cas = $mapa[$i][$j]->getValue();

                                if($valor_cas != -1)
                                {
                                    $mapa[$i][$j]->setValue($valor_cas+1);
                                }
                            }
                        }
                    }
                }
            }
        }

        $this->mapa = $mapa;
        $this->minas_totales = $minas;
        $this->noMinas_totales = ($filas_t*$colum_t)-$minas;
    }

    function getMapa()
    {
        return $this->mapa;
    }

    function revelar($f_rev,$c_rev)
    {   
        $this->mapa[$f_rev][$c_rev]->changeVisible();

        if($this->mapa[$f_rev][$c_rev]->getValue() == -1)
        {
            //si le diste a una mina, devuelve false, por lo que perdiste
            return false;
        }
        $this->noMinas_rev++;

        //bucle que recorre alrededor de la casilla para aumentar comprobar si el numero de al lado el igual a 0
        for ($i = $f_rev-1; $i<=$f_rev+1; $i++)
        {
            //compruebo que no se salga del limite por la arriba y debajo  del mapa
            if ($i>=0 && $i<sizeof($this->mapa))
            {
                for($j = $c_rev-1; $j<=$c_rev+1; $j++)
                {
                    //compruebo que no se salga del limite por izuierda y por derecha, ademas compruebo que esa posicion 
                    //sea 0 y su valor de visible sea 0, en ese caso ejecutara el programa de nuevo
                    if ($j>=0 && $j<sizeof($this->mapa[0]))
                    {
                        //si el valor de la coordenada es 0 y el de su alrededor es 0, volvera a ejecutarse la misma funcion
                        if($this->mapa[$i][$j]->getValue() == 0 && $this->mapa[$i][$j]->getVisible() == 0)
                        {
                            $this->revelar($i,$j);
                        }
                        //si encuentra otra casilla que no sea 0 y no sea una mina, ademas que la casilla pulsada es un 0, entonces la revela
                        else if ($this->mapa[$i][$j]->getValue() != -1 && $this->mapa[$i][$j]->getVisible() == 0 && $this->mapa[$f_rev][$c_rev]->getValue() == 0)
                        {
                            $this->mapa[$i][$j]->changeVisible();
                            $this->noMinas_rev++;
                        }
                        
                    }
                    
                }
            }
        }

        return true;
    }

    function checkVictoria()
    {
        if ($this->noMinas_totales == $this->noMinas_rev)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    function mostrarTodo()
    {
        //cuando pierdas, revelara todo el mapa, por lo que cambia todos los visibles a 1
        for($i = 0; $i<sizeof($this->mapa);$i++)
        {
            for($j = 0; $j<sizeof($this->mapa[0]); $j++)
            {
                
                $this->mapa[$i][$j]->changeVisible();
            }
            
        }
    }
}

function test()
{
    $mapa_test = new Mapa();
    $mapa_test->crearMapa(3,3,3);
    $mapa_test->revelar(1,1);
    print_r($mapa_test->getMapa());
}

?>