# Buscaminas

## Funcionamiento juego

Campo de juego: El juego comienza con un campo de juego rectangular compuesto por casillas. Cada casilla puede contener una mina o estar vacía.

Minas ocultas: Antes de empezar, se distribuyen aleatoriamente un cierto número de minas en el campo. El jugador no puede ver la ubicación de las minas al principio.

Descubrimiento de casillas: El jugador comienza seleccionando una casilla para descubrirla. Si la casilla está vacía, se mostrará un número que indica cuántas minas hay en las casillas adyacentes.

Números indicadores: Los números en las casillas revelan la cantidad de minas en las casillas circundantes. Utilizando esta información, el jugador debe deducir la ubicación de las minas sin hacer clic accidentalmente en una.

Ganar y perder: El jugador gana al descubrir todas las casillas vacías sin tocar ninguna mina. Si el jugador hace clic en una casilla con una mina, pierde el juego.

Debes introducir cuantas filas y columnas quieres que tenga el mapa y el numero de minas, ademas de tu nombre para el leaderboard

## Objetos 

### Casilla

El objeto casilla esta compuesto por 2 elementos, su valor y si esta visible o no, su valor se obtiene al crearlo y su visibilidad por defecto es 0

Tiene metodos getter y setter para obtener sus datos, modificar el valor y otra para modificar la visibilidad a 1 (no puede volver a 0)

### Mapa

Compuesto por un array para almacenar el mapa entero.

Inicia con el metodo crearMapa() dandole por parametro filas, columnas y numero de minas

Metodo getMapa() te devuelve el array del mapa

- **revelar()** le das la posicion de una casilla y cambia su visibilad y las adyacentes, si una adyacente es un 0, hace recursividad hasta que no quedan casillas con 0 adyancentes entre ellos ademas aumenta noMinas_rev que tiene contador de cuantas casillas han sido reveladas sin ser una mina. Si la casilla revelada es un -1, devuelve false, en caso contrario, devuelve true.

- **checkVictoria()** comprueba si has ganado comparando si el contador de casillas reveladas sin ser mina es igual a la cantidad de casillas totales que no contiene una.

- **mostrarTodo()** cambia la visibilidad de cada una de las casillas para mostrarlo entero

## Funciones

### Relacionado con el mapa

- **printMapa()** deberas darle un array que será el mapa, lo imprimira entero y dependiendo de la propiedad de Visible del objeto Casilla, mostrará la casilla vacia (blanco con una imagen para la url y obtener mediante GET datos de la casilla pulsada) o la mostrará con un color u otro dependiendo de su valor

### Relacionado con el leaderboard

El leaderboard esta guardado en un txt, leer_leaderboard() obtiene los datos del txt y lo transforma a un array y lo devuelve con todos los datos

- **add_leaderboard()** añadira al leaderboard la nueva puntuacion con sus datos, deberas pasar tambien el array con el leaderboard y si es superior a uno de los 10 mejores, lo agregará en la posicion adecuada. Devuelve el array leader actualizado

- **printLeaderboard()** Imprime una tabla con los datos del leaderboard entero

- **calcPuntos()** mediante una formula, con el numero de casillas, tiempo y minas

## SESIONES

- **$_SESSION['mapa']** contiene el objeto del mapa completo
- **$_SESSION['datos']** es un array que contiene 3 valores, en otden son el nombre, numero de casillas y numero de minas en el mapa

- **$_SESSION['tInicio']** contiene un time() con la hora en la que se inicia el juego

- **$_SESSION['tFinal']** contiene un time() con la hora en la que se finaliza el juego

## REQUEST

- **$_REQUEST['operacion']** contiene que tipo de operacion contiene al acceder desde un formulario

- **$_REQUEST['la_fila']** contiene la fila de la casilla que pulsaste
- **$_REQUEST['la_columna']** contiene la columna de la casilla que pulsaste

## INDEX.PHP

Inicia una sesion y comprueba el valor de operacion
En el switch operacion puede tener varios valores
- **crear_mapa** obtenido del formulario al iniciar un juego, crea el objeto y valida que el numero de casillas este entre 2 y 900, que el nombre no este vacio y el numero de minas sea menor al numero de casillas. Crea el objeto y lo guarda en $_SESSION['mapa'], guarda los datos en $_SESSION['datos'] e inicia $_SESSION['tInicio']

- **revelar** obtenido al pulsar una de las celdas. Obtiene la fila y columna ademas de la casilla y ejecuta revelar() del objeto Mapa.

Comprueba si pisaste una mina, en caso contrario, comprobamos si has ganado con checkVictoria(). Si devuelve true, creamos $_SESSION['tFinal'] y te envia a leaderboard.php

## LEADERBOARD.PHP

Primero, con el mapa, lo revelo entero y lo imprimo por pantalla para que el usuario vea el resultado final

Despues, si todos los valores de $_SESSION existen, ejecuto leer_leaderboard(), y guardo en 3 variables el nombre, numero de casillas y numero de minas ademas de calcular el tiempo total tardado ($_SESSION['tFinal'] - $_SESSION['tInicio']).

Calculo los puntos obtenidos con los 3 valores y la funcion calcPuntos() y ejecuto add_leaderboard(). Si entras en el top 10 apareceras, en caso contrario no.

Al final muestro el leaderboard completo por pantalla
