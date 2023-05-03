<?php
    require_once("../model/candidatos.php");
    require_once("../model/form_model.php");

    $formulario = new Formulario('../databases/vote_forms.db');
    $candidatos = new Candidatos('../databases/candidatos.db');

    if($formulario->verificar_existencia_rut($_POST["rut"]) === true){
        $formulario->guardarVoto($_POST);
        echo 'SAVED ';
        $candidato = $_POST['candidato'];

        if($candidatos->verificar_existencia_id($_POST["candidato"]) === true){
            $candidatos->update_votos($candidato);
            echo 'Voto guardado y sumado al candidato';
        }
    }else{
        echo 'EL RUT YA EXISTE';
    }

?>