<?php
    class Formulario {
        private $database;

        //Conexion a la base de datos
        public function __construct($location){
            $this->database = new SQLite3($location,SQLITE3_OPEN_READWRITE);
        }

        // Verificar si el rut existe para errores con PK
        public function verificar_existencia_rut($rut){
            //https://www.php.net/manual/es/sqlite3.querysingle.php
            $query = $this->database->prepare("Select count(*) FROM votos where rut = :rut");
            $query->bindValue(':rut',$rut,SQLITE3_INTEGER);
            
            if ($query->execute() === false) {
                return false;
            }
        
            return true;
        }

        public function getAllData(){
            $query    = $this->database->query('Select * FROM votos');
            $votos = array();
            
            while ($row = $query->fetchArray()) {
                $votos[] = $row;
            }
            
            return $votos;
        }

        // Ingresar voto
        public function guardarVoto($form){
            $query = $this->database->prepare('insert into votos (rut,nombre_apellido,alias,email,region,comuna,opciones,candidato) values (:rut,:nombre,:alias,:email,:region,:comuna,:opciones,:candidato)');
            $query->bindValue(':rut',$form['rut'],SQLITE3_TEXT);
            $query->bindValue(':nombre',$form['nombre_apellido'],SQLITE3_TEXT);
            $query->bindValue(':alias',$form['alias'],SQLITE3_TEXT);
            $query->bindValue(':email',$form['email'],SQLITE3_TEXT);
            $query->bindValue(':region',$form['region'],SQLITE3_INTEGER);
            $query->bindValue(':comuna',$form['comuna'],SQLITE3_INTEGER);
            $query->bindValue(':opciones',$form['opciones'],SQLITE3_TEXT);
            $query->bindValue(':candidato',$form['candidato'],SQLITE3_INTEGER);
            $query->execute();
            
        }
    }
?>