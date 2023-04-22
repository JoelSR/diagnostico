<?php
    // Archivo para mostrar los datos en la base de datos
    require_once('model/form_model.php');

    $votos_model = new Formulario('./databases/vote_forms.db');

    $json = json_encode($votos_model->getAllData());

    foreach ($votos_model->getAllData() as $key => $value) {
        print_r($value);
        echo '<br>';
    }
?>