<?php
    class Candidatos {
        private $database;

        public function __construct($location){
            $this->database = new SQLite3($location,SQLITE3_OPEN_READWRITE);
        }

        // Obtener todos los candidates
        public function get_candidatos(){
            $query      = $this->database->query('Select id,nombre,apellido FROM candidatos');
            $candidatos = array();
            
            while ($row = $query->fetchArray()) {
                $candidatos[] = $row;
            }
            
            return $candidatos;
        }

        // Verificar si el id existe para errores con PK
        /*https://www.php.net/manual/es/sqlite3.querysingle.php*/
        public function verificar_existencia_id($id){
            $stm = "Select count(*) FROM candidatos where id = '$id'";
            $query = $this->database->querySingle($stm);

            if($query === 0){
                return false;
            }

            return true;
        }

        // Sumar 1 a los votos del candidato
        public function update_votos($id){
            $query = $this->database->query("update candidatos SET votos = votos+1 where id = '$id'");
            return "Updated";
        }
    }
?>