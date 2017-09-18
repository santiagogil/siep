<?php echo $this->Html->script(array('tooltip', 'datepicker', 'moment', 'bootstrap-datetimepicker')); ?>
<?php echo $this->Html->css(array('/js/select2/select2.min')); ?>
<?php echo $this->Html->script(array('/js/select2/select2.min')); ?>
<?php echo $this->Html->script(array('/js/select2/es')); ?>


<style>
    .big-checkbox {width: 100px; height: 100px;}
</style>

<fieldset>
    <?php
        echo $this->Form->input('empleado_id', array('type' => 'hidden'));
        echo $this->Form->input('legajo_nro', array('type' => 'hidden'));
    ?>


    <div class="form-group">
        <label class="col-md-4 control-label">Nombres y Apellidos*</label>
        <div class="col-md-4">
            <!-- Autocomplete para nombre de Personas -->
            <div>
                <input id="PersonaNombreCompleto" class="form-control" data-toggle="tooltip" data-placemente="bottom" placeholder="Ingrese el nombre completo">
                <input id="PersonaId" name="data[Persona][persona_id]" type="text" style="display:none;">
                <div class="alert alert-danger" role="alert" id="AutocompleteError" style="display:none;">
                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                    <span class="sr-only">Error:</span>
                    La persona no fue localizada.
                    <?php echo $this->Html->link("Crear persona",array('controller'=>'personas','action'=>'add'));?>
                </div>
            </div>
            <script>
                $( function() {
                    $( "#PersonaNombreCompleto" ).autocomplete({
                        source: "<?php echo $this->Html->url(array('controller'=>'Alumnos','action'=>'autocompleteNombrePersona'));?>",
                        minLength: 2,
                        // Evento: se ejecuta al seleccionar el resultado
                        select: function( event, ui ) {
                            // Elimina ID de persona previo a establecer la seleccion
                            $("#PersonaId").val("");

                            if(ui.item != undefined) {
                                var nombre_completo = ui.item.Persona.nombre_completo_persona;
                                $("#PersonaNombreCompleto").val(nombre_completo);
                                $("#PersonaId").val(ui.item.Persona.id);
                                return false;
                            }
                        },
                        response: function(event, ui) {
                            // Elimina ID de persona al obtener respuesta
                            $("#PersonaId").val("");
                            if (ui.content.length === 0) {
                                $("#AutocompleteError").show();
                                $("#PersonaId").val("");
                            } else {
                                $("#AutocompleteError").hide();
                            }
                        }
                    }).autocomplete("instance")._renderItem = function( ul, item ) {
                        // Renderiza el resultado de la respuesta
                        var nombre_completo = item.Persona.nombre_completo_persona + " - "+item.Persona.documento_nro;
                        return $( "<li>" )
                            .append( "<div>" +nombre_completo+ "</div>" )
                            .appendTo( ul );
                    };
                });
            </script>
            <!-- End Autocomplete -->
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Tipo de inscripción*</label>
        <div class="col-md-4">
            <select name="data[Inscripcion][tipo_inscripcion]" class="form-control" data-toggle="tooltip" data-placement="bottom" title="Seleccione una opción">
                <option value="1">Hermanos - Alumnos regulares</option>
                <option value="2">Pase</option>
                <option value="3">Hijo docente de la institución</option>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Centro*</label>
        <div class="col-md-4">
            <?php echo $this->Form->input('centro_id', array('label'=>false,  'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción'));  ?>
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Seccion*</label>
        <div class="col-md-4">
            <?php echo $this->Form->input('Curso', array('multiple' => true, 'label'=>false,  'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción'));  ?>
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Documentación Presentada</label>
        <div class="col-md-4">

            <?php echo $this->Form->input('fotocopia_dni', array('label' => false, 'type' => 'checkbox', 'before' => '<label class="checkbox-inline">', 'after' => 'Fotocopia DNI</label>'));?>
            <?php echo $this->Form->input('certificado_septimo', array('label' => false, 'type' => 'checkbox', 'before' => '<label class="checkbox-inline">', 'after' => 'Certificado Primario Completo</label>'));?>
            <?php echo $this->Form->input('analitico', array('label' => false, 'type' => 'checkbox', 'before' => '<label class="checkbox-inline">', 'after' => 'Certificado Analítico</label>'));?>
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Observaciones</label>
        <div class="col-md-4">
            <?php echo $this->Form->input('observaciones', array('label'=>false, 'type' => 'textarea', 'class' => 'form-control')); ?>
        </div>
    </div>


