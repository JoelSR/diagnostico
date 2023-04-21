<?php
    require_once('poblar_bd.php');

    class Regiones {
        private $database;

        public function __construct(){
            $this->database = new SQLite3('prueba_t.db',SQLITE3_OPEN_READWRITE);
        }

        public function verificar(){
            $result = $this->database->query('select * from regiones');
            
            if($result->fetchArray() == false){
                $poblar = new Poblar();
                $poblar->poblarBD();
            }
        }

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