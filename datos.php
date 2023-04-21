<?php
    // Archivo para mostrar los datos en la base de datos
    require_once('model/form_model.php');

    $votos_model = new Formulario('./databases/vote_forms.db');

    $json = json_enconde($votos_model->getAllData());

    echo $json;
?>