# Buscaminas

## Funcionamiento juego

Campo de juego: El juego comienza con un campo de juego rectangular compuesto por casillas. Cada casilla puede contener una mina o estar vacía.

Minas ocultas: Antes de empezar, se distribuyen aleatoriamente un cierto número de minas en el campo. El jugador no puede ver la ubicación de las minas al principio.

Descubrimiento de casillas: El jugador comienza seleccionando una casilla para descubrirla. Si la casilla está vacía, se mostrará un número que indica cuántas minas hay en las casillas adyacentes.

Números indicadores: Los números en las casillas revelan la cantidad de minas en las casillas circundantes. Utilizando esta información, el jugador debe deducir la ubicación de las minas sin hacer clic accidentalmente en una.

Ganar y perder: El jugador gana al descubrir todas las casillas vacías sin tocar ninguna mina. Si el jugador hace clic en una casilla con una mina, pierde el juego.

## Objetos 

### Casilla

El objeto casilla esta compuesto por 2 elementos, su valor y si esta visible o no, su valor se obtiene al crearlo y su visibilidad por defecto es 0

Tiene metodos getter y setter para obtener sus datos, modificar el valor y otra para modificar la visibilidad a 1 (no puede volver a 0)

### Mapa

Compuesto por un array para almacenar el mapa entero.

Inicia con el metodo crearMapa() dandole por parametro filas, columnas y numero de minas

Metodo getMapa() te devuelve el array del mapa

revelar() le das la posicion de una casilla y cambia su visibilad y las adyacentes, si una adyacente es un 0, hace recursividad hasta que no quedan casillas con 0 adyancentes entre ellos ademas aumenta noMinas_rev que tiene contador de cuantas casillas han sido reveladas sin ser una mina.

checkVictoria() comprueba si has ganado comparando si el contador de casillas reveladas sin ser mina es igual a la cantidad de casillas totales que no contiene una.

mostrarTodo() cambia la visibilidad de cada una de las casillas para mostrarlo entero
