<?php
    require_once('poblar_bd.php');

    class Regiones {
        private $database;

        public function __construct(){
            $this->database = new SQLite3('./databases/prueba_t.db',SQLITE3_OPEN_READWRITE);
        }

        // Verificar si ya estan las regiones
        public function verificar(){
            $result = $this->database->query('select * from regiones');
            
            if($result->fetchArray() == false){
                $poblar = new Poblar();
                $poblar->poblarBD();
            }
        }

        // Seleccionar todas los datos de la tabla regiones
        public function get_regiones(){
            $query    = $this->database->query('Select * FROM regiones');
            $regiones = array();
            
            while ($row = $query->fetchArray()) {
                $regiones[] = $row;
            }
            
            $this->database->close();
            return $regiones;
        }
    }
?>