</fieldset>


<?php
/*
if (($current_user['role'] == 'superadmin') || ($current_user['puesto'] == 'Dirección Colegio Secundario') || ($current_user['puesto'] == 'Supervisión Secundaria') || ($current_user['puesto'] == 'Dirección Instituto Superior') || ($current_user['puesto'] == 'Supervisión Secundaria')) {
echo $this->Form->input('Inscripcion.Materia', array('multiple' => true, 'label'=>'Unidades Curriculares*', 'empty' => 'Ingrese una unidad...', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción'));
}
*/
?>

        <?php
        /*
                $tipos_alta = array('Regular' => 'Regular', 'Equivalencia'=>'Equivalencia');
                echo $this->Form->input('tipo_alta', array('label' => 'Alta tipo*', 'default' => 'Ingrese un tipo...', 'options' => $tipos_alta, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción'));
        ?><br>
        <?php
            if (($current_user['role'] == 'superadmin') || ($current_user['puesto'] == 'Dirección Colegio Secundario') || ($current_user['puesto'] == 'Supervisión Secundaria') || ($current_user['puesto'] == 'Dirección Instituto Superior') || ($current_user['puesto'] == 'Supervisión Secundaria')) {
                echo $this->Form->input('estado', array('type' => 'hidden'));
                $condiciones_aprobacion = array('Promocion directa' => 'Promocion directa', 'Examen regular' => 'Examen regular', 'Examen libre' => 'Examen libre', 'Examen de reválida' => 'Examen de reválida', 'Equivalencia' => 'Equivalencia', 'Saberes adquiridos' => 'Saberes adquiridos', 'Examen regular y Equivalencia' => 'Examen regular y equivalencia');
                echo $this->Form->input('condicion_aprobacion', array('label' => 'Condición de aprobación*', 'options' => $condiciones_aprobacion, 'empty' => 'Ingrese una opción...', 'between' => '<br>', 'class' => 'form-control'));?><br>
              <div class="row">
                <div class="input-group">
                  <span class="input-group-addon">
                    <?php  echo $this->Form->input('recursante', array('between' => '<br>', 'class' => 'form-control', 'label' => false, 'type' => 'checkbox', 'before' => '<label class="checkbox">', 'after' => '<br><i></i><br>Recursante</label>'));?>
                  </span>
                </div>
              </div>

              <?php

                $tipos_cursa = array('Cursa algun espacio curricular'=>'Cursa algun espacio curricular', 'Sólo se inscribe a rendir final' =>'Sólo se inscribe a rendir final', 'Cursa espacio curricular y rinde final'=>'Cursa espacio curricular y rinde final');
                echo $this->Form->input('cursa', array('label' => 'Cursa*', 'empty' => 'Ingrese una opción...', 'options' => $tipos_cursa, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción'));
                $tipos_fines = array('No' => 'No', 'Sí línea deudores de materias.' => 'Sí línea deudores de materias.', 'Sí línea trayectos educativos.' => 'Sí línea   trayectos educativos.');
                echo $this->Form->input('fines', array('label' => 'Fines*', 'empty' => 'Ingrese una opción...', 'options' => $tipos_fines, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción'));
            }
        */
        ?>

</div>



<script type="text/javascript">
    $('select').select2({
        language: "es"
    });
</script>
