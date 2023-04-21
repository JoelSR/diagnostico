<?php
    require_once('../model/comunas.php');
    $comunas_class  = new Comunas();

    if (isset($_POST['id'])) {
        $comunas = $comunas_class->get_comunas_by_region($_POST['id']);

        echo json_encode($comunas);
    }
?>