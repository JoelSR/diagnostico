<?php
    class Candidatos {
        private $database;

        public function __construct(){
            $this->database = new SQLite3('candidatos.db',SQLITE3_OPEN_READWRITE);
        }

        public function get_candidatos(){
            $query    = $this->database->query('Select id,nombre,apellido FROM candidatos');
            $candidatos = array();
            
            while ($row = $query->fetchArray()) {
                $candidatos[] = $row;
            }
            
            $this->database->close();
            return $candidatos;
        }
    }
?>