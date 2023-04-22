<?php
    require_once('model/regiones.php');
    require_once('model/candidatos.php');

    $regiones_model = new Regiones();
    $regiones_model->verificar();
    $regiones = $regiones_model->get_regiones();

    $candidatos_model = new Candidatos('databases/candidatos.db');
    $candidatos = $candidatos_model->get_candidatos();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>
            FORMULARIO DE VOTACIÓN
        </title>
        <!--BOOTSTRAP-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        <!--STYLESHEET-->
        <link href="template.css" rel="stylesheet">
    </head>
    <body>
        <div> 
            <br>
            <div class="container">
                <h3><b>FORMULARIO DE VOTACIÓN:</b></h3>

                <form method="post" id="vote-form">
                    <!--INPUT DE NOMBRE-->
                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label">Nombre y Apellido</label>
                        <div class="col-sm-9">
                            <input id="name" type="text" required>
                        </div>
                        <span id='errorName'></span>
                    </div>
                    <!--INPUT DE ALIAS-->
                    <div class="form-group row">
                        <label for="alias" class="col-sm-3 col-form-label">Alias</label>
                        <div class="col-sm-9">
                            <input id="alias" type="text" required>
                            <span id='errorAlias'></span>
                        </div>
                    </div>
                    <!--INPUT RUT-->
                    <div class="form-group row">
                        <label for="rut" class="col-sm-3 col-form-label">RUT</label>
                        <div class="col-sm-9">
                            <input id="rut" type="text" required>
                            <span id='errorRut'></span>
                        </div>
                    </div>
                    <!--INPUT DE EMAIL-->
                    <div class="form-group row">
                        <label for="email" class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                            <input id="email" type="email" required>
                            <span id='errorEmail'></span>
                        </div>
                    </div>
                    <!--SELECCION DE REGION-->
                    <div class="form-group row">
                        <label for="region" class="col-sm-3 col-form-label">Región</label>
                        <div class="col-sm-9">
                            <select name="region_seleccionada" id="region_seleccionada" required>
                                <option value="-1"></option>
                                <?php
                                    foreach ($regiones as $row) {
                                        echo '<option value="'.$row['id'].'">'.$row['nombre_region'].'</option>';
                                    }
                                ?>
                            </select>
                            <span id='errorRegion'></span>
                        </div>
                    </div>
                    <!--SELECCION DE COMUNA-->
                    <div class="form-group row">
                        <label for="comuna" class="col-sm-3 col-form-label">Comuna</label>
                        <div class="col-sm-9">
                            <select name="comuna_seleccionada" id="comuna_seleccionada" required>
                                <option value="-1"></option>
                            </select>
                            <span id='errorComuna'></span>
                        </div>
                    </div>
                    <!--SELECCION DE CANDIDATO-->
                    <div class="form-group row">
                        <label for="candidato" class="col-sm-3 col-form-label">Candidato</label>
                        <div class="col-sm-9">
                            <select id="candidato_seleccionado" required>
                                <option value="-1"></option>
                                <?php
                                    foreach ($candidatos as $row) {
                                        echo '<option value="'.$row['id'].'">'.$row['nombre'].' '.$row['apellido'].'</option>';
                                    }
                                ?>
                            </select>
                            <span id='errorCandidato'></span>
                        </div>
                    </div>
                    <!--COMO SE ENTERO-->
                    <fieldset class="form-group row">
                        <label for="informacion" class="col-sm-3 col-form-label">Como se enteró de Nosotros</label>
                        <div class="col-sm-9">
                            <label class="checkbox-inline">
                            <input type="checkbox" value="web">Web
                            </label>
                            <label class="checkbox-inline">
                            <input type="checkbox" value="tv">TV
                            </label>
                            <label class="checkbox-inline">
                            <input type="checkbox" value="redes_sociales">Redes Sociales
                            </label>
                            <label class="checkbox-inline">
                            <input type="checkbox" value="amigo">Amigo
                            </label>
                        </div>
                        <span id='errorCheck'></span>
                    </fieldset>
                    <br>
                    <input type="submit" value="Votar">
                </form>
            </div>
        </div>
    </body>

    <!--JQUERY|AJAX-->
    <script src="js/jquery-3.6.4.min.js"></script>
    <!--COMUNAS POR REGION SELECCIONADA-->
    <script>
        $(document).ready(function(){
            $("#region_seleccionada").change(function(){
                let selected = $('#region_seleccionada').val();
                $("#comuna_seleccionada").empty();
                $("#comuna_seleccionada").append($("<option>",{
                    value: -1,
                    text : ""
                }));

                $.ajax({
                    url  : "/Prueba/controllers/comunas_controller.php",
                    type : "POST",
                    data : { 'id': selected},
                    success: function(comunas){
                        
                        $.each(JSON.parse(comunas),function(i,comuna){
                            $("#comuna_seleccionada").append($("<option>", {
                                value: comuna.id,
                                text : comuna.nombre_comuna
                            }))
                        })
                    },
                    error: function(error) { console.error(error); }
                });
            });
        });
    </script>
    <script>
        $("#vote-form").submit(function(){
            event.preventDefault();

            //DATOS
            const nombre = $("#name").val();
            const alias = $("#alias").val();
            let rut = $("#rut").val();
            const email = $("#email").val();
            const region = $("#region_seleccionada").val();
            const comuna = $("#comuna_seleccionada").val();
            const candidato = $("#candidato_seleccionado").val();
            let checked = $('input[type=checkbox]:checked').map(function() {
                return $(this).val()
            }).get()
            
            /* VALIDACIONES */
            let valid = true

            // Verificar que almenos existe una letra o un numero
            let aliasRegex = /(?:[a-z._-])(?:\d)|(?:\d)(?:[a-z._-])/i
            let error = document.getElementById('errorAlias')
            if(alias.legnth<5 || !aliasRegex.test(alias)){
                error.textContent = "5 caracteres minimo, contener numeros y letras"
                error.style.color = "red"
                valid = valid && false
            }else{
                error.textContent = ""
            }            

            // Validar que se selecciono una comuna
            error = document.getElementById('errorComuna')
            if(comuna == -1){
                error.textContent = "Seleccione una comuna"
                error.style.color = "red"
                valid = valid && false
            }else{
                error.textContent = ""
            }

            // Validar que se seleccionaron mas de dos opciones
            error = document.getElementById('errorCheck')
            if(checked.length<2){
                error.textContent = "Seleccione al menos 2 opciones"
                error.style.color = "red"
                valid = valid && false
            }else{
                error.textContent = "" 
                checked = JSON.stringify(checked)
            }


            // Validar que se selecciono un candidato
            error = document.getElementById('errorCandidato')
            if(candidato == -1){
                error.textContent = "Seleccione una Candidato"
                error.style.color = "red"
                valid = valid && false
            }else{
                error.textContent = ""
            }

            // Validar que se selecciono una region
            error = document.getElementById('errorRegion')
            if(region == -1){
                error.textContent = "Seleccione una region"
                error.style.color = "red"
                valid = valid && false
            }else{
                error.textContent = ""
            }

            // Validar Email
            let emailRegex = /^[\w\.]+@[\w]+\.[a-z]{2,}$/i
            error = document.getElementById('errorEmail')
            if(!emailRegex.test(email)){
                error.textContent = "Ingrese un email valido"
                error.style.color = "red"
                valid = valid && false
            }else{
                error.textContent = ""
            }
            
            // Validar RUT
            // Capturar grupos para luego unirlos
            let rutRegex = /([1-3]?[0-9])\.?(\d{3})\.?(\d{3})-?([\dKk])$/
            let partes = rutRegex.exec(rut)
            error = document.getElementById('errorRut')
            if(partes){
                // Partes del Rut
                let digitos  = partes.slice(1,4).join('')
                let digito_v = partes[4]
                rut = digitos+'-'+digito_v

                // SUMA y MULT
                let suma = 0
                let mult = 2

                // https://es.wikipedia.org/wiki/Rol_%C3%9Anico_Tributario
                for(let i=digitos.length-1;i>=0;i--) {
                    suma += digitos[i]*mult
                    mult += 1
                    if(mult>7){
                        mult = 2
                    }
                }

                let calc_dig_v = 11-(suma%11)

                digito_v = (digito_v == 'K' || digito_v == 'k')?10:digito_v;
                digito_v = (digito_v == 0)?11:digito_v;


                
                if(calc_dig_v != digito_v){
                    error.textContent = "Compruebe su digito verificador"
                    error.style.color = "red"
                    valid = valid && false
                }else{
                    error.textContent = ""
                }
            }else{
                error.textContent = "Ingrese un rut valido"
                error.style.color = "red"
                valid = valid && false
            }
            
            // VALIDACION PARA ENVIAR LOS DATOS
            if(valid){
                $.ajax({
                    url  : "/Prueba/controllers/form_controller.php",
                    type : "POST",
                    data : { "nombre_apellido": nombre, "alias": alias, "rut": rut,
                        "email": email, "region": region, "comuna": comuna,
                        "candidato": candidato, "opciones": checked},
                    success: function(response){
                        console.log(response)
                        window.location = 'datos.php'
                    },
                    error: function(response) { console.error(response); }
                });
            }else{
                return;
            }
            
        })
    </script>
</html>