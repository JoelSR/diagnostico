# prueba_diagnostico

- Para PHP se utiliza la versión 7.4.33
- Para la base de datos se hizo uso de SQLite en su versión 3.34.1
- Para el servidor se hizo uso de Apache/2.4.56

Este trabajo se realizó en un sistema unix like, por lo que para la instalación
de la herramientas utlizadas se hicieron de la siguiente manera.

## PHP
- sudo apt install php7.4-cli php7.4-mbstring php7.4-xml php7.4-common php7.4-curl

## SQLite3
- sudo apt-get install sqlite3
Para poder utilizar sqlite3 con php se debe instalar lo siguiente:
- sudo apt-get install php7.4-sqlite3

Para permitir el uso de sqlite3 con php se debe modificar el archivo de php.ini
descomentando la extensión de sqlite3 y agregando la ubicación del modulo de la extensión
para sqlite3 (sqlite3.so)