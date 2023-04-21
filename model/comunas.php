<?php
    class Comunas {
        private $database;

        //Conexion a la base de datos
        public function __construct(){
            $this->database = new SQLite3('../prueba_t.db',SQLITE3_OPEN_READWRITE);
        }

        // Peticion de comunas por ID de region
        public function get_comunas_by_region($id){
            $query = $this->database->prepare('Select id,nombre_comuna FROM comunas where id_region = :id');
            $query->bindValue(':id',$id, SQLITE3_INTEGER);

            $result = $query->execute();

            $comunas = array();
            while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                $comunas[] = $row;
            }

            $this->database->close();
            return $comunas;
        }
    }
?>