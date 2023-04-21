<?php
    class Poblar{
        private $database;
        
        public function __construct(){
            $this->database = new SQLite3('../databases/prueba_t.db',SQLITE3_OPEN_READWRITE);
        }
    
        public function poblarBD(){
            // Archivo obtenido desde https://gist.github.com/juanbrujo/0fd2f4d126b3ce5a95a7dd1f28b3d8dd
            $regiones_comunas = file_get_contents('regiones_comunas.json');

            $regiones_comunas_array = json_decode($regiones_comunas,true);

            //ver estructura del arreglo
            //print_r($regiones_comunas_array['regiones']);

            foreach ($regiones_comunas_array['regiones'] as $region) {
                $query_region = $this->database->prepare('insert into regiones (nombre_region) values (:region)');
                $query_region->bindValue(':region',$region['region'],SQLITE3_TEXT);
                $query_region->execute();

                // id de ultima region ingresada
                $id = $this->database->lastInsertRowID();

                foreach ($region['comunas'] as $comuna) {
                    $query_comuna = $this->database->prepare('insert into comunas (nombre_comuna,id_region) values (:comuna, :id_region)');
                    $query_comuna->bindValue(':comuna',$comuna,SQLITE3_TEXT);
                    $query_comuna->bindValue(':id_region',$id,SQLITE3_INTEGER);
                    $query_comuna->execute();
                }
            } 
        }  
    }
?